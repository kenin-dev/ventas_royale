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

	public function editar(){
		$id = $this->input->post('id');
		$tipo_consumo = $this->input->post('tipo_consumo');
		$destino = $this->input->post('destino');

		if (count($this->Pedido_model->buscar_pedido($id)) > 0) {
			$data = array(
				'ped_tipo_consumo' => $tipo_consumo,
				'ped_destino' => $destino
			);

			$editar = $this->Pedido_model->actualizar_consumo_destino($id,$data);
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

	public function pedido_rest(){
		$id_pedido = $this->input->post('pedido');
		$info = $this->Pedido_model->consultar_pedidos_avanzados($id_pedido);
		echo json_encode($info);
	}   

}