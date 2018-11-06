<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Pedido_model");
        $this->load->model('Categorias_model');
        $this->load->model('Mesa_model');
		// $this->load->model("Productos_model");
	}

	public function index(){

		$this->listar();
	}


	public function listar(){
		$data  = array(
			'pedidos' => $this->Pedido_model->consultar_pedidos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pedido/listar",$data);
		$this->load->view("layouts/footer");
	}

	public function nuevo(){
		$data = array(
			"categorias" => $this->Categorias_model->getCategorias()
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/pedido/registrar",$data);
		$this->load->view("layouts/footer");
	}

	public function agregar(){
		// Pedido
		$fecha = $this->input->post("fecha");
		$subtotal = $this->input->post("subtotal");
		$tipo_consumo = $this->input->post('tipo_consumo');
		$destino = $this->input->post('destino');
		$estado = 'pendiente';

		// Detalle
		$productos = $this->input->post("idproductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$detalles = $this->input->post("detalles");

		$pedido = array(
			'ped_fecha' => $fecha,
			'ped_subtotal' => $subtotal,
			'ped_tipo_consumo' => $tipo_consumo,
			'ped_destino' => $destino,
			'ped_estado' => $estado
		);
		if ($this->Pedido_model->insertar_pedido($pedido)) {
			$pedido_id = $this->Pedido_model->recuperarID();
			
			$cont = 0;
			for ($i=0; $i < count($productos); $i++) { 
				$detalle  = array(
					'pedido_id' => $pedido_id,
					'producto_id' => $productos[$i], 
					'dp_precio' => $precios[$i],
					'dp_cantidad' => $cantidades[$i],
					'dp_importe'=> $importes[$i],
					'dp_detalle'=> $detalles[$i]
				);

				if ($this->Pedido_model->insertar_detalle_pedido($detalle) == 1) {
					$cont++;
				}
			}

			if (count($productos) == $cont) {
				redirect(base_url()."movimientos/pedido/listar");
			}else{
				redirect(base_url()."movimientos/ventas/add");
			}

		}else{
			echo "La venta no se pudo registrar";
		}

	}

	public function eliminar($id=null){
		if (is_null($id)) {
			$this->session->set_flashdata('error', 'pedido no especificado!');
		}else{
			if ($this->Pedido_model->eliminar_pedido($id)) {
				$this->Pedido_model->eliminar_detalle_pedido($id);
				$this->session->set_flashdata('correcto', 'pedido eliminado correctamente!');

			}else{
				$this->session->set_flashdata('error', 'el pedido no se pudo eliminar, intente de nuevo.!');
			}
		}
		redirect('movimientos/pedido/listar','refresh');

	}

	public function editar($id = null){
		if (is_null($id)) {
			echo "Especifique un pedido";
		}else{
			
			$pedido = $this->Pedido_model->buscar_pedido($id);
			if (count($pedido) > 0) {

				$pedido_detalle = $this->Pedido_model->consultar_detalle_pedidos($id);
				$mesas = $this->Mesa_model->getMesasTodas();
				$data = array(
					'pedido' => $pedido,
					'detalle' => $pedido_detalle,
					'mesa' => $mesas

				);
				$this->load->view("layouts/header");
				$this->load->view("layouts/aside");
				$this->load->view("admin/pedido/editar",$data);
				$this->load->view("layouts/footer");

			}else{
				echo "Pedido no encontrado : ".$id;
			}

		}
	}

	public function actualizar(){
		$id = $this->input->post('id');
		$tipo_consumo = $this->input->post('tipo_consumo');
		$destino = $this->input->post('destino');

		if (count($this->Pedido_model->buscar_pedido($id)) > 0) {
			$data = array(
				'ped_tipo_consumo' => $tipo_consumo,
				'ped_destino' => $destino
			);

			$editar = $this->Pedido_model->actualizar($id,$data);
			if ($editar > 0) {
				$this->session->set_flashdata('correcto', 'Pedido modificado correctamente!');
			}else{
				$this->session->set_flashdata('error', 'el proceso edicion no se completo.!');

			}
			redirect('movimientos/pedido/listar','refresh');

		}else{
			echo "pedido no encontrado";
		}
	}



// Funciones Rest

	public function pedido_rest(){
		$id_pedido = $this->input->post('pedido');
		$info = $this->Pedido_model->consultar_pedidos_avanzados($id_pedido);
		echo json_encode($info);
	}   

	public function pedido_info_rest(){
		$id = $this->input->post('id');
		$pedido = $this->Pedido_model->buscar_pedido($id);
		if (count($pedido) > 0) {
			echo json_encode($pedido);
		}else{
			echo "false";
		}
	}

	public function pedido_detalle_info_rest(){
		$id = $this->input->post('id');
		$pedido_detalle = $this->Pedido_model->consultar_detalle_pedidos($id);
		echo json_encode($pedido_detalle);
	}

	public function actualizar_tipo_consumo_rest(){
		$id = $this->input->post('id');
		$tipo_consumo = $this->input->post('tipo');
		$destino = $this->input->post('destino');
		$data = array(
			'ped_tipo_consumo' => $tipo_consumo,
			'ped_destino' => $destino
		);
		$actualizar = $this->Pedido_model->actualizar($id,$data);

		echo json_encode($actualizar);
	}

	public function eliminar_detalle_rest(){
		$id_pedido  = $this->input->post('id_pedido'); 
		$id_detalle = $this->input->post('id_detalle');
		$subtotal   = $this->input->post('n_subtotal');
		$data = array(
			'ped_subtotal' => $subtotal
		);
		// echo $id_pedido.' '.$id_detalle.' '.$subtotal;

		$eliminar = $this->Pedido_model->eliminar_pedido_producto($id_detalle);
		if ($eliminar > 0) {
			$actualizar_pedido = $this->Pedido_model->actualizar($id_pedido,$data);
			echo json_encode($actualizar_pedido);
		}else{
			echo json_encode($eliminar);	
		}
		// echo json_encode($eliminar);
	}

}