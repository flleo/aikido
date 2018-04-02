<?php 
// Importaciones
require_once 'Usuario.php';
require_once 'MySQL.php';

abstract class UsuarioDataSource
{

	// Metodos
        static public function nuevoUsuarioFrontEnd( $nombre,  $email, $telefono, $usuario, $password, $grado, $foto)
	{
		MySQL::conectar(); // Conectar la BD
		// Crea un objeto de Usuario
		$idNuevoUsuario = MySQL::insertar ('INSERT INTO tabla_usuarios_front_end ( Nombre, Email,
		  		Telefono, Usuario, Password, Grado, Foto) 
				VALUES("'.$nombre.'", "'.$email.'","'.$telefono.'", "'.$usuario.'", "'.$password.'", "'.$grado.'", "'.$foto.'")');
		MySQL::cerrar(); // Cerrar la BD
		// Devuelve un objeto Usuario
                if($idNuevoUsuario!=null){
                    return new Usuario(
                                    $idNuevoUsuario,
                                    $nombre,
                                    $email,
                                    $telefono,
                                    $usuario,
                                    $password,
                                    $grado,
                                    $foto
                    );
                }
	}
	
	static public function todosLosUsuariosFrontEnd()
	{
		// Conectas la BD
		MySQL::conectar(); 
		
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT * FROM  tabla_usuarios_front_end');
		// Cerramos la BD
		MySQL::cerrar();
		
		
		$arrayDeObjetos = array();  // Array vacio

		/*
		 * Guarda cada diccionario en una 
		 * variable $arrayDiccionary, que va a contener 
		 * todos los datos de la consulta, se van a guardar 
		 * temporalmente en una variable llamada $diccionary
		 * Ejemplo por cada diccionario sera una vuelta 
		 */
		foreach ($arrayDiccionary as $diccionary){
			// Creamos objeto array de clase Usuario
			$arrayDeObjetos[] = new Usuario
			 ($diccionary['Id'],
			  $diccionary['Nombre'],
			  $diccionary['Email'],
			  $diccionary['Telefono'], 
			  $diccionary['Usuario'],
			  $diccionary['Password'],
			  $diccionary['Grado'],
                          $diccionary['Foto']
			  );
			
			// Ejemplo: $arrayDeObjetos[dicc1,dicc2,...];
		}
		// devolvemos el array de array
		return $arrayDeObjetos;
	}
        
       
	
	static public function todosLosUsuariosGrado($grado)
	{
		// Conectas la BD
		MySQL::conectar();
	
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT * FROM  tabla_usuarios_back_end where Grado ='.$grado);
		// Cerramos la BD
		MySQL::cerrar();
	
	
		$arrayDeObjetos = array();  // Array vacio
	
		/*
		 * Guarda cada diccionario en una
		 * variable $arrayDiccionary, que va a contener
		 * todos los datos de la consulta, se van a guardar
		 * temporalmente en una variable llamada $diccionary
		 * Ejemplo por cada diccionario sera una vuelta
		 */
		foreach ($arrayDiccionary as $diccionary){
			// Creamos objeto array de clase Usuario
			$arrayDeObjetos[] = new Usuario
				   ($diccionary['Id'],
					$diccionary['Nombre'],
					$diccionary['Email'],
					$diccionary['Telefono'],
					$diccionary['Usuario'],
					$diccionary['Password'],
					$diccionary['Grado'],
                                        $diccionary['Foto']
					);
				
			// Ejemplo: $arrayDeObjetos[dicc1,dicc2,...];
		}
		// devolvemos el array de array
		return $arrayDeObjetos;
	}
	
	// Funcion para borrar un usuario
	static public function borrarUsuarioFrontEndConId($id)
	{
		// Conectamos la BD
		MySQL::conectar();
		
		// Eliminamos un registro por id
		$resultado=MySQL::eliminar('DELETE FROM tabla_usuarios_front_end WHERE Id='.$id);
		
		MySQL::cerrar(); // Cerrar BD
		
		return $resultado;
	}
	// Funcion para borrar un usuario
	
	/*
	 * Esta funcion lo que hace es guardar en la BD 
	 * de manera permanente, los valores que le pasamos
	 * dentro del objeto $objetoUsuarioActualizar
	 */
	 

	static public function  traeUsuarioBackEnd()
	{
		MySQL::conectar(); // Conectar BD
	
		$arrayDeDiccionary = MySQL::leerDatos('SELECT * FROM tabla_usuarios_back_end');
	
		MySQL::cerrar(); // Cerramos la BD
	
		if(count($arrayDeDiccionary)==0) {
			return null;
		}
	
		return new Usuario(
				$arrayDeDiccionary[0]['Id'],
				$arrayDeDiccionary[0]['Nombre'],
				$arrayDeDiccionary[0]['Email'],
				$arrayDeDiccionary[0]['Telefono'],
				$arrayDeDiccionary[0]['Usuario'],
				$arrayDeDiccionary[0]['Password'],
				$arrayDeDiccionary[0]['Grado'],
                                $arrayDeDiccionary[0]['Foto']
		);
	}
	
        
        
	static public function  traeUsuarioFrontEndConId($id)
	{
		MySQL::conectar(); // Conectar BD
	
		$arrayDeDiccionary = MySQL::leerDatos('SELECT * FROM tabla_usuarios_front_end WHERE Id='.$id);
	
		MySQL::cerrar(); // Cerramos la BD
	
		if(count($arrayDeDiccionary)==0) {
			return null;
		}
	
		return new Usuario(
				$arrayDeDiccionary[0]['Id'],
				$arrayDeDiccionary[0]['Nombre'],
				$arrayDeDiccionary[0]['Email'],
				$arrayDeDiccionary[0]['Telefono'],
				$arrayDeDiccionary[0]['Usuario'],
				$arrayDeDiccionary[0]['Password'],
				$arrayDeDiccionary[0]['Grado'],
                                $arrayDeDiccionary[0]['Foto']
		);
	}
	
