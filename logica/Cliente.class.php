<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion{
    private $dniCliente;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $nombres;
    private $direccionCliente;
    private $telefonoCiente;
    private $celularCliente;
    private $emailCliente;
    
    function getDniCliente() {
        return $this->dniCliente;
    }

    function getApellidoPaterno() {
        return $this->apellidoPaterno;
    }

    function getApellidoMaterno() {
        return $this->apellidoMaterno;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getDireccionCliente() {
        return $this->direccionCliente;
    }

    function getTelefonoCiente() {
        return $this->telefonoCiente;
    }

    function getCelularCliente() {
        return $this->celularCliente;
    }

    function getEmailCliente() {
        return $this->emailCliente;
    }

    function setDniCliente($dniCliente) {
        $this->dniCliente = $dniCliente;
    }

    function setApellidoPaterno($apellidoPaterno) {
        $this->apellidoPaterno = $apellidoPaterno;
    }

    function setApellidoMaterno($apellidoMaterno) {
        $this->apellidoMaterno = $apellidoMaterno;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setDireccionCliente($direccionCliente) {
        $this->direccionCliente = $direccionCliente;
    }

    function setTelefonoCiente($telefonoCiente) {
        $this->telefonoCiente = $telefonoCiente;
    }

    function setCelularCliente($celularCliente) {
        $this->celularCliente = $celularCliente;
    }

    function setEmailCliente($emailCliente) {
        $this->emailCliente = $emailCliente;
    }

        
    
     public function listar() {
        try {
            $sql = "select * from cliente where estado_cliente='A' order by 2";
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

                
                $sql = "INSERT INTO cliente(dni_cliente, apellido_paterno, apellido_materno, nombres, direccion_cliente, telefono_cliente, celular_cliente, email_cliente, estado_cliente)
                        VALUES (:p_dni_cliente, :p_apellido_paterno, :p_apellido_materno,
                            :p_nombres, :p_direccion_cliente, :p_telefono_cliente, :p_celular_cliente, :p_email_cliente, 'A')";
                
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_dni_cliente", $this->getDniCliente());
                $sentencia->bindParam(":p_apellido_paterno", $this->getApellidoPaterno());
                $sentencia->bindParam(":p_apellido_materno", $this->getApellidoMaterno());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_direccion_cliente", $this->getDireccionCliente());
                $sentencia->bindParam(":p_telefono_cliente", $this->getTelefonoCiente());
                $sentencia->bindParam(":p_celular_cliente", $this->getCelularCliente());
                $sentencia->bindParam(":p_email_cliente", $this->getEmailCliente());
                $sentencia->execute();
                $this->dblink->commit();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                return true;

        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = " UPDATE cliente
                        SET apellido_paterno=:p_apellido_paterno, apellido_materno=:p_apellido_materno, nombres=:p_nombres, 
                             direccion_cliente=:p_direccion_cliente, telefono_cliente=:p_telefono_cliente, celular_cliente=:p_celular_cliente, email_cliente=:p_email_cliente
                        WHERE dni_cliente=:p_dni_cliente;";
            
            $sentencia = $this->dblink->prepare($sql);
                
                $sentencia->bindParam(":p_apellido_paterno", $this->getApellidoPaterno());
                $sentencia->bindParam(":p_apellido_materno", $this->getApellidoMaterno());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_direccion_cliente", $this->getDireccionCliente());
                $sentencia->bindParam(":p_telefono_cliente", $this->getTelefonoCiente());
                $sentencia->bindParam(":p_celular_cliente", $this->getCelularCliente());
                $sentencia->bindParam(":p_email_cliente", $this->getEmailCliente());
                $sentencia->bindParam(":p_dni_cliente", $this->getDniCliente());
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
    }
    
    public function leerDatos($p_dni_cliente){
        try {
            $sql = "select * from cliente where dni_cliente = :p_dni_cliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni_cliente", $p_dni_cliente);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
                
    }
    
    public function eliminar($p_dni_cliente) {
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
                        cliente 
                    set
                        estado_cliente='I'
                    where 
                        dni_cliente = :p_dni_cliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_dni_cliente", $p_dni_cliente);
            $sentencia->execute();
            
            $this->dblink->commit();
                
            return true;
                
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
    }
}


   

