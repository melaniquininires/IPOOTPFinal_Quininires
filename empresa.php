<?php

include_once('BaseDatos.php');

class empresa{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;

    public function __construct(){
        $this->idempresa=0;
        $this->enombre="";
        $this->edireccion="";
    }
    
    public function cargar($idempresa,$enombre,$edireccion){
        
        $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }

    function getIdempresa()
    {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;

        return $this;
    }


    public function getEnombre()
    {
        return $this->enombre;
    }


    public function setEnombre($enombre)
    {
        $this->enombre = $enombre;

        return $this;
    }

 
    public function getEdireccion()
    {
        return $this->edireccion;
    }


    public function setEdireccion($edireccion)
    {
        $this->edireccion = $edireccion;

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

   

    public function Buscar($idempresa){
        $base= new BaseDatos();
        $consultaEmpresa="Select * from empresa where idempresa=".$idempresa;
        $resp= false;
        if($base->Iniciar()){
        if($base->Ejecutar($consultaEmpresa)){
            if($row2=$base->Registro()){
                $this->cargar($idempresa,$row2['enombre'],$row2['edireccion']);
                $resp= true;
            }
        } else {
            $this->setMensajeoperacion($base->getError());
        } 
    } else{
        $this->setMensajeoperacion($base->getError());
    }
        return $resp;
    }

    public static function listar($condicion=""){
        $mensajeError= "";
        $arregloEmpresa= null;
        $base= new BaseDatos();
        $consultaEmpresas= "select * from empresa ";
        if($condicion != ""){
            $consultaEmpresas= $consultaEmpresas.'where '.$condicion;
        }
        $consultaEmpresas.= "order by idempresa";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresas)){
                $arregloEmpresa= array();
                while($row2=$base->Registro()){
                    $id=$row2['idempresa'];
                    $nombre=$row2['enombre'];
                    $direccion=$row2['edireccion'];
                    $empre= new empresa();
                    
                    $empre->cargar($id,$nombre,$direccion); 
                    array_push($arregloEmpresa, $empre);
                }
            } else{
              
                $this->setMensajeoperacion($base->getError());

            }
        } else{
          
           $this->setMensajeoperacion($base->getError());

        } return $arregloEmpresa;
    }


    public function insertar(){
        $base= new BaseDatos();
        $resp= false;
        $consultaInsertar="INSERT INTO empresa (enombre, edireccion)
        VALUES ('".$this->getEnombre()."', '".$this->getEdireccion()."')";
   
        if($base->Iniciar()){
            if($id = $base->Ejecutar($consultaInsertar)){
               // $this->setIdempresa($id);//no setear por autoincrement
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function modificar($idamodificar){
        $resp= false;
        $base= new BaseDatos();
        $consultaModifica= "UPDATE empresa SET enombre='".$this->getEnombre()."', edireccion='".
                            $this->getEdireccion()."' WHERE idempresa=".$idamodificar;//$this->getIdempresa();
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

    public function eliminar($idaeliminar){
        $base= new BaseDatos();
        $resp= false;
        if($base->Iniciar()){
            $consultaBorra= "DELETE FROM empresa WHERE idempresa=".$idaeliminar;
            if($base->Ejecutar($consultaBorra)){
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
            return $resp;
        }
    }



    public function __toString(){
        return "\n Id Empresa: ".$this->getIdempresa().
        "\n Nombre: ".$this->getEnombre().
        "\n Direccion: ".$this->getEdireccion()."\n";
    }






}
