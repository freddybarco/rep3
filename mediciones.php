<!DOCTYPE html>
<html lang="es">
	<head>
		
		<meta charset="ISO-8859-1" />
		<meta name="description"  content="Formulario de datos" />
		<meta name="keywords" content="HTML5" />
		<title>Formulario de datos</title>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
		<script>
		
		
		 $(document).ready(function(){
		 	$("#uno").click(function(){
		
		$.post("http://localhost/asignacion3/guardar.php").done(function(data) {
  			alert( data.success);
			});
		});
 		$("#cerrar").click(function(){
		
		$.post("http://localhost/asignacion3/cerrar.php").done(function(data) {
  			alert("Sesion Cerrada");
			});
		});



		 });
		</script>
		
	</head>
<body>




<section>
	
<h2>TABLA</h2>

<form action="<?php  require_once("obtener.php");
	$gb=new obtener;
	$val=$gb->mostrar();?>" method="post">

 <input type="submit" name="submit" value="Recuperar"> 
</form>
<form>
<button id='uno'>Guardar</button><p class="telefonoc" id="demo"></br></form>
<form>
<button id='cerrar'>Cerrar sesion</button></br></form>




<p>____________________________________________________________________________________</p>

</section>

<aside>

<?php

echo $val;
class acceso
{
	public function __construct()
	{
		session_start();

		if(!$_SESSION["hgddX34355fD"])
		{
			header('Location: index.php');
		}

	}



}


$gb=new acceso;

?>

</aside>

<footer>
	<small>@@@@@@@@@@@@</small> 

</footer>

</body>
</html>

