<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("login")) {
                redirect(base_url());
        }
        $this->load->model("Ventas_model");
    }
    
    public function index() {
        
    }

    public function pedido_registro_exito($id){

        $this->load->model("Ventas_model");
        $pedido = $this->Ventas_model->get_pedidos_id($id);
        // echo json_encode($pedido);
        $data = array(
            "pedido" => $pedido,
        );

        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/mensajes/pedido_impresion",$data);
        $this->load->view("layouts/footer");
    }
}

