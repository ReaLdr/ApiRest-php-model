<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meses extends CI_Controller {

    public function mes( $mes ){

        //cargar helpers
        $this->load->helper('utilidades');
        echo json_encode(obtener_mes( $mes ));

        /* $mes -= 1;
        $meses = array(
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        );

        echo json_encode($meses[$mes]); */
    }
    
}