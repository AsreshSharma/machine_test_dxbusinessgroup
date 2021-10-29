<?php
class Query_model extends CI_Model { 

    
    public function select_limit_offset($table,$offset='0', $limit=1,$type = 'result') {
        $this->db->select('*')->from($table);
        if ($offset != '' && $limit != '') {
            $this->db->limit($limit, $offset);
        }
        $qry = $this->db->get();
        if ($type == 'row') {
            return $qry->row();
        } else {
            return $qry->result();
        }
    } 

    public function select($table,$orderby = '', $ordering = '',$type = 'result') {
        $this->db->select('*')->from($table);
        if ($orderby != '' && $ordering != '') {
            $this->db->order_by($orderby, $ordering);
        }
        $qry = $this->db->get();
        if ($type == 'row') {
            return $qry->row();
        } else {
            return $qry->result();
        }
    } 

    public function select_where($table, $where, $type = 'result', $orderby = '', $ordering = '') {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from($table);
        if ($orderby != '' && $ordering != '') {
            $this->db->order_by($orderby, $ordering);
        }
        $qry = $this->db->get();
        if ($type == 'row') {
            return $qry->row();
        } else {
            return $qry->result();
        }
    } 
    
    public function insert($table, $array) {
        $qry = $this->db->insert($table, $array);
        if ($qry) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        } 
    } 


    public function update($table, $array, $id ,$idname = 'id') {
        $this->db->set($array)->where($idname, $id)->update($table);
        if($this->db->affected_rows()>0){
            return 'true';
        }else{
            return 'false';
        } 
    } 

    public function delete($table, $id, $idname = 'id') {
        $this->db->where($idname, $id)->delete($table);
    }     

}

?>