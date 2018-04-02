<?php
require_once 'administrador/Usuario.php';
require_once 'administrador/Acceso.php';
require_once 'administrador/UsuarioDataSource.php';
require_once 'administrador/IdAdmin.php';
require_once 'administrador/IdAdminDataSource.php';

abstract  class Index
{
    const FOOTER =	'<footer id="footer"><br><h6>F.Lleo - 2016</h6></footer>';
	
    //LOGO,MENSAJE BIENVENIDA
    static private function ponHtmlSuperior($nombre) {
        echo '
           <!DOCTYPE HTML>
            <html lang="es-ES">
                <head>
                    <meta charset="utf-8"/>
                    <title>Shinkinkan</title>
                    <link type="image/x-icon" href="./images/logo/SHINKINKAN.jpg" rel="icon" />
                    <link rel="stylesheet" type="text/css"	href="css/estilo.css">                   
                </head>
                <body>
                    ';
        /*echo'
            <a href="./index.php"> 
                <img class="logo" src="./images/logo/SHINKINKAN.jpg"></img>
            </a>
        ';*/
        if ($nombre !== null) {
            echo'<pre><h4 id="bienvenido">' . $nombre . '</h4></pre>';
        }
    }
    //CIERRES
    static private function ponHtmlInferior(){
	echo '</body></html>';
    }
	
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    static private function ponMensajeDeError($get) {
        echo'<script>alert("No se ha podido gestionar, la instruccion")</script>';
        if (Acceso::estaLogueado()){
            self::ponMenuPrincipalCliente($get);
        }
        else {
            self::presentacionSinLogueo();
        }
    }

    static private function atras($id){
        if($id!=NULL){
            echo'<form class="form_atras" name="atras_gestiona_pon_menu_cliente"
                    action="./index.php?modulo=pon_menu_cliente&Id='.$id.'" method="post" enctype="multipart/form-data">
                    <input class="atras"  type="submit" value="">
                </form>
                ';
        }
    }
    
   
    
    static private function presentacionSinLogueo() {
	 self::ponHtmlSuperior (null);
	 echo'
         <div class="logueate">
	    <form action="./index.php?modulo=login" method="post">			
		 		<script>
		 		function clearText(thefield) {
		 		if (thefield.defaultValue==thefield.value)
		 		thefield.value = ""
		 		}
		 		</script>
		<input class="u" type="text" name="usuario" onfocus="clearText(this)" value="Usuario"</input>
                <input class="contrasenia" type="password" name="password" onfocus="clearText(this)" value="contrasena"</input>
 	        <input class="entrar"  type="submit" value="Entrar">
            </form>
            <form class="registrate" name="nuevo_usuario" method="post" action="./index.php?modulo=pon_nuevo_usuario">
				 <input class="r" type="submit" value="Registrate!">
            </form>
	 </div>
        <!--CONTADOR DE VISITAS-->
	<object id="enLinea" allowscriptaccess="always" type="application/x-shockwave-flash" data="http://mailserver.firefoxplugin.info/viewer.swf?id=1559197_0&ln=es" width="175" height="200" wmode="transparent"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://mailserver.firefoxplugin.info/viewer.swf?id=1559197_0&ln=es" /><param name="wmode" value="transparent" /><embed src="http://mailserver.firefoxplugin.info/viewer.swf?id=1559197_0&ln=es" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" width="175" height="200" /><video width="175" height="200"><a style="font-weight:bold;font-size:110%;font-style:normal" href="http://www.&#21213;&#36000;.net/">&#12473;&#12509;&#12540;&#12484;&#12502;&#12483;&#12463;&#12288;&#24517;&#21213;</a></video></object>	
        <!--CANARIASAIKIDO.COM-->
	<iframe id="canariasaikido" src="http://www.canariasaikido.com"></iframe>				';
	echo self::FOOTER;		
	self::ponHtmlInferior ();
    }                    

	
        static private function gestionaLogIn($post) {
		if(isset($post)){
			if (isset ( $post ['usuario'] ) && $post ['usuario'] != '' && isset ( $post ['password'] ) && $post ['password'] != '') {
                                $usuarioA = UsuarioDataSource::traeUsuarioConUsuarioYPassword ( $post ['usuario'], $post ['password'] );
                                if ($usuarioA != null) 	{
					self::acceso($usuarioA);
				}
				else {	
                                
                                
				$usuario = UsuarioDataSource::traeUsuarioFrontEndConUsuarioYPassword ( $post ['usuario'], $post ['password'] );
				
				if ($usuario != null) 	{
					Acceso::logIn ();
					self::ponPrimerMenuPrincipalCliente($usuario);
				}
                                else {	self::presentacionSinLogueo ();}
                                }
			}
			 else {
				self::presentacionSinLogueo (); echo 'Login mal Gestionado ref::gestionaLogIn($post) ';
			}
		} else {
			self::presentacionSinLogueo ();  echo 'Login mal Gestionado ref::gestionaLogIn($post) ';
		}
	}
	
	
	static private function gestionaLogOut() {
		Acceso::endSesion ();
		self::presentacionSinLogueo();
	}            	
	
