<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesa_model extends CI_Model {

	public function getMesasTodas(){
		// $this->db->where("estado","1");
		$resultados = $this->db->get("mesa");
		return $resultados->result();
	}

	public function getMesasLibres(){
		$this->db->where("estado","libre");
		$resultados = $this->db->get("mesa");
		return $resultados->result();
	}

	// public function save($data){
	// 	return $this->db->insert("categorias",$data);
	// }
	// public function getCategoria($id){
	// 	$this->db->where("id",$id);
	// 	$resultado = $this->db->get("categorias");
	// 	return $resultado->row();

	// }

	// public function update($id,$data){
	// 	$this->db->where("id",$id);
	// 	return $this->db->update("categorias",$data);
	// }
}
