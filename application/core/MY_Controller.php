<?php

/**
 * @author 在我面前跪下
 * @data 2013-10-13 21:33:05
 */
class MY_Controller extends CI_Controller {

    protected static $data = '';

    public function __construct() {
        self::$data = new stdClass();
        parent::__construct();
    }

    /**
     * 图片缩略
     * @param type $img 图片
     * @param type $name 新名称
     * @param type $width 宽
     * @param type $height 高
     * @param type $dir 存放路径
     */
    protected function image_thumb($img, $name) {
        $dir = 'upload';
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['quality'] = 100;
        $config['source_image'] = $dir . '/' . $img;
        $config['new_image'] = $dir . '/' . $name . $img;
        if(file_exists($config['new_image'])){
            return;
        }
        $config['maintain_ratio'] = true;
        $config['width'] = 167;
        $config['height'] = 100;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
            die;
        }
        $this->image_lib->clear();
        
        $config['image_library'] = 'gd2';
        $config['quality'] = 100;
        $config['source_image'] = $dir . '/' . $name . $img;
        $config['new_image'] = $dir . '/' . $name . $img;
        $config['maintain_ratio'] = 0;
        $config['width'] = 100;
        $config['height'] = 100;
        $config['x_axis'] = 33;
        $config['y_axis'] = 0;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->crop()) {
            echo $this->image_lib->display_errors();
            die;
        }
        $this->image_lib->clear();
    }
    
    
    /**
     * 判断设备
     * @return 设备pc/tablet/mobile
     */
    protected function detct() {
        self::$data->responsive = '<script src="' . base_url('js/responsive.js') . '" charset="utf-8"></script>';
        $this->load->library('Mobile_Detect');
        if ($this->mobile_detect->isTablet()) {
            self::$data->shebei = 't';
            self::$data->detct = '/css/cssTablet.css';
        } else if ($this->mobile_detect->isMobile()) {
            self::$data->shebei = 'm';
            self::$data->detct = '/css/cssMobile.css';
        } else {
            self::$data->shebei = 'p';
            self::$data->responsive = '';
            self::$data->detct = '/css/cssPc.css';
        }

//        if (isset(self::$data->banner)) {
//            if (!$this->mobile_detect->isTablet() && $this->mobile_detect->isMobile()) {
//                self::$data->banner = '<div class="banner"><img src="/upload/' . self::$data->banner->img . '" id="banner-img" data-responsive="yes" /></div>';
//            } else {
//                self::$data->banner = '<div class="banner"><img src="/upload/' . self::$data->banner->title . '"/></div>';
//            }
//        }
    }

    /**
     * 
     * @param type $view 主体
     * @param type $data 数据
     * @param type $header 头
     * @param type $footer 尾
     */
    protected function VIEW($view, $header = FALSE, $footer = FALSE) {
//        self::$data->title.='-安德美';
        if ($header) {
            $this->load->view($header, self::$data);
        }
        $this->load->view($view, self::$data);
        if ($footer) {
            $this->load->view($footer, self::$data);
        }
    }

    /**
     * @return 自适应裁剪
     */
    protected function responsive() {
        $this->detct();
        if (!self::$data->responsive) {
            exit(json_encode(array('img' => 0)));
        }
        $config['width'] = $w = ($this->G('ww') ? $this->G('ww') : $this->G('w')) * 1.5;

        $img = $this->G('img');

        $new_img = $w . '_' . $img;
        $firstIsnotResponsive = false;
        if (!is_file('./upload/responsive/' . $new_img)) {
            $firstIsnotResponsive = true;
            $this->load->library('image_lib');
            if (is_file('./img/' . $img)) {
                $config['source_image'] = 'img/' . $img;
            } elseif (is_file('./upload/' . $img)) {
                $config['source_image'] = 'upload/' . $img;
            }
            $config['image_library'] = 'gd2';
            $config['quality'] = 100;
            $config['new_image'] = 'upload/responsive/' . $new_img;
            $param = getimagesize($config['source_image']);
            if ($w < $param[0]) {
                $config['height'] = ceil(($w / $param[0]) * $param[1]);
            } else {
                $config['width'] = $param[0];
                $config['height'] = $param[1];
            }

            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
                die;
            }
            $this->image_lib->clear();
        }
        if ($firstIsnotResponsive) {
            exit(json_encode(array('img' => 0)));
        } else {
            exit(json_encode(array('img' => '/upload/responsive/' . $config['width'] . '_' . $img)));
        }
    }

    /**
     * $_GET防注入
     * @param type $field
     * @return $_GET
     */
    protected function G($field, $default = '') {
        $this->get = $this->input->get($field);
        $GET_FILTER = "'|(and)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
        if (preg_match("/" . $GET_FILTER . "/is", $this->get) == 1) {
            header("Status: 400 Bad Request");
            exit('在我面前跪下！！');
        }
        if (!$this->get) {
            return $default;
        }
        return $this->get;
    }

    /**
     * $_POST防注入
     * @param type $field
     * @param type $default
     * @return $_POST
     */
    protected function P($field, $default = '') {
        $this->post = $this->input->post($field);
        $POST_FILTER = "\\b(and)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
        if (preg_match("/" . $POST_FILTER . "/is", $this->post) == 1) {
            header("Status: 400 Bad Request");
            exit('在我面前跪下！！');
        }
        if (!$this->post) {
            return $default;
        }
        return $this->post;
    }

    //put your code here
}

##############################################################

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->is_login();
    }

    private function is_login() {
        if (!$this->session->userdata('user_name')) {
            redirect('admin/login');
        }
    }

    /**
     * 图片缩略
     * @param type $img 图片
     * @param type $name 新名称
     * @param type $width 宽
     * @param type $height 高
     * @param type $dir 存放路径
     */
    protected function image_thumb($img, $name, $width, $height, $dir = 'upload') {
        $config['image_library'] = 'gd2';
        $config['quality'] = 100;
        $config['source_image'] = $dir . '/' . $img;
        $config['new_image'] = $dir . '/' . $name . $img;
        echo file_exists($config['new_image']);
        die;
        $param = getimagesize($config['source_image']);
        if ($width && $height) {
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $width;
            $config['height'] = $height;
        } else {
            if ($width) {#只传了宽
                if ($width < $param[0]) {
                    $config['width'] = $width;
                    $config['height'] = ($width / $param[0]) * $param[1];
                } else {
                    $config['width'] = $param[0];
                    $config['height'] = $param[1];
                }
            } else {#只传了高
                if ($height < $param[1]) {
                    $config['height'] = $height;
                    $config['width'] = ($height / $param[1]) * $param[0];
                } else {
                    $config['width'] = $param[0];
                    $config['height'] = $param[1];
                }
            }
        }

        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
            die;
        }
        $this->image_lib->clear();
    }

}

?>
