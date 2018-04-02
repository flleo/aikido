<?php

class Usuario
{
	// Atributos
	private $_id;
	private $_nombre;
	private $_email;
	private $_telefono;
	private $_usuario;
	private $_password;
	private $_grado;
        private $_foto;
	
	// Gets
	public function getId()
	{
		return $this->_id;
	}
	
	
	public function getNombre()
	{
		return $this->_nombre;
	}
	
	public function getEmail()
	{
		return $this->_email;
	}
	
	public function getTelefono()
	{
		return $this->_telefono;
	}
	
	public function getUsuario()
	{
		return $this->_usuario;
	}
	
	public function getPassword()
	{
		return $this->_password;
	}
	
	public function getGrado()
	{
		return $this->_grado;
	}
        
        public function getFoto()
	{
		return $this->_foto;
	}
     
	
	public function __construct(
									$id,
									$nombre,
									$email,
			 						$telefono, 
									$usuario, 
									$password,
									$grado,
                                                                        $foto
								)
	{ 
		$this->_id=$id;
		$this->_nombre=$nombre;
		$this->_email=$email;
		$this->_telefono=$telefono;
		$this->_usuario=$usuario;
		$this->_password=$password;
		$this->_grado=$grado;
                $this->_foto=$foto;
	}
		
}