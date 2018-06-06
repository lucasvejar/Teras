<?php     if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{


    public function __construct(){
        parent::__construct();
        $this -> load -> model("Usuario","modeloUsuario",true);
    }

    public function index(){
        //ANDA BIEN $this -> modeloUsuario -> creoUsuario(38156798,"Alberto","Rodriguez","2222","l@gmail.com");
        //ANDA BIEN $r = $this -> modeloUsuario -> buscarUsuario('lucasficus@gmail.com');
        //ANDA BIEN $this-> modeloUsuario -> eliminarUsuario(123456);
    }



}

?>
