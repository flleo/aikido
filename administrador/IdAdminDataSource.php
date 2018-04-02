<?php
require_once 'IdAdmin.php';
require_once 'MySQL.php';

abstract class IdAdminDataSource
{

	// Metodos

	static public function nuevoUsuario( $idAdmin)
	{
	
		MySQL::conectar(); // Conectar la BD
	
		// Crea un objeto de Usuario
		$id = MySQL::insertar ('INSERT INTO tabla_idAdmin (IdAdmin) 
				VALUES("'.$idAdmin.'")');
	
		MySQL::cerrar(); // Cerrar la BD
	
		// Devuelve un objeto Usuario
                if($id!=null){
                    return new IdAdmin($idAdmin);
                }
	}
      
        static public function  traeUsuario()
	{
		MySQL::conectar(); // Conectar BD
	
		$arrayDeDiccionary = MySQL::leerDatos('SELECT * FROM tabla_idAdmin ');
	
		MySQL::cerrar(); // Cerramos la BD
	
		if(count($arrayDeDiccionary)==0) {
			return null;
		}
	
		return new IdAdmin(
				$arrayDeDiccionary[0]['IdAdmin']
				
		);
	}
        
        static public function borrar(){
                MySQL::conectar(); // Conectar BD
		$resultado = MySQL::eliminar('TRUNCATE TABLE tabla_idAdmin');
		MySQL::cerrar(); // Cerramos la BD
		return $resultado;
        }
	
}