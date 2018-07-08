<?php

require_once '../datos/Conexion.clase.php';

class Marca extends Conexion {
    private $codigoMarca;
    private $nombreMarca;
    
    function getCodigoMarca() {
        return $this->codigoMarca;
    }

    function getNombreMarca() {
        return $this->nombreMarca;
    }

    function setCodigoMarca($codigoMarca) {
        $this->codigoMarca = $codigoMarca;
    }

    function setNombreMarca($nombreMarca) {
        $this->nombreMarca = $nombreMarca;
    }

        public function listar() {
        try {
            $sql = "select * from marca where estado_marca='A'";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('marca') as correlativo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            if ($sentencia->rowCount()){
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->setCodigoMarca($resultado["correlativo"]);
                
                $sql = "INSERT INTO marca(
                        codigo_marca, nombre_marca, estado_marca) 
                        values 
                        (:p_codigo_marca, :p_nombre_marca, 'A')";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":p_nombre_marca", $this->getNombreMarca());
                $sentencia->execute();
                
                $sql = "update correlativo set numero = numero + 1 where tabla='marca'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true;
                
            }else{
                throw new Exception("No se encontró el correlativo para la tabla marca");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = " UPDATE marca
                        SET nombre_marca=:p_nombre_marca
                      WHERE codigo_marca = :p_codigo_marca; ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nombre_marca", $this->getNombreMarca());
            $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function leerDatos($p_codigo_marca){
        try {
            $sql = "select * from marca where codigo_marca = :p_codigo_marca";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_marca", $p_codigo_marca);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
                
    }
    
    public function eliminar($p_codigo_marca) {
        $this->dblink->beginTransaction();
        try {
//            $sql = "select * from venta_articulo where codigo_articulo = :p_codigo_articulo";
//            $sentencia = $this->dblink->prepare($sql);
//            $sentencia->bindParam(":p_codigo_articulo", $p_codigo_articulo);
//            $sentencia->execute();
//            if($sentencia->rowCount()){
//                throw new Exception("No es posible eliminar este registro por encontrar informacion dependiente");
//            }
            
            $sql = "Update
                        marca
                    set
                        estado_marca='I'
                    where 
                        codigo_marca = :p_codigo_marca";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_marca", $p_codigo_marca);
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
    }
    
}
