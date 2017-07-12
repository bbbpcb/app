<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:04
 */

class Zhengshu extends Admin_Controller
{


    public function __construct(){
        parent::__construct();
        $this->load->model('zhengshu_mdl','zhengshu');
    }


    public function index(){

        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->zhengshu->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=zhengshu';
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
        $list = $this->zhengshu->getList($where);
        $data['list'] = $list;


        $this->load->view('home/home_zhengshu',$data);

    }

    public function home_import(){


        if(!empty($_FILES)){

            $config['upload_path'] = './uploads/zhengshu/';
            $config['allowed_types'] = 'txt';

            $this->load->library('upload', $config);
            if ( $upload = $this->upload->do_upload('filename'))
            {
                $upload = $this->upload->data();
                $data['filename'] = $upload['file_name'];
                //读取
                $zarr = array();
                $count = 0;
                $handle = @fopen("./uploads/zhengshu/".$data['filename'], "r");
                if ($handle) {
                    while (!feof($handle)) {
                        $buffer = fgets($handle, 4096);
                        if(!empty($buffer)){
                            $zarr[] = preg_replace('/\s/i','',$buffer);
                        }
                    }

                    if(count($zarr)){
                        foreach($zarr as $k => $v){
                            $zhenghu['zsnum'] = $v;
                            $zhenghu['createtime'] = time();
                            if($this->zhengshu->add($zhenghu)){
                                $count++;
                            }
                        }
                    }
                    $data['msg'] = '成功导入:'.$count.'条数据';
                    fclose($handle);
                }else{
                    $data['msg'] = '文件读出出错';
                }

                $this->load->view('home/home_msg',$data);
            }else{
                echo $this->upload->display_errors();
            }

        }else{

            $this->load->view('home/home_import');
        }
    }

    public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->zhengshu->del($config);
        redirect('d=home&c=zhengshu');

    }


    public function delall(){

        $this->zhengshu->delall();
        redirect('d=home&c=zhengshu');
    }
}