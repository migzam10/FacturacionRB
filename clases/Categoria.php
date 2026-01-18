<?php
class Categoria{
            public function save($nombrer)
        {
            $c = new Conexion();
			$conexion = $c->conectar();
			$nombre = $c->test_input($nombrer);
			$sql = "INSERT INTO categorias(nombre,estado) values('$nombre','activo')";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }
                public function edit($datos)
        {
            $c = new Conexion();
			$conexion = $c->conectar();
			$nombre = $c->test_input($datos[1]);
			$sql = "update categorias set nombre = '$nombre' where id_categoria=$datos[0]";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }
                public function delete($id)
        {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "update categorias set estado = 'inactivo' where id_categoria=$id";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }
    public function mostrar()
    {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "select * from categorias where estado = 'activo'";
			$result = mysqli_query($conexion,$sql);
            return $result; 
    }
    public function traer($id)
    {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "select * from categorias where id_categoria=$id";
			$result = mysqli_query($conexion,$sql);
            $ver = mysqli_fetch_row($result);
            return html_entity_decode($ver[1]); 
    }
    
    public function mostrar_cb()
    {
            $c = new Conexion();
			$conexion = $c->conectar();
			$sql = "select * from categorias";
			$result = mysqli_query($conexion,$sql);
            return $result;         
    }
    
}


?>