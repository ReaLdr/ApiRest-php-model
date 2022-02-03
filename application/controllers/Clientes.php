<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require ( APPPATH.'/libraries/RestController.php');
require ( APPPATH.'/libraries/RestController.php');

require ( APPPATH.'/libraries/Format.php');

use chriskacerguis\RestServer\RestController;

class Clientes extends RestController {
    public function index_get(){
        
        $this->load->helper('utilidades');

        $data = array(
                    'nombre' => 'daniel rea', 
                    'contacto' => 'melissa Flores', 
                    'direccion' => 'redicencial villa'
                );
        
        // $data['nombre'] = strtoupper( $data['nombre'] );
        // $data['contacto'] = strtoupper( $data['contacto'] );

        $campos_capitalizar = array('nombre', 'contacto');

        $data = capitalizar_arreglo( $data, $campos_capitalizar );

        echo json_encode($data);
    }

    public function cliente( $id ){
        $this->load->model('Cliente_model');

        $cliente = $this->Cliente_model->get_cliente($id);

        echo json_encode($cliente);
    }
}