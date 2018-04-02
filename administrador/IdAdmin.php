<?php

 class IdAdmin
{
     
    private $_idAdmin;
    
    public function __construct($id)
    {
        $this->_idAdmin = $id;
                
    }
    
    public function getIdAdmin()
    {
        return $this->_idAdmin;
    }
}
