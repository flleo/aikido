<?php



class TipoUsuario {
	
	// Atributos
	private $_id;
	private $_nombre;

	// Gets
	public function getId()
	{
		return $this->_id;
	}
	
	public function getNombre()
	{
		return $this->_nombre;
	}
	
	public function __construct($id, $nombre) 
	{
		$this->_id=$id;
		$this->_nombre=$nombre;
	}
}