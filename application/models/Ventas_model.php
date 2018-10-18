<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model {

	public function getVentas(){
		$this->db->select("v.*,c.nombre,c.ape_paterno,c.ape_materno,tc.nombre as tipocomprobante");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}
	public function getVentasbyDate($fechainicio,$fechafin){
		$this->db->select("v.*,c.nombre,tc.nombre as tipocomprobante");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->where("v.ven_fecha >=",$fechainicio);
		$this->db->where("v.ven_fecha <=",$fechafin);
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->result();
		}else
		{
			return false;
		}
	}

	public function getVenta($id){
		$this->db->select("v.*,c.nombre,c.direccion,c.telefono,c.num_documento as documento,tc.nombre as tipocomprobante");
		$this->db->from("ventas v");
		$this->db->join("clientes c","v.cliente_id = c.id");
		$this->db->join("tipo_comprobante tc","v.tipo_comprobante_id = tc.id");
		$this->db->where("v.id",$id);
		$resultado = $this->db->get();
		return $resultado->row();
	}

	public function getDetalle($id){
		$this->db->select("dt.*,p.codigo,p.nombre");
		$this->db->from("detalle_venta dt");
		$this->db->join("productos p","dt.producto_id = p.id");
		$this->db->where("dt.venta_id",$id);
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function getComprobantes(){
		$resultados = $this->db->get("tipo_comprobante");
		return $resultados->result();
	}

	public function getComprobante($idcomprobante){
		$this->db->where("id",$idcomprobante);
		$resultado = $this->db->get("tipo_comprobante");
		return $resultado->row();
	}

	public function getproductos($valor){
		$this->db->select("id,codigo,nombre as label,precio,stock");
		$this->db->from("productos");
		$this->db->like("nombre",$valor);
		$resultados = $this->db->get();
		return $resultados->result_array();
	}

	public function save($data){
		return $this->db->insert("ventas",$data);
	}

	public function guardar_pedido($pedido){
		return $this->db->insert("ventas",$pedido);
	}

	public function guardar_pedido_detalle($data){
		
		if ($this->db->insert("detalle_venta",$data)) {
			return 1;
		}else{
			return 0;
		}
	}

	public function lastID(){
		return $this->db->insert_id();
	}

	public function updateComprobante($idcomprobante,$data){
		$this->db->where("id",$idcomprobante);
		$this->db->update("tipo_comprobante",$data);
	}

	public function save_detalle($data){
		$this->db->insert("detalle_venta",$data);
	}

	public function years(){
		$this->db->select("YEAR(ven_fecha) as year");
		$this->db->from("ventas");
		$this->db->group_by("year");
		$this->db->order_by("year","desc");
		$resultados = $this->db->get();
		return $resultados->result();
	}

	public function montos($year){
		$this->db->select("MONTH(ven_fecha) as mes, SUM(ven_total) as monto");
		$this->db->from("ventas");
		$this->db->where("ven_fecha >=",$year."-01-01");
		$this->db->where("ven_fecha <=",$year."-12-31");
		$this->db->group_by("mes");
		$this->db->order_by("mes");
		$resultados = $this->db->get();
		return $resultados->result();
	}
        
    public function totalVentaDia($fecha) {
        $query = $this->db->query("CALL sp_TotalVentasDia('$fecha')");
        $result = $query->result();
//      $query->next_result();
		$query->free_result();
        return $result;
    }

    public function delete($id){

    	$sql = "DELETE FROM ventas WHERE ventas.id = '$id'";
    	//$del = $this->query($sql);
    	if ($del = $this->db->query($sql)) {
    		return 1;
    	}else{
    		return 0;
    	}

    }

    public function verificar($id){

    	$sql = "SELECT * FROM ventas WHERE ventas.id = '$id'";
    	$query = $this->db->query($sql);
    	return $query->result();
    }

    public function delete_detalle($id){
  		$sql = "DELETE FROM detalle_venta WHERE detalle_venta.venta_id = '$id'";
  		$query = $this->db->query($sql);
  		return $query;  	
    }

    public function info_venta($id){

    	$sql = "call pa_venta_info($id)";
    	$consulta = $this->db->query($sql);
    	return $consulta->result();
    }

    public function get_ventas(){
    	$sql = "SELECT v.id as 'venta_id',v.fecha as 'venta_fecha',v.subtotal as 'venta_subtotal',v.tipo_consumo as 'venta_tipo_consumo',v.destino as 'venta_destino',v.estado as 'venta_estado' FROM ventas v 
    	WHERE v.estado = 'venta'";
    	$consulta = $this->db->query($sql);
    	return $consulta->result();
    }

    public function get_pedidos(){
    	$sql = "SELECT v.id as 'venta_id',v.fecha as 'venta_fecha',v.subtotal as 'venta_subtotal',v.tipo_consumo as 'venta_tipo_consumo',v.destino as 'venta_destino',v.estado as 'venta_estado' FROM ventas v 
    	WHERE v.estado = 'pedido'";
    	$consulta = $this->db->query($sql);
    	return $consulta->result();

    }
    public function get_pedidos_id($id){
    	$sql = "SELECT v.id as 'venta_id',v.fecha as 'venta_fecha',v.subtotal as 'venta_subtotal',v.tipo_consumo as 'venta_tipo_consumo',v.destino as 'venta_destino',v.estado as 'venta_estado' FROM ventas v 
    	WHERE v.estado = 'pedido' AND v.id = '$id'";
    	$consulta = $this->db->query($sql);
    	return $consulta->result();

    }

    //METODOS NUEVOS
    public function insertar_venta($data){
		return $this->db->insert("ventas",$data);
	}

	public function consultar_ventas(){
    	$sql = "select v.ven_id,v.ven_fecha,v.ven_igv,v.ven_descuento,v.ven_total,v.ven_total,v.tipo_comprobante_id,v.num_documento,v.serie,v.ven_monto_recibido,v.ven_monto_devuelto,p.ped_tipo_consumo,p.ped_subtotal,p.ped_destino,concat(c.nombre,' ',c.ape_paterno,' ',c.ape_materno) as 'cli_nombres' from ventas v INNER JOIN pedido p ON v.pedido_id = p.ped_id INNER JOIN clientes c ON v.cliente_id = c.id";
		$resultado = $this->db->query($sql);
		return $resultado->result();
    }

    public function consultar_ventas_avanzado($id){
    	$sql = "CALL pa_venta_info('$id')";
		$resultado = $this->db->query($sql);
		return $resultado->result();
    }
}