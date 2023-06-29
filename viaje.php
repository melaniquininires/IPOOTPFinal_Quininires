<?php
include_once 'BaseDatos.php';
include_once 'empresa.php';

class viaje{
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $vimporte;
    private $mensajeoperacion;

    public function __construct(){
        $this->idviaje=0;
        $this->vdestino= "";
        $this->vcantmaxpasajeros=0;
        $this->objEmpresa= new empresa();//=0;
        $this->objResponsable= new responsable();//0;
        $this->vimporte=0.0;        
    }

    public function cargar($idviaje,$vdestino,$vcantmaxpasajeros,$objEmpresa,$objResponsable,$vimporte){
        $this->setIdviaje($idviaje);
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setobjEmpresa($objEmpresa);
        $this->setobjResponsable($objResponsable);
        $this->setVimporte($vimporte);
    }


    public function getIdviaje()
    {
        return $this->idviaje;
    }


    public function setIdviaje($idviaje)
    {
        $this->idviaje = $idviaje;

        return $this;
    }


    public function getVdestino()
    {
        return $this->vdestino;
    }


    public function setVdestino($vdestino)
    {
        $this->vdestino = $vdestino;

        return $this;
    }


    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }


    public function setVcantmaxpasajeros($vcantmaxpasajeros)
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;

        return $this;
    }

    public function getobjEmpresa()
    {
        return $this->objEmpresa;
    }


    public function setobjEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;

        return $this;
    }

 
    public function getobjResponsable()
    {
        return $this->objResponsable;
    }

 
    public function setobjResponsable($objResponsable)
    {
        $this->objResponsable = $objResponsable;

        return $this;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }


    public function setVimporte($vimporte)
    {
        $this->vimporte = $vimporte;

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
    
    public function Buscar($idviaje){
        $base= new BaseDatos();
        $consultaViaje= "select * from viaje where idviaje=".$idviaje;
        $resp= false;
        if($base->Iniciar()){
        if($base->Ejecutar($consultaViaje)){
            if($row2=$base->Registro()){
                $idempresa = $row2['idempresa'];
                $rnroEmpleado = $row2['rnumeroempleado'];
                $objEmpresa = new empresa(); 
                $objResponsable = new responsable(); 
                $objEmpresa->cargar($idempresa,'',''); 
                $objResponsable->cargar($rnroEmpleado,'','','');
                $this->cargar($idviaje,$row2['vdestino'],$row2['vcantmaxpasajeros'],$objEmpresa,$objResponsable,$row2['vimporte']);
                $resp= true;
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }
    } else {
        $this->setMensajeoperacion($base->getError());
    } return $resp;
}

public static function listar($condicion=""){
    $mensajeError= "";
    $arregloViaje= null;
    $base= new BaseDatos();
    $consultaViajes= "select * from viaje ";
    if($condicion != ""){
        $consultaViajes= $consultaViajes.'where '.$condicion;
    }
    $consultaViajes.= " order by idviaje";
    if($base->Iniciar()){
        if($base->Ejecutar($consultaViajes)){
            $arregloViaje= array();
            while($row2= $base->Registro()){
                $id=$row2['idviaje'];
                $vdest=$row2['vdestino'];
                $vcantmaxp=$row2['vcantmaxpasajeros'];
                $objEmpresa= new empresa();
                $objEmpresa->Buscar($row2['idempresa']);
                $objResponsable= new responsable();
                $objResponsable->Buscar($row2['rnumeroempleado']);
                $vimp=$row2['vimporte'];
                $viaj= new viaje();
                $viaj->cargar($id,$vdest,$vcantmaxp,$objEmpresa,$objResponsable,$vimp);//buscar
                array_push($arregloViaje,$viaj);
            }
        } else {
           
            $this->setMensajeoperacion($base->getError());
        }
    } else{
      
        $this->setMensajeoperacion($base->getError());
        
    } return $arregloViaje;
}

public function insertar(){
    $base= new BaseDatos();
     $resp= false;
    $consultaInsertar="INSERT INTO viaje (vdestino,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte)
    VALUES ('".$this->getVdestino()."', '".$this->getVcantmaxpasajeros()."', '".$this->getobjEmpresa()->getIdempresa()
    ."', '".$this->getobjResponsable()->getRnumeroempleado()
    ."', '".$this->getVimporte()."')";
    if($base->Iniciar()){
        if($id = $base->devuelveIDInsercion($consultaInsertar)){
            $this->setIdviaje($id);
            $resp=true;
        } else{
            $this->setMensajeoperacion($base->getError());
        }
    } else{
        $this->setMensajeoperacion($base->getError());
    } return $resp;
}

    public function modificar($idamodificar){
        $resp= false;
        $base= new BaseDatos();
        $consultaModifica= "UPDATE viaje SET vdestino='".$this->getVdestino()."', vcantmaxpasajeros='".
        $this->getVcantmaxpasajeros()."', idempresa='".$this->getobjEmpresa()->getIdempresa()."', rnumeroempleado='".$this->getobjResponsable()->getRnumeroempleado()
        ."', vimporte='".$this->getVimporte()."' WHERE idviaje=".$idamodificar;
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
            $consultaBorra= "DELETE FROM viaje WHERE idviaje=".$idaeliminar;
            if($base->Ejecutar($consultaBorra)){
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
            return $resp;
        }
    }



    
    public function __toString(){
        return "\n---------------------------------\n".
        "Id viaje: ".$this->getIdviaje().
        "\nDestino: ".$this->getVdestino().
        "\nCant Max de Pasajeros: ".$this->getVcantmaxpasajeros().
        "\nEmpresa-> ".$this->getobjEmpresa()->getIdempresa().
        "\nResponsable-> ".$this->getobjResponsable()->getRnumeroempleado().
        "\nImporte: ".$this->getVimporte()."\n";
    }





}