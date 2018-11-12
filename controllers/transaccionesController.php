<?php
class transaccionesController extends AppController

{

    public function __construct(){

    parent::__construct();

    }

    public function index(){

    $transacciones = $this->loadModel("transaccion");

    $this->_view->transaccion = $transacciones->findAll();

    $this->_view->titulo = "Listado de transacciones";

    $this->_view->renderizar("index");

    }

    public function agregar(){
        if ($_POST) {

        	if (empty($_POST['description']) || $_POST['description'] == "") {
                $this->_messages->warning(
                    'No ha llenado la información de la transacción',
                    $this->redirect(array("controller"=>"transacciones", "action" => "agregar"))
                );
                return;
            }
            $transacciones = $this->loadModel("transaccion");
            if ($transacciones->add($_POST)) {
                $this->_messages->success(
                    'La transacción se guardó correctamente',
                    $this->redirect(array("controller"=>"transacciones"))
                );
            }

        }

        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();

        $cuentas=$this->loadModel("cuenta");
        $this->_view->cuentas=$cuentas->listarTodo();

        $this->_view->titulo="Agregar tarea";
        $this->_view->renderizar("agregar");
    }

    public function editar($id=null){
        if ($_POST) {
            $transaccion = $this->loadModel("transaccion");
            if ($transaccion->edit($_POST)) {
                $this->_messages->success(
                    'La transacción se guardó correctamente',
                    $this->redirect(array("controller"=>"transacciones"))
                );
            } else {
               $this->_view->flashMessage = "La cuenta no se guardó";
               $this->redirect(array(
                    "controller"=>"transacciones",
                    "action"=>"editar/".$id)
                );
            }

            $this->redirect(array("controller"=>"transacciones"));
        }

        $transaccion = $this->loadModel("transaccion");
        $this->_view->transaccion=$transaccion->find($id);

        $categorias=$this->loadModel("categoria");
        $this->_view->categorias=$categorias->listarTodo();

        $cuentas=$this->loadModel("cuenta");
        $this->_view->cuentas=$cuentas->listarTodo();

        $this->_view->titulo="Editar transacción";
        $this->_view->renderizar("editar");
    }

    public function eliminar($id){
        $transaccion = $this->loadModel("transaccion");
        $registro = $transaccion->find($id);

        if (!empty($registro)) {
            $transaccion->delete($id);
            $this->_messages->success(
                    'La transacción se eliminó correctamente',
                    $this->redirect(array("controller"=>"transacciones"))
                );
        }
    }
}