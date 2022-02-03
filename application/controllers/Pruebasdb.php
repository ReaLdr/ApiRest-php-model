<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

    public function __construct(){
        // llamado del constructor del padre
        parent::__construct();

        $this->load->database();
        $this->load->helper('utilidades');
    }

    public function insertar(){

        // =============================== //
        // INSERTAR UN REGISTRO A LA VEZ            
        // =============================== //
        /* $data = array(
            'nombre' => 'leonardó daniel',
            'apellido' => 'rea martínez'
        );

        $data = capitalizar_todo( $data );
    
        $this->db->insert('test', $data);
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')

        $respuesta = array(
            'err' => FALSE,
            'id_inserted' => $this->db->insert_id()
        );

        echo json_encode($respuesta); */


        // =============================== //
        // INSERTAR MÚLTIPLES REGISTROS A LA VEZ
        // =============================== //

        $data = array(
                    array(
                        'nombre' => 'verónica',
                        'apellido' => 'martínez'
                    ),
                    array(
                        'nombre' => 'juan',
                        'apellido' => 'pérez'
                    )
                );
    
        $this->db->insert_batch('test', $data);
        echo $this->db->affected_rows();
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date'),  ('Another title', 'Another name', 'Another date')

    }

    public function actualizar(){
        
        $data = array(
            'nombre' => 'victor',
            'apellido' => 'martínez'
        );

        $data = capitalizar_todo( $data );
        
        $this->db->where('id', 1);
        $this->db->update('test', $data);
        echo "todo ok!";
        // Produces:
        //
        //      UPDATE mytable
        //      SET title = '{$title}', name = '{$name}', date = '{$date}'
        //      WHERE id = $id
        
    }

    public function eliminar(){
        $this->db->where('id', 1);
        $this->db->delete('test');

        echo "Eliminado!";

        // Produces:
        // DELETE FROM mytable
        // WHERE id = $id
    }

    public function tabla(){

        $this->db->select('id, nombre, correo');
        $this->db->from('clientes');
        $this->db->where('id  <', 10); // Produces: WHERE name = 'Joe'
        $this->db->where('activo', 1);
        $query = $this->db->get();  // Produces: SELECT id, nombre, correo FROM clientes

        echo json_encode($query->result());
        
    }

    public function clientes_beta(){

        // $this->load->database();

        $query = $this->db->query('SELECT id, nombre, correo, telefono1 FROM clientes limit 10');
        
        /* foreach ($query->result() as $row){
            echo $row->id;
            echo $row->nombre;
            echo $row->correo;
        } */
        
        // echo 'Total registros: ' . $query->num_rows();
        
        $respuesta = array(
            'err'=> FALSE,
            'mensaje' => 'Registros cargados correctamente',
            'total_registros' => $query->num_rows(),
            'clientes' => $query->result()
        );
        
        echo json_encode($respuesta);
    }
    
    public function cliente( $id ){
        // $this->load->database();
        
        $query = $this->db->query('SELECT * FROM clientes WHERE id = ' . $id);
        $fila = $query->row();

        if(isset($fila)){
            // Fila existe
            $respuesta = array(
                'err'=> FALSE,
                'mensaje' => 'Registros cargado correctamente',
                // 'total_registros' => $query->num_rows(),
                'cliente' => $fila
            );
        } else{
            // Fila no existe
            $respuesta = array(
                'err'=> TRUE,
                'mensaje' => 'El registro con el id ('.$id.') no existe ',
                'total_registros' => 0,
                'cliente' => null
            );
        }

        echo json_encode($respuesta);
        
    }

}