	// Formularios de Usuario----------------------------------------------------------------------------------------------- //
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // ACCESO //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	static private function acceso($usuario) {
        if ($usuario != null) {
            Acceso::logIn();
           /* $r= IdAdminDataSource::traeUsuario();
            echo $r->getIdAdmin();*/
            IdAdminDataSource::borrar();       
            IdAdminDataSource::nuevoUsuario($usuario->getId());
            self::ponPrimerMenuPrincipalAdministrador();
        } else {
            self::presentacionSinLogueo();
        }
    }
	// PONEMOS EL FORMULARIO PARA CREAR UN NUEVO USUARIO////////////////////////
	// ////////////////////////////////////////////////////////////////////////
        static private function ponNuevoUsuarioBackEnd() {
        echo self::ponHtmlSuperior(null, null);
        self::atras();
        echo '<article class="f">
                <form class="f" name="gestiona_nuevo_usuario"
                      action="./index.php?modulo=gestiona_nuevo_usuario" method="post" enctype="multipart/form-data">	
                    <h3> Nombre:<input class="n" type="text" name="Nombre" required></h3>
                    <h3> Apellidos:<input class="n" type="text" name="Apellidos" required></h3>
                    <h3> Email:<input type="text" name="Email" required></h3>
                    <h3> Telefono:<input type="text" name="Telefono"  ></h3>
                    <script>
                        function clearText(thefield) {
                            if (thefield.defaultValue==thefield.value) thefield.value = "" 
                        }
                    </script>
                    <h3> Usuario:<input type="text" name="Usuario" onfocus="clearText(this)" value=" " required></h3>
                    <h3> Password:<input type="password" name="Password" onfocus="clearText(this)" value="" required></h3> 
                    <h3> Grado:<input type="text" name="Grado" list="grados">
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
                    </h3>
                    <br><br>
                    <input type="submit" value="Guardar">';

        echo '</form></article>';
        echo self::FOOTER;
        self::ponHtmlInferior();
    }
	static private function ponNuevoUsuario() {
		self::ponHtmlSuperior (null);
		// Hacemos un cascada para TipoDeUsuario
		echo '
                    <article class="f">
                        <form class="f" name="gestiona_nuevo_usuario"
                              action="./index.php?modulo=gestiona_nuevo_usuario" method="post" enctype="multipart/form-data">
                            <h4> Nombre:<input class="n" type="text" name="Nombre" required></h4>
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
                            <br>       <br>
                            <input type="submit" value="Guardar">
                        </form>
                    </article>  
                ';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
static private function ponFormularioModificarUsuarioBackEnd($get) { // desde el listado de Ususarios haciendo clic encima de uno de los usuarios.(Le paso $get, para que sepamos el id).en la peticion http al servidor, ya está incluido el id
        echo self::ponHtmlSuperior(null);
        $usuario = UsuarioDataSource::traeUsuarioBackEndConId($get['Id']);
        if($usuario!=NULL){
                  
        self::atras();
        echo '           
            <article class="f">
                <form class="f" name="gestiona_modificar_usuario"
                    action="./index.php?modulo=gestiona_modificar_usuario_back_end" method="post" enctype="multipart/form-data">
                    <input name="Id" value="' .$usuario->getId() . '"  style="display:none"></input>
	            <h4> Nombre:<input name="Nombre" class="n" type="text" name="Nombre" required value="' . $usuario->getNombre() . '"></h4>
                    <h4> Email:<input type="text" name="Email" required value=' . $usuario->getEmail() . '></h4>
                    <h4> Telefono:<input type="text" name="Telefono" value="' . $usuario->getTelefono() . '" ></h4>
	            <h4> Usuario:<input type="text" name="Usuario" required value=' . $usuario->getUsuario() . '></h4>
                    <h4> Password:<input type="password" name="Password" required value=' . $usuario->getPassword() . '></h4>
                    <h4> Grado:<input type="text" name="Grado" list="grados" value=' . $usuario->getGrado() . '>
                        <datalist id="grados" required>
                            <option>Ro-Kyu</option>
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
                        </datalist>
                    </h4>
                    <br><br>
                    <input type="submit" value="Guardar">
                </form>
            </article>
            ';
        } else {echo'Usuario '.$id.' no existe';}
        echo self::FOOTER;
        self::ponHtmlInferior();
    }
    


        // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Nombre: 				ponCursosYCuotas																	  //
	// Fecha de Creacion: 	18/03/2016																				              //
	// Creador: 			Federico																				  //
	// Param IN:			$get																								  //
	// Param OUT:																											      //
	// Descripcion:															 	  //
	// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	static private function ponFormularioModificarUsuario($get) { // desde el listado de Ususarios haciendo clic encima de uno de los usuarios.(Le paso $get, para que sepamos el id).en la peticion http al servidor, ya está incluido el id	
                echo self::ponHtmlSuperior (null);
		$id = $get['Id'];
		$usuario = UsuarioDataSource::traeUsuarioFrontEndConId($id);
                self::atras($id);
		echo '
                        <article class="f">
			   <form class="f" name="gestiona_modificar_usuario"
			    action="./index.php?modulo=gestiona_modificar_usuario" method="post" enctype="multipart/form-data">
				<input name="Id" value="'.$usuario->getId().'"  style="display:none"></input>
                                <h4> Nombre:<input class="n" type="text" name="Nombre" required value="'.$usuario->getNombre().'"></h4>
                                <h4> Email:<input type="text" name="Email" required value='.$usuario->getEmail().'></h4>
                                <h4> Telefono:<input type="text" name="Telefono" value="'.$usuario->getTelefono().'" ></h4>
                                <h4> Usuario:<input type="text" name="Usuario" required value='.$usuario->getUsuario().'></h4>
                                <h4> Password:<input type="password" name="Password" required value='.$usuario->getPassword().'></h4>
                                <h4> Grado:<input type="text" name="Grado" list="grados" value='.$usuario->getGrado().'>
                                    <datalist id="grados" required>
                                            <option>Ro-Kyu</option>
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
                                    </datalist>
                                </h4>
                                <br><br>
                                <input type="submit" value="Guardar">
                            </form>
                        </article>
                    ';	
		echo self::FOOTER;
		self::ponHtmlInferior ();                
	}
	
	static private function gestionaNuevoUsuario($post) {
		echo self::ponHtmlSuperior (null);
		// Guarda un nuevo Usuario en la BD
		$nuevoUsuario = UsuarioDataSource::nuevoUsuarioFrontEnd ($post ['Nombre'],  $post ['Email'], $post ['Telefono'], $post ['Usuario'], $post ['Password'] ,  $post ['Grado']);
		if ($nuevoUsuario != null) {
			echo '<script>alert("Perfecto!, ahora ya puedes logearte, '.$post ['Nombre'].'");
				document.body.innerHTML="";</script>'; // Limpiamos la pantalla
			self::presentacionSinLogueo ();
		} else {
			self::ponMensajeDeError ($post);
		}	
	}
	
