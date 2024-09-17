<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type,Authorization, Accept, X-Request-Width, x-xsrf-token');
header('ContentType: application/json; charset=utf-8');

include 'config.php';
$post=json_decode(file_get_contents('php://input'),true);

if($post['accion']=='loggin'){
    $sentencia=sprintf("SELECT * FROM profesor WHERE usu_profesor='%s' and cla_profesor='%s' ", $post['usuario'], $post['clave']);
    $result=mysqli_query($mysqli,$sentencia);
    $f=0;
    $datos=array();
    while($row=mysqli_fetch_assoc($result))
    {
            array_push($datos, array(
                'codigo'=>$row['cod_profesor'],
                'nombre'=>$row['nom_profesor'],
                'apellido'=>$row['ape_profesor'],   
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

if($post['accion']=='Agregar'){
    $sentencia=sprintf("INSERT INTO profesor (nom_profesor, ape_profesor, usu_profesor, cla_profesor, mail_profesor)
    VALUES ('%s','%s','%s','%s','%s')", $post['nom'],$post['ape'],$post['usu'],$post['cla'],$post['mail']);
    $result=mysqli_query($mysqli, $sentencia);
    if($result){
        $envio=json_encode(array('error'=>false,'mensaje'=>'Sus Datos Se Han Agregado '));
    }else
    {
        $envio=json_encode(array('error'=>true,'mensaje'=>'Error Al Guardar'));
    }
    echo $envio;
}