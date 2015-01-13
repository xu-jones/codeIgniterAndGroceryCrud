<?php

/**
 * @author 在我面前跪下
 * @data 2013-11-3 14:40:31
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('admin/login');
    }

    public function login_in() {
        $this->load->library('session');
        $data['user_name'] = $this->input->post('name');
        $data['user_password'] = md5($this->input->post('password'));
        $this->load->model('login_model');
        $this->login_model->login_in_($data);
        if ($this->session->userdata('user_name')) {
            redirect('admin/index');
        } else {
            //$this->session->set_userdata('error','用户名或者密码错误');
            redirect('admin/login');
        }
    }

    public function change_password() {
        $output->li = '';
        $this->load->view('admin/change_password', $output);
    }

    public function change_password_getJSON() {
        $p1 = md5($this->input->get('p1'));
        $p2 = md5($this->input->get('p2'));
        if ($p1 != $p2) {
            echo json_encode(array('code' => -1, 'info' => '两次密码不一致！'));
        } else {
            $this->load->model('login_model');
            $this->login_model->change_password_($p1);
            echo json_encode(array('code' => 1));
        }
        exit();
    }

    public function login_out() {
        $this->load->library('session');
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    //put your code here
}

?>
