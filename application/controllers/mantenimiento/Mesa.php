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
			'clientes' => $this->Clientes_model->getClientes(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/clientes/list",$data);
		$this->load->view("layouts/footer");

	}

	public function get_mesas_rest(){

		$mesas = $this->Mesa_model->getMesasTodas();
		echo json_encode($mesas);

	}
}