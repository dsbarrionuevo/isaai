<?php

/**
 * 
 *
 * @author Parisi Germán
 * @version 1.0
 */
class TipoCambio {

    private $_id;
    private $_nombre;
    private $_descripcion;

    public function __construct() {
        $this->_id = null;
        $this->_nombre = null;
        $this->_descripcion = null;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_nombre() {
        return $this->_nombre;
    }

    public function set_id($id) {
        $this->_id = $id;
    }

    public function set_nombre($nombre) {
        $this->_nombre = $nombre;
    }

    public function get_descripcion() {
        return $this->_descripcion;
    }

    public function set_descripcion($_descripcion) {
        $this->_descripcion = $_descripcion;
    }

    public static function determinar_tipo_cambio($cambio) {
        $tipos_cambio = array();
        //$tipo_cambio->set_id(1); //TODO por defecto
        if ($cambio->is_maquina_nueva() == true) {
            $tipo_cambio = new TipoCambio();
            $tipo_cambio->set_id(2);
            $tipos_cambio[] = $tipo_cambio;
        }
        $componentes_cambiados = $cambio->get_componentes_cambiados();
        foreach ($componentes_cambiados as $componente_cambiado) {
            if (is_array($componente_cambiado)) {
                $nombre_clase_componente = strtolower(get_class($componente_cambiado[0]));
            } else {
                $nombre_clase_componente = strtolower(get_class($componente_cambiado));
            }
            $id_tipo_cambio;
            switch ($nombre_clase_componente) {
                case("procesador"):
                    $id_tipo_cambio = 3;
                    break;
                case("bios"):
                    $id_tipo_cambio = 4;
                    break;
                case("disco"):
                    $id_tipo_cambio = 5;
                    break;
                case("memoria"):
                    $id_tipo_cambio = 6;
                    break;
                case("monitor"):
                    $id_tipo_cambio = 7;
                    break;
                case("periferico"):
                    $id_tipo_cambio = 8;
                    break;
                case("placared"):
                    $id_tipo_cambio = 9;
                    break;
                case("placasonido"):
                    $id_tipo_cambio = 10;
                    break;
                case("placavideo"):
                    $id_tipo_cambio = 11;
                    break;
            }
            $esta = false;
            foreach ($tipos_cambio as $tipo) {
                if ($tipo->get_id() == $id_tipo_cambio) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $tipo_cambio = new TipoCambio();
                $tipo_cambio->set_id($id_tipo_cambio);
                $tipos_cambio[] = $tipo_cambio;
            }
        }
        $conexion = Conexion::get_instacia(CONEXION_ISAAI);
        $tipos_cambio_final = array();
        if (!empty($tipos_cambio)) {
            $cantidad_cambios = 0;
            foreach ($tipos_cambio as $tipo_cambio_actual) {
                $consulta = "SELECT * FROM tipos_cambio WHERE id = {$tipo_cambio_actual->_id}";
                $resultados = $conexion->consultar_simple($consulta);
                if (!empty($resultados)) {
                    $tipo_cambio_actual->set_nombre($resultados[0]['nombre']);
                    $tipo_cambio_actual->set_descripcion($resultados[0]['descripcion']);
                    $tipos_cambio_final[] = $tipo_cambio_actual;
                    $cantidad_cambios++;
                }
            }
            /*
              //Todos los tipos d cambio esta implicito para cada rol
              if($cantidad_cambios >= 9 ){
              $tipos_cambio_final[] = (new TipoCambio())->set_id(1);
              }
             */
            if ($cantidad_cambios >= 1) {
                $tipo_cambio = new TipoCambio();
                $tipo_cambio->set_id(1);//cualquier cambio
                $consulta = "SELECT * FROM tipos_cambio WHERE id = 1";
                $resultados = $conexion->consultar_simple($consulta);
                if (!empty($resultados)) {
                    $tipo_cambio->set_nombre($resultados[0]['nombre']);
                    $tipo_cambio->set_descripcion($resultados[0]['descripcion']);

                    $tipos_cambio_final[] = $tipo_cambio;
                }
            }
            return $tipos_cambio_final;
        }
    }

}
