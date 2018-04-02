<?php

require_once 'Usuario.php';
require_once 'Acceso.php';
require_once 'UsuarioDataSource.php';
require_once 'IdAdmin.php';
require_once 'IdAdminDataSource.php';

abstract class Index {
    
    const FOOTER = '    <footer id="footer">
                            <h6>flleo - 2016</h6>
                        </footer>
                   ';
   
    
    static private function ponHtmlSuperior($nombre) {
      
        echo '
			<!DOCTYPE HTML>
			<html lang="es-ES">
			<head>
                            <meta charset="utf-8"/>
                            <title>Aikido</title>
                            <link rel="stylesheet" type="text/css"	href="../css/estilo.css">
			</head>	
                        <body>
		';
       echo' <a href="http://localhost/aikido/administrador/index.php"> 
                <img class="logo" src="http://localhost/aikido/images/logo/SHINKINKAN.jpg"></img>
            </a>
        ';
        
        if ($nombre !== null)
            echo'<pre><h4 id="bienvenido">' . $nombre . '</h4></pre>';
    }

    static private function ponHtmlInferior() {
        echo '   
                </body>
            </html>
        ';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    static private function ponMensajeDeError() {
        echo'<script>alert("No se ha podido gestionar, la instruccion")</script>';
        if (Acceso::estaLogueado())
            self::ponMenuPrincipalAdministrador();
        else {
            self::presentacionSinLogueo();
        }
    }
    
    static private function acceso($usuario) {
        if ($usuario != null) {
            Acceso::logIn();
            IdAdminDataSource::borrar();
            IdAdminDataSource::nuevoUsuario($usuario->getId());
            self::ponPrimerMenuPrincipalAdministrador();
        } else {
            self::presentacionSinLogueo();
        }
    }
    
