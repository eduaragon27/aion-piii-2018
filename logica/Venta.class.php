<?php

require_once '../datos/Conexion.class.php';

class Venta extends Conexion{
    
    private $dniUsuario;
    private $dniCliente;
    private $direccion;
    private $celular;
    private $latitud;
    private $longitud;
    private $detalleVenta;

    function getDniUsuario() {
        return $this->dniUsuario;
    }

    function getDniCliente() {
        return $this->dniCliente;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCelular() {
        return $this->celular;
    }

    function getLatitud() {
        return $this->latitud;
    }

    function getLongitud() {
        return $this->longitud;
    }

    function getDetalleVenta() {
        return $this->detalleVenta;
    }

    function setDniUsuario($dniUsuario) {
        $this->dniUsuario = $dniUsuario;
    }

    function setDniCliente($dniCliente) {
        $this->dniCliente = $dniCliente;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    function setDetalleVenta($detalleVenta) {
        $this->detalleVenta = $detalleVenta;
    }

    
        
public function registrarVenta(){
    try {
        $sql="
            
select f_registrar_venta(:p_dni_cliente,
                        :p_dni_usuario,
                        :p_direccion, 
                        :p_celular,
                        :p_latitud,
                        :p_longitud, 
                        :p_detalle_venta
                        ) as resultado;";
        $sentencia = $this->dbLink->prepare($sql);
        $sentencia->bindParam(":p_dni_cliente", $this->getDniCliente());
        $sentencia->bindParam(":p_dni_usuario", $this->getDniUsuario());
        $sentencia->bindParam(":p_direccion", $this->getDireccion());
        $sentencia->bindParam(":p_celular", $this->getCelular());
        $sentencia->bindParam(":p_latitud", $this->getLatitud());
        $sentencia->bindParam(":p_longitud", $this->getLongitud());
        $sentencia->bindParam(":p_detalle_venta", $this->getDetalleVenta());
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado;
        
    } catch (Exception $exc) {
        throw $exc;
    }
    
}

 public function listar() {
        try {
            $sql = "select 
	v.codigo_venta, 
	(c.nombres || ' ' || c.apellido_paterno || ' ' || c.apellido_materno) as cliente,
	codigo_usuario, 
	v.fecha_venta, 
	v.total, 
	case v.estado when 'E' then 'Emitida' when 'C' then 'Cancelada' end as estado
from 
	venta v inner join cliente c on c.codigo_cliente = v.codigo_cliente
order by 
	2";
            $sentencia = $this->dbLink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    public function cambiarEstado($p_codigo_venta) {
        $this->dbLink->beginTransaction();
        try {
            
          $sql = "select f_estado_venta(:p_codigo_venta)";
                $sentencia = $this->dbLink->prepare($sql);
                $sentencia->bindParam(":p_codigo_venta", $p_codigo_venta);
                $sentencia->execute();
            $this->dbLink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dbLink->rollBack();
            throw $exc;
        }
        
    }
}
