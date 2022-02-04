<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require ( APPPATH.'/libraries/RestController.php');
require ( APPPATH.'/libraries/Format.php');

use chriskacerguis\RestServer\RestController;

class Facturacion extends RestController {

    public function factura_get(){

        $factura_id = $this->uri->segment(3);

        $this->load->database();

        $this->db->where( 'factura_id', $factura_id );
        $query = $this->db->get('facturacion');
        $factura = $query->row();
        
        $this->db->reset_query();
        
        $this->db->where( 'factura_id', $factura_id );
        $query = $this->db->get('facturacion_detalle');

        $detalle = $query->result();


        $respuesta = array(
            'err' => FALSE,
            'mensaje' => 'Factura cargada correctamente',
            'factura' => $factura,
            'detalle' => $detalle
        );

        $this->response($respuesta);

        echo $factura_id;
    }

}