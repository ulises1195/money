<?php

class cuentasController extends AppController
{
    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $cuentas = $this->loadModel("cuenta");

        $this->_view->cuentas = $cuentas->listarTodo();

        $this->_view->titulo = "Listado de cuentas";

        $this->_view->renderizar("index");

    }

    public function agregar()
    {
        if ($_POST) {
            if (empty($_POST['name']) || $_POST['name'] == "") {
                $this->_messages->warning(
                    'No ha llenado la información de la cuenta',
                    $this->redirect(array("controller" => "cuentas", "action" => "agregar"))
                );
                return;
            }

            $cuentas = $this->loadModel("cuenta");
            if ($cuentas->guardar($_POST)) {
                $this->_messages->success(
                    'La cuenta se guardó correctamente',
                    $this->redirect(array("controller" => "cuentas"))
                );
            }
        }

        $cuentas = $this->loadModel("cuenta");
        $this->_view->cuentas = $cuentas->listarTodo();

        $this->_view->titulo = "Agregar cuenta";
        $this->_view->renderizar("agregar");
    }

    public function editar($id = null)
    {
        if ($_POST) {
            $cuenta = $this->loadModel("cuenta");

            if (empty($_POST['name']) || $_POST['name'] == "") {
                $this->_messages->success(
                    'No ha llenado la información de la cuenta',
                    $this->redirect(array("controller" => "cuentas", "action" => "editar/" . $_POST['id']))
                );
                return;
            }

            if ($cuenta->actualizar($_POST)) {
                $this->_messages->success(
                    'La cuenta se guardó correctamente',
                    $this->redirect(array("controller" => "cuentas"))
                );
            } else {
                $this->_view->flashMessage = "La cuenta no se guardó";
                $this->redirect(array(
                        "controller" => "cuentas",
                        "action" => "editar/" . $id)
                );
            }

        }


        $cuenta = $this->loadModel("cuenta");
        $this->_view->cuenta = $cuenta->buscarPorId($id);

        $cuentas = $this->loadModel("cuenta");
        $this->_view->cuentas = $cuentas->listarTodo();

        $this->_view->titulo = "Editar cuenta";
        $this->_view->renderizar("editar");
    }

    public function eliminar($id)
    {
        $cuenta = $this->loadModel("cuenta");
        $registro = $cuenta->buscarPorId($id);
        if (!empty($registro)) {
            if ($cuenta->eliminarPorId($id)) {
                $this->_messages->success(
                    'La cuenta se eliminó correctamente',
                    $this->redirect(array("controller" => "cuentas"))
                );
            } else {
                $this->_messages->warning(
                    'La cuenta está en uso, no se puede eliminar',
                    $this->redirect(array("controller" => "cuentas"))
                );
            }
        }
    }
}