	static public function traeUsuarioBackEndConUsuarioYPassword($usu, $pass)
	{
		MySQL::conectar();
		
		$arrayDeDictionary = MySQL::leerDatos('SELECT * FROM tabla_usuarios_back_end WHERE Usuario= "'.$usu.'" AND
					 Password = "'.$pass.'"');
		MySQL::cerrar();
		if(count($arrayDeDictionary)==0){
			echo '<h4 id="usuario_data_source">El usuario no esta registrado</h4>'; 
			return null;			
		}else { 
		return new Usuario($arrayDeDictionary[0]['Id'],  $arrayDeDictionary[0]['Nombre'], 
				$arrayDeDictionary[0]['Email'],	$arrayDeDictionary[0]['Telefono'], $arrayDeDictionary[0]['Usuario'],
				$arrayDeDictionary[0]['Password'], $arrayDeDictionary[0]['Grado'], $arrayDeDictionary[0]['Foto']);	
	          } 
        }
        
        
        
        static public function traeUsuarioFrontEndConUsuarioYPassword($usu, $pass)
	{
		MySQL::conectar();
		
		$arrayDeDictionary = MySQL::leerDatos('SELECT * FROM tabla_usuarios_front_end WHERE Usuario= "'.$usu.'" AND
					 Password = "'.$pass.'"');
		MySQL::cerrar();
		if(count($arrayDeDictionary)==0){
			echo '<h4 id="usuario_data_source">El usuario no esta registrado</h4>'; 
			return null;			
		}else { 
		return new Usuario($arrayDeDictionary[0]['Id'],  $arrayDeDictionary[0]['Nombre'], 
				$arrayDeDictionary[0]['Email'],	$arrayDeDictionary[0]['Telefono'], $arrayDeDictionary[0]['Usuario'],
				$arrayDeDictionary[0]['Password'], $arrayDeDictionary[0]['Grado'], $arrayDeDictionary[0]['Foto']);	
	          } 
        }
        
        static public function comprobarUsuarioFrontEndConUsuarioOPassword($usu, $pass)
	{
		$existe = false;
                MySQL::conectar();
		$arrayDeDictionary = MySQL::leerDatos('SELECT * FROM tabla_usuarios_front_end WHERE Usuario= "'.$usu.'" OR
					 Password = "'.$pass.'"');
		MySQL::cerrar();
		if(count($arrayDeDictionary)>0){
			$existe = true;			
		}
                return $existe;
        }
	 
	static public function actualizaUsuarioBackEnd(Usuario $objetoUsuarioActualizar)
	{
	
		MySQL::conectar(); // Conectar la BD
		// es para actualizar un registro
	    return MySQL::update('UPDATE tabla_usuarios_back_end SET 
				
				Nombre= "'.$objetoUsuarioActualizar->getNombre().'",
				Email= "'.$objetoUsuarioActualizar->getEmail().'",	
				Telefono= '.$objetoUsuarioActualizar->getTelefono().',
				Usuario= "'.$objetoUsuarioActualizar->getUsuario().'",	 						
				Password= "'.$objetoUsuarioActualizar->getPassword().'",
                                Grado= "'.$objetoUsuarioActualizar->getGrado().'",
                                Foto= "'.$objetoUsuarioActualizar->getFoto().'"
                              
                              
				WHERE Id= '.$objetoUsuarioActualizar->getId()
						);
		
			
		MySQL::cerrar(); // Cerrar la BD
		
	}
	
        static public function actualizaUsuarioFrontEnd(Usuario $objetoUsuarioActualizar)
	{
	
            MySQL::conectar(); // Conectar la BD
		// es para actualizar un registro
	    return MySQL::update('UPDATE tabla_usuarios_front_end SET 
				
				Nombre= "'.$objetoUsuarioActualizar->getNombre().'",
				Email= "'.$objetoUsuarioActualizar->getEmail().'",	
				Telefono= '.$objetoUsuarioActualizar->getTelefono().',
				Usuario= "'.$objetoUsuarioActualizar->getUsuario().'",	 						
				Password= "'.$objetoUsuarioActualizar->getPassword().'",
                                Grado= "'.$objetoUsuarioActualizar->getGrado().'",
                                Foto= "'.$objetoUsuarioActualizar->getFoto().'"
				WHERE Id= '.$objetoUsuarioActualizar->getId()
						);
		
			
		MySQL::cerrar(); // Cerrar la BD
		
	}
        
        static public function actualizaUsuarioFrontEndDesdeAdmin(Usuario $objetoUsuarioActualizar)
	{
	
            MySQL::conectar(); // Conectar la BD
		// es para actualizar un registro
	    return MySQL::update('UPDATE tabla_usuarios_front_end SET 
				
				Nombre= "'.$objetoUsuarioActualizar->getNombre().'",
				Email= "'.$objetoUsuarioActualizar->getEmail().'",	
				Telefono= '.$objetoUsuarioActualizar->getTelefono().',
                                Grado= "'.$objetoUsuarioActualizar->getGrado().'"
                                
				WHERE Id= '.$objetoUsuarioActualizar->getId()
						);
		
	}
			
}