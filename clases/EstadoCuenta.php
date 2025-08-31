<?php
class EstadoCuenta
{
    public function consultarCreditosPendientes($id_cliente)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT v.id_venta, v.fecha, v.total, v.credito_pendiente, 
                       (SELECT COALESCE(SUM(monto), 0) FROM pagos WHERE id_venta = v.id_venta AND estado = 'A') as total_pagado
                FROM ventas v 
                WHERE v.id_cliente = '$id_cliente' 
                AND v.tipo = 'credito' 
                AND v.estado = 'A'
                AND ((SELECT COALESCE(SUM(monto), 0) FROM pagos WHERE id_venta = v.id_venta AND estado = 'A') < v.total)
                ORDER BY v.fecha DESC";
        return mysqli_query($conexion, $sql);
    }

    public function registrarPago($id_venta, $monto, $tipo_pago)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $fecha = date('Y-m-d H:i:s');

        // Iniciar transacción
        mysqli_begin_transaction($conexion);

        try {
            // Obtener el total de la venta y el total pagado hasta ahora
            $sql_venta = "SELECT v.total, 
                         (SELECT COALESCE(SUM(monto), 0) FROM pagos WHERE id_venta = v.id_venta AND estado = 'A') as total_pagado
                         FROM ventas v WHERE v.id_venta = '$id_venta'";
            $result = mysqli_query($conexion, $sql_venta);
            $venta = mysqli_fetch_assoc($result);

            $total_venta = $venta['total'];
            $total_pagado = $venta['total_pagado'];
            $nuevo_total_pagado = $total_pagado + $monto;

            // Verificar si el pago excede el total de la venta
            if ($nuevo_total_pagado > $total_venta) {
                mysqli_rollback($conexion);
                return "excede";
            }

            // Insertar el pago
            $sql_pago = "INSERT INTO pagos (id_venta, fecha, monto, tipo_pago) 
                        VALUES ('$id_venta', '$fecha', '$monto', '$tipo_pago')";
            mysqli_query($conexion, $sql_pago);

            // Calcular el saldo pendiente
            $saldo_pendiente = $total_venta - $nuevo_total_pagado;

            // Actualizar el saldo pendiente en la venta
            $estado_credito = ($saldo_pendiente <= 0) ? 'pagado' : 'pendiente';

            $sql_update = "UPDATE ventas 
                          SET credito_pendiente = $saldo_pendiente,
                              estado_credito = '$estado_credito'
                          WHERE id_venta = '$id_venta'";
            mysqli_query($conexion, $sql_update);

            mysqli_commit($conexion);
            return "ok";
        } catch (Exception $e) {
            mysqli_rollback($conexion);
            return "error";
        }
    }

    public function obtenerHistorialPagos($id_venta)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT id_pago, fecha, monto, tipo_pago 
                FROM pagos 
                WHERE id_venta = '$id_venta' 
                AND estado = 'A' 
                ORDER BY fecha DESC";
        return mysqli_query($conexion, $sql);
    }

    public function obtenerSaldoPendiente($id_venta)
    {
        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT total, 
                (SELECT COALESCE(SUM(monto), 0) FROM pagos WHERE id_venta = '$id_venta' AND estado = 'A') as total_pagado
                FROM ventas WHERE id_venta = '$id_venta'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] - $row['total_pagado'];
    }

    public function clientesPendientes()
    {
        $c = new Conexion();
        $conexion = $c->conectar();


        $sql = "SELECT DISTINCT c.id_cliente, c.nombre 
            FROM ventas v INNER JOIN cliente c 
            ON v.id_cliente = c.id_cliente 
            WHERE v.estado_credito = 'pendiente'";
        $result = mysqli_query($conexion, $sql);
        return $result;
    }
}
