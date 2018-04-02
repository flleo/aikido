<?php
require_once 'Acceso.php';
require_once 'UsuarioDataSource.php';

abstract  class Index
{
	const FOOTER =	'
			<footer id="footer"><h6>F.Lleo - 2015</h6></footer>';
	
	
	static private function ponHtmlSuperior() {
		echo '
			<!DOCTYPE HTML>
			<html lang="es-ES">
			<head>
			<title>Aikido</title>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css"	href="../css/estilo.css">
			</head>
			<body>
			
			<a href="http://localhost/aikido/administrador/index.php">
				<img class="logo" src="http://localhost/aikido/images/fondo/bambu.jpeg"></img>
			</a>
			';
	
	}
	static private function ponHtmlInferior(){
		echo '</article></body></html>';
	
	}
	static private function ponMensajeDeError()
	{
		echo'<script>alert("Lo sentimos, se ha producido un error, estamos trabajando para solucionarlo")</script>';
		self::presentacionSinLogeo();
	}
	static private function presentacionSinLogeo() {
		self::ponHtmlSuperior (null,null);
		
		
		echo '
	 <div class="logueate">
	   <form name="logueate" action="http://localhost/aikido/administrador/index.php?modulo=login" method="post">
		    <h1>Aikikai Canarias</h1>
			<h2>Tenerife</h2><h2>Administrador</h2>
	
		 		<script>
		 		function clearText(thefield) {
		 		if (thefield.defaultValue==thefield.value)
		 		thefield.value = ""
		 		}
		 		</script>
	
			<input class="u" type="text" name="usuario" onfocus="clearText(this)" value="Usuario"</input>
            <input class="p" type="password" name="password" onfocus="clearText(this)" value="contrasena"</input>
		
 	        <input class="ur"  type="submit" value="Administrador Registrado:Entrar">
		</form>
		<form class="r" name="nuevo_usuario" method="post" action="http://localhost/aikido/administrador/index.php?modulo=pon_nuevo_usuario">
				 <input class="nr" type="submit" value="Registrate Administrador!">
	 	</form>
	 </div>
			';
		echo self::FOOTER;
		echo self::ponHtmlInferior ();
	}
	
	static private function ponNuevoUsuario()
	{
		echo self::ponHtmlSuperior();
			
		//Hacemos un cascada para TipoDeUsuario
		echo '<article class="f">
				<form class="f" name="gestiona_nuevo_usuario"
				 action="http://localhost/aikido/administrador/index.php?modulo=gestiona_nuevo_usuario"
		method="post" enctype="multipart/form-data">
                <h4> Nombre:<input class="n" type="text" name="Nombre" required></h4>
                <h4> Usuario:<input type="text" name="Usuario" required></h4>
				<h4> Password:<input type="password" name="Password" required></h4>            <br>						                <br>
				<input type="submit" value="Guardar">';
		
	
		echo'</form></article>';
		echo self::FOOTER;
		self::ponHtmlInferior();
		 
	}
	
	static private function ponFormularioModificarUsuario($get) { // desde el listado de Ususarios haciendo clic encima de uno de los usuarios.(Le paso $get, para que sepamos el id).en la peticion http al servidor, ya está incluido el id
	
		echo self::ponHtmlSuperior (null,null);
		$id = $get['Id'];
		$usuario = UsuarioDataSource::traeUsuarioConId($id);
		// Hacemos un cascada para TipoDeUsuario
		echo '<article class="f">
			   <form class="f" name="gestiona_modificar_usuario"
			    action="http://localhost/aikido/index.php?modulo=gestionaModificarUsuario" method="post" enctype="multipart/form-data">
	
	                <h4> Nombre:<input class="n" type="text" name="Nombre" required values='.$usuario->getNombre().'></h4>
					<h4> Email:<input type="text" name="Email" required></h4>
					<h4> Telefono:<input type="text" name="Telefono"  ></h4>
	                <h4> Usuario:<input type="text" name="Usuario" required></h4>
					<h4> Password:<input type="password" name="Password" required></h4>
					<h4> Grado:<input type="text" name="Grado" list="grados">
									<datalist id="grados" required>
										<option>Ro-Kyu
										<option>Go-Kyu</option>
										<option>Shi-Kyu</option>
										<option>San-Kyu</option>
										<option>Ni-Kyu</option>
										<option>Ichi-Kyu</option>
										<option>Shodan</option>
										<option>Nidan</option>
										<option>Sandan</option>
										<option>Yodan</option>
										<option>Godan</option>
										<option>Rokudan</option>
										<option>Shichidan</option>
										<option>Hachidan</option>
										<option>Kudan</option>
										<option>Judan</option>
									</datalist>
					</h4>
					<br>						                <br>
					<input type="submit" value="Guardar">';
	
		echo '</form></article>';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function gestionaNuevoUsuario($post)
	{
		echo self::ponHtmlSuperior();
	
		// Guarda un nuevo Usuario en la BD
		$nuevoUsuario = UsuarioDataSource::nuevoUsuario ( $post ['Nombre'], $post ['Usuario'], $post ['Password'] );
	
		if ($nuevoUsuario!=null) {
			echo'<script>alert("Perfecto!, ahora ya puede logearse");
				document.body.innerHTML="";</script>';//Limpiamos la pantalla
			self::presentacionSinLogeo($nuevoUsuario->getNombre());
		}
		else { self::ponMensajeDeError();}
	}
	
	static private function gestionaLogIn($post) {
		if(isset($post)){
			if (isset ( $post ['usuario'] ) && $post ['usuario'] != '' && isset ( $post ['password'] ) && $post ['password'] != '') {
					
				$usuario = UsuarioDataSource::traeUsuarioConUsuarioYPassword ( $post ['usuario'], $post ['password'] );
	
				if ($usuario != null) 	{
					Acceso::logIn ();
					self::ponPrimerMenuPrincipalCliente($usuario);
				}
				else {	self::presentacionSinLogeo ();}
			}
			else {
				self::presentacionSinLogeo (); echo 'Login mal Gestionado 100';
			}
		} else {
			self::presentacionSinLogeo ();  echo 'Login mal Gestionado 103';
		}
	}
	
	static private function ponPrimerMenuPrincipalCliente($get) {
	
		self::ponHtmlSuperior (null,null);
		echo'<pre><h5 id="bienvenido">Bienvenido!&nbsp'.$get->getNombre().'</h5></pre> ';
		$id=$get->getId();
		self::menuPrincipalCliente($id);
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function ponMenuPrincipalCliente($get) {
		$id = $get['Id'];
		$usuario = UsuarioDataSource::traeUsuarioConId($id);
		self::ponHtmlSuperior($usuario->getNombre(),$usuario->getApellidos());
		self::menuPrincipalCliente($id);
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function ponMenuPrincipalAdministrador($id) {
		echo'
				<article id="mpa"
				<h4>Bienvenido Administrador, '.$usuario->getNombre().' </h4>
				<h1>Aikikai Canarias</h1>
			<h2>Tenerife</h2><h2>Administrador</h2>
						
			<div class="cliente">
					<a id="cliente" href="//localhost/aikido/index.php?modulo=modificar_usuario&Id='.$id.'">Gestion de Usuario</a>
					<a id="cliente" href="//localhost/aikido/index.php?modulo=programa&Id='.$id.'">Programa</a>
					<a id="cliente" href="//localhost/aikido/index.php?modulo=proximo_examen&Id='.$id.'">Tu proximo examen</a>
					<a id="cliente" href="//localhost/aikido/index.php?modulo=armas&Id='.$id.'"> Armas </a>
			</div>
			<br>
			';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}

	static private function menuPrincipalCliente($id) {
		echo'
				<article id="mpa"
				<h4>Bienvenido Administrador, '.$usuario->getNombre().' </h4>
				<h1>Aikikai Canarias</h1>
			<h2>Tenerife</h2><h2>Administrador</h2>
			<div class="cliente">
					<a id="cliente" href="//localhost/aikido/administrador/index.php?modulo=modificar_usuario&Id='.$id.'">Gestion de Usuario</a>
					<a id="cliente" href="//localhost/aikido/administrador/index.php?modulo=programa&Id='.$id.'">Programa</a>
					<a id="cliente" href="//localhost/aikido/administrador/index.php?modulo=proximo_examen&Id='.$id.'">Tu proximo examen</a>
					<a id="cliente" href="//localhost/aikido/administrador/index.php?modulo=armas&Id='.$id.'"> Armas </a>
			</div>
			<br>
			';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static public function ejecutar($get, $post) {
	
		if (Acceso::estaLogueado ()) {
			if (isset ( $get ['modulo'] ) && $get ['modulo'] != '') { // INICIO 1.1
				switch ($get ['modulo']) {
					//Login logout
					case 'login' :
						self::gestionaLogIn ( $post );
						break;
							
					case 'logout':
						self::gestionaLogOut();
						break;
						// Opciones de Tipo de Usuario//
	
					case 'modificar_usuario' :
						self::ponFormularioModificarUsuario ($get);
						break;
							
					case 'listado_usuario' :
						self::listadoUsuario ( "" );
						break;
							
					case 'pon_nuevo_usuario' :
						self::ponNuevoUsuario (); // 394
						break;
							
					case 'gestiona_modificar_usuario' :
						self::gestionaModificarUsuario ( $post );
						break;
							
					case 'gestiona_nuevo_usuario' :
						self::gestionaNuevoUsuario ( $post );
						break;
							
					case 'inicio' :
						self::presentacionSinLogeo ();
						break;
							
						// Opciones Menu Principal de Usuarios //
					case 'pon_menu_cliente' :
						self::ponMenuPrincipalCliente($get);break;
	
					case 'pon_menu_empresa' :
						self::ponMenuPrincipalEmpresa($get);break;
	
						// Opciones de Programa y Examen//
	
					case 'programa':
						self::programa($get);break;
	
					case 'proximo_examen' :
						self::proximoExamen($get);
						break;
							
						//Cursos y Cuotas
	
					case 'cursos_cuotas':
						self::ponCursosYCuotas($get);break;
	
					case 'gestiona_cursos_y_cuotas':
						self::gestionaModificarCursosYCuotas($post);break;
							
						//Armas
						
					case 'armas':
						self::armas($get);
						break;
	
					default :
						self::ponMensajeDeError ($get);
						break;
				} // FIN 1.1
			} else { // INICIO 2
				self::presentacionSinLogeo (null);
	
			} // FIN 2
		}
		else {		// SI NO ESTA LOGUEADO
	
			if (count ( $get ) == 0) {
				self::presentacionSinLogeo ();
			} else {
	
				if (isset ( $get ['modulo'] )) {
					switch ($get ['modulo']) {
						case 'pon_nuevo_usuario':		self::ponNuevoUsuario ();			break;
						case 'gestiona_nuevo_usuario':	self::gestionaNuevoUsuario($post);	break;
						case 'login': 					self::gestionaLogIn($post);			break;
						default: 	{
							self::presentacionSinLogeo ();	break;
						}
					}
				}
			}
	
		}
	}
	
	
}

Index::ejecutar($_GET,$_POST);