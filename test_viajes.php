<?php
include_once 'empresa.php';
include_once 'responsable.php';
include_once 'viaje.php';
include_once 'pasajero.php';



$opcion = 0;
while($opcion != 5){
echo "\n------------- BIENVENIDO ------------\n";
echo "1) Trabajar con empresas \n";
echo "2) Trabajar con responsables \n";
echo "3) Trabajar con viajes \n"; 
echo "4) Trabajar con pasajeros \n";
echo "5) Salir \n";
echo "Ingrese la opcion deseada: ";
$opcion = trim(fgets(STDIN));
switch($opcion){
    case 1: 
        echo "\n***** MENU DE EMPRESAS *****\n";
        $opcion1= 0;
        while($opcion1 != 5){
            echo "\n1) Insertar empresa \n";
            echo "2) Ver empresas \n";
            echo "3) Modificar empresa \n";
            echo "4) Eliminar empresa \n";
            echo "5) Volver al menu principal \n";
            echo "Ingrese la opcion deseada: ";
            $opcion1= trim(fgets(STDIN));
            switch($opcion1){
                case 1:
                    echo "Ingrese el nombre de la empresa: ";
                    $enombre= trim(fgets(STDIN));
                    echo "Ingrese la direccion de la empresa: ";
                    $edireccion= trim(fgets(STDIN));
                    $obj_empresa= new empresa();
                    $obj_empresa->cargar('',$enombre,$edireccion);
                    $respuesta= $obj_empresa->insertar();
                    if($respuesta==true){
                        echo "\nLa empresa fue ingresada en la BD";
                    } else{
                        echo $obj_empresa->getmensajeoperacion();
                    }
                    break;
                case 2:
                    //creo obj empresa
                    $obj_empresa = new empresa();
                     $colempresas = $obj_empresa->listar();
                     if(count($colempresas)==0){
                        echo "No hay empresas cargadas---\n";
                     } else{
                        foreach($colempresas as $unaEmpresa){
                            echo $unaEmpresa;
                            echo "---------------------------------";
                         } 
                     }
                    break;
                case 3:
                    $obj_empresa= new empresa();
                    $colempresas = $obj_empresa->listar();
                    foreach($colempresas as $unaEmpresa){
                        echo $unaEmpresa;
                        echo "---------------------------------";
                    }
                    echo "Ingrese el ID de la empresa a modificar: ";
                    $idAModificar= trim(fgets(STDIN));
                    echo "Ingrese el nuevo nombre: ";
                    $nuevoENombre= trim(fgets(STDIN));
                    echo "Ingrese la nueva direccion: ";
                    $nuevaEDireccion= trim(fgets(STDIN));
                    $obj_empresa->setEnombre($nuevoENombre);
                    $obj_empresa->setEdireccion($nuevaEDireccion);
                    $respuesta= $obj_empresa->modificar($idAModificar);
                    if($respuesta== true){
                        $colempresas= $obj_empresa->listar();
                        echo "\n=>Modificacion realizada correctamente.";
                        foreach($colempresas as $unaEmpresa){
                            echo $unaEmpresa;
                            echo "-------------*------------------";
                        }
                    } else {
                        echo $obj_empresa->getMensajeoperacion();
                    }
                    break;
                case 4:
                    $obj_empresa= new empresa();
                    $colempresas = $obj_empresa->listar();
                    foreach($colempresas as $unaEmpresa){
                        echo $unaEmpresa;
                        echo "---------------------------------";
                    }
                    echo "Ingrese el ID de la empresa que desea eliminar: ";
                    $idAEliminar= trim(fgets(STDIN));
                    //Busco si dicha empresa esta asociada a un viaje
                    $obj_viaje= new viaje();
                    $colviajes= $obj_viaje->listar();
                    $encontreViaje= false;
                    $i=0;
                    while($i<count($colviajes) && !$encontreViaje){ 
                        $idabuscar= $colviajes[$i]->getobjEmpresa()->getIdempresa();
                        if($idabuscar== $idAEliminar){
                            echo "No se puede eliminar porque la empresa esta asociada a un VIAJE \n ==> Primero debe eliminar el viaje\n";
                            $encontreViaje= true;
                        } else{
                            $i++;
                        }
                    }
                    if(!$encontreViaje){
                        $respuesta= $obj_empresa->eliminar($idAEliminar);
                        if($respuesta== true){
                            $colempresas= $obj_empresa->listar();
                            echo "\n=> Eliminacion realizada correctamente.";
                        } else {
                            echo $obj_empresa->getMensajeoperacion();
                        }
                    }
                    break;
                case 5:
                    echo "Volviendo al menu principal... \n";
                    break;
                default:
                    echo "Opcion invalida, intente nuevamente: \n";
                    
            }
        }
        break;
    case 2:
        echo "\n***** MENU DE RESPONSABLES *****\n";
        $opcion1= 0;
        while($opcion1 != 5){
            echo "\n1) Insertar responsable \n";
            echo "2) Ver responsables \n";
            echo "3) Modificar responsable \n";
            echo "4) Eliminar responsable \n";
            echo "5) Volver al menu principal \n";
            echo "Ingrese la opcion deseada: ";
            $opcion1= trim(fgets(STDIN));
            switch($opcion1){
                case 1:
                    echo "Ingrese el numero de licencia: ";
                    $nrolic= trim(fgets(STDIN));
                    echo "Ingrese el nombre del responsable: ";
                    $rnombre= trim(fgets(STDIN));
                    echo "Ingrese el apellido del responsable: ";
                    $rapellido= trim(fgets(STDIN));
                    $obj_responsable= new responsable();
                    $obj_responsable->cargar('',$nrolic,$rnombre,$rapellido);
                    $respuesta= $obj_responsable->insertar();
                    if($respuesta== true){
                        echo "\n=> El responsable fue cargado en la BD";
                        $colresponsables= $obj_responsable->listar();
                        foreach($colresponsables as $unResponsable){
                            echo $unResponsable;
                            echo "----------------------------------";
                        }
                    } else{
                        echo $obj_responsable->getMensajeoperacion();
                    }
                    break;
                case 2:
                     $obj_responsable = new responsable();
                     $colresponsables = $obj_responsable->listar();
                     if(count($colresponsables)==0){
                        echo "No hay responsables cargados---\n";
                     } else{
                        foreach($colresponsables as $unResponsable){
                            echo $unResponsable;
                            echo "---------------------------------";
                         } 
                     }

                    break;
                case 3:
                    $obj_responsable= new responsable();
                    $colresponsables = $obj_responsable->listar();
                    foreach($colresponsables as $unResponsable){
                        echo $unResponsable;
                        echo "---------------------------------";
                     }
                     echo "\nIngrese el numero de empleado que desea modificar: ";
                     $nroempamodificar= trim(fgets(STDIN));
                     echo "Ingrese el nuevo numero de licencia: ";
                     $nrolic= trim(fgets(STDIN));
                     echo "Ingrese el nuevo nombre: ";
                     $rnombre= trim(fgets(STDIN));
                     echo "Ingrese el nuevo apellido: ";
                     $rapellido= trim(fgets(STDIN));
                     $obj_responsable->setRnumerolicencia($nrolic);
                     $obj_responsable->setRnombre($rnombre);
                     $obj_responsable->setRapellido($rapellido);
                     $respuesta= $obj_responsable->modificar($nroempamodificar);
                     if($respuesta== true){
                        $colresponsables= $obj_responsable->listar();
                        echo "\n=>Modificacion realizada correctamente.";
                        foreach($colresponsables as $unResponsable){
                            echo $unResponsable;
                            echo "-------------*------------------";
                        }
                     } else {
                        echo $obj_responsable->getMensajeoperacion();
                     }
                    break;
                case 4:
                    $obj_responsable= new responsable();
                    $colresponsables = $obj_responsable->listar();
                    foreach($colresponsables as $unResponsable){
                        echo $unResponsable;
                        echo "---------------------------------";
                     }
                     echo "\nIngrese el nro de empleado que desea eliminar: ";
                     $nroempaeliminar= trim(fgets(STDIN));
                     //verifico si el responsable esta asociado a un viaje
                     $obj_viaje= new viaje();
                     $colviajes= $obj_viaje->listar();
                     $encontreResponsable= false;
                     $i=0;
                     while($i<count($colviajes) && !$encontreResponsable){
                        $responsableabuscar= $colviajes[$i]->getobjResponsable()->getRnumeroempleado();
                        if($responsableabuscar== $nroempaeliminar){
                            echo "No se puede eliminar porque el responsable esta asociado a un Viaje\n ==>Elimine el viaje primero\n";
                            $encontreResponsable= true;
                        } else{
                            $i++;
                        }
                     } 
                     if(!$encontreResponsable){
                        $respuesta= $obj_responsable->eliminar($nroempaeliminar);
                        if($respuesta== true){
                           $colresponsables= $obj_responsable->listar();
                           echo "\n=>Eliminacion realizada correctamente.";
                           foreach($colresponsables as $unResponsable){
                               echo $unResponsable;
                               echo "-------------*------------------";
                           }
                        } else {
                           echo $obj_responsable->getMensajeoperacion();
                        }
                     }
                    break;
                case 5:
                    echo "Volviendo al menu principal \n";
                    break;
                default:
                    echo "Opcion invalida, intente nuevamente: \n";

                }
            }
        break;
    case 3:
        echo "\n***** MENU DE VIAJES *****\n";
        $opcion1= 0;
        while($opcion1 != 6){
            echo "\n1) Insertar viaje \n";
            echo "2) Ver viajes \n";
            echo "3) Modificar viaje \n";
            echo "4) Eliminar viaje \n";
            echo "5) Ver pasajeros por viaje \n";
            echo "6) Volver al menu principal \n";
            echo "Ingrese la opcion deseada: ";
            $opcion1= trim(fgets(STDIN));
            switch($opcion1){
                case 1:
                    echo "Ingrese destino: ";
                    $destino= trim(fgets(STDIN));
                    echo "Ingrese cantidad maxima de pasajeros: ";
                    $cantmaxp= trim(fgets(STDIN));
                    echo "Estas son las empresas cargadas: \n";
                    $obj_empresa = new empresa();
                    $colempresas = $obj_empresa->listar();
                    $empresaEncontrada= false;
                    while(!$empresaEncontrada){
                        foreach($colempresas as $unaEmpresa){
                            echo $unaEmpresa;
                            echo "---------------------------------";
                        }
                        echo "\n Elija el ID de la empresa que desea relacionar a este viaje: ";
                        $idemp= trim(fgets(STDIN));
                        if($obj_empresa->Buscar($idemp)){
                            $empresaEncontrada= true;
                            echo "Se asocio el viaje correctamente \n";
                        }
                    }
                    echo "\n Estas son los responsables cargados: \n";
                    $obj_responsable = new responsable();
                    $colresponsables = $obj_responsable->listar();
                    $responsableEncontrado= false;
                    while(!$responsableEncontrado){
                        foreach($colresponsables as $unResponsable){
                            echo $unResponsable;
                            echo "---------------------------------";
                         }
                         echo "\nElija el Nro de empleado del responsable que desea relacionar a este viaje: ";
                         $rnroemp= trim(fgets(STDIN));
                         if($obj_responsable->Buscar($rnroemp)){
                            $responsableEncontrado= true;
                            echo "Se asocio el responsable correctamente \n";
                         }
                    }
                     echo "Ingrese el importe: ";
                     $vimp= trim(fgets(STDIN));
                     $obj_viaje= new viaje();
                     $obj_viaje->cargar('',$destino,$cantmaxp,$obj_empresa,$obj_responsable,$vimp);
                     $respuesta= $obj_viaje->insertar();
                     if($respuesta== true){
                        echo "\n=>El viaje fue cargado en la BD\n";
                        $colviajes= $obj_viaje->listar();
                        foreach($colviajes as $unViaje){
                            echo $unViaje;
                            echo "----------------------------";
                        }
                     } else{
                        echo $obj_viaje->getMensajeoperacion();
                     }
                    break;
                case 2:
                    $obj_viaje= new viaje();
                    $colviajes= $obj_viaje->listar();
                    if(count($colviajes)== 0){
                        echo "No hay viajes cargados---\n";
                    } else{
                        foreach($colviajes as $unViaje){
                            echo $unViaje;
                            echo "--------------------------------";
                        }
                    }

                    break;
                case 3:
                    $obj_viaje= new viaje();
                    $colviajes= $obj_viaje->listar();
                    foreach($colviajes as $unViaje){
                        echo $unViaje;
                        echo "--------------------------------";
                    }
                    $idencontrado= false;
                    while(!$idencontrado){
                        echo "\n Elija el ID del viaje a modificar ";
                        $idviaje= trim(fgets(STDIN));
                        if($obj_viaje->Buscar($idviaje)){
                            $idencontrado= true;
                        } else{
                            echo "ERROR, Id no encontrado\n";
                        }
                    }
                    echo "Ingrese el nuevo destino: ";
                    $vdest= trim(fgets(STDIN));
                    echo "Ingrese la nueva cantidad maxima de pasajeros: ";
                    $cantmaxpa= trim(fgets(STDIN));
                    echo "Estas son las empresas cargadas: \n";
                    $obj_empresa = new empresa();
                    $colempresas = $obj_empresa->listar();
                    $empresaEncontrada= false;
                    while(!$empresaEncontrada){
                        foreach($colempresas as $unaEmpresa){
                            echo $unaEmpresa;
                            echo "---------------------------------";
                        }
                        echo "\n Elija el ID de la empresa que desea relacionar a este viaje: ";
                        $idemp= trim(fgets(STDIN));
                        if($obj_empresa->Buscar($idemp)){
                            $empresaEncontrada= true;
                            echo "Se asocio el viaje correctamente \n";
                        }
                    }
                     echo "Estos son los responsables cargados: \n";
                     $obj_responsable= new responsable();
                     $colresponsables = $obj_responsable->listar();
                     $responsableEncontrado= false;
                     while(!$responsableEncontrado){
                         foreach($colresponsables as $unResponsable){
                             echo $unResponsable;
                             echo "---------------------------------";
                          }
                          echo "\nElija el Nro de empleado del responsable que desea relacionar a este viaje: ";
                          $rnroemp= trim(fgets(STDIN));
                          if($obj_responsable->Buscar($rnroemp)){
                             $responsableEncontrado= true;
                             echo "Se asocio el responsable correctamente \n";
                          }
                     }
                      echo "Ingrese el nuevo importe: ";
                      $imp= trim(fgets(STDIN));
                      $obj_viaje->setVdestino($vdest);
                      $obj_viaje->setVcantmaxpasajeros($cantmaxpa);
                      $obj_viaje->setobjEmpresa($obj_empresa);
                      $obj_viaje->setobjResponsable($obj_responsable);
                      $obj_viaje->setVimporte($imp);
                      $respuesta= $obj_viaje->modificar($idviaje);
                      if($respuesta== true){
                        $colviajes= $obj_viaje->listar();
                        echo "\n=>Modificacion realizada correctamente.";
                        foreach($colviajes as $unViaje){
                            echo $unViaje;
                            echo "\n--------------*-----------------\n";
                        }
                      } else{
                        echo $obj_viaje->getMensajeoperacion();
                      }

                    break;
                case 4:
                    $obj_viaje= new viaje();
                    $colviajes= $obj_viaje->listar();
                    foreach($colviajes as $unViaje){
                        echo $unViaje;
                        echo "--------------------------------";
                    }
                    echo "\nIngrese el ID del viaje que desea eliminar: ";
                    $idaeliminar= trim(fgets(STDIN));
                    //Busco si hay pasajeros asociados a este viaje
                    $obj_pasajero= new pasajero();
                    $colpasajeros= $obj_pasajero->listar();
                    $encontrepasajero= false;
                    $i=0;
                    while($i<count($colpasajeros)&& !$encontrepasajero){
                        $idabuscar=$colpasajeros[$i]->getobjViaje()->getIdviaje();
                        if($idabuscar== $idaeliminar){
                            echo "No se puede eliminar el viaje porque hay pasajeros asociados a dicho viaje\n ==>Elimine primero los pasajeros\n";
                            $encontrepasajero= true;
                        } else {
                            $i++;
                        }
                    }
                    if(!$encontrepasajero){
                        $respuesta= $obj_viaje->eliminar($idaeliminar);
                        if($respuesta== true){
                            echo "\n=>Eliminacion realizada correctamente.\n"; 
                        }else{
                            echo "Numero de ID NO encontrado.\n";//echo $obj_viaje->getMensajeoperacion();
                          }   
                    }
                    break;
                case 5:
                    echo "Estos son los viajes cargados: \n";
                    $obj_viaje= new viaje();
                    $colviajes= $obj_viaje->listar();
                    foreach($colviajes as $unViaje){
                        echo "ID viaje: ".$unViaje->getIdviaje()." - Destino: " .$unViaje->getVdestino();
                        echo "\n--------------------------------\n";
                    }
                    echo "\nIngrese el ID del viaje para ver sus pasajeros: ";
                    $idviaje= trim(fgets(STDIN));
                    $obj_pasajero= new pasajero;
                    $condicion=" idviaje= ".$idviaje;
                    $colpasajeros= $obj_pasajero->listar($condicion);
                    $cuentaPasajeros=0;
                    if($colpasajeros == null){
                        echo "=====> NO se encontraron pasajeros\n";
                    }else{
                    echo "Estos son los pasajeros cargados: \n";
                    foreach($colpasajeros as $unPasajero){
                        $cuentaPasajeros+=1;
                        echo "\nPasajero ".$cuentaPasajeros." ----->".$unPasajero;
                        echo "-------------------------------";
                    } echo "\nCANTIDAD TOTAL DE PASAJEROS: ".$cuentaPasajeros;
                }
                    break;


                case 6:
                    echo "Volviendo al menu principal \n";
                    break;
                   // echo "Saliendo...";
                   // exit();
                default:
                    echo "Opcion invalida, intente nuevamente: \n";
                }
            }

        break;
    case 4:
        echo "\n***** MENU DE PASAJEROS *****\n";
        $opcion1= 0;
        while($opcion1 != 5){
            echo "\n1) Insertar pasajero \n";
            echo "2) Ver pasajeros \n";
            echo "3) Modificar pasajero \n";
            echo "4) Eliminar pasajero \n";
            echo "5) Volver al menu principal \n";
            echo "Ingrese la opcion deseada: ";
            $opcion1= trim(fgets(STDIN));
            switch($opcion1){
                case 1:
                    echo "Ingrese Documento del pasajero: ";
                    $documento= trim(fgets(STDIN)); 
                    $duplicado= false;
                    $i=0;
                    $obj_pasajero1= new pasajero();
                    $colpasajeros1= $obj_pasajero1->listar();
                    while($i<count($colpasajeros1) && !$duplicado){
                        $dniabuscar= $colpasajeros1[$i]->getPdocumento();
                        if($dniabuscar== $documento){
                            echo "Documento DUPLICADO\n";
                            $duplicado= true;
                            exit();
                        } else{
                            $i++;
                        }                    
                    }                   
                    echo "Ingrese el nombre: ";
                    $pnom= trim(fgets(STDIN));
                    echo "Ingrese el apellido: ";
                    $pape= trim(fgets(STDIN));
                    echo "Ingrese el telefono: ";
                    $ptel= trim(fgets(STDIN));
                    echo "Estos son los viajes cargados: \n";
                    $obj_viaje1= new viaje();
                    $colviajes1= $obj_viaje1->listar();
                    $viajeEncontrado= false;
                    while(!$viajeEncontrado){
                        foreach($colviajes1 as $unViaje){
                            echo $unViaje;
                            echo "--------------------------------\n";
                        }
                        echo "\nElija el ID del viaje que desea relacionar con este pasajero: ";
                        $idviaje= trim(fgets(STDIN));
                        if($obj_viaje1->Buscar($idviaje)){
                            $viajeEncontrado= true;
                            //echo "Se asocio el viaje al pasajero \n";
                        } else{
                            echo "(x)(x)(x)->ERROR, ID no encontrado\n";
                        }
                    }
                    $cuentaPasajeros=0;
                    $condicion= "idviaje= ".$idviaje;
                    $obj_pasajero= new pasajero();
                    $colpasajeros= $obj_pasajero->listar($condicion);
                    $cuentaPasajeros= count($colpasajeros);
                   // echo "La cantidad de pasajeros ingresada para el viaje seleccionado es: ".$cuentaPasajeros;
                    $obj_viaje2= new viaje();
                    $colviajes2= $obj_viaje2->listar();
                    $cantidadMaxP=0;
                    $i= 0;
                    $encontrecant= false;
                    while($i<count($colviajes2) && !$encontrecant){
                        $idbuscado= $colviajes2[$i]->getIdviaje();
                        if($idbuscado == $idviaje){
                            $cantidadMaxP= $colviajes2[$i]->getVcantmaxpasajeros();
                            $encontrecant= true;
                        } else{
                            $i++;
                        }
                    }
                    if($cuentaPasajeros < $cantidadMaxP){
                        $obj_pasajero= new pasajero();
                            $obj_pasajero->cargar($documento,$pnom,$pape,$ptel,$obj_viaje1);
                            $respuesta= $obj_pasajero->insertar();
                            if($respuesta== true){
                                echo "\nEl pasajero fue cargado en la BD\n";
                            } else {
                                echo $obj_pasajero->getMensajeoperacion();
                            }
                        }
                    break;
                case 2:
                    $obj_pasajero= new pasajero();
                    $colpasajeros= $obj_pasajero->listar();
                    if(count($colpasajeros) == 0){
                        echo "NO hay pasajeros cargados\n";
                    } else{
                        foreach($colpasajeros as $unPasajero){
                            echo "\n-----------------------------------\n";
                            echo $unPasajero;
                            echo "\n-----------------------------------\n";
                        }
                    }

                    break;
                case 3:
                echo "Estos son los pasajeros cargados: ";
                $obj_pasajero= new pasajero();
                $colpasajeros= $obj_pasajero->listar();
                foreach($colpasajeros as $unPasajero){
                    echo $unPasajero;
                    echo "-----------------------------------";
                }
                $docencontrado= false;
                while(!$docencontrado){
                    echo "\nIngrese el documento del pasajero que desea modificar: ";
                    $documento= trim(fgets(STDIN));
                    if($obj_pasajero->Buscar($documento)){
                        $docencontrado= true;
                    } else{
                        echo "(x)(x)(x)ERROR-> Documento no encontrado\n";
                    }
                }
                
                echo "Ingrese el nuevo nombre: ";
                $pnom= trim(fgets(STDIN));
                echo "Ingrese el nuevo apellido: ";
                $pape= trim(fgets(STDIN));
                echo "Ingrese el nuevo telefono: ";
                $ptel= trim(fgets(STDIN));
                echo "Estos son los viajes cargados: \n";
                $obj_viaje= new viaje();
                $colviajes= $obj_viaje->listar();
                foreach($colviajes as $unViaje){
                    echo $unViaje;
                    echo "--------------------------------";
                }
                $viajeEncontrado= false;
                while(!$viajeEncontrado){
                    echo "\nIngrese el nuevo id del viaje al cual quiere relacionar a este pasajero: ";
                    $idviaj= trim(fgets(STDIN));
                    if($obj_viaje->Buscar($idviaj)){
                        $viajeEncontrado= true;
                        echo "Se asocio el viaje correctamente\n";
                    } else{
                        echo "(x)(x)(x)ERROR, viaje NO encontrado\n";
                    }
                }
                $obj_pasajero->setPdocumento($documento);
                $obj_pasajero->setPnombre($pnom);
                $obj_pasajero->setPapellido($pape);
                $obj_pasajero->setPtelefono($ptel);
                $obj_pasajero->setobjViaje($obj_viaje);
                $respuesta= $obj_pasajero->modificar($documento);
                if($respuesta== true){
                    $colpasajeros= $obj_pasajero->listar();
                    echo "\n=>Modificacion realizada correctamente.\n";
                    foreach($colpasajeros as $unPasajero){
                        echo "--------------------------";
                        echo $unPasajero;
                        echo "--------------------------";
                    }
                } else{
                    echo $obj_pasajero->getMensajeoperacion();
                }
                    break;
                case 4:
                    $obj_pasajero= new pasajero();
                    $colpasajeros= $obj_pasajero->listar();
                    foreach($colpasajeros as $unPasajero){
                        echo "--------------------------\n";
                        echo $unPasajero;
                        echo "--------------------------\n";
                    }
                    echo "\nIngrese el documento del pasajero que desea eliminar: ";
                    $docaeliminar= trim(fgets(STDIN));
                    $i=0;
                    $encontrado= false;
                    while($i<count($colpasajeros)&& !$encontrado){
                        if($colpasajeros[$i]->getPdocumento() == $docaeliminar){
                            $encontrado= true;
                        } else{
                            $i++;
                        }
                    }
                    if($encontrado){
                        $respuesta= $obj_pasajero->eliminar($docaeliminar);
                        if($respuesta== true){
                            $colpasajeros= $obj_pasajero->listar();
                            echo "\n=>Eliminacion realizada correctamente.\n";
                        } else{
                            echo "Numero de documento NO encontrado";//$obj_pasajero->getMensajeoperacion();
                        }
                    }             
                    break;
                case 5:
                    echo "Volviendo al menu principal \n";
                    break;
                default:
                echo "Opcion invalida, intente nuevamente: \n";       
            }
        }

        break;
    case 5:
        echo "Saliendo....";
        exit();
    default:
        echo "Opcion invalida, intente nuevamente: \n";
        
}
}


