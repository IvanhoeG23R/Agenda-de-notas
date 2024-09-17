<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials:true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type,Authorization, Accept, X-Request-Width, x-xsrf-token');
header('ContentType: application/json; charset=utf-8');

include 'config.php';
$post=json_decode(file_get_contents('php://input'),true);


if($post['accion']=="listar"){
    $sentencia=sprintf("SELECT * FROM nivel");
    $result=mysqli_query($mysqli,$sentencia);
    $f=mysqli_num_rows($result);
    $datos=array();

    while($row= mysqli_fetch_assoc($result)){

        array_push($datos,array(
            'codigo'=>$row['cod_nivel'],
            'nombre'=>$row['nom_nivel']
            
            
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

?>