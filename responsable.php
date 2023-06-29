<?php
include_once('BaseDatos.php');

class responsable{
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeoperacion;

    public function __construct(){
        $this->rnumeroempleado=0;
        $this->rnumerolicencia=0;
        $this->rnombre="";
        $this->rapellido="";
    }

    public function cargar($rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido){
        $this->setRnumeroempleado($rnumeroempleado);
        $this->setRnumerolicencia($rnumerolicencia);
        $this->setRnombre($rnombre);
        $this->setRapellido($rapellido);

    }


    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado($rnumeroempleado)
    {
        $this->rnumeroempleado = $rnumeroempleado;

        return $this;
    }


    public function getRnumerolicencia()
    {
        return $this->rnumerolicencia;
    }

    public function setRnumerolicencia($rnumerolicencia)
    {
        $this->rnumerolicencia = $rnumerolicencia;

        return $this;
    }

 
    public function getRnombre()
    {
        return $this->rnombre;
    }
 
    public function setRnombre($rnombre)
    {
        $this->rnombre = $rnombre;

        return $this;
    }


    public function getRapellido()
    {
        return $this->rapellido;
    }

    public function setRapellido($rapellido)
    {
        $this->rapellido = $rapellido;

        return $this;
    }


    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;

        return $this;
    }

    public function Buscar($rnumeroempleado){
        $base= new BaseDatos();
        $consultaResponsable= "select * from responsable where rnumeroempleado=".$rnumeroempleado;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaResponsable)){
                if($row2=$base->Registro()){
                 
                    $this->cargar($rnumeroempleado,$row2['rnumerolicencia'],$row2['rnombre'],$row2['rapellido']);
                    $resp= true;
                }
            } else{
                $this->setMensajeoperacion($base->getError());
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }
        return $resp;
    }

    public static function listar($condicion=""){
        $mensajeError= "";
        $arregloResponsable= null;
        $base= new BaseDatos();
        $consultaResponsable= "select * from responsable ";
        if($condicion != ""){
            $consultaResponsable= $consultaResponsable.'where'.$condicion;
        }
        $consultaResponsable.= "order by rnumeroempleado";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaResponsable)){
                $arregloResponsable= array();
                while($row2=$base->Registro()){
                    $nroempleado=$row2['rnumeroempleado'];
                    $nrolicencia=$row2['rnumerolicencia'];
                    $nombre= $row2['rnombre'];
                    $apellido= $row2['rapellido'];
                    $resp= new responsable();
                    $resp->cargar($nroempleado,$nrolicencia,$nombre,$apellido);
                    array_push($arregloResponsable,$resp);
                }
            } else {
           
              $this->setMensajeoperacion($base->getError());

            }
        } else{
       
           $this->setMensajeoperacion($base->getError());

        } return $arregloResponsable;
    }

    public function insertar(){
        $base= new BaseDatos();
        $resp= false;
        $consultaInsertar= "INSERT INTO responsable (rnumerolicencia, rnombre, rapellido)
        VALUES ('".$this->getRnumerolicencia()."', '".$this->getRnombre()."', '".$this->getRapellido()."')";
        if($base->Iniciar()){
            if($id = $base->Ejecutar($consultaInsertar)){
                $resp= true;
            } else {
                $this->setMensajeoperacion($base->getError());
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }   
        return $resp;
    }

    public function modificar($nroempamodificar){
        $resp= false;
        $base= new BaseDatos();
        $consultaModifica= "UPDATE responsable SET rnumerolicencia='".$this->getRnumerolicencia()."', rnombre='".
        $this->getRnombre()."', rapellido='".$this->getRapellido()."' WHERE rnumeroempleado=".$nroempamodificar;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModifica)){
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function eliminar($nroempaeliminar){
        $base= new BaseDatos();
        $resp= false;
        if($base->Iniciar()){
            $consultaBorra= "DELETE FROM responsable WHERE rnumeroempleado=".$nroempaeliminar;
            if($base->Ejecutar($consultaBorra)){
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
            return $resp;
        }
    }

 

    public function __toString(){
        return "\n=>Responsable\n ".
        "Nro Empleado: ".$this->getRnumeroempleado().
        "\nNro Licencia: ".$this->getRnumerolicencia().
        "\nNombre: ".$this->getRnombre().
        "\nApellido: ".$this->getRapellido()."\n";
    }







}
    
