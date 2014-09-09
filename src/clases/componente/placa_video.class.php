<?php

/**
 * Representa una placa de video en nuestro sistema.
 *
 * @author Diego Barrionuevo
 * @version 1.0
 */
class PlacaVideo extends Componente {

    private $_nombre;
    private $_memoria;
    private $_chipset;

    function __construct($_id, $_nombre, $_memoria, $_chipset) {
        parent::__construct($_id);
        $this->_nombre = $_nombre;
        $this->_memoria = $_memoria;
        $this->_chipset = $_chipset;
    }

    public function get_nombre() {
        return $this->_nombre;
    }

    public function get_memoria() {
        return $this->_memoria;
    }

    public function get_chipset() {
        return $this->_chipset;
    }

    public function set_nombre($_nombre) {
        $this->_nombre = $_nombre;
    }

    public function set_memoria($_memoria) {
        $this->_memoria = $_memoria;
    }

    public function set_chipset($_chipset) {
        $this->_chipset = $_chipset;
    }

    public function equals($componente) {
        $igual = true;
        $igual &= $this->_chipset === $componente->get_chipset();
        $igual &= $this->memoria === $componente->get_memoria();
        $igual &= $this->nombre === $componente->get_nombre();
        return $igual;
    }

}
