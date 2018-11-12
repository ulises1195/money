<?php

class categoriasController extends AppController

{

    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $categorias = $this->loadModel("categoria");

        $this->_view->categorias = $categorias->listarTodo();

        $this->_view->titulo = "Listado de categorías";

        $this->_view->renderizar("index");

    }

    public function agregar()
    {
        if ($_POST) {
            if (empty($_POST['name']) || $_POST['name'] == "") {
                $this->_messages->warning(
                    'No ha llenado la información de la categoría',
                    $this->redirect(array("controller" => "categorias", "action" => "agregar"))
                );
                return;
            }

            $categorias = $this->loadModel("categoria");
            if ($categorias->guardar($_POST)) {
                $this->_messages->success(
                    'La categoría se guardó correctamente',
                    $this->redirect(array("controller" => "categorias"))
                );
            }
        }

        $categorias = $this->loadModel("categoria");
        $this->_view->categorias = $categorias->listarTodo();

        $this->_view->titulo = "Agregar categoría";
        $this->_view->renderizar("agregar");
    }

    public function editar($id = null)
    {
        if ($_POST) {
            $categoria = $this->loadModel("categoria");

            if (empty($_POST['name']) || $_POST['name'] == "") {
                $this->_messages->success(
                    'No ha llenado la información de la categoría',
                    $this->redirect(array("controller" => "categorias", "action" => "editar/" . $_POST['id']))
                );
                return;
            }

            if ($categoria->actualizar($_POST)) {
                $this->_messages->success(
                    'La categoría se guardó correctamente',
                    $this->redirect(array("controller" => "categorias"))
                );
            } else {
                $this->_view->flashMessage = "La categoría no se guardó";
                $this->redirect(array(
                        "controller" => "categorias",
                        "action" => "editar/" . $id)
                );
            }

        }


        $categoria = $this->loadModel("categoria");
        $this->_view->categoria = $categoria->buscarPorId($id);


        $categorias = $this->loadModel("categoria");
        $this->_view->categorias = $categorias->listarTodo();

        $this->_view->titulo = "Editar categoría";
        $this->_view->renderizar("editar");
    }

    public function eliminar($id)
    {
        $categoria = $this->loadModel("categoria");
        $registro = $categoria->buscarPorId($id);
        if (!empty($registro)) {
            if ($categoria->eliminarPorId($id)) {
                $this->_messages->success(
                    'La categoría se eliminó correctamente',
                    $this->redirect(array("controller" => "categorias"))
                );
            } else {
                $this->_messages->warning(
                    'La categoría está en uso, no se puede eliminar',
                    $this->redirect(array("controller" => "categorias"))
                );
            }
        }
    }
}