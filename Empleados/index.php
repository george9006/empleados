<?php
	require "empleados.php";
?>

<!--index-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>CRUD con PHP Y MYSQL</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

	<div class="container">
		<form action="" method="POST" enctype="multipart/form-data">

			<!--modal bootstrap-->		

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">


					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>

					      <div class="modal-body">
					        	<div class="form-row">
					        		
					        		<input type="hidden" required name="txtID" value="<?php echo $txtID; ?>" placeholder="" id="txt1" require="">

									<div class="form-group col-md-4">
										<label for="">Nombre(s):</label>
										<input type="text" class="form-control <?php echo(isset($error['Nombre']))?"is-invalid":""; ?>" name="txtNombre" required value="<?php echo $txtNombre; ?>" placeholder="" id="txt2" require="">

										<div class="invalid-feedback">
											<?php echo(isset($error['Nombre'])) ? $error['Nombre']: ""; ?>
										</div>
										<br>
									</div>
									
									<div class="form-group col-md-4">
										<label for="">Apellido Paterno:</label>
										<input type="text" class="form-control <?php echo(isset($error['ApellidoP']))?"is-invalid":""; ?>"" name="txtApellidoP" required value="<?php echo $txtApellidoP; ?>" placeholder="" id="txt3" require="">

										<div class="invalid-feedback">
											<?php echo(isset($error['ApellidoP']))?$error['ApellidoP']:""; ?>
										</div>
										<br>
									</div>

									<div class="form-group col-md-4">
										<label for="">Apellido Materno:</label>
										<input type="text" class="form-control <?php echo(isset($error['ApellidoM']))?"is-invalid":""; ?>" name="txtApellidoM" required value="<?php echo $txtApellidoM; ?>" placeholder="" id="txt4" require="">

										<div class="invalid-feedback">
											<?php echo(isset($error['ApellidoM']))?$error['ApellidoM']:""; ?>
										</div>
										<br>
									</div>

									<div class="form-group col-md-12">
										<label for="">Correo:</label>
										<input type="email" class="form-control <?php echo(isset($error['Correo']))?"is-invalid":""; ?>" name="txtCorreo" required value="<?php echo $txtCorreo; ?>" placeholder="" id="txt5" require="">

										<div class="invalid-feedback">
											<?php echo(isset($error['Correo']))?$error['Correo']:""; ?>
										</div>
										<br>
									</div>

									<div class="form-group col-md-12">
										<label for="">Foto:</label>

										<?php if($txtFoto!=""){?>
											<br/>
												<img class="img-thumbnail rounded mx-auto d-block width="100px" src="../Imagenes/<?php echo $txtFoto;?>" />
											<br/>
										<?php } ?>
										<input type="file" class="form-control" accept="image/*" name="txtFoto" value="<?php echo $txtFoto; ?>" placeholder="" id="txt6" require="">
										<br>
									</div>

					        	</div>

					      </div>


					      <div class="modal-footer">
					        
<button value="btnAgregar" <?php echo $accionAgregar;?> class="btn btn-success" type="submit" name="action">Agregar</button>

<button value="btnModificar" <?php echo $accionModificar;?> class="btn btn-warning" type="submit" name="action">Modificar</button>

<button value="btnEliminar" onclick="return Confirmar('Realmente deseas borrar?');" <?php echo $accionEliminar;?> class="btn btn-danger" type="submit" name="action">Eliminar</button>

<button value="btnCancelar" <?php echo $accionCancelar;?> class="btn btn-primary" type="submit" name="action">Cancelar</button>

					      </div>
					    </div>
					  </div>
					</div>

					
					<br/>
					<br/>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					  Agregar registro +
					</button>
					<br/>
					<br/>

		</form>


		<!--Tabla para mostrar datos-->
		<div class="row">
			<table class="table table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th>Foto</th>
						<th>Nombre Completo</th>
						<th>Correo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<!--Recorrer arreglo de la consulta y guardar cada registro en el arreglo "$empleado"-->
				<?php foreach($listaEmpleados as $empleado){ ?>
	
					<tr>
						<td><img class="img-thumbnail" width="100px" src="../Imagenes/<?php echo $empleado['Foto'];?>"/></td>
						<td><?php echo $empleado['Nombre']." ".$empleado['ApellidoP']." ".$empleado['ApellidoM']; ?></td>
						<td><?php echo $empleado['Correo']?></td>
						<td>

							<!--Formulario oculto-->
							<!--Se envia la informacion del registro seleccionado a la misma pagina mediante POST-->
							<!--Los elementos del form Se deben llamar igual que los del otro formulario por que es el nombre que recoera el metodo POST-->
							<form action="" method="POST">

								<input type="hidden" name="txtID" value="<?php echo $empleado['ID'];?>">

								<input type="submit" value="Seleccionar" class="btn btn-info" name="action">
								<button value="btnEliminar" onclick="return Confirmar('Realmente deseas borrar?');" type="submit" class="btn btn-danger" name="action">Eliminar</button>
							</form>
						</td>

					</tr>
				<?php } ?>
			</table>
		</div>


			<?php if($mostrarModal){?>

				<script>
					$('#exampleModal').modal('show');
				</script>

			<?php } ?>

			<script>
				function Confirmar(Mensaje){

					return (confirm(Mensaje))?true:false;
				}

			</script>

	</div>

</body>
</html>