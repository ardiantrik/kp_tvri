<?php
    class MainModel extends CI_Model{
        public function __construct(){
            parent::__construct();
        }

        public function insertData($tabelName,$data)
        {
            $res = $this->db->insert($tabelName,$data);
            return $res;
        }

        public function selectAllData($tabelName)
        {
        	$this->db->select("*");
        	$this->db->from($tabelName);
        	$data = $this->db->get();
        	return $data->result_array();
        }

        public function selectSpecify($tabelName,$where)
        {
            $data = $this->db->get_where($tabelName,$where);
            return $data->result_array();
        }

        public function updateData($tabelName,$data,$where)
        {
            $this->db->where($where);
            $this->db->update($tabelName,$data);
            if($this->db->affected_rows() == 1){
                return true; //add your code here
              }else{
                return false; //add your your code here
              }
        }

        public function deleteData($tabelName,$where)
        {
            $res = $this->db->delete($tabelName,$where);
            return $res;
        }

        public function queryGetHelper($sql)
        {
            $res = $this->db->query($sql);
            return $res->result_array();
        }

        
    }
?>