    static private function atras(){
        $usuario = IdAdminDataSource::traeUsuario();
        $idA = $usuario->getIdAdmin();
        if($idA!=NULL){
            echo'<form class="form_atras" name="atras_gestiona_pon_menu_administrador"
                    action="http://localhost/aikido/administrador/index.php?modulo=pon_menu_administrador&Id='.$idA.'" method="post" enctype="multipart/form-data">
                    <input class="atras"  type="submit" value="">
                </form>
                ';
        }
        /*else {
            echo' <a href="http://localhost/administrador/aikido/index.php"> 
                        <img class="logo" src="http://localhost/aikido/images/logo/SHINKINKAN.jpg"></img>
                  </a>
            ';
        }*/
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGIN,CONTADOR VISITAS,CALENDARIO
    static private function presentacionSinLogueo() {/*
        self::ponHtmlSuperior(null, null);
        echo'<div class="logueate">
                <form action="http://localhost/aikido/administrador/index.php?modulo=login" method="post">		
                    <script>
                        function clearText(thefield) {
                            if (thefield.defaultValue==thefield.value) thefield.value = "" 
                        }
                    </script>
                    <input class="u" type="text" name="usuario" onfocus="clearText(this)" value="Usuario"</input>
                    <input class="p" type="password" name="password" onfocus="clearText(this)" value="contrasena"</input>
                    <input class="ur"  type="submit" value="Entra Administrador">
                </form>
                <form class="r" name="nuevo_usuario" method="post" action="http://localhost/aikido/administrador/index.php?modulo=pon_nuevo_usuario">
                    <input class="nr" type="submit" value="Registrate Administrador!">
                </form>
                <img class="admin" id="o´sensei" src="../images/o´sensei.jpg"/>
                <img class="admin" id="catana1" src="../images/katana/1.jpeg"/>
            </div>
            ';        
        echo self::FOOTER;
        self::ponHtmlInferior();*/
    }

   
    
    static private function gestionaLogIn($post) {
        if (isset($post)) {
            if (isset($post ['usuario']) && $post ['usuario'] != '' && isset($post ['password']) && $post ['password'] != '') {
                $usuario = UsuarioDataSource::traeUsuarioConUsuarioYPassword($post ['usuario'], $post ['password']);
                self::acceso($usuario);
            } else {
                self::presentacionSinLogueo();
                echo 'Login mal Gestionado ref::gestionaLogIn($post)';
            }
        } else {
            self::presentacionSinLogueo();
            echo 'Login mal Gestionado ref::gestionaLogIn($post)';
        }
    }

    static private function gestionaLogOut() {
        Acceso::endSesion();
        self::presentacionSinLogueo();
    }

    // Formularios de Usuario----------------------------------------------------------------------------------------------- //
    // PONEMOS EL FORMULARIO PARA CREAR UN NUEVO USUARIO////////////////////////
    // ////////////////////////////////////////////////////////////////////////
    static private function ponNuevoUsuarioBackEnd() {
        echo self::ponHtmlSuperior(null, null);
        self::atras();
        echo '<article class="f">
                <form class="f" name="gestiona_nuevo_usuario"
                      action="http://localhost/aikido/administrador/index.php?modulo=gestiona_nuevo_usuario" method="post" enctype="multipart/form-data">	
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

     static private function ponFormularioModificarUsuarioFrontEnd($get) { // desde el listado de Ususarios haciendo clic encima de uno de los usuarios.(Le paso $get, para que sepamos el id).en la peticion http al servidor, ya está incluido el id
        echo self::ponHtmlSuperior(null, null);
        $usuario = UsuarioDataSource::traeUsuarioFrontEndConId($get['Id']);
        self::atras();       
        echo '           
            <article class="f">
                <form class="f" name="gestiona_modificar_usuario"
                    action="http://localhost/aikido/administrador/index.php?modulo=gestiona_modificar_usuario_front_end" method="post" enctype="multipart/form-data">
                    <input name="Id" value="' . $usuario->getId() . '"  style="display:none"></input>                    
	            <h4> Nombre:<input name="Nombre" class="n" type="text" name="Nombre" required value="' . $usuario->getNombre() . '"></h4>
                    <h4> Email:<input type="text" name="Email" required value=' . $usuario->getEmail() . '></h4>
                    <h4> Telefono:<input type="text" name="Telefono" value="' . $usuario->getTelefono() . '"  ></h4>
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
        echo self::FOOTER;
        self::ponHtmlInferior();
    }
    static private function ponFormularioModificarUsuarioBackEnd() { // desde el listado de Ususarios haciendo clic encima de uno de los usuarios.(Le paso $get, para que sepamos el id).en la peticion http al servidor, ya está incluido el id
        echo self::ponHtmlSuperior(null);
        $usuario = UsuarioDataSource::traeUsuarioBackEnd();
        if($usuario!=NULL){
                  
        self::atras();
        echo '           
            <article class="f">
                <form class="f" name="gestiona_modificar_usuario"
                    action="http://localhost/aikido/administrador/index.php?modulo=gestiona_modificar_usuario_back_end" method="post" enctype="multipart/form-data">
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
    // Nombre:                          gestionaModificarUsuarioFrontEnd																			  //
    // Fecha de Creacion:               18/07/2016																				              //
    // Creador: 			Federico																				  			//
    // Param IN:																												  //
    // Param OUT:			$post																								  //
    // Descripcion:			Funcion que modifica los datos de un usuario, recogiendo dichos cambios con el atributo, $post. 	  //
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static private function gestionaModificarUsuarioFrontEnd($post) { // en el caso de que el id este en el get, le tengo que pasar la variable del $get
        if (isset($post ['Id']) && $post ['Id'] != '') {
            // creamos un objeto usuario con los datos del post, para pasarselos al datasource para que lo modifique en la BD
            $usuarioAModificar = new Usuario($post ['Id'], $post ['Nombre'], $post ['Email'], $post ['Telefono'],null,null, $post ['Grado']);
            $resultadoDeLaModificacion = UsuarioDataSource::actualizaUsuarioFrontEndDesdeAdmin($usuarioAModificar);
            if ($resultadoDeLaModificacion != false) {
                echo '<script>alert("El usuario esta actualizado.");</script>';
                self::ponMenuPrincipalAdministrador();
            } else {
                echo'error::El usuario no ha sido actualizado ,$post!=null ref::gestionaModificarUsuarioFrontEnd($post)';
                self::ponMensajeDeError($post);
            }
        } else {
            echo'error::El usuario no ha sido actualizado ,$post=null ref::gestionaModificarUsuarioFrontEnd($post)';
            self::ponMensajeDeError($post);
        }
    }

// cierro modificar

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
                    <a href="http://localhost/aikido/administrador/index.php?modulo=modificar_usuario_front_end&Id=' . $id . '">
                        Modificar Usuario</a>
                </li>
                <li>
                    <a href="http://localhost/aikido/administrador/index.php?modulo=borrar_usuario_front_end&Id=' . $id . '">
                        Borrar Usuario</a>
                </li>
	   <br><br>';

        self::FOOTER;
    }
    
     static private function opcionesUsuarioBackEndBorrar($id) {
        echo '<br>
                <li>
                    <a href="http://localhost/aikido/administrador/index.php?modulo=borrar_usuario_back_end&Id=' . $id . '">
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
        self::menuPrincipalAdministrador(IdAdminDataSource::traeUsuario()->getIdAdmin());
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
                    action="http://localhost/aikido/administrador/index.php?modulo=logout" method="post" enctype="multipart/form-data">
                    <input class="salir" type="submit" value="Salir">
                </form><br>
                <div id="cliente">
                    <table>
                        <td>
                            <form name="modificar_administrador"
                            action="http://localhost/aikido/administrador/index.php?modulo=modificar_usuario_back_end&Id='.IdAdminDataSource::traeUsuario()->getIdAdmin().'" method="post" enctype="multipart/form-data">
                                <input type="submit" value="Gestion de Usuario">
                            </form>
                        </td>                          
                        <td>
                            <form  name="todos_usuarios_front_end"
                            action="http://localhost/aikido/administrador/index.php?modulo=listado_usuario_front_end" method="post" enctype="multipart/form-data">
                                <input type="submit" value="Listado Usuarios">
                            </form>
                        </td>
                        <td>
                            <form  name="todos_administradores"
                            action="http://localhost/aikido/administrador/index.php?modulo=listado_usuario_back_end" method="post" enctype="multipart/form-data">
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
            case 'modificar_usuario_front_end' :
                self::ponFormularioModificarUsuarioFrontEnd($get);
                break;
            case 'modificar_usuario_back_end' :
                self::ponFormularioModificarUsuarioBackEnd($get);
                break;
            case 'listado_usuario_front_end' :
                self::listadoUsuarioFrontEnd();
                break;
            case 'listado_usuario_back_end' :
                self::listadoUsuarioBackEnd();
                break;
            case 'pon_nuevo_usuario' :
                self::ponNuevoUsuarioBackEnd($get); // 394
                break;
            case 'gestiona_modificar_usuario_front_end' :
                self::gestionaModificarUsuarioFrontEnd($post);
                break;
            case 'gestiona_modificar_usuario_back_end' :
                self::gestionaModificarUsuarioBackEnd($post);
                break;
            case 'gestiona_nuevo_usuario' :
                self::gestionaNuevoUsuarioBackEnd($post);
                break;
            case 'borrar_usuario_back_end':
                self::gestionaBorrarUsuarioBackEnd($get);
                break;
            case 'borrar_usuario_front_end':
                self::gestionaBorrarUsuarioFrontEnd($get);
                break;
            // Opciones Menu Principal de Adminsitrador //
            case 'pon_menu_administrador' :
                self::ponMenuPrincipalAdministrador();
                break;
            // Opciones de Programa y Examen//
            case 'programa':
                self::programa();
                break;
            //Cursos Puntos y Cuotas
            case 'cursos_cuotas':
                self::ponCursosYCuotas();
                break;
            case 'gestiona_cursos_y_cuotas':
                self::gestionaModificarCursosYCuotas($post);
                break;
            default :
                self::ponMensajeDeError();
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
                    self::presentacionSinLogeo();
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
