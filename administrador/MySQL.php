<?php


abstract class MySQL 
{
	// Atributos
	const USUARIO='root';//u745303872_fede';
	const CLAVE='';//vat2StopH';
	const SERVIDOR='localhost';
	const BD='bdaikido';//u745303872_aiki';
	static private $_conexion;
	
     // Atributos
   

	// Metodo para conectar a la base de datos//////////////////////////////////////////////////////
	static public function conectar()
	{
		// self (para constantes y varibles estaticas)
           
		self::$_conexion=mysqli_connect(self::SERVIDOR, self::USUARIO, self::CLAVE, self::BD);
                
	}
	
	// Para cerrar la conexion//////////////////////////////////////////////////////////////////////
	static public function cerrar()
	{
		// funcion para cerrar la conexion de BD
		mysqli_close(self::$_conexion);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	static public function leerDatos($sql)
	{
	
		$resultado = mysqli_query(self::$_conexion, $sql); 
		$returnArray=array();
		 
		
		// mysql_fetch_array
                if($resultado!=null) {
		
		while($fila=mysqli_fetch_assoc ( $resultado )) {

			// Aqui se mete cada diccionario en el array
			$returnArray[]=$fila;
					
		  }
		    return $returnArray; // devuelve el array de arrays
	  } else { return null;}
	}
	
	// Metodo para borrar un registro/////////////////////////////////////////////////////////////////////////
	static public function eliminar($sql)
	{
		/* Le pasamos la consulta SQL, y le 
		 * pasamos la conexion
		 */
		
		try { // Donde puede dar error
			
		// Los registros los vamos a eliminar de 1 en 1
		$resultado = mysqli_query(self::$_conexion, $sql); 
	    // $resultado va guardar un valor booleano	
	        
		}
		
		// Aqui se gestiona el error
		catch (Exception $e){
			$resultado = false;
		}
               
		return $resultado;  
	}
	
	// Metodo para actualizar un registro /////////////////////////////////////////////////////////////////////
	static public function update($sql)
	{
		try{
			$resultado = mysqli_query(self::$_conexion, $sql); 
		}
		catch(Exception $e){
			return $resultado = false;
		}
		return $resultado;
	}
	
	// Inserta un nuevo registro/////////////////////////////////////////////////////////////////////////////
	static public function insertar($sql)
	{
	 	/* Le pasamos la consulta SQL, y le
	 	 * pasamos la conexion
	 	*/
	 	$respuesta = mysqli_query(self::$_conexion,$sql);
	 	// Se le ingresa un nuevo registro
	 	
	 	// Devuelve la ultima id creada
	 	// echo "NOTA SIGNIFICATIVA: <br>Esta es la ultima posicion ".mysql_insert_id();
                return $respuesta;//mysqli_insert_id(self::$_conexion);
	 	
	} 	 
}
?>				