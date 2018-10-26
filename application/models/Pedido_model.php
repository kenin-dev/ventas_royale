<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_model extends CI_Model {
	
	public function insertar_pedido($data){
		return $this->db->insert("pedido",$data);
	}

	public function insertar_detalle_pedido($data){
		if ($this->db->insert("detalle_pedido",$data)) {
			return 1;
		}else{
			return 0;
		}
	}

	public function consultar_pedidos(){
		$sql = "select * from pedido p where p.ped_estado = 'pendiente'";
		$resultado = $this->db->query($sql);
		return $resultado->result();
	}

	public function consultar_pedidos_avanzados($id){
		$sql = "call pa_pedido_buscar('$id')";
		$resultado = $this->db->query($sql);
		return $resultado->result();
	}

	public function eliminar_pedido($id){
		$sql = "delete from pedido where ped_id='$id'";
		$eliminar = $this->db->query($sql);
		return $eliminar;
	}
	public function eliminar_detalle_pedido($id){
		$sql = "delete from detalle_pedido where pedido_id='$id'";
		$eliminar = $this->db->query($sql);
		return $eliminar;
	}

	public function recuperarID(){
		return $this->db->insert_id();
	}

	public function buscar_pedido($id){
		$sql = "select * from pedido p where p.ped_id='$id'";
		$pedido = $this->db->query($sql);
		return $pedido->row();
	}

	public function actualizar_consumo_destino($id,$data){
		$this->db->where("ped_id",$id);
		$this->db->update("pedido",$data);
		return $this->db->affected_rows();
	}

	public function FinalizarPedido($id){
		$sql = "UPDATE pedido p set p.ped_estado='finalizado' WHERE p.ped_id='$id'";
		if ($this->db->query($sql)) {
			return 1;
		}else{
			return 0;
		}

	}
}