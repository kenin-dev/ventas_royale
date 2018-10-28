<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VentaTotal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("login")) {
                redirect(base_url());
        }
        $this->load->model("Ventas_model");
        $this->load->model("Pedido_model");
    }
    
    public function index() {
        // $today = getdate();
        // $mon = str_pad($today['mon'], 2, '0', STR_PAD_LEFT);
        // $day = str_pad($today['mday'], 2, '0', STR_PAD_LEFT);
        // $fecha = sprintf("%s-%s-%s", $today['year'], $mon, $day);
        // if($this->input->post('fecha')) {
        //     $fecha = $this->input->post('fecha');
        // }
        $fecha = $this->input->get('fecha');

        if (!isset($fecha)) {
            $fecha = date("Y-m-d");
        }
        // $productos = $this->Ventas_model->totalVentaDia($fecha);
        // $ventas = $this->Ventas_model->getVentasActual($fecha);
        $data = array(
            'fecha' => $fecha,
            'productos' => $this->Ventas_model->totalVentaDia($fecha),
            // 'ventas' => $this->Ventas_model->getVentasActual($fecha)
        );
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/reportes/venta_total",$data);
        $this->load->view("layouts/footer");
    }
}

