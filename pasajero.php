<?php
include_once('BaseDatos.php');

class pasajero{
    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $objViaje;
    private $mensajeoperacion;


public function __construct(){
    $this->pdocumento="";
    $this->pnombre="";
    $this->papellido="";
    $this->ptelefono=0;
    $this->objViaje=new viaje();
    
}
    public function cargar($pdocumento,$pnombre,$papellido,$ptelefono,$objViaje){
        $this->setPdocumento($pdocumento);
        $this->setPnombre($pnombre);
        $this->setPapellido($papellido);
        $this->setPtelefono($ptelefono);
        $this->setobjViaje($objViaje);

    }
 
    public function getPdocumento()
    {
        return $this->pdocumento;
    }


    public function setPdocumento($pdocumento)
    {
        $this->pdocumento = $pdocumento;

        return $this;
    }

    
    public function getPnombre()
    {
        return $this->pnombre;
    }


    public function setPnombre($pnombre)
    {
        $this->pnombre = $pnombre;

        return $this;
    }


    public function getPapellido()
    {
        return $this->papellido;
    }

 
    public function setPapellido($papellido)
    {
        $this->papellido = $papellido;

        return $this;
    }


    public function getPtelefono()
    {
        return $this->ptelefono;
    }


    public function setPtelefono($ptelefono)
    {
        $this->ptelefono = $ptelefono;

        return $this;
    }


    public function getobjViaje()
    {
        return $this->objViaje;
    }

 
    public function setobjViaje($objViaje)
    {
        $this->objViaje = $objViaje;

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

    public function Buscar($pdocumento){
        $base= new BaseDatos();
        $consultaPasajero= "select * from pasajero where pdocumento=".$pdocumento;
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                if($row2=$base->Registro()){
                    $idviaje= $row2['idviaje'];
                    $objViaje= new viaje;
                    $objViaje->cargar($idviaje,'','','','','');
                    $this->cargar($pdocumento,$row2['pnombre'],$row2['papellido'],$row2['ptelefono'],$objViaje);
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
        $arregloPasajero= null;
        $base= new BaseDatos();
        $consultaPasajero= "select * from pasajero ";
        if($condicion != ""){
            $consultaPasajero= $consultaPasajero.' where '.$condicion;
        }
        $consultaPasajero.= " order by pdocumento";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                $arregloPasajero= array();
                while($row2=$base->Registro()){
                    $pdocumento= $row2['pdocumento'];
                    $pnombre= $row2['pnombre'];
                    $papellido= $row2['papellido'];
                    $ptelefono= $row2['ptelefono'];
                    $objViaje= new viaje();
                    $objViaje->Buscar($row2['idviaje']);
                    $pasaj= new pasajero();
                    $pasaj->cargar($pdocumento,$pnombre,$papellido,$ptelefono,$objViaje);
                    array_push($arregloPasajero,$pasaj);
                }
            } else{
                $this->setMensajeoperacion($base->getError());

            }
        } else{
            $this->setMensajeoperacion($base->getError());

        } return $arregloPasajero;
    }

    public function insertar(){
        $base= new BaseDatos();
        $resp= false;
        $consultaInsertar= "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje)
        VALUES ('".$this->getPdocumento()."', '".$this->getPnombre()."', '".$this->getPapellido()."', '".$this->getPtelefono()."', '".
        $this->getobjViaje()->getIdviaje()."')";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $resp= true;
            } else {
                $this->setMensajeoperacion($base->getError());
            }
        } else{
            $this->setMensajeoperacion($base->getError());
        }   
        return $resp;   
    }

    public function modificar($pdocamodificar){
        $resp= false;
        $base= new BaseDatos();
        $consultaModifica= "UPDATE pasajero SET pnombre='".$this->getPnombre().
        "', papellido='".$this->getPapellido()."', ptelefono='".$this->getPtelefono()
        ."', idviaje='".$this->getobjViaje()->getIdviaje()."' WHERE pdocumento=".$pdocamodificar;
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

    public function eliminar($pdocaeliminar){
        $base= new BaseDatos();
        $resp= false;
        if($base->Iniciar()){
            $consultaBorra= "DELETE FROM pasajero WHERE pdocumento=".$pdocaeliminar;
            if($base->Ejecutar($consultaBorra)){
                $resp= true;
            } else{
                $this->setMensajeoperacion($base->getError());
            }
            return $resp;
        }
    }


    public function __toString(){
        return "Pasajero - Documento: ".$this->getPdocumento().
        "\nNombre y apellido: ".$this->getPnombre().", ".$this->getPapellido().
        "\nTelefono: ".$this->getPtelefono().
        "\n ID viaje del pasajero: ".$this->getobjViaje()->getIdviaje()."\n";
        
    }

}