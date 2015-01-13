<?php

/**
 * @author 在我面前跪下
 * @data 2013-12-14 21:25:40
 */
class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    protected function row($sql) {
        return $this->db->query($sql)->row();
    }

    protected function result($sql) {
        return $this->db->query($sql)->result();
    }
protected function result_array($sql) {
        return $this->db->query($sql)->result_array();
    }
    protected function update_($sql) {
        $this->db->query($sql);
    }
    //put your code here
}

?>
