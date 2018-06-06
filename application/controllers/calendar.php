<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller
{

    public function __construct() {
        Parent::__construct();
        $this->load->model("Calendar_model","calendario",true);

    }

    public function index()
    {
        $this->load->view("calendar/index.php", array());
    }

    public function traeEvento(){
        $res = $this -> calendario -> getEventos();
        echo json_encode($res);
    }


    public function modificaFechaEvento(){
        $parametros['id_evento'] = $this->input->post('id');
        $parametros['fecha_inicio'] = $this->input->post('fecha_inicio');
        $parametros['fecha_fin'] = $this->input->post('fecha_fin');

        $r = $this-> calendario -> updateEvento($parametros);

        echo $r;
    }

    public function borrarEvento($parametros){
        $id = $this->input->post('id');
        $r = $this-> calendario -> borrar($id);
        echo $r;
    }

    public function modificarEvento(){
        $parametros['id'] = $this->input->post('id');
        $parametros['nombre'] = $this->input->post('nombre');
        $parametros['descripcion'] = $this->input->post('descripcion');
        $r = $this-> calendario -> modificarEvento($parametros);
        echo $r;
    }

}

?>
