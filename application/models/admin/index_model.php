<?php

/**
 * Description of index_
 * @author 在我面前跪下
 * @data 2013-11-25 16:00:32 
 */
class Index_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    function result_($where,$columns='*',$table='shecai_info'){
        return $this->db->select($columns)->get_where($table,$where)->result();
    }
    function row_($where,$columns='*',$table='shecai_info'){
        return $this->db->select($columns)->get_where($table,$where)->row();
    }
    /**
 *@return 初始化推荐
 */
    public function tuijian_on_out_($id, $table = 'shecai_info') {
        $tuijian = $this->db->select('tuijian')->get_where($table, array('id' => $id))->row();
        if ($tuijian->tuijian) {
            return 'javascript:tuijian_out(' . $id . ');';
        } else {
            return 'javascript:tuijian_on(' . $id . ');';
        }
    }
/**
 *@return 修改推荐状态
 */
    public function tuijian_on_out_ajax_($id,$tuijian){
        $sql = "UPDATE shecai_info SET tuijian=$tuijian WHERE id = $id;";
        $this->db->query($sql);
    }
    //put your code here
}

?>
