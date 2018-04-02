<?php


// Importaciones
require_once 'administrador/TipoGrado.php';
require_once 'administrador/MySQL.php';

abstract class TipoGradoDataSource
{
		
	// Metodos
	static public function todosLosTiposDeGrado()
	{
		// Conectas la BD
		MySQL::conectar();
		
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT * FROM tabla_tipo_grado');
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
			// Creamos objeto array de clase TipoUsuario
			$arrayDeObjetos[] = new TipoGrado($diccionary['Id'], 
					$diccionary['Nombre']);
			 
			// Ejemplo: $arrayDeObjetos[dicc1,dicc2,...];
		}
		// devolvemos el array de diccionarios
		return $arrayDeObjetos;
	}
	
	// Funcion para borrar una TipoUsuario 
	static public function borrarConId($id)
	{
		// Conectamos la BD
		MySQL::conectar();
		
		// Eliminamos un registro por id
		$resultado=MySQL::eliminar('DELETE FROM tabla_tipo_grado WHERE Id='.$id);
		
		MySQL::cerrar(); // Cerrar BD
		
		return $resultado; 
	}
	
	/*
	 * Esta funcion lo que hace es guardar en la BD 
	 * de manera permanente, los valores que le pasamos
	 * dentro del objeto $objetoTipoUsuarioActualizar
	 */
	static public function actualizaTipoGrado(TipoGrado $objetoTipoGradoActualizar)
	{
		MySQL::conectar(); // Conectar la BD
		
		
		// es para actualizar un registro
		MySQL::update('UPDATE tabla_tipo_grado SET Nombre="'
				.$objetoTipoGradoActualizar->getNombre().'" WHERE Id= '
				.$objetoTipoGradoActualizar->getId());
			
		MySQL::cerrar(); // Cerrar la BD
	}
	
	static public function nuevoTipoGrado($nombre)
	{
		MySQL::conectar(); // Conectar la BD
		
		// Crea un objeto de TipoUsuario
		$idNuevoTipoUsuario = MySQL::insertar
		  ('INSERT INTO tabla_tipo_grado (Nombre) 
		  		VALUES("'.$nombre.'")');
		
		MySQL::cerrar(); // Cerrar la BD
		
		// Devuelve un objeto TipoUsuario
		return new TipoGrado($idNuevoTipoGrado, $nombre);
			
	}
	
	static public function TipoGradoConId($id)
	{
		MySQL::conectar(); // Conectar BD
	
		$arrayDeDiccionary = MySQL::leerDatos('SELECT * FROM tabla_tipo_grado WHERE id='.$id);
	
		MySQL::cerrar(); // Cerramos la BD
	
		if(count($arrayDeDiccionary)==0) {
			return null;
		}
	
		return new TipoUsuario($arrayDeDiccionary[0]['Id'],
						$arrayDeDiccionary[0]['Nombre']);
	}
	
}
