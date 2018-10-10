<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VentaTotal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("login")) {
                redirect(base_url());
        }
        $this->load->model("Ventas_model");
    }
    
    public function index() {
        $today = getdate();
        $mon = str_pad($today['mon'], 2, '0', STR_PAD_LEFT);
        $day = str_pad($today['mday'], 2, '0', STR_PAD_LEFT);
        $fecha = sprintf("%s-%s-%s", $today['year'], $mon, $day);
        if($this->input->post('fecha')) {
            $fecha = $this->input->post('fecha');
        }
        $result = $this->Ventas_model->totalVentaDia($fecha);
        $data = [
            'fecha' => $fecha,
            'ventas' => $result
        ];
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/reportes/venta_total",$data);
        $this->load->view("layouts/footer");
    }
}

