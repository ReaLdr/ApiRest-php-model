<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require ( APPPATH.'/libraries/RestController.php');
require ( APPPATH.'/libraries/RestController.php');

require ( APPPATH.'/libraries/Format.php');

use chriskacerguis\RestServer\RestController;

class Clientes extends RestController {

    public function __construct(){
        // llamado del constructor del padre
        parent::__construct();

        $this->load->database();
        $this->load->model('Cliente_model');
        // $this->load->helper('utilidades');
    }

    public function paginar_get(){
        
        $this->load->helper('paginacion');
        
        $pagina     = $this->uri->segment(3);
        $por_pagina = $this->uri->segment(4);
        $campos = array('id', 'nombre', 'telefono1');

        $respuesta = paginar_todo( 'clientes', $pagina, $por_pagina, $campos );

        $this->response( $respuesta );
    }

    public function cliente_put(){
        $data = $this->put();

        $this->load->library('form_validation');

        $this->form_validation->set_data( $data );

        // $this->form_validation->set_rules( 'correo', 'correo electronico', 'required|valid_email' );

        if($this->form_validation->run( 'cliente_put' )) { //TRUE:: TODO BIEN | FALSE:: FALLA ALGUNA REGLA
            // Todo bien
            $cliente = $this->Cliente_model->set_datos($data);
            $respuesta = $cliente->insert();
            if($respuesta['err']){
                $this->response( $respuesta, RestController::HTTP_BAD_REQUEST );
            } else{
                $this->response( $respuesta );
            }
            
        } else{
            // Algo mal
            $respuesta = array( 'err' => TRUE, 'mensaje' => 'Hay errores en el envío de información', 'errores' => $this->form_validation->get_errores_arreglo() );

            $this->response( $respuesta, RestController::HTTP_BAD_REQUEST );
        }
    }

    public function cliente_get(){

        $cliente_id = $this->uri->segment(3);

        // Validar cleinte_id
        if( !isset($cliente_id) ){
            $respuesta = array('err' => TRUE, 'mensaje' => 'Es necesario el ID del cliente');
            $this->response( $respuesta, RestController::HTTP_BAD_REQUEST );
            return;
        }

        $cliente = $this->Cliente_model->get_cliente($cliente_id);
        // echo json_encode($cliente);
        if(isset($cliente)){
            // unset($cliente->telefono1); // Quitar de la respuesta
            $respuesta = array('err' => FALSE, 'mensaje' => 'Registro cargado correctamente.', 'cliente' => $cliente);
            $this->response( $respuesta );
        } else{
            $respuesta = array('err' => TRUE, 'mensaje' => 'El registro con el id ' . $cliente_id . ' no existe.', 'cliente' => null);
            $this->response( $respuesta, RestController::HTTP_NOT_FOUND );
        }


    }
}