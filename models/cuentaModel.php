<?php

class CuentaModel extends AppModel{

    private static $nombre = "cuentas";

    public function listarTodo(){
        $cuentas=$this->_db->query("SELECT * FROM accounts");

        return $cuentas->fetchall();
    }

    public function guardar($datos=array()){
        $consulta = $this->_db->prepare(
            "INSERT INTO accounts 
                (name)
                VALUES (:name)"
        );
        $consulta->bindParam(":name", $datos["name"]);

        if ($consulta->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function buscarPorId($id){
        $cuenta = $this->_db->prepare(
            "SELECT * FROM accounts WHERE id=:id
        ");

        $cuenta->bindParam(":id", $id);
        $cuenta->execute();
        $registro = $cuenta->fetch();

        if ($registro) {
            return $registro;
        } else {
            return false;
        }
    }

    public function actualizar($datos=array()){
        $consulta = $this->_db->prepare(
            "UPDATE accounts SET
                name=:name
                WHERE id=:id
        ");
        $consulta->bindParam(":id", $datos["id"]);
        $consulta->bindParam(":name", $datos["name"]);

        if ($consulta->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function eliminarPorId($id){
        $consulta = $this->_db->prepare(
            "DELETE FROM accounts WHERE id=:id"
        );
        $consulta->bindParam(":id", $id);
        if ($consulta->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
