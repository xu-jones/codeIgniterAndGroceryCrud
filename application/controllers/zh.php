<?php

/**
 * @author xu.jones 在我面前跪下
 * @data 2014-3-12 10:31:52
 */
class Zh extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('zh_model');
//        parent::$data->qq = $this->zh_model->result_('', 'qq,title', 'shecai_qq');
    }

    /**
     * @return  首页
     */
    public function index() {
        parent::$data->menu = 'index';
        parent::$data->title = '首页';
        parent::$data->info = $this->zh_model->result_(array('category' => 11), array('img','url'));
        parent::$data->vis = $this->zh_model->catalogs();
        parent::VIEW('index', 'header', 'footer');
    }

    /**
     * @return 公司
     */
    public function aboutUs() {
        parent::$data->menu = 'about';
        parent::$data->title = '公司';
        parent::$data->img = $this->zh_model->result_(array('category' => 21), array('img'));
        parent::$data->info = $this->zh_model->row_(array('category' => 22));
        parent::VIEW('aboutUs_company', 'header', 'footer');
    }

    /**
     * @return 设计
     */
    public function aboutUs2() {
        parent::$data->menu = 'about';
        parent::$data->title = '设计';
        parent::$data->img = $this->zh_model->row_(array('category' => 31), array('img'));
        parent::$data->info = $this->zh_model->row_(array('category' => 32));
        parent::VIEW('aboutUs_designer', 'header', 'footer');
    }

    /**
     * @return  视觉识别系统
     */
    public function vis() {
        parent::$data->menu = 'vis';
        parent::$data->title = '视觉识别系统';
        parent::$data->vis = $this->zh_model->catalogs();
        parent::$data->info = $this->zh_model->result_page_(41, 'id,img,title,year,company', 0);
        parent::VIEW('vis', 'header', 'footer');
    }

    /**
     * @return  视觉识别系统
     */
    public function visMore() {
        $page = parent::G('page');
        if (is_numeric($page)) {
            
            $info = $this->zh_model->result_page_(41, 'id,img,title,year,company', $page*6);
        } else {
            echo json_encode(array('msg' => 'page is error!', 'code' => 500));
        }
        if ($info) {
            $data= '';
            foreach ($info as $v){
                $data .='<div class="visTuijianMainDiv">
            <a href="/zh/visInfo?id='.$v->id.'"><img src="/upload/'.$v->img.'" class="visTuijianMainDivImg"/></a>
            <p class="visTuijianMainDivP1">'. $v->year .'</p>
            <p class="visTuijianMainDivP2">'. $v->title .'</p>
            <p class="visTuijianMainDivP3">'. $v->company .'</p>
        </div>';
            }
            echo json_encode(array('code'=>200,'page'=>$page+1,'data'=>$data));
        } else {
            echo json_encode(array('code'=>404));
        }
        die;
    }

    /**
     * @return  视觉识别系统info
     */
    public function visInfo() {
        $id = parent::G('id');
        parent::$data->menu = 'vis';
        parent::$data->title = '视觉识别系统';
        parent::$data->info = $this->zh_model->row_(array('id' => $id));
        if (parent::$data->info) {
            preg_match_all('/src="\/upload\/(.*)"/Ui', parent::$data->info->description, $matches);
            if ($matches[1]) {
                parent::$data->info->description = $matches[1];
                $allImg = count($matches[1]);
                if($allImg >1){
                    $allImg = $allImg-1;
                }
                foreach ($matches[1] as $v) {
                    parent::image_thumb($v, '100x100');
                }
            } else {
                parent::$data->info->description = '';
            }
            
            parent::$data->h =600+ceil($allImg/8)*112.5;
            parent::VIEW('visInfo', 'header', 'footer');
        } else {
            redirect();
        }
    }

    /**
     * @return  画册
     */
    public function catalogs() {
        parent::$data->menu = 'catalogs';
        parent::$data->leftMenu = $this->zh_model->result_(array('category' => 51), array('title', 'id'));
        $id = parent::G('id');
        if (!$id && parent::$data->leftMenu) {
            $id = parent::$data->leftMenu[0]->id;
        }
        parent::$data->id = $id;
        $img = $this->zh_model->row_(array('id' => $id), 'id,img,title,description');
        if ($img) {
            preg_match_all('/src="(.*)"/Ui', $img->description, $matches);
            if ($matches[1]) {
                $img->description = '';
                foreach ($matches[1] as $v) {
                    $img->description .= $v . ',';
                }
                $img->description = trim($img->description, ',');
            } else {
                $img->description = '';
            }
        } else {
            $img = new stdClass();
            $img->description = '';
            $img->img = '';
        }

        parent::$data->img = $img;
        parent::$data->title = '画册';
        parent::VIEW('catalogs', 'header', 'footer');
    }

    /**
     * @return  广告视频
     */
    public function video() {
        parent::$data->menu = 'video';
        parent::$data->title = '广告视频';
        parent::$data->info = $this->zh_model->result_(array('category' => 61), 'id,img,url,title');
        parent::VIEW('video', 'header', 'footer');
    }

    /**
     * @return  联系 
     */
    public function contact() {
        parent::$data->menu = 'contact';
        parent::$data->title = '联系';
        parent::$data->info = $this->zh_model->row_(array('category' => 71), 'description');
        parent::VIEW('contact', 'header', 'footer');
    }

    /**
     * @return 自适应图片
     */
    public function responsive() {
        parent::responsive();
    }

    //put your code here
}

?>
