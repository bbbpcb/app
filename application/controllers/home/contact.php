<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午4:05
 */

class Contact extends Admin_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('contact_mdl','contact');
    }

    public function person(){

        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->contact->get_count('person');

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=contact&m=person';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;
        $list = $this->contact->getList('person',$where);
        $data['list'] = $list;

        $this->load->view('home/home_contact_person',$data);

    }

    public function company(){

        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->contact->get_count('company');


        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=contact&m=company';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;
        $list = $this->contact->getList('company',$where);
        $data['list'] = $list;

        $this->load->view('home/home_contact_company',$data);
    }

    public function del(){
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $where = array(
                'id' => $id
            );
        $this->contact->del($type,$where);
        
        redirect('d=home&c=contact&m='.$type);
    }

    //删除所有

    public function delall(){

        $type = $this->input->get('type');
        if($type == 'person'){
            $this->contact->delall('person');
        }elseif($type == 'company'){
            $this->contact->delall('company');
        }else{
            exit('action error');
        }

        redirect('d=home&c=contact&m='.$type);
     
    }

}