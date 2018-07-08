<?php

require_once '../datos/Conexion.clase.php';

class Sesion extends Conexion {
    private $email;
    private $clave;
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    public function validarSesion(){
    $sql = "select * from f_validar_sesion(:p_email,:p_clave)";
    $sentencia = $this->dblink->prepare($sql);
    $sentencia->bindParam(":p_email", $this->getEmail());
    $sentencia->bindParam(":p_clave", md5($this->getClave()));
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    
     /*session_name("aion");
                        session_start();
                        $_SESSION["nombre_usuario"] = $resultado["nombre_usuario"];
                        $_SESSION["dni_usuario"] = $resultado["dni_usuario"];
                        $_SESSION["email_usuario"] = $this->getEmail();
                        $_SESSION["codigo_cargo"] = $resultado["codigo_cargo"];
                        */
    
    
    return $resultado;
                    
    }
    
    public function obtenerFoto($codigo) {
        $foto = "../fotos_usuarios/".$codigo;

        if (file_exists( $foto . ".png" )){
            $foto = $foto . ".png";

        }else if (file_exists( $foto . ".PNG" )){
            $foto = $foto . ".PNG";

        }else if (file_exists( $foto . ".jpg" )){
            $foto = $foto . ".jpg";

        }else if (file_exists( $foto . ".JPG" )){
            $foto = $foto . ".JPG";

        }else{
            $foto = "none";
        }

        if ($foto == "none"){
            return $foto;
        }else{
            return Funciones::$DIRECCION_WEB_SERVICE . $foto;
        }

    }
    
     public function obtenerOpcionesMenu($codigoCargo) {
        try {
            $sql = "
                select
                        distinct 
                        m.codigo_menu,
                        m.nombre
                from
                        menu m
                        inner join menu_item_accesos a on ( m.codigo_menu = a.codigo_menu )
                where
                        a.codigo_cargo = :p_codigo_cargo
                        and a.acceso = '1'
                order by
                        1
                ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cargo", $codigoCargo);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function obtenerOpcionesMenuItem($codigoCargo, $codigoMenu) {
        try {
            $sql = "
                    select
                            m.nombre,
                            m.archivo
                    from
                            menu_item m
                            inner join menu_item_accesos a 
                            on 
                            ( 
                                    m.codigo_menu = a.codigo_menu and 
                                    m.codigo_menu_item = a.codigo_menu_item 
                            )

                    where
                            a.codigo_cargo = :p_codigo_cargo
                            and a.codigo_menu = :p_codigo_menu
                            and a.acceso = '1'
                    order by
                            a.codigo_menu_item
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            
            $sentencia->bindParam(":p_codigo_cargo", $codigoCargo);
            $sentencia->bindParam(":p_codigo_menu", $codigoMenu);
            
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
}
