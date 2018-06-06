<?php

class Calendar_Model extends CI_Model
{

    public function getEventos(){
        $this->db->select('id, title, start, end, description');
        $this->db->from('calendar_events');

        return $this->db->get()->result();
    }



    public function updateEvento($parametros){
        $campos = array(
            'start' => $parametros['fecha_inicio'],
            'end' => $parametros['fecha_fin']
        );

        $this->db->where('id',$parametros['id_evento']);
        $this->db->update('calendar_events',$campos);

        if ($this->db->affected_rows() == 1) {
            return 1;
        }else{
            return 0;
        }
    }

    public function borrar($id){
        $this->db->where('id',$id);
        return $this->db->delete('calendar_events');
    }

    public function modificarEvento($parametros){
        $campos = array(
            'title' => $parametros['nombre'],
            'description' => $parametros['descripcion']
        );

        $this->db->where('id',$parametros['id']);
        $this->db->update('calendar_events',$campos);

        if ($this->db->affected_rows() == 1) {
            return 1;
        }else{
            return 0;
        }
    }

}

?>
