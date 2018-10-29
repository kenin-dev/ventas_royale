<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Mesa_model");
	}

	public function index()
	{
		$data  = array(
			'mesas' => $this->Mesa_model->getMesasTodas(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/mesas/listar",$data);
		$this->load->view("layouts/footer");

	}

	public function get_mesas_rest(){

		$mesas = $this->Mesa_model->getMesasTodas();
		echo json_encode($mesas);

	}

	public function listar(){
		$mesas = $this->Mesa_model->getMesasTodas();
	}

	public function nuevo(){
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/mesas/registrar");
		$this->load->view("layouts/footer");
	}

	public function agregar(){
		$nombre = $this->input->post('numero');
		$descripcion = $this->input->post('descripcion');
		$estado = 'activo';

		$data = array(
			'mesa_numero' => $nombre,
			'mesa_descripcion' => $descripcion,
			'mesa_estado' => $estado
		);

		$agregar = $this->Mesa_model->insertar($data);
		if (count($agregar) > 0) {
			$this->session->set_flashdata('correcto', 'Mesa agregada correctamente!');
		}else{
			$this->session->set_flashdata('error', 'El registro no se pudo completar');
		}

		redirect('mantenimiento/mesa','refresh');

	}

	public function eliminar($id = null){
		if (is_null($id)) {
			$this->session->set_flashdata('error', 'Mesa no especificada');
			redirect('mantenimiento/mesa','refresh');
		}

		$eliminar = $this->Mesa_model->remover($id);
		if (count($eliminar) > 0) {
			$this->session->set_flashdata('correcto', 'Mesa eliminada correctamente');
		}else{
			$this->session->set_flashdata('error', 'El proceso no se pudo completar!');
		}

		redirect('mantenimiento/mesa','refresh');
	}

	public function editar($id = null){
		if (is_null($id)) {
			$this->session->set_flashdata('error', 'Mesa no especificada');
			redirect('mantenimiento/mesa','refresh');
		}

		$mesa = $this->Mesa_model->consultar_mesa($id);
		if (count($mesa) > 0) {
			$data = array(
				'mesa' => $mesa,
			);
			$this->load->view("layouts/header");
			$this->load->view("layouts/aside");
			$this->load->view("admin/mesas/editar",$data);
			$this->load->view("layouts/footer");
		}else{
			$this->session->set_flashdata('error', 'Mesa no encontrada');
			redirect('mantenimiento/mesa','refresh');
		}

	}

	public function actualizar(){
		$id = $this->input->post('id');
		$nombre = $this->input->post('numero');
		$descripcion = $this->input->post('descripcion');
		$estado = 'activo';

		$data = array(
			'mesa_numero' => $nombre,
			'mesa_descripcion' => $descripcion,
			'mesa_estado' => $estado
		);
		$actualizar = $this->Mesa_model->update($id,$data);
		if (count($actualizar) > 0) {
			$this->session->set_flashdata('correcto', 'Edicion completada');
		}else{
			$this->session->set_flashdata('error', 'El proceso no se pudo completar!');
		}
		redirect('mantenimiento/mesa','refresh');
	}


}