<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type,Authorization, Accept, X-Request-Width, x-xsrf-token');
header('ContentType: application/json; charset=utf-8');

include 'config.php';
$post=json_decode(file_get_contents('php://input'),true);


if($post['accion']=="listar"){
    $sentencia=sprintf("SELECT * FROM semestre");
    $result=mysqli_query($mysqli,$sentencia);
    $f=mysqli_num_rows($result);
    $datos=array();

    while($row= mysqli_fetch_assoc($result)){

        array_push($datos,array(
            'codigo'=>$row['cod_semestre'],
            'nombre'=>$row['nom_semestre']
            
            
        ));
        $f++;
    }
    if($f>0)
    {
        $respuesta=json_encode(array('estado'=>true,'datos'=>$datos));
    }
    else
    {
        $respuesta=json_encode(array('estado'=>false));
    }
    echo $respuesta;
}

if($post['accion']=='ActualizarSemestre'){
    $sentencia=sprintf("UPDATE semestre SET nom_semestre='%s', ape_contacto='%s', tel_contacto='%s', email_contacto='%s'
    WHERE cod_contacto='%s'", $post['nom'],$post['ape'],$post['tel'],$post['email'],$post['percodigo']);
    $result= mysqli_query($mysqli, $sentencia);
    if($result){
        $envio=json_encode(array('error'=>false,'mensaje'=>'Datos Del Contacto  Actualizados'));
    }else{
        $envio=json_encode(array('error'=>true,'mensaje'=>'Error Al Actualizar Datos Del Contacto'));
    }
    echo $envio;
}

if($post['accion']=='ConsultarDato'){
    $sentencia=sprintf("SELECT * FROM semestre WHERE cod_contacto='%s'", $post['cod']);
    $result=mysqli_query($mysqli,$sentencia);
    if(mysqli_num_rows($result)>0)
    {
        while($row=mysqli_fetch_array($result))
        {
            $datos[]=array(
                'codigo'=>$row['cod_contacto'],
                'nombre'=>$row['nom_contacto'],
                
            );
        }
        $envio=json_encode(array('error'=>false, 'contactos'=>$datos));
    }
    else
    {
        $envio=json_encode(array('error'=>true, 'mensaje'=>'No Existe El Contacto Consultado'));
    }
    echo $envio;
}

?>