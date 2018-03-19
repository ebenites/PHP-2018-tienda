<?php
class Producto {
    
    public function getPrecio() {
        return 'S/.' . $this->precio;
    }
    
    public function getEstado() {
        return $this->estado == 1?"Activo":"Inactivo";
    }
    
}
