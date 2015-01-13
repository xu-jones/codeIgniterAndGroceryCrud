<?php

/**
 * @author 在我面前跪下
 * @data 2013-11-2 23:15:22
 * 框架集成了七牛，需要手动修改 $qiniuBucket 全局搜索下有2个地方！！！
 */
class Index extends Admin {

    private $upload_dir = 'upload';
    private $crud = '';
    private $img_name = ''; #新图片名称
    private $width = ''; #宽
    private $height = ''; #高

    public function __construct() {
        parent::__construct();
        $this->load->library('Grocery_CRUD');
        $this->crud = new Grocery_CRUD();
        $this->crud->unset_print()->unset_export()->unset_read();
        $this->crud->set_table('shecai_info');
    }

    public function index() {
        redirect('admin/index/index11');
    }

    /**
     * @return 焦点图
     */
    public function index11() {
        $this->crud->set_theme('flexigrid');
        $this->crud->set_subject('（焦点图）');
        $this->crud->where('category', '11');
        $this->crud->columns('img','description');
        $this->crud->display_as(array(
            'img' => '图片(1000*600)',
            'description' =>'多张图片上传'
        ));
        $this->crud->field_type('category', 'hidden', '11');
        $this->crud->fields('img', 'description','category');
        $this->crud->required_fields('img');
        $this->crud->set_field_upload('img', $this->upload_dir);
        
        $output = $this->crud->render();
        
        $output->li = 'index11';
        $this->load->view('admin/index', $output);
    }

#callbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallbackcallback

    /**
     * 
     * @return 排序默认65535
     */
    public function callback_add_field_order_by() {
        return '<input id="field-order_by" name="order_by" type="text" value="65535" maxlength="5">';
    }

    public function tuijian_on_out($primary_key) {
        $this->load->model('admin/index_model');
        return $this->index_model->tuijian_on_out_($primary_key);
    }

    public function tuijian_on_ajax() {
        $id = parent::G('id');
        $this->load->model('admin/index_model');
        $this->index_model->tuijian_on_out_ajax_($id, 1);
        echo json_encode(array('status' => 1));
        exit();
    }

    public function tuijian_out_ajax() {
        $id = parent::G('id');
        $this->load->model('admin/index_model');
        $this->index_model->tuijian_on_out_ajax_($id, 0);
        echo json_encode(array('status' => 1));
        exit();
    }

    public function aaa(){
        
    }
    //put your code here
}

?>
