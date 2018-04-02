<?php

abstract class Acceso
{
	CONST MIN_EXPIRED = 5;
	
	static public function estaLogueado()//esta funcion devolvera verdadero o falso.
	{
		$valor_devuelto = false;
		session_cache_expire(self::MIN_EXPIRED);//tiempo que dura la sesion(cuando se abra)
           
                    //session_start();//iniciamos la sesion, si estaba abierta solo renueva el cache, sigue usando la anterior
		
                    if(isset($_SESSION)){ //$_SESSION es una variable que indica que si estas conectado o no
                            $sessionLife = time()-$_SESSION['start']; //time() es el tiempo ahora, da el intervalo en segundos

                            if($sessionLife < (60*self::MIN_EXPIRED)){//60*self::MIN_EXPIRE dara el tiempo en segundos.
                                    $valor_devuelto = true;
                                    $_SESSION['start'] = time();//renovamos la sesion
                            }
                    }
                    else {
                            session_start();//iniciamos la sesion, si estaba abierta solo renueva el cache, sigue usando la anterior
                            $valor_devuelto = true;
                    }
               
                
		
		return $valor_devuelto;
	}
	
	static public function logIn()
	{
		session_cache_expire(self::MIN_EXPIRED);
		//session_start();
		$_SESSION['start'] = time();
	}
	
	static public function endSesion()
	{
		//session_start();
		$_SESSION = array();
		session_destroy();
	}
}