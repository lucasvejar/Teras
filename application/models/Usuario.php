<?php

class Usuario extends DataMapper{

    var $table = 'usuario';


    // constructor de la clase Usuario
    public function __construct($dni = null)
    {
        parent:: __construct($dni);
    }



    var $validation = array(
        'dni'                => array('label' => 'dni',
                                     'rules' => array('required','unique')),
        'password'        => array('label' => 'password',
                                     'rules'=>array('encrypt')),
        'nombre'            => array('label' => 'nombre'),
        'apellido'            => array('label' => 'apellido'),
        'email'                => array('label' => 'email',
                                       'rules' => array('required'))

    );



    public function _encrypt($field)
    {
        // Don't encrypt an empty string
        if (!empty($this->{$field}))
        {
            // Generate a random salt if empty
            if (empty($this->salt))
            {
                $this->salt = md5(uniqid(rand(), true));
            }

            $this->{$field} = sha1($this->salt . $this->{$field});
        }
    }

    public function creoUsuario($dni,$nombre,$apellido,$password,$email)
    {
        $u = new Usuario();
        $u -> nombre = $nombre;
        $u -> dni = $dni;
        $u -> apellido = $apellido;
        $u -> password = $password;
        $u -> email = $email;
        $u -> save();
    }


    public function buscarUsuario($valorBusqueda = null)
    {
        if ($valorBusqueda != null){
            $this -> where('dni',$valorBusqueda);
            $this -> or_where('nombre',$valorBusqueda);
            $this-> or_where('email',$valorBusqueda) ->get();
        } else {
            $this -> get();
        }
        return $this;
    }

    public function eliminarUsuario($dni){
        $u = new Usuario();
        $u -> where('dni',$dni)-> get();
        $this-> get_by_id($u->id);
        if ($this->delete()){
            echo "Se borro correctamente el elemento.";
        }else{
            echo " No se pudo borrar el elemento.";
        }
    }



}

?>
