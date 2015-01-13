<?php

/**
 * Description of zh_model
 * @author 在我面前跪下
 */
class zh_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    function num_rows_($where, $table = 'shecai_info') {
        return $this->db->get_where($table, $where)->num_rows();
    }

    function result_page_($category, $columns, $limit, $offset=6) {
        $sql = "SELECT $columns FROM shecai_info WHERE category=$category AND tuijian=0 ORDER BY order_by ASC LIMIT $limit,$offset";
        return parent::result($sql);
    }

    /**
     * 
     * @param type $where where
     * @param type $clumns 字段
     * @param type $table 表
     * @param type $limit limit
     * @return type result
     */
    function result_($where = false, $clumns = '*', $table = 'shecai_info') {
        $this->db->select($clumns);
        if ($table == 'shecai_info') {
            $this->db->order_by('order_by', 'asc');
        }
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get($table)->result();
    }

    function catalogs() {
        $this->db->order_by('order_by', 'asc');
        $this->db->where(array('category' => 41, 'tuijian' => 1))->limit(6);
        return $this->db->get('shecai_info')->result();
    }

    /**
     * 
     * @param type $where where
     * @param type $clumns 字段
     * @param type $table 表
     * @param type $limit limit
     * @return type row
     */
    function row_($where, $clumns = '*', $table = 'shecai_info') {
        return $this->db->select($clumns)->get_where($table, $where)->row();
    }

    function insert_($data, $table = 'shecai_info') {
        $this->db->insert($table, $data);
    }

    function tuijian_() {
        $sql = "SELECT id,img,title,time FROM shecai_info WHERE category=32 AND tuijian=1 ORDER BY id DESC LIMIT 6";
        return parent::result($sql);
    }

    public function banner_($cid) {
        return $this->db->get_where('shecai_info', array('category' => $cid))->row();
    }

//    public function three_(){
//        $sql = "SELECT id,title,img,url FROM shecai_info where category=23 AND tuijian=1 ORDER BY order_by asc LIMIT 3";
//        $data['news'] = parent::result($sql);
//        $sql = "SELECT id,title,img,url FROM shecai_info where category=32 ORDER BY order_by asc LIMIT 3";
//        $data['p'] = parent::result($sql);
//        return $data;
//    }
    //put your code here
}
