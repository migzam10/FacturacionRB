<?php
date_default_timezone_set("America/Bogota");
class Venta
{
    public function save($clientee, $total, $tipo, $id_cliente, $estado_credito, $id_consecutivo, $fecha)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $cliente = $c->test_input($clientee);
        
        $sql = "INSERT INTO ventas(cliente,fecha,estado,total,tipo,id_cliente, estado_credito, id_venta) 
                values('$cliente','$fecha','A','$total','$tipo','$id_cliente', '$estado_credito', '$id_consecutivo')";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }


    public function save_detalle($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        


        if (isset($_SESSION['tablacomprastemp'])) {
            $datos = $_SESSION['tablacomprastemp'];
            $r = 0;
            for ($i = 0; $i < count($datos); $i++) {
                $d = explode("||", $datos[$i]);

                $cantidad = number_format($d[2], 2, '.', '');
                $precio = number_format($d[1], 2, '.', '');

                $sql = "INSERT into detalle_ventas(id_ventas,id_productos,cantidad,precio,importe, id_categoria)
                values('$id','$d[0]','$cantidad','$precio','$d[3]','$d[5]')";

                $r = $r + $result = mysqli_query($conexion, $sql);
            }
            return $r;
        } else {
            return "not";
        }
    }

    public function consecutivo()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT COALESCE(MAX(id_venta), 0) + 1 AS next_id FROM ventas";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        
        return $row['next_id'];
    }


    public function trae_venta()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT id_venta from ventas group by id_venta desc";
        $result = mysqli_query($conexion, $sql);
        $id = mysqli_fetch_row($result)[0];

        return $id;
    }
    public function baja_stock($stock, $id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "CALL baja_stock('$stock','$id')";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }


    public function mostrar()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "select * from ventas where estado = 'A'";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }

    public function mostrarI()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "select * from ventas where estado = 'I'";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }


    public function mostrar_porid($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "select id_venta,cliente,fecha,total,tipo,id_cliente from ventas where id_venta = '$id'";
        $result = mysqli_query($conexion, $sql);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "id_venta" => html_entity_decode($ver[0]),
            "cliente" => html_entity_decode($ver[1]),
            "fecha" => html_entity_decode(date('d/m/Y', strtotime($ver[2]))),
            "total" => html_entity_decode(number_format($ver[3], 0, ',', '.')),
            "tipo" => html_entity_decode($ver[4]),
            "numero" => html_entity_decode($ver[5])
        );
        return $datos;
    }


    public function traer_detalles($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "select de.cantidad,de.id_productos,de.precio,de.importe 
                    from detalle_ventas as de where de.id_ventas = $id";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }


    public function marcar_venta($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "update ventas set estado = 'A' where id_venta = '$id'";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }


    public function consultar_venta($f1, $f2)
    {
        $f1 = $f1 . ' 00:00:00';
        $f2 = $f2 . ' 23:59:59';
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT * FROM ventas WHERE estado = 'A' AND fecha BETWEEN '$f1' AND '$f2'";
        //echo $sql;
        $result = mysqli_query($conexion, $sql);

        return $result;
    }

    public function consultar_venta_total($f1, $f2)
    {
        $f1 = $f1 . ' 00:00:00';
        $f2 = $f2 . ' 23:59:59';
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT SUM(total) AS total_importe 
                    FROM ventas WHERE estado = 'A' AND fecha BETWEEN '$f1' AND '$f2'";
        //echo $sql;
        $result = mysqli_query($conexion, $sql);

        return $result;
    }

    public function eliminar_venta($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "DELETE FROM ventas WHERE id_venta = '$id'";
        $result = mysqli_query($conexion, $sql);

        $sql2 = "DELETE FROM detalle_ventas WHERE id_ventas = '$id'";
        $result2 = mysqli_query($conexion, $sql2);

        return $result;
    }


    public function anular_venta($id)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "update ventas set estado = 'I' where id_venta = '$id'";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }

    public function consultar_venta_c($f1, $f2, $id_categoria)
    {
        $f1 = $f1 . ' 00:00:00';
        $f2 = $f2 . ' 23:59:59';
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT v.id_venta,c.nombre,dv.id_productos,dv.cantidad,dv.precio,dv.importe,c.id_categoria
        FROM ventas v JOIN detalle_ventas dv ON v.id_venta = dv.id_ventas 
        JOIN categorias c ON dv.id_categoria = c.id_categoria 
        WHERE c.id_categoria = $id_categoria AND v.fecha BETWEEN '$f1' AND '$f2' ORDER BY v.id_venta;";
        //echo $sql;
        $result = mysqli_query($conexion, $sql);

        return $result;
    }

    public function consultar_venta_c_total($f1, $f2, $id_categoria)
    {
        $f1 = $f1 . ' 00:00:00';
        $f2 = $f2 . ' 23:59:59';
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT SUM(dv.importe) AS total_importe
        FROM ventas v JOIN detalle_ventas dv ON v.id_venta = dv.id_ventas 
        JOIN categorias c ON dv.id_categoria = c.id_categoria 
        WHERE c.id_categoria = $id_categoria AND v.fecha BETWEEN '$f1' AND '$f2' ORDER BY v.id_venta;";
        //echo $sql;
        $result = mysqli_query($conexion, $sql);

        return $result;
    }
}
