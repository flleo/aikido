<?php 
// Importaciones
require_once 'Curso.php';
require_once 'MySQL.php';

abstract class CursoDataSource
{

	// Metodos

    // Funcion para borrar un usuario
	static public function borrarCursoConId($idCurso)
	{
		// Conectamos la BD
		MySQL::conectar();
		// Eliminamos un registro por id
		$resultado=MySQL::eliminar('DELETE FROM tabla_cursos WHERE Id='.$idCurso);
		MySQL::cerrar(); // Cerrar BD
		return $resultado;
	}
    
	  static public function comprobarFechaCurso($fechaInicio, $fechaFin)
       {
        $existe;
        MySQL::conectar();
        $numeroCursos = MySQL::leerDatos('SELECT COUNT(*) FROM tabla_cursos WHERE FechaInicio BETWEEN ' . $fechaInicio . ' AND
					  ' . $fechaFin . ' OR FechaFin BETWEEN ' . $fechaInicio . ' AND
					  ' . $fechaFin . '');
        MySQL::cerrar();
        if ($numeroCursos > 0) {$existe = true;}
        else{$existe = false;}
        
        return $existe;
    }
	
	
	
        static public function nuevoCurso( $fechaInicio, $fechaFin, $curso, $puntos, $precioSocio, $precioNoSocio, $pagado)
	{
		MySQL::conectar(); // Conectar la BD
		// Crea un objeto de Usuario
		$idNuevoCurso = MySQL::insertar ('INSERT INTO tabla_cursos  (FechaInicio,FechaFin,Curso,Puntos,PrecioSocio,PrecioNoSocio,Pagado) VALUES("'.$fechaInicio.'", "'.$fechaFin.'", "'.$curso.'","'.$puntos.'", "'.$precioSocio.'","'.$precioNoSocio.'", "'.$pagado.'")');
		MySQL::cerrar(); // Cerrar la BD
		// Devuelve un objeto Usuario
                if($idNuevoCurso!=null){
                    return new Usuario(
                                    $idNuevoCurso,
                                    $fechaInicio,
                                    $fechaFin,
                                    $curso,
                                    $puntos,
                                    $precioSocio,
                                    $precioNoSocio,
                                    $pagado
                    );
                }
	}
	
	static public function todosLosCursos()
	{
		// Conectas la BD
		MySQL::conectar(); 
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT * FROM tabla_cursos');
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
			$arrayDeObjetos[] = new Curso
                            ($diccionary['Id'],
                             $diccionary['FechaInicio'],
                             $diccionary['FechaFin'],
                             $diccionary['Curso'],
                             $diccionary['PrecioSocio'],
                             $diccionary['PrecioNoSocio'],
                             $diccionary['Puntos'], 
                             $diccionary['Pagado']
                             );
			// Ejemplo: $arrayDeObjetos[dicc1,dicc2,...];
		}
		// devolvemos el array de array
		return $arrayDeObjetos;
	}
        
       
	
	static public function todosLosUsuariosDelCurso($idCurso)
	{
		// Conectas la BD
		MySQL::conectar();
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT IdUsuario FROM  tabla_cursos_usuarios where IdCurso ='.$idCurso);
		// Cerramos la BD
		MySQL::cerrar();
		// devolvemos el array de array
		return $arrayDiccionary;
	}
        
        static public function todosLosCursosDelUsuario($idUsuario)
	{
		// Conectas la BD
		MySQL::conectar();
		// Creas un array de diccionarios una variable normal y corriente
		$arrayDiccionary = MySQL::leerDatos('SELECT * FROM tabla_cursos where Id in 
                        (SELECT IdCurso FROM  tabla_cursos_usuarios where IdUsuario = '.$idUsuario.')');
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
			$arrayDeObjetos[] = new Curso
				   (    $diccionary['Id'],
					$diccionary['FechaInicio'],
                                        $diccionary['FechaFin'],
					$diccionary['Curso'],
                                        $diccionary['PrecioSocio'],
                                        $diccionary['PrecioNoSocio'],
					$diccionary['Puntos'],
					$diccionary['Pagado']
					);
			// Ejemplo: $arrayDeObjetos[dicc1,dicc2,...];
		}
		// devolvemos el array de array
		return $arrayDeObjetos;
	}
        
     

	static public function  traeCursoConId($id)
	{
		MySQL::conectar(); // Conectar BD
	
		$arrayDeDiccionary = MySQL::leerDatos('SELECT * FROM tabla_cursos WHERE Id='.$id);
	
		MySQL::cerrar(); // Cerramos la BD
	
		if(count($arrayDeDiccionary)==0) {
			return null;
		}
	
		return new Curso(
                                        $arrayDeDiccionary[0]['Id'],
					$arrayDeDiccionary[0]['FechaInicio'],
                                        $arrayDeDiccionary[0]['FechaFin'],
					$arrayDeDiccionary[0]['Curso'],
                                        $arrayDeDiccionary[0]['PrecioSocio'],
                                        $arrayDeDiccionary[0]['PrecioNoSocio'],
					$arrayDeDiccionary[0]['Puntos'],
					$arrayDeDiccionary[0]['Pagado']
		);
	}
	
	static public function actualizaCurso(Curso $objetoCursoActualizar)
	{
            MySQL::conectar(); // Conectar la BD
		// es para actualizar un registro
	    return MySQL::update('UPDATE tabla_cursos SET 
                
				FechaInicio= "'.$objetoCursoActualizar->getFechaInicio().'",
                                FechaFin= "'.$objetoCursoActualizar->getFechaFin().'",
				Curso= "'.$objetoCursoActualizar->getCurso().'",
                                PrecioSocio= "'.$objetoCursoActualizar->getPrecioSocio().'",
                                PrecioNoSocio= "'.$objetoCursoActualizar->getPrecioNoSocio().'",
				Puntos= '.$objetoCursoActualizar->getPuntos().',
				Pagado= "'.$objetoCursoActualizar->getPagado().'"	
                                    
				WHERE Id= '.$objetoCursoActualizar->getId()
						);
            
	}			
}