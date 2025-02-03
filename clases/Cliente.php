<?php
class Cliente{
            public function save($datos)
        {
            $c = new Conexion();
			$conexion = $c->conectar();

            //$id,$nombre,$direccion,$telefono,$email
//echo "Cliente.php";
            $id = $c->test_input($datos[0]);
			$nombre = $c->test_input($datos[1]);
            $direccion = $c->test_input($datos[2]);
            $telefono = $c->test_input($datos[3]);
            $email = $c->test_input($datos[4]);
            $ciudad = $c->test_input($datos[5]);
			$sql = "INSERT INTO cliente(id_cliente,nombre,telefono,direccion, email, ciudad) 
                    values('$id','$nombre','$telefono','$direccion','$email','$ciudad')";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }

        public function edit($datos)
        {
            $c = new Conexion();
			$conexion = $c->conectar();
            $id = $datos[0];
			$nombre = $c->test_input($datos[1]);
            $direccion = $c->test_input($datos[2]);
            $telefono = $c->test_input($datos[3]);
            $email = $c->test_input($datos[4]);
            $ciudad = $c->test_input($datos[5]);
			$sql = "update cliente set nombre = '$nombre', direccion = '$direccion',telefono = '$telefono',
            email = '$email', ciudad = '$ciudad' where id_cliente=$id";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }

       


    public function mostrar()
    {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "select * from cliente";
			$result = mysqli_query($conexion,$sql);
            return $result; 
    }

    
    public function traer($id)
    {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "select * from cliente where id_cliente=$id";
			$result = mysqli_query($conexion,$sql);
            $ver = mysqli_fetch_row($result);
            $datos = array(
               "id_cliente" =>html_entity_decode($ver[0]),
               "nombre" =>html_entity_decode($ver[1]),
               "direccion" =>html_entity_decode($ver[2]),
               "telefono" =>html_entity_decode($ver[3]),
               "email" =>html_entity_decode($ver[4]),
               "ciudad" =>html_entity_decode($ver[5])
             );
            return $datos;
    }
}
