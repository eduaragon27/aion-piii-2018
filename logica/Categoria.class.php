<?php

require_once '../datos/Conexion.clase.php';

class Categoria extends Conexion {
    private $codigoCategoria;
    private $nombreCategoria;
    private $requiereColor;
    
    function getRequiereColor() {
        return $this->requiereColor;
    }

    function setRequiereColor($requiereColor) {
        $this->requiereColor = $requiereColor;
    }

        
    function getCodigoCategoria() {
        return $this->codigoCategoria;
    }

    function getNombreCategoria() {
        return $this->nombreCategoria;
    }

    function setCodigoCategoria($codigoCategoria) {
        $this->codigoCategoria = $codigoCategoria;
    }

    function setNombreCategoria($nombreCategoria) {
        $this->nombreCategoria = $nombreCategoria;
    }

    
        
    public function listar() {
        try {
            $sql = "select codigo_categoria,
                    nombre_categoria,
                    case requiere_color when 'S' then 'Si requiere color' when 'N' then 'No requiere color' end as requiere_color
                    from categoria where estado_categoria='A' order by 2";
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
            $sql = "select * from f_generar_correlativo('categoria') as correlativo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            if ($sentencia->rowCount()){
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->setCodigoCategoria($resultado["correlativo"]);
                
                $sql = "INSERT INTO categoria(
                        codigo_categoria, nombre_categoria, estado_categoria, requiere_color) 
                        values 
                        (:p_codigo_categoria, :p_nombre_categoria, 'A', :p_requiere_color);";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_nombre_categoria", $this->getNombreCategoria());
                $sentencia->bindParam(":p_requiere_color", $this->getRequiereColor());
                $sentencia->execute();
                
                $sql = "update correlativo set numero = numero + 1 where tabla='categoria'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true;
                
            }else{
                throw new Exception("No se encontró el correlativo para la tabla categoria");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = " UPDATE categoria
                        SET nombre_categoria=:p_nombre_categoria, requiere_color=:p_requiere_color
                      WHERE codigo_categoria = :p_codigo_categoria; ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_nombre_categoria", $this->getNombreCategoria());
            $sentencia->bindParam(":p_requiere_color", $this->getRequiereColor());
            $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function leerDatos($p_codigo_categoria){
        try {
            $sql = "select * from categoria where codigo_categoria = :p_codigo_categoria";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_categoria", $p_codigo_categoria);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
                
    }
    
    public function eliminar($p_codigo_categoria) {
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
                        categoria 
                    set
                        estado_categoria='I'
                    where 
                        codigo_categoria = :p_codigo_categoria";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_categoria", $p_codigo_categoria);
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
    }
    
}
