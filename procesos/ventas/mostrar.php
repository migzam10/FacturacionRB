<?php
    require "../../clases/Venta.php";
    require "../../clases/Conexion.php";
    $obj = new Venta();
    $result = $obj->mostrar();

    if (!$result)
    {
        die("error");
    }
    else{
        $arreglo["data"] = []; 
        while($data = mysqli_fetch_assoc($result))
        {
            $arreglo["data"][] = $data;
        }
        echo json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    }
?>