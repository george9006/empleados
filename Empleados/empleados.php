<?php

//Recoger datos del formulario mediante metodo POST...

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellidoP=(isset($_POST['txtApellidoP']))?$_POST['txtApellidoP']:"";
$txtApellidoM=(isset($_POST['txtApellidoM']))?$_POST['txtApellidoM']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtFoto=(isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

//Existe un boton con nombre "action" ?
$action=(isset($_POST['action']))?$_POST['action']:"";


$error=array();

$accionAgregar="";
$accionModificar=$accionEliminar=$accionCancelar="disabled";
$mostrarModal=false;

//Conexión
include("../Conexion/conexion.php");

//Identificar que boton de pulsó
switch ($action) {

	case 'btnAgregar':


		//Validacion del lado del servidor
		if($txtNombre==""){
			$error['Nombre']="Escribre el nombre";
		}

		if($txtApellidoP==""){
			$error['ApellidoP']="Escribre el apellido paterno";
		}

		if($txtApellidoM==""){
			$error['ApellidoM']="Escribre el apellido materno";
		}

		if($txtCorreo==""){
			$error['Correo']="Escribre correo";
		}


		if(count($error)>0){
			$mostrarModal=true;
			break;
		}

		//Consulta "insertar"
		$sentencia=$pdo->prepare("INSERT INTO empleados(Nombre,ApellidoP,ApellidoM,Correo,Foto) VALUES(:Nombre,:ApellidoP,:ApellidoM,:Correo,:Foto) ");

		//Referenciar los valores mediante PDO
		//Datos obtenidos del formulario ->>> referencia
			$sentencia->bindParam(':Nombre',$txtNombre);
			$sentencia->bindParam(':ApellidoP',$txtApellidoP);
			$sentencia->bindParam(':ApellidoM',$txtApellidoM);
			$sentencia->bindParam(':Correo',$txtCorreo);

			$Fecha=new DateTime();
			$nombreArchivo=($txtFoto!="")?$Fecha->getTimeStamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jfif";

			$tmpFoto= $_FILES["txtFoto"]["tmp_name"];

			if($tmpFoto!=""){

				move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);
			}

			$sentencia->bindParam(':Foto',$nombreArchivo);


			//Ejecutar consulta
			$sentencia->execute();

			header('Location:index.php');


		break;
	
	case 'btnModificar':

			//Consulta "Modificar"
		$sentencia=$pdo->prepare("UPDATE empleados SET 
			Nombre=:Nombre,
			ApellidoP=:ApellidoP,
			ApellidoM=:ApellidoM,
			Correo=:Correo WHERE
			id=:id");


			

		//Referenciar los valores mediante PDO
		//Datos obtenidos del formulario ->>> referencia
			$sentencia->bindParam(':Nombre',$txtNombre);
			$sentencia->bindParam(':ApellidoP',$txtApellidoP);
			$sentencia->bindParam(':ApellidoM',$txtApellidoM);
			$sentencia->bindParam(':Correo',$txtCorreo);
		
			$sentencia->bindParam('id',$txtID);
			

			//Ejecutar consulta
			$sentencia->execute();


			$Fecha=new DateTime();
			$nombreArchivo=($txtFoto!="")?$Fecha->getTimeStamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jfif";

			$tmpFoto= $_FILES["txtFoto"]["tmp_name"];


			//Modificar la foto 

			if($tmpFoto!=""){

				move_uploaded_file($tmpFoto,"../Imagenes/".$nombreArchivo);


				//Eliminar la imagen anterior en el servidor
				$sentencia=$pdo->prepare("SELECT Foto FROM empleados WHERE id=:id");
			
				$sentencia->bindParam(':id',$txtID);
				$sentencia->execute();

				$empleado=$sentencia->fetch(PDO::FETCH_LAZY);
				print_r($empleado);
				var_dump($empleado);

				
				if(isset($empleado["Foto"])){

					if(file_exists("../Imagenes/".$empleado["Foto"])){

						if ($empleado['Foto']!="imagen.jfif") {
							
							unlink("../Imagenes/".$empleado["Foto"]);
						}
					}
				}


				//Actualizar la foto

				$sentencia=$pdo->prepare("UPDATE empleados SET Foto=:Foto WHERE id=:id");

				$sentencia->bindParam(':Foto',$nombreArchivo);
				$sentencia->bindParam(':id',$txtID);
				$sentencia->execute();

			}


			header('Location:index.php');

		echo "modificar";
		break;

	case 'btnEliminar':

		
			$sentencia=$pdo->prepare("SELECT Foto FROM empleados WHERE id=:id");
			
			$sentencia->bindParam('id',$txtID);
			$sentencia->execute();

			$empleado=$sentencia->fetch(PDO::FETCH_LAZY);
			print_r($empleado);
			var_dump($empleado);

			//Borrar imagen del servidor

			if(isset($empleado["Foto"])&&($empleado['Foto']!="imagen.jpg")){

				if(file_exists("../Imagenes/".$empleado["Foto"])){
					unlink("../Imagenes/".$empleado["Foto"]);
				}
			}


			$sentencia=$pdo->prepare("DELETE FROM empleados WHERE id=:id");
			
			$sentencia->bindParam('id',$txtID);
			$sentencia->execute();


			header('Location:index.php');
		

		break;

		case 'btnCancelar':

			header('Location:index.php');

		break;


		case 'Seleccionar':

			$accionAgregar="disabled";
			$accionModificar=$accionEliminar=$accionCancelar="";
			$mostrarModal=true;


			$sentencia=$pdo->prepare("SELECT * FROM empleados WHERE id=:id");
			
			$sentencia->bindParam('id',$txtID);
			$sentencia->execute();

			$empleado=$sentencia->fetch(PDO::FETCH_LAZY);

			$txtNombre=$empleado['Nombre'];
			$txtApellidoP=$empleado['ApellidoP'];
			$txtApellidoM=$empleado['ApellidoM'];
			$txtCorreo=$empleado['Correo'];
			$txtFoto=$empleado['Foto'];

		break;
	
}

	//Consulta de todos los datos de la BD

	$sentencia=$pdo->prepare("SELECT * FROM empleados");
	$sentencia->execute();
	$listaEmpleados= $sentencia->fetchAll(PDO::FETCH_ASSOC);

	//print_r($listaEmpleados);

?>