
<div class="row">
	<div class="col-xs-12 text-center">
		<b>Empresa de Ventas</b><br>
		Calle Moquegua 430 <br>
		Tel. 481890 <br>
		Email:
	</div>
</div> <br>
<div class="row">
	<div class="col-xs-6">	
		<b>CLIENTE</b><br>
		<b>NOMBRE:</b> <?php echo $venta->nombre;?> <br>
		<b>DNI:</b> <?php echo $venta->documento;?><br>
		<b>TELEFONO:</b> <?php echo $venta->telefono;?> <br>
		<b>DIRECCION</b> <?php echo $venta->direccion;?><br>
	</div>	
	<div class="col-xs-6">	
		<b>COMPROBANTE</b> <br>
		<b>COMPROBANTE:</b> <?php echo $venta->tipocomprobante;?><br>
		<b>SERIE:</b> <?php echo $venta->serie;?><br>
		<b>Nro°:</b><?php echo $venta->num_documento;?><br>
		<b>FECHA</b> <?php echo $venta->fecha;?>
	</div>	
</div>
<br>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					
					<th>NOMBRE</th>
					<th>PRECIO</th>
					<th>CANTIDAD</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($detalles as $detalle):?>
				<tr>
					
					<td><?php echo $detalle->nombre;?></td>
					<td><?php echo $detalle->precio;?></td>
					<td><?php echo $detalle->cantidad;?></td>
					<td><?php echo $detalle->importe;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" class="text-right"><strong>SUBTOTAL:</strong></td>
					<td><?php echo $venta->subtotal;?></td>
				</tr>
				<tr>
					<td colspan="4" class="text-right"><strong>IGV:</strong></td>
					<td><?php echo $venta->igv;?></td>
				</tr>
				<tr>
					<td colspan="4" class="text-right"><strong>DESCUENTO:</strong></td>
					<td><?php echo $venta->descuento;?></td>
				</tr>
				<tr>
					<td colspan="4" class="text-right"><strong>TOTAL:</strong></td>
					<td><?php echo $venta->total;?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>