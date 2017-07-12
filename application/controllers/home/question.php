<?php


class Question extends Admin_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('question_mdl','question');
        $this->load->model('question_reply_mdl','question_reply');
	}


	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 

        $count = $this->question->get_count();
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=question';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $list = $this->question->getList($wherelist);
        $data['list'] = $list;


	   $this->load->view('home/home_question',$data);
	}


    public function reply()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $id = $this->input->get('id');
        $data['qid'] = $id;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       
        $where = !empty($id) ? array('qid'=>$id) : array();
        $count = $this->question_reply->get_count($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=question&m=reply';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['where'] = $where;
        $list = $this->question_reply->getList($wherelist);
        $data['list'] = $list;


       $this->load->view('home/home_question_reply',$data);
    }

    public function add()
    {
        if(!empty($_POST)){
            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $data['rank'] = $this->input->post('rank');

            $id = isset($_POST['id']) ? $this->input->post('id') : '0';


            if($id){
                $config = array('id'=>$id);
                $this->feedback->update($config,$data);
            }else{
               
                $this->feedback->add($data);
            }

            redirect('d=home&c=feedback');
        }else{ 


            $this->load->view('home/home_feedback_add');
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->feedback->get_one_by_id($where);
        $data['info'] = $info;

        $this->load->view('home/home_feedback_update',$data);

    }

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->question->del($where);
        redirect('d=home&c=question');
    }

                    //delete
    public function del_reply()
    {
        $id = $this->input->get('id');
        $qid = $this->input->get('qid');
        $where['id'] = $id;
        $this->question_reply->del($where);
        redirect('d=home&c=question&m=reply&id='.$qid);
    }

    //修改排序
    public function rank()
    {
        $rank = $this->input->post('rank');
        $id = $this->input->post('id');
        $len = count($id);
        for($i=0;$i<$len;$i++){
            $config = array('id'=>$id[$i]);
            $data['rank'] = $rank[$i];
            $this->feedback->update($config,$data);
        }

        redirect('d=home&c=feedback');
    }







}