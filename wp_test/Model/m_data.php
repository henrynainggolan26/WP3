<?php
	class M_data extends CI_Model{
		function show_data(){
			return $this->db->get('user');
		}
		function input_data($data, $table){
			$this->db->insert($table, $data);
		}
	}
?>