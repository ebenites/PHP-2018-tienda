<?php
class UsuarioRepository {
    
    public static function validar($username, $password) {
        
        $query = "select u.id, u.username, u.nombres, u.roles_id, r.nombre as roles_nombre, u.email 
                from usuarios u
                inner join roles r on r.id = u.roles_id
                where username=:username and password=:password";
        
        $con = Conexion::getConexion();
        $stmt = $con->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        if($usuario = $stmt->fetchObject('Usuario')){
            return $usuario;
        }
        
        return NULL;
    }
    
}
