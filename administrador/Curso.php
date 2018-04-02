<?php

class Curso
{
	// Atributos
	private $_id;
	private $_fechaInicio;
        private $_fechaFin;
	private $_curso;
	private $_puntos;
        private $_precioSocio;
        private $_precioNoSocio;
	private $_pagado;
	
	
	// Gets
	public function getId()
	{
		return $this->_id;
	}
	
	
	public function getFechaInicio()
	{
		return $this->_fechaInicio;
	}
        
        public function getFechaFin()
	{
		return $this->_fechaFin;
	}
	
	public function getCurso()
	{
		return $this->_curso;
	}
	
	public function getPuntos()
	{
		return $this->_puntos;
	}
	
        public function getPrecioSocio()
        {
            return $this->_precioSocio;
        }
        
        public function getPrecioNoSocio()
        {
            return $this->_precioNoSocio;
        }
        
	public function getPagado()
	{
		return $this->_pagado;
	}
	     
	
	public function __construct(
									$id,
									$fechaInicio,
                                                                        $fechaFin,
									$curso,
                                                                        $puntos,
                                                                        $precioSocio,
                                                                        $precioNoSocio,
									$pagado 
								)
	{ 
		$this->_id=$id;
		$this->_fechaInicio=$fechaInicio;
                $this->_fechaFin=$fechaFin;
		$this->_curso=$curso;
                $this->_puntos=$puntos;
                $this->_precioSocio=$precioSocio;
                $this->_precioNoSocio=$precioNoSocio;
		$this->_pagado=$pagado;
	}
		
}