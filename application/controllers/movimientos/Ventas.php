<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata("login")) {
			redirect(base_url());
		}
		$this->load->model("Ventas_model");
		$this->load->model("Clientes_model");
		$this->load->model("Productos_model");
        $this->load->model('Categorias_model');
        $this->load->model('Pedido_model');
	}

	public function index(){
		// $data  = array(
		// 	'ventas' => $this->Ventas_model->getVentas(), 
		// );
		// $this->load->view("layouts/header");
		// $this->load->view("layouts/aside");
		// $this->load->view("admin/ventas/list",$data);
		// $this->load->view("layouts/footer");
		$this->listar();
	}

	public function ver_ventas(){
		$data  = array(
			'ventas' => $this->Ventas_model->get_ventas(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/list",$data);
		$this->load->view("layouts/footer");
		// redirect('movimientos/ventas','refresh');
	}

	public function ver_pedidos(){
		$data  = array(
			'ventas' => $this->Ventas_model->get_pedidos(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/list_pedido",$data);
		$this->load->view("layouts/footer");
	}

	public function add(){
		$data = array(
			"tipocomprobantes" => $this->Ventas_model->getComprobantes(),
			"tipoclientes" => $this->Clientes_model->getTipoClientes(),
			"tipodocumentos" => $this->Clientes_model->getTipoDocumentos(),
			"clientes" => $this->Clientes_model->getClientes(),
                    "categorias" => $this->Categorias_model->getCategorias(),
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/add",$data);
		$this->load->view("layouts/footer");
	}

	public function getproductos(){
		$valor = $this->input->post("valor");
		$clientes = $this->Ventas_model->getproductos($valor);
		echo json_encode($clientes);
	}
        
        public function getproductosCategoria(){
            $valor = $this->input->post("valor");
            $productos = $this->Productos_model->getproductosCategoria($valor);
            echo json_encode($productos);
	}
	public function add_pedido(){
		// Pedido
		$fecha = $this->input->post("fecha");
		$subtotal = $this->input->post("subtotal");
		$igv = '';
		$descuento = '';
		$total = '';
		$idcomprobante = '';
		$idcliente = '';
		$idusuario = '';
		$num_documento = '';
		$serie = '';
		$tipo_consumo = $this->input->post('tipo_consumo');
		$destino = $this->input->post('destino');
		$estado = 'pedido';

		// Detalle
		$productos = $this->input->post("idproductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$detalles = $this->input->post("detalles");

		$pedido = array(
			'fecha' => $fecha,
			'subtotal' => $subtotal,
			'igv' => $igv,
			'descuento' => $descuento,
			'total' => $total,
			'tipo_comprobante_id' => $idcomprobante,
			'cliente_id' => $idcliente,
			'usuario_id' => $idusuario,
			'num_documento' => $num_documento,
			'serie' => $serie,
			'tipo_consumo' => $tipo_consumo,
			'destino' => $destino,
			'estado' => $estado
		);
		if ($this->Ventas_model->guardar_pedido($pedido)) {
			$venta = $this->Ventas_model->lastID();
			
			$cont = 0;
			for ($i=0; $i < count($productos); $i++) { 
				$detalle  = array(
					'producto_id' => $productos[$i], 
					'venta_id' => $venta,
					'precio' => $precios[$i],
					'cantidad' => $cantidades[$i],
					'importe'=> $importes[$i],
					'detalle'=> $detalles[$i]
				);

				// $this->Ventas_model->save_detalle($data);
				// $this->updateProducto($productos[$i],$cantidades[$i]);

				if ($this->Ventas_model->guardar_pedido_detalle($detalle) == 1) {
					// redirect(base_url()."movimientos/ventas");
					$cont++;

				}
			}
			if (count($productos) == $cont) {
				redirect(base_url()."movimientos/ventas/ver_pedidos");
			}else{
				redirect(base_url()."movimientos/ventas/add");
			}
			// echo count($productos).'-'.$cont;

		}else{
			echo "La venta no se pudo registrar";
		}

	}

	public function store(){
		$fecha = $this->input->post("fecha");
		$subtotal = $this->input->post("subtotal");
		$igv = $this->input->post("igv");
		$descuento = $this->input->post("descuento");
		$total = $this->input->post("total");
		$idcomprobante = $this->input->post("idcomprobante");
		$idcliente = $this->input->post("idcliente");
		$idusuario = $this->session->userdata("id");
		$numero = $this->input->post("numero");
		$serie = $this->input->post("serie");

		$idproductos = $this->input->post("idproductos");
		$precios = $this->input->post("precios");
		$cantidades = $this->input->post("cantidades");
		$importes = $this->input->post("importes");
		$detalles = $this->input->post("detalles");

		$data = array(
			'fecha' => $fecha,
			'subtotal' => $subtotal,
			'igv' => $igv,
			'descuento' => $descuento,
			'total' => $total,
			'tipo_comprobante_id' => $idcomprobante,
			'cliente_id' => $idcliente,
			'usuario_id' => $idusuario,
			'num_documento' => $numero,
			'serie' => $serie
                    
		);

		if ($this->Ventas_model->save($data)) {
			$idventa = $this->Ventas_model->lastID();
			$this->updateComprobante($idcomprobante);
			$this->save_detalle($idproductos,$idventa,$precios,$cantidades,$importes,$detalles);
			redirect(base_url()."movimientos/ventas");

		}else{
			redirect(base_url()."movimientos/ventas/add");
		}
	}

	protected function save_detalle($productos,$idventa,$precios,$cantidades,$importes,$detalles){
		for ($i=0; $i < count($productos); $i++) { 
			$data  = array(
				'producto_id' => $productos[$i], 
				'venta_id' => $idventa,
				'precio' => $precios[$i],
				'cantidad' => $cantidades[$i],
				'importe'=> $importes[$i],
				'detalle'=> $detalles[$i]
			);

			$this->Ventas_model->save_detalle($data);
			$this->updateProducto($productos[$i],$cantidades[$i]);

		}
	}
	protected function updateComprobante($idcomprobante){
		$comprobanteActual = $this->Ventas_model->getComprobante($idcomprobante);
		$data  = array(
			'cantidad' => $comprobanteActual->cantidad + 1, 
		);
		$this->Ventas_model->updateComprobante($idcomprobante,$data);
	}


	protected function updateProducto($idproducto,$cantidad){
		$productoActual = $this->Productos_model->getProducto($idproducto);
		$data = array(
			'stock' => $productoActual->stock - $cantidad, 
		);
		$this->Productos_model->update($idproducto,$data);
	}

	public function view(){
		$idventa = $this->input->get("id");
		$data = array(
			"venta" => $this->Ventas_model->getVenta($idventa),
			"detalles" =>$this->Ventas_model->getDetalle($idventa)
		);
		$this->load->view("admin/ventas/view",$data);
	}

	public function delete($id){

		if( $this->session->userdata('id')!=null ){

			//$id = $this->input->post('id');
			
			if (strlen($id)>0) {
			
				$this->load->model('Ventas_model');
				$verificar = $this->Ventas_model->verificar($id);
				//echo count($verificar);

				if (count($verificar)>0) {
					$eliminar_det = $this->Ventas_model->delete_detalle($id);
					if ($eliminar_det) {
						$eliminar = $this->Ventas_model->delete($id);
						//echo $eliminar_det;
						redirect(base_url().'movimientos/ventas','refresh');
					}else{
						//echo "error al eliminar";
					}
				}else{
					//echo "la venta no existe";
				}
			}else{

				//echo "datos incompletos";
			}
			redirect(base_url().'movimientos/ventas', 'refresh');

		}else{



		}

	}


	/*METODOS NUEVOS*/
    public function registrar($id = null){
    	if (is_null($id)) {
    		$this->session->set_flashdata('error', 'no se especifico el pedido.');
    		redirect('movimientos/pedido/listar','refresh');
    	}else{

    		$pedido = $this->Pedido_model->buscar_pedido($id);
    		if (count($pedido) > 0) {
    			$data = array(
    				"tipocomprobantes" => $this->Ventas_model->getComprobantes(),
    				"pedido" => $pedido,
					"tipoclientes" => $this->Clientes_model->getTipoClientes(),
					"tipodocumentos" => $this->Clientes_model->getTipoDocumentos(),
					"clientes" => $this->Clientes_model->getClientes()
    			);

    			$this->load->view("layouts/header");
				$this->load->view("layouts/aside");
				$this->load->view("admin/ventas/registrar",$data);
				$this->load->view("layouts/footer");
    			
    		}else{
    			
    			$this->session->set_flashdata('error', 'El pedido no existe.');
    			redirect('movimientos/pedido/listar','refresh');
    		}
    	}
    }

    public function agregar_venta(){

    	//$this->updateComprobante($idcomprobante);

    	$id_pedido = $this->input->post('id_pedido');
    	$id_cliente = $this->input->post("cliente_id");
		$id_usuario = $this->session->userdata("id");
    	$fecha = $this->input->post('fecha');
    	$igv = $this->input->post('igv');
    	$descuento = $this->input->post('descuento');
    	$total = $this->input->post('total');
    	$tcomp_valor = explode("-",$this->input->post('tipo_comprobante'));
    	$tipo_comprobante = $tcomp_valor[0];
    	$num_documento = $this->input->post('numero');
    	$serie = $this->input->post('serie');
    	$recibido = $this->input->post('recibido');
    	$devuelto = $this->input->post('devuelto');

    	$venta = array(
			'pedido_id' => $id_pedido,
			'cliente_id' => $id_cliente,
			'usuario_id' => $id_usuario,
			'ven_fecha' => $fecha,
			'ven_igv' => $igv,
			'ven_descuento' => $descuento,
			'ven_total' => $total,
			'tipo_comprobante_id' => $tipo_comprobante,
			'num_documento' => $num_documento,
			'serie' => $serie,
			'ven_monto_recibido' => $recibido,
            'ven_monto_devuelto' => $devuelto       
		);

		// print_r($venta);
		if ($this->Ventas_model->insertar_venta($venta)) {
			$this->updateComprobante($tipo_comprobante);
			$pedido_fin = $this->Pedido_model->FinalizarPedido($id_pedido);
			if ($pedido_fin == 1) {
				$this->session->set_flashdata('correcto', 'Venta Registrada Correcamente');
				// redirect('movimientos/ventas','refresh');
			}else{
				$this->session->set_flashdata('error', 'Proceso completado al 80%!');
			}
			redirect('movimientos/ventas','refresh');
		}else{
			$this->session->set_flashdata('error', 'El proceso no se pudo completar.!');
			redirect('movimientos/ventas','refresh');
		}
    }	

    public function listar(){
    	$data  = array(
			'ventas' => $this->Ventas_model->consultar_ventas(), 
		);
		$this->load->view("layouts/header");
		$this->load->view("layouts/aside");
		$this->load->view("admin/ventas/listar",$data);
		$this->load->view("layouts/footer");
    }

    public function venta_rest(){
		$id_venta = $this->input->post('venta');
		$info = $this->Ventas_model->consultar_ventas_avanzado($id_venta);
		echo json_encode($info);
	} 
        

}