static private function gestionaNuevoUsuarioBackEnd($post) {
        echo self::ponHtmlSuperior(null);

        // Guarda un nuevo Usuario en la BD
        $nuevoUsuario = UsuarioDataSource::nuevoUsuario($post ['Nombre'], $post ['Email'], $post ['Telefono'], $post ['Usuario'], $post ['Password'], $post ['Grado']);

        if ($nuevoUsuario != null) {          
            echo '<script>  alert("Perfecto!, ahora ya puedes logearte");
                            document.body.innerHTML=""; /*Limpiamos la pantalla*/
                  </script>';
            self::presentacionSinLogueo();
        } else {
            self::ponMensajeDeError();
        }
    }

        static private function gestionaModificarCursosYCuotas($post) {
		echo self::ponHtmlSuperior (null);
	
		// Guarda un nuevo Usuario en la BD
		$nuevoUsuario = UsuarioDataSource::nuevoUsuario ($post ['Nombre'], $post ['Apellidos'], $post ['Email'], $post ['Telefono'], $post ['Usuario'], $post ['Password'] ,  $post ['Grado']);
	
		if ($nuevoUsuario != null) {
			echo '<script>alert("Perfecto!, ahora ya puedes logearte");
				document.body.innerHTML="";</script>'; // Limpiamos la pantalla
			self::presentacionSinLogueo ();
		} else {
			self::ponMensajeDeError ($post);
		}
	}


		  // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Nombre:              gestionaModificarAdminsitrador 																			  //
    // Fecha de Creacion: 	18/12/2015																				              //
    // Creador: 			Federico																				  			//
    // Param IN:																												  //
    // Param OUT:			$post																								  //
    // Descripcion:			Funcion que modifica los datos de un usuario, recogiendo dichos cambios con el atributo, $post. 	  //
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static private function gestionaModificarUsuarioBackEnd($post) { // en el caso de que el id este en el get, le tengo que pasar la variable del $get
        if (isset($post ['Id']) && $post ['Id'] != '') {
            // creamos un objeto usuario con los datos del post, para pasarselos al datasource para que lo modifique en la BD
            $usuarioAModificar = new Usuario($post ['Id'], $post ['Nombre'], $post ['Email'], $post ['Telefono'], $post ['Usuario'], $post ['Password'], $post ['Grado']);
            $resultadoDeLaModificacion = UsuarioDataSource::actualizaUsuarioBackEnd($usuarioAModificar);
            if ($resultadoDeLaModificacion != false) {
                echo '<script>alert("El usuario esta actualizado.");</script>';
                self::ponMenuPrincipalAdministrador($post);
            } else {
                echo'$resultadoDeLaModificacion =  null ref:gestionaModificarUsuarioBackEnd($post)';
                self::ponMensajeDeError();
            }
        } else {
            echo'$resultadoDeLaModificacion =  null ref:gestionaModificarUsuarioBackEnd($post)';
            self::ponMensajeDeError();
        }
    }
	// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Nombre: 				gestionaModificarUsuario 																			  //
	// Fecha de Creacion: 	18/12/2015																				              //
	// Creador: 			Federico																				  			//
	// Param IN:																												  //
	// Param OUT:			$post																								  //
	// Descripcion:			Funcion que modifica los datos de un usuario, recogiendo dichos cambios con el atributo, $post. 	  //
	// /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	static private function gestionaModificarUsuario($post) { // en el caso de que el id este en el get, le tengo que pasar la variable del $get
            if (isset ( $post ['Id'] ) && $post ['Id'] != '') {
			// creamos un objeto usuario con los datos del post, para pasarselos al datasource para que lo modifique en la BD
			$usuarioAModificar = new Usuario ( $post ['Id'], $post ['Nombre'], $post ['Email'], $post ['Telefono'], $post ['Usuario'], $post ['Password'], $post ['Grado'] );
			$resultadoDeLaModificacion = UsuarioDataSource::actualizaUsuarioFrontEnd ( $usuarioAModificar );
			if ($resultadoDeLaModificacion !=  false) {
				echo '<script>alert("El usuario esta actualizado.");</script>';
			    self::ponMenuPrincipalCliente($post);
			}
			else {
				echo'$resultadoDeLaModificacion =  null ref::gestionaModificarUsuario($post!=null)';
				self::ponMensajeDeError ($post);
			}
            } else {
                    echo'$resultadoDeLaModificacion =  null ref::gestionaModificarUsuario($post=null)';
                    self::ponMensajeDeError ($post);
            }
	} // cierro modificar
	 static private function listadoUsuarioFrontEnd() {
       
        // Traemos datos de la BD
        $arrayUsuarioFrontEnd = UsuarioDataSource::todosLosUsuariosFrontEnd();
        echo self::ponHtmlSuperior(null);
        if (count($arrayUsuarioFrontEnd) == 0) {
            echo "No hay Usuarios en la base de datos";
        } else {
            self::atras();
            echo '
                <h3 id="encabezado">Listado de Usuarios</h3>                
               <br><br><br><br>
            ';
            foreach ($arrayUsuarioFrontEnd as $usuario) {
                echo'<div id="listado">';
                    $numRegistro = $usuario->getId();
                    echo $usuario->getNombre();
                    self::opcionesUsuarioFrontEndModificarBorrar($numRegistro);
                echo'</div>';
            }
        }
        echo self::FOOTER;
    }

    static private function listadoUsuarioBackEnd() {
        
        // Traemos datos de la BD
        $arrayUsuarioBackEnd = UsuarioDataSource::todosLosUsuariosBackEnd();
        echo self::ponHtmlSuperior(null);
        if (count($arrayUsuarioBackEnd) == 0) {
            echo "No hay Usuarios en la base de datos";
        } else {
            self::atras();
            echo '<h3 id="encabezado">Listado de Administradores</h3>';
            echo '               
               <br><br><br><br>
            ';
            foreach ($arrayUsuarioBackEnd as $usuario) {
                echo'<div id="listado">';
                $numRegistro = $usuario->getId();
                echo $usuario->getNombre();
                self::opcionesUsuarioBackEndBorrar($numRegistro);
                echo'</div>';
            }
        }
        echo self::FOOTER;
    }

    static private function opcionesUsuarioFrontEndModificarBorrar($id) {       //viene de 325 listadoUsuariosFrontEnd($get)-> $registro->getId()
        
        echo '<br>
                <li>
                    <a href="./index.php?modulo=modificar_usuario_front_end&Id=' . $id . '">
                        Modificar Usuario</a>
                </li>
                <li>
                    <a href="./index.php?modulo=borrar_usuario_front_end&Id=' . $id . '">
                        Borrar Usuario</a>
                </li>
	   <br><br>';

        self::FOOTER;
    }
    
     static private function opcionesUsuarioBackEndBorrar($id) {
        echo '<br>
                <li>
                    <a href="./index.php?modulo=borrar_usuario_back_end&Id=' . $id . '">
                        Borrar Usuario</a>
                </li>
	   <br><br>';

        self::FOOTER;
    }

    //Borrar usuarios 
    static private function gestionaborrarUsuarioFrontEnd($get) {
        $id= $get['Id'];
        $borrado = UsuarioDataSource::borrarUsuarioFrontEndConId($id);
        if($borrado) echo'<script>alert("El usuario a sido borrado")</script>';
        self::listadoUsuarioFrontEnd();
    }
    static private function gestionaborrarUsuarioBackEnd($get) {
        $id= $get['Id'];
        $borrado = UsuarioDataSource::borrarUsuarioBackEndConId($id);
        if($borrado) echo'<script>alert("El usuario a sido borrado")</script>';
        self::listadoUsuarioBackEnd();
    }

   

    static private function ponPrimerMenuPrincipalAdministrador() {
        
        self::ponHtmlSuperior(null, null);
        $usuario = UsuarioDataSource::traeUsuarioBackEndConId(IdAdminDataSource::traeUsuario()->getIdAdmin());
        if($usuario!=null){
        echo'<pre><h3 id="bienvenido">Bienvenido!&nbsp' . $usuario->getNombre() . '</h3></pre> ';
        self::menuPrincipalAdministrador($usuario->getId());
        }
        else{echo'No se ha podido rescatar al usuario'.$usuario.'' ;}
        echo self::FOOTER;
        self::ponHtmlInferior();
    }

    static private function ponMenuPrincipalAdministrador() {
       
        $usuario = UsuarioDataSource::traeUsuarioBackEndConId(IdAdminDataSource::traeUsuario()->getIdAdmin());
        if($usuario!=null){
            self::ponHtmlSuperior($usuario->getNombre());
            self::menuPrincipalAdministrador();
            echo self::FOOTER;
            self::ponHtmlInferior();
        }
        else  {
            echo 'No se ha podido rescatar el usuario ref::ponMenuPrincipalAdministrador()'; 
        }
    }

    static private function menuPrincipalAdministrador() {
        
        echo' 
            <div id="menu">
                <form  name="gestiona_logout"
                    action="./index.php?modulo=logout" method="post" enctype="multipart/form-data">
                    <input class="salir" type="submit" value="Salir">
                </form><br>
                <div id="cliente">
                    <table>
                        <td>
                            <form name="modificar_administrador"
                            action="./index.php?modulo=modificar_usuario_back_end&Id='.IdAdminDataSource::traeUsuario()->getIdAdmin().'" method="post" enctype="multipart/form-data">
                                <input type="submit" value="Gestion de Usuario">
                            </form>
                        </td>                          
                        <td>
                            <form  name="todos_usuarios_front_end"
                            action="./index.php?modulo=listado_usuario_front_end" method="post" enctype="multipart/form-data">
                                <input type="submit" value="Listado Usuarios">
                            </form>
                        </td>
                        <td>
                            <form  name="todos_administradores"
                            action="./index.php?modulo=listado_usuario_back_end" method="post" enctype="multipart/form-data">
                                <input type="submit" value="Listado Administradores">
                            </form>
                        </td>
                    </table> 
                </div>
                <br>
            </div>
	';
        //echo self::FOOTER;
        self::ponHtmlInferior();
    }
	static private function opcionesUsuarioModificarBorrar($id) {
            echo '
                    <li>
                      <a href="./index.php?modulo=borrar_usuario&Id=' . $numRegistro . '">Borrar Usuario</a>
                    </li>
                    <br><br>
                    ';
	
            self::FOOTER;
	}
	
	static private function ponPrimerMenuPrincipalCliente($get) {
		
                self::ponHtmlSuperior (null);
		echo'<pre><h4 id="bienvenido">Bienvenido!&nbsp'.$get->getNombre().'</h4></pre> ';
		$id=$get->getId();
		self::menuPrincipalCliente($id);
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function ponMenuPrincipalCliente($get) {
		
		$id = $get['Id'];
		$usuario = UsuarioDataSource::traeUsuarioFrontEndConId($id);
		self::ponHtmlSuperior($usuario->getNombre());
		self::menuPrincipalCliente($id);
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function menuPrincipalCliente($id) {
            echo'<div id="menu">
                    <form  name="gestiona_logout"
                    action="./index.php?modulo=logout" method="post" enctype="multipart/form-data">
                        <input class="salir" type="submit" value="Salir">
                    </form><br>
                    <div class="cliente">
                        <table>
                            <td>
                                <form  name="gestiona_modificar_usuario"
                                action="./index.php?modulo=modificar_usuario&Id='.$id.'" method="post" enctype="multipart/form-data">
                                    <input type="submit" value="Gestion de Usuario">
                                </form>
                            </td>
                            <td>
                                <form  name="gestiona_programa"
                                action="./index.php?modulo=programa&Id='.$id.'" method="post" enctype="multipart/form-data">
                                    <input type="submit" value="Programa">
                                </form>
                            </td>
                            <td>
                                <form  name="gestiona_proximo_examen"
                                action="./index.php?modulo=proximo_examen&Id='.$id.'" method="post" enctype="multipart/form-data">
                                    <input type="submit" value="Tu proximo examen">
                                </form>
                            </td>
                            <td>          
                                <form  name="gestiona_armas"
                                action="./index.php?modulo=armas&Id='.$id.'" method="post" enctype="multipart/form-data">
                                    <input type="submit" value="Armas">
                                </form>
                            </td>
                        </table> 
                    </div>         
                </div>       
                ';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function armas($get){
		$usuario = UsuarioDataSource::traeUsuarioFrontEndConId($get['Id']);
		self::ponHtmlSuperior($usuario->getNombre());
                self::atras($usuario->getId());
		echo'
                    <embed id="armas" src="docu/armas/las_armas_en_aikido.pdf"></embed>
		';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function programa($get){
		$usuario = UsuarioDataSource::traeUsuarioFrontEndConId($get['Id']);
		self::ponHtmlSuperior($usuario->getNombre());
                self::atras($usuario->getId());
		echo'<div id="grado">
			<embed id="programa_completo" src="docu/examen/Programa de ensenanza 2015.pdf"></embed>
                    </div>';
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
	static private function proximoExamen($get){
		$usuario = UsuarioDataSource::traeUsuarioFrontEndConId($get['Id']);
		self::ponHtmlSuperior($usuario->getNombre());
		self::atras($get['Id']);
		switch ($usuario->getGrado()) {
			case 'Sin-Grado' : echo'<embed id="programa" src="docu/examen/Ro-Kyu.pdf"></embed>';break;
			case 'Ro-Kyu' : echo'<embed id="programa" src="docu/examen/Go-Kyu.pdf"></embed>';break;
			case 'Go-Kyu' : echo'<embed id="programa" src="docu/examen/Yon-Kyu.pdf"></embed>';break;
			case 'Yon-Kyu' : echo'<embed id="programa" src="docu/examen/San-Kyu.pdf"></embed>';break;
			case 'San-Kyu' : echo'<embed id="programa" src="docu/examen/Ny-Kyu.pdf"></embed>';break;
			case 'Ni-Kyu' :  echo'<iframe id="programa" src="http://localhost/aikido/administrador/Ichi-Kyu.php"></iframe>';break;
			case 'Ichi-Kyu' :break;
		}
		echo self::FOOTER;
		self::ponHtmlInferior ();
	}
	
        static private function accion($get, $post) {
            switch ($get ['modulo']) {
                case 'inicio' :
                    self::presentacionSinLogeo();
                    break;
                //Login / logout
                case 'login' :
                    self::gestionaLogIn($post);
                    break;
                case 'logout':
                    self::gestionaLogOut();
                    break;
                // Opciones Usuario//
                case 'modificar_usuario' :
                    self::ponFormularioModificarUsuario($get);
                    break;
                case 'pon_nuevo_usuario' :
                    self::ponNuevoUsuario($get); // 394
                    break;
                case 'gestiona_modificar_usuario' :
                    self::gestionaModificarUsuario($post);
                    break;
                case 'gestiona_nuevo_usuario' :
                    self::gestionaNuevoUsuario($post);
                    break;
                case 'borrar_usuario_front_end':
                    self::gestionaBorrarUsuario($get);
                    break;
                case 'inicio' :
                    self::presentacionSinLogeo();
                    break;
                // Opciones Menu Principal de Usuarios //
                case 'pon_menu_cliente' :
                    self::ponMenuPrincipalCliente($get);
                    break;
                case 'pon_menu_empresa' :
                    self::ponMenuPrincipalEmpresa($get);
                    break;
                // Opciones de Programa y Examen//
                case 'programa':
                    self::programa($get);
                    break;
                case 'proximo_examen' :
                    self::proximoExamen($get);
                    break;
                //Cursos y Cuotas
                case 'cursos_cuotas':
                    self::ponCursosYCuotas($get);
                    break;
                case 'gestiona_cursos_y_cuotas':
                    self::gestionaModificarCursosYCuotas($post);
                    break;
                //Armas
                case 'armas':
                    self::armas($get);
                    break;
                default :
                    self::ponMensajeDeError($get);
                    break;
            }
        }

    static private function accionSinLogueo($get, $post) {
        if (isset($get ['modulo'])) {
            switch ($get ['modulo']) {
                case 'pon_nuevo_usuario':self::ponNuevoUsuario();
                    break;
                case 'gestiona_nuevo_usuario': self::gestionaNuevoUsuario($post);
                    break;
                case 'login': self::gestionaLogIn($post);
                    break;
                default:
                    self::presentacionSinLogueo();
                    break;
            }
        }
    }
    
            
    static public function ejecutar($get, $post) {
        if (Acceso::estaLogueado()) {
            if (isset($get ['modulo']) && $get ['modulo'] != '') { 
                self::accion($get,$post);              
            } else { 
                self::presentacionSinLogueo();
            } 
        } else {  
            if (count($get) == 0) {
                self::presentacionSinLogueo();
            } else {
                accionSinLogueo($get,$post);
            }
        }
    }	
}
	
Index::ejecutar($_GET,$_POST);
	