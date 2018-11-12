<?php 

class CategoriaModel extends AppModel{
    private static $nombre = "categorias";
    
    public function listarTodo(){
        $categorias=$this->_db->query("SELECT * FROM categories");

        return $categorias->fetchall();
    }

    public function guardar($datos=array()){
        $consulta = $this->_db->prepare(
            "INSERT INTO categories 
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
        $categoria = $this->_db->prepare(
            "SELECT * FROM categories WHERE id=:id
        ");

        $categoria->bindParam(":id", $id);
        $categoria->execute();
        $registro = $categoria->fetch();

        if ($registro) {
            return $registro;
        } else {
            return false;
        } 
    }

    public function actualizar($datos=array()){
        $consulta = $this->_db->prepare(
            "UPDATE categories SET
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
            "DELETE FROM categories WHERE id=:id"
        );
        $consulta->bindParam(":id", $id);
        if ($consulta->execute()) {
            return true;
        } else {
            return false;
        }
    }

}