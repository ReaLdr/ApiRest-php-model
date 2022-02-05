<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {


    
    public $id;
    public $nombre;
    public $activo;
    public $correo;
    public $zip;
    public $telefono1;
    public $telefono2;
    public $pais;
    public $direccion;

    public function get_cliente( $id ){
        $this->db->where( array( 'id'=>$id, 'status' => 'activo' ) );
        $query = $this->db->get( 'clientes' );

        $row = $query->custom_row_object(0, 'Cliente_model');

        if(isset($row)){
            $row->id        = intval($row->id);
            $row->activo    = intval($row->activo);
        }


        return $row;
    }

    public function set_datos( $data_cruda_post ){

        foreach ($data_cruda_post as $nombre_campo => $valor_campo) {
            if( property_exists('Cliente_model', $nombre_campo) ){
                $this->$nombre_campo = $valor_campo;
            }
        }

        if( $this->activo == NULL ){
            $this->activo = 1;
        }

        $this->nombre = mb_strtoupper( $this->nombre );

        return $this;

    }

    public function insert(){
        
        // Verificar el correo
        $query = $this->db->get_where( 'clientes', array('correo' =>$this->correo ) );
        $cliente_correo = $query->row();

        if(isset( $cliente_correo )){
            // EXISTE
            $respuesta = array( 'err' =>TRUE, 'mensaje' => 'El correo electrónico ya está registrado' );
            // $this->response( $respuesta, RestController::HTTP_BAD_REQUEST );
            return $respuesta;
        }

        // $cliente = $this->Cliente_model->set_datos($data);

        $exe_insert = $this->db->insert('clientes', $this );

        if($exe_insert){
            // insertado
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro insertado correctamente',
                'cliente_id' => $this->db->insert_id()
            );
        } else{
            // no sucedio
            $respuesta = array(
                'err' =>TRUE,
                'mensaje' => 'Error al insertar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number() );
        }

        return $respuesta;
        
    }
    
    public function update(){
        
        // Verificar el correo
        $this->db->where( 'correo =', $this->correo );
        $this->db->where( 'id !=', $this->id );
        $query = $this->db->get( 'clientes' );

        $cliente_correo = $query->row();

        if(isset( $cliente_correo )){
            // EXISTE
            $respuesta = array( 'err' =>TRUE, 'mensaje' => 'El correo electrónico ya está registrado por otro usuario' );
            // $this->response( $respuesta, RestController::HTTP_BAD_REQUEST );
            return $respuesta;
        }

        $this->db->reset_query();

        $this->db->where('id', $this->id );

        $exe_insert = $this->db->update('clientes', $this );

        if($exe_insert){
            // insertado
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro actualizado correctamente',
                'cliente_id' => $this->id
            );
        } else{
            // no sucedio
            $respuesta = array(
                'err' =>TRUE,
                'mensaje' => 'Error al actualizar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number() );
        }

        return $respuesta;
        
    }
    
    
    public function delete( $cliente_id ){

        $this->db->set('status', 'borrado');
        $this->db->where('id', $cliente_id);

        $exe_delete = $this->db->update('clientes');

        if($exe_delete){
            // insertado
            $respuesta = array(
                'err' => FALSE,
                'mensaje' => 'Registro eliminado correctamente'
            );
        } else{
            // no sucedio
            $respuesta = array(
                'err' =>TRUE,
                'mensaje' => 'Error al eliminar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->_error_number() );
        }

        return $respuesta;
    }



}

