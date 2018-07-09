<?php

require_once '../datos/Conexion.clase.php';
class Producto extends Conexion {
    
   private $codigoProducto;
   private $nombreProducto;
   private $descripcionProducto;
   private $estadoProducto;
   private $precio;
   private $stock;
   private $color;
   private $codigoMarca;
   private $codigoCategoria;
   
   function getStock() {
       return $this->stock;
   }

   function setStock($stock) {
       $this->stock = $stock;
   }

      function getCodigoProducto() {
       return $this->codigoProducto;
   }

   function getNombreProducto() {
       return $this->nombreProducto;
   }

   function getDescripcionProducto() {
       return $this->descripcionProducto;
   }

   function getEstadoProducto() {
       return $this->estadoProducto;
   }

   function getPrecio() {
       return $this->precio;
   }

   function getColor() {
       return $this->color;
   }

   function getCodigoMarca() {
       return $this->codigoMarca;
   }

   function getCodigoCategoria() {
       return $this->codigoCategoria;
   }

   function setCodigoProducto($codigoProducto) {
       $this->codigoProducto = $codigoProducto;
   }

   function setNombreProducto($nombreProducto) {
       $this->nombreProducto = $nombreProducto;
   }

   function setDescripcionProducto($descripcionProducto) {
       $this->descripcionProducto = $descripcionProducto;
   }

   function setEstadoProducto($estadoProducto) {
       $this->estadoProducto = $estadoProducto;
   }

   function setPrecio($precio) {
       $this->precio = $precio;
   }

   function setColor($color) {
       $this->color = $color;
   }

   function setCodigoMarca($codigoMarca) {
       $this->codigoMarca = $codigoMarca;
   }

   function setCodigoCategoria($codigoCategoria) {
       $this->codigoCategoria = $codigoCategoria;
   }

   
   public function listar2() {
       try {
           $sql = "select * from producto order by 2" ;
           $sentencia = $this->dblink->prepare($sql);
           $sentencia->execute();
           $resultado=$sentencia->fetchALL(PDO::FETCH_ASSOC);
           return $resultado;
       } catch (Exception $exc) {
           throw $exc;;
       }
      }
    
        public function obtenerFoto($codigo) {
        $foto = "../fotos_productos/".$codigo;

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
            return Funciones::$REPOSITORIO_IMAGENES_WEB_SERVICE . $foto;
        }

    }
public function cargarDatosProducto($nombre) {
        try {
            $sql ="
                select
                        codigo_producto,
                        nombre_producto
                        descripcion_producto,
                        precio,
                        color,
                        stock
                from
                        producto
                where
                        lower(nombre_producto) like :p_nombre ";
            
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    public function listar() {
        try {
            $sql = "select

                    a.codigo_producto,
                    a.descripcion_producto,
                    a.nombre_producto,
                    a.color,
                    a.precio,
                    a.stock,
                    case a.estado_producto when 'A' then 'Activo' when 'I' then 'Inactivo' end as estado_producto,
                    c.nombre_categoria as categoria,
                    c.requiere_color,
                    m.nombre_marca as marca

            from 
                    producto a inner join categoria c on 
                    (a.codigo_categoria = c.codigo_categoria) 
                    inner join marca m on 
                    (a.codigo_marca = m.codigo_marca)
            where
                    a.estado_producto='A'";
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
            $sql = "select * from f_generar_correlativo('producto') as correlativo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            if ($sentencia->rowCount()){
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $this->setCodigoProducto($resultado["correlativo"]);
                
                $sql = "INSERT INTO producto(
                        codigo_producto, nombre_producto, descripcion_producto, estado_producto, stock, precio,
                        color, codigo_marca, codigo_categoria) 
                        values 
                        (:p_codigo_producto, :p_nombre_producto, :p_descripcion_producto, :p_estado_producto, :p_stock, :p_precio, 
                        :p_color, :p_codigo_marca, :p_codigo_categoria);";
                
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
                $sentencia->bindParam(":p_nombre_producto", $this->getNombreProducto());
                $sentencia->bindParam(":p_descripcion_producto", $this->getDescripcionProducto());
                $sentencia->bindParam(":p_estado_producto", $this->getEstadoProducto());
                $sentencia->bindParam(":p_stock", $this->getStock());
                $sentencia->bindParam(":p_precio", $this->getPrecio());
                $sentencia->bindParam(":p_color", $this->getColor());
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->execute();
                
                $sql = "update correlativo set numero = numero + 1 where tabla='producto'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true;
                
            }else{
                throw new Exception("No se encontró el correlativo para la tabla menú");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = " UPDATE producto
                     SET nombre_producto=:p_nombre_producto, descripcion_producto=:p_descripcion_producto, 
                         estado_producto=:p_estado_producto, stock=:p_stock, precio=:p_precio, color=:p_color, codigo_marca=:p_codigo_marca, 
                         codigo_categoria=:p_codigo_categoria
                     WHERE codigo_producto= :p_codigo_producto;
                     ";
            $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_nombre_producto", $this->getNombreProducto());
                $sentencia->bindParam(":p_descripcion_producto", $this->getDescripcionProducto());
                $sentencia->bindParam(":p_estado_producto", $this->getEstadoProducto());
                $sentencia->bindParam(":p_stock", $this->getStock());
                $sentencia->bindParam(":p_precio", $this->getPrecio());
                $sentencia->bindParam(":p_color", $this->getColor());
                $sentencia->bindParam(":p_codigo_marca", $this->getCodigoMarca());
                $sentencia->bindParam(":p_codigo_categoria", $this->getCodigoCategoria());
                $sentencia->bindParam(":p_codigo_producto", $this->getCodigoProducto());
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function leerDatos($p_codigo_producto){
        try {
            $sql = "select * from producto where codigo_producto = :p_codigo_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_producto", $p_codigo_producto);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
                
    }
    
    public function eliminar($p_codigo_producto) {
        $this->dblink->beginTransaction();
        try {
//            $sql = "select * from venta_producto where codigo_producto = :p_codigo_producto";
//            $sentencia = $this->dblink->prepare($sql);
//            $sentencia->bindParam(":p_codigo_producto", $p_codigo_producto);
//            $sentencia->execute();
//            if($sentencia->rowCount()){
//                throw new Exception("No es posible eliminar este registro por encontrar informacion dependiente");
//            }
            
            $sql = "Update
                        producto 
                    set
                        estado_producto='I'
                    where 
                        codigo_producto = :p_codigo_producto";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_producto", $p_codigo_producto);
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
    }
}