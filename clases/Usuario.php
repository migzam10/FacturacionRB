<?php
class Usuario{
    
		public function login($datos)
		{
			$c = new Conexion();
			$conexion = $c->conectar();
			$password = mysqli_real_escape_string($conexion,sha1(md5($datos[1])));
			//$password = mysqli_real_escape_string($conexion,$datos[1]);
			$usuario = mysqli_real_escape_string($conexion,$datos[0]);
			$sql = "select * from usuarios where usuario='$usuario' and clave='$password'";
			$result = mysqli_query($conexion,$sql);

			if(mysqli_num_rows($result) > 0)
			{
                $_SESSION['usuario'] = $datos[0];
                $_SESSION['datos'] = $result->fetch_object();
				return 1;
			}
			else
			{
				return 0;
			}
		}
        public function cambiarpass($passwords)
        {
            $c = new Conexion();
			$conexion = $c->conectar();
			$password = mysqli_real_escape_string($conexion,sha1(md5($passwords)));
            $usuario = $_SESSION['datos']->usuario;
			$sql = "UPDATE usuarios SET clave = '$password' where usuario='$usuario'";
			$result = mysqli_query($conexion,$sql);
            return $result;
        }
}


?>