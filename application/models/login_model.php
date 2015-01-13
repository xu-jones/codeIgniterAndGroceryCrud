<?php

/**
 * @author 在我面前跪下
 * @data 2013-11-4 21:16:23
 */
class login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login_in_($data) {
        $ok = $this->db->get_where('shecai_admin', $data)->num_rows();
        if ($ok) {
            $this->session->set_userdata($data);
        }
    }

    public function change_password_($p) {
        $this->db->query("UPDATE shecai_admin SET user_password='{$p}' WHERE user_name='admin';");
    }

    //put your code here
}

?>
