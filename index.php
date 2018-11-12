<?php

/**
* / linux
* \ windows
*/

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__FILE__)) . DS);
define("APP_PATH", ROOT . "aplication" . DS);
//Imprimir ruta del proyecto
//echo APP_PATCH;

require_once(APP_PATH . "Config.php");
require_once(APP_PATH . "Request.php");
require_once(APP_PATH . "Bootstrap.php");
require_once(APP_PATH . "Controller.php");
require_once(APP_PATH . "Model.php");
require_once(APP_PATH . "View.php");
require_once(APP_PATH . "Database.php");
#mover el archivo a la carpeta libs
require_once(ROOT."libs".DS."FlashMessages.php");
//Comprobar que los archivos se estan cargando correctamente
//echo "<pre>";print_r(get_required_files());
/*try{
	Bootstrap::run(new Request);
}catch(Exception $e){
	echo $e->getMessage();
}

?>*/
if (!session_id()) @session_start();

try {
	Bootstrap::run(new Request);
} catch (Exception $e){
	echo $e->getMessage();
}