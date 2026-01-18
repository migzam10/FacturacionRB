<?php
    require "../../clases/Reporte.php";
    require "../../clases/Conexion.php";
    $obj = new Reporte();
    $result = $obj->productos_01();

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