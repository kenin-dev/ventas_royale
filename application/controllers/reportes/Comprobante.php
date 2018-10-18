<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("login")) {
                redirect(base_url());
        }
        // $this->load->model("Ventas_model");
    }
    
    public function index() {
        
    }

   
}

