<?php
date_default_timezone_set("America/Bogota");
class Reporte
{



    public function ventas_dia()
    {
        $c = new Conexion();
        $conexion = $c->conectar();

        $f1 = date('y-m-d') . ' 00:00:00';
        $f2 = date('y-m-d') . ' 23:59:59';


        $sql = "SELECT COUNT(*) FROM ventas where estado = 'A' AND fecha BETWEEN '$f1' AND '$f2'";
        $result = mysqli_query($conexion, $sql);
        $re = mysqli_fetch_row($result)[0];

        return $re;
    }
    public function dinero_dia()
    {
        $f1 = date('y-m-d') . ' 00:00:00';
        $f2 = date('y-m-d') . ' 23:59:59';

        $c = new Conexion();
        $conexion = $c->conectar();

        $sql = "SELECT SUM(total) FROM ventas where estado = 'A' AND  fecha BETWEEN '$f1' AND '$f2'";
        $result = mysqli_query($conexion, $sql);
        $re = mysqli_fetch_row($result)[0];

        return $re;
    }
    public function stock_0()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $fecha = date('y-m-d');
        $sql = "SELECT count(id_producto) FROM productos where stock < 10";
        $result = mysqli_query($conexion, $sql);
        $re = mysqli_fetch_row($result)[0];

        return $re;
    }
    public function productos_dia()
    {
        $f1 = date('y-m-d') . ' 00:00:00';
        $f2 = date('y-m-d') . ' 23:59:59';
        $c = new Conexion();
        $conexion = $c->conectar();
        $fecha = date('y-m-d');
        $sql = "SELECT SUM(de.cantidad) FROM detalle_ventas AS de
            INNER JOIN ventas AS ve ON ve.id_venta=de.id_ventas
            WHERE ve.fecha BETWEEN '$f1' AND '$f2'";
        $result = mysqli_query($conexion, $sql);
        $re = mysqli_fetch_row($result)[0];

        return $re;
    }

    public function productos_0()
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT id_producto,nombre,stock from productos where stock < 10 and estado = 'activo' order by stock asc";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }
    public function productos_01()
    {
        $c = new Conexion();
        $conexion = $c->conectar();

        $sql = "SELECT pro.id_producto,pro.nombre,pro.precio_compra,pro.precio_venta,pro.stock,pr.nombre as id_proveedor,ca.nombre
            as id_categoria FROM categorias AS ca
            INNER JOIN productos AS pro ON pro.id_categoria=ca.id_categoria INNER JOIN proveedores AS pr ON pr.id_proveedor=pro.id_proveedor where stock < 10 order by stock asc";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }

    public function ventas_mes()
    {
        $c = new Conexion();
        $conexion = $c->conectar();

        $sql = "SELECT DAY(fecha) AS dia, count(id_venta) AS total_vendido 
                FROM ventas WHERE estado = 'A' AND  YEAR(fecha) = YEAR(CURRENT_DATE()) AND MONTH(fecha) = MONTH(CURRENT_DATE()) 
                GROUP BY DAY(fecha) ORDER BY DAY(fecha)";
        $result = mysqli_query($conexion, $sql);
        return $result;

    }


    public function ventas_mes_total()
    {
        $c = new Conexion();
        $conexion = $c->conectar();

        $sql = "SELECT sum(total) as total 
                FROM ventas WHERE estado = 'A' 
                AND YEAR(fecha) = YEAR(CURRENT_DATE()) AND MONTH(fecha) = MONTH(CURRENT_DATE())";
        $result = mysqli_query($conexion, $sql);
        $re = mysqli_fetch_row($result)[0];
        return $re;

    }


}
