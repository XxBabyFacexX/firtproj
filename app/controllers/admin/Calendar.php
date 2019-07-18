<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller
{

    private $shop;
    private $group;

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if ($this->Customer || $this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->load->library('form_validation');
        $this->load->admin_model('calendar_model');
    }

    public function index()
    {
        $this->data['cal_lang'] = $this->get_cal_lang();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('calendar')));
        $meta = array('page_title' => lang('calendar'), 'bc' => $bc);
        $this->data['shops']=$this->get_shops();
        $this->data['groups']=$this->get_groups();
        $this->data['ownShop']=$this->get_shops($this->session->userdata['user_id']);
        $this->page_construct('calendar', $meta, $this->data);
    }

    public function list(){
        $this->data['cal_lang'] = $this->get_cal_lang();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('calendar')));
        $meta = array('page_title' => lang('calendar'), 'bc' => $bc);
        $this->data['shops']=$this->get_shops();
        $this->data['groups']=$this->get_groups();
        $this->data['ownShop']=$this->get_shops($this->session->userdata['user_id']);
        $this->page_construct('calendar/list', $meta, $this->data);
    }

    public function get_events()
    {
        $this->sma->checkPermissions('index');
        
        $cal_lang = $this->get_cal_lang();
        $this->load->library('fc', array('lang' => $cal_lang));

        if (!isset($_GET['start']) || !isset($_GET['end'])) {
            die("Please provide a date range.");
        }

        if ($cal_lang == 'ar') {
            $start = $this->fc->convert2($this->input->get('start', true));
            $end = $this->fc->convert2($this->input->get('end', true));
        } else {
            $start = $this->input->get('start', true);
            $end = $this->input->get('end', true);
        }

        $input_arrays = $this->calendar_model->getEvents($start, $end);
        $start = $this->fc->parseDateTime($start);
        $end = $this->fc->parseDateTime($end);
        $output_arrays = array();

        foreach ($input_arrays as $array) {
           
            $this->fc->load_event($array);
            if ($this->fc->isWithinDayRange($start, $end)) {
                $output_arrays[] = $this->fc->toArray();
            }
        }

        // $this->sma->send_json($output_arrays);
        $this->sma->send_json($output_arrays);
    }

    public function add_event()
    {
        $this->sma->checkPermissions();

        $this->form_validation->set_rules('title', lang("title"), 'trim|required');
        $this->form_validation->set_rules('start', lang("start"), 'required');
        

        if ($this->form_validation->run() == true) {
            $data = array(
                'title' => $this->input->post('title'),
                'start' => $this->sma->fld($this->input->post('start')),
                'end' => $this->input->post('end') ? $this->sma->fld($this->input->post('end')) : NULL,
                'description' => $this->input->post('description'),
                'color' => $this->input->post('color') ? $this->input->post('color') : '#000000',
                'user_id' => $this->session->userdata('user_id'),
                'group_name'=>$this->input->post('group_name'),
                'shop'=>$this->input->post('shop')
                );

            if ($this->calendar_model->addEvent($data)) {
                $res = array('error' => 0, 'msg' => lang('event_added'));
                $this->sma->send_json($res);
            } else {
                //echo($this->db->get_compiled_select());
                $res = array('error' => 1, 'msg' => lang('action_failed'));
                $this->sma->send_json($res);
            }
        }
    }

    public function update_event()
    {
        $this->sma->checkPermissions();

        echo "<pre>";
        print_r ($this->input->post());
        echo "</pre>";

        $this->form_validation->set_rules('title', lang("title"), 'trim|required');
        $this->form_validation->set_rules('start', lang("start"), 'required');

        if ($this->form_validation->run() == true) {
            $id = $this->input->post('id');
            if($event = $this->calendar_model->getEventByID($id)) {
                if(!$this->Owner && $event->user_id != $this->session->userdata('user_id')) {
                    $res = array('error' => 1, 'msg' => lang('access_denied'));
                    $this->sma->send_json($res);
                }
            }
            $data = array(
                'title' => $this->input->post('title'),
                'start' => $this->sma->fld($this->input->post('start')),
                'end' => $this->input->post('end') ? $this->sma->fld($this->input->post('end')) : NULL,
                'description' => $this->input->post('description'),
                'color' => $this->input->post('color') ? $this->input->post('color') : '#000000',
                'user_id' => $this->session->userdata('user_id'),
                'group_name'=>$this->input->post('group_name'),
                'shop'=>$this->input->post('shop')
                );

            if ($this->calendar_model->updateEvent($id, $data)) {
                $res = array('error' => 0, 'msg' => lang('event_updated'));
                $this->sma->send_json($res);
            } else {
                $res = array('error' => 1, 'msg' => lang('action_failed'));
                $this->sma->send_json($res);
            }
        }
    }

    public function delete_event($id)
    {
        $this->sma->checkPermissions(null, true);

        if($this->input->is_ajax_request()) {
            if($event = $this->calendar_model->getEventByID($id)) {
                if(!$this->Owner && $event->user_id != $this->session->userdata('user_id')) {
                    $res = array('error' => 1, 'msg' => lang('access_denied'));
                    $this->sma->send_json($res);
                }
                $this->db->delete('calendar', array('id' => $id));
                $res = array('error' => 0, 'msg' => lang('event_deleted'));
                $this->sma->send_json($res);
            }
        }
    }

    public function get_cal_lang() {
        switch ($this->Settings->user_language) {
            case 'arabic':
            $cal_lang = 'ar-ma';
            break;
            case 'french':
            $cal_lang = 'fr';
            break;
            case 'german':
            $cal_lang = 'de';
            break;
            case 'italian':
            $cal_lang = 'it';
            break;
            case 'portuguese-brazilian':
            $cal_lang = 'pt-br';
            break;
            case 'simplified-chinese':
            $cal_lang = 'zh-tw';
            break;
            case 'spanish':
            $cal_lang = 'es';
            break;
            case 'thai':
            $cal_lang = 'th';
            break;
            case 'traditional-chinese':
            $cal_lang = 'zh-cn';
            break;
            case 'turkish':
            $cal_lang = 'tr';
            break;
            case 'vietnamese':
            $cal_lang = 'vi';
            break;
            default:
            $cal_lang = 'en';
            break;
        }
        return $cal_lang;
    }

    public function get_shops($id=NULL){
        $res=$this->calendar_model->get_shops($id);
        return $res;
    }

    public function get_groups($id=NULL){
        $res=$this->calendar_model->get_groups($id);
        return $res;
    }

    public function set_shop(){

        $this->shop=($this->input->get('shop_name'));
        echo $this->group;
        echo $this->user;
    }

    public function set_user(){
        $this->group=($this->input->get('user'));
        echo $this->user;
        echo $this->group;
    }

     function get_all_events()
    {
        $this->sma->checkPermissions('index', TRUE);
        //$supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;

       
       // $detail_link = anchor('admin/products/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('product_details'));
        $delete_link = "<a href='#' class='tip po' title='<b>" . $this->lang->line("delete_product") . "</b>' data-content=\"<p>". lang('r_u_sure') . "</p><a class='btn btn-danger  delete' >"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_product') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            
            <li><a class="add"><i class="fa fa-plus-circle"></i> ' . lang('add_event') . '</a></li>
            <li><a class="edit"><i class="fa fa-edit"></i> ' . lang('edit_product') . '</a></li>';
        
        $action .= '<li class="divider"></li>
            <li>' . $delete_link . '</li>
            </ul>
        </div></div>';
        $this->load->library('datatables');

        $this->datatables->select ('id,title,description,start,end,user_id,group_name,shop')
        ->from('calendar');
        $this->datatables->add_column("Actions", $action);
       
        echo $this->datatables->generate();
    }

    public function delete(){
        if($this->calendar_model->deleteEvent($this->input->get('id'))){
            echo lang('event_deleted');
        }
        else{
            echo lang('error_while_deleting');
        }
    }

    public function get_event_by_id(){
        $res=$this->calendar_model->getEventByID($this->input->get('id'));
        echo json_encode($res);
    }

    public function delete_all(){
        if($this->input->get("cbox_value")!=array()){
            $id=$this->input->get("cbox_value");
            for($count=0;$count<count($id);$count++){
                $this->calendar_model->deleteEvent($id[$count]);
            }
        }
    }
}