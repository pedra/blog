<?php
//Buffer de saída
ob_start();

//Constantes com localização de diretórios de recursos
define('PPHP', __DIR__.'/');
define('LIB', PPHP.'lib/');
define('CONTROLLER', PPHP.'controller/');
define('MODEL', PPHP.'model/');
define('VIEW', PPHP.'../html/');

//Adicionando o caminho das Librarys no "include_path"
set_include_path('.' . PATH_SEPARATOR . str_replace('phar:', 'phar|', PPHP).trim(get_include_path(), ' .'));
//Registrando uma função de AutoLoade para as classes
spl_autoload_register(
	function ($class) {
        $class = ltrim('/' . strtolower(trim(strtr($class, '_\\', '//'), '/ ')), ' /\\') . '.php';
        $pth = explode(PATH_SEPARATOR, ltrim(get_include_path(), '.'));
        array_shift($pth);
        foreach ($pth as $f) {
            if (file_exists($f = str_replace('phar|', 'phar:', $f) . $class))
               return require_once $f;
        }
   	}
);
//Adicionando o autoloader do Composer - se existir.
if (file_exists(LIB . 'autoload.php')) include LIB . 'autoload.php';
      
      
//Defaults
$controller = 'Main';
$action = 'index';
$param = array();
 
//confirmando a variável   
if(!isset($_GET['phpstarturl'])) $_GET['phpstarturl'] = '';
 
//criando um array com os dados da URL   
$u = explode ('/', trim($_GET['phpstarturl'], ' /') );         
 
//Localizando o CONTROLLER
if(isset($u[0]) && file_exists(CONTROLLER.strtolower($u[0]).'.php')) {
    $controller = $u[0];
    array_shift($u);
}
include CONTROLLER.strtolower($controller).'.php';
$ctrl = new $controller();
 
//Localizando a ACTION
if(isset($u[0]) && method_exists($ctrl, $u[0])) {
    $action = $u[0];
    array_shift($u);
}

//Pegando os Parâmetros      
$param = $u;

//Rodando a action
call_user_func_array(array($ctrl, $action), $param);



//Output
header('Content-Type: text/html; charset=utf-8');
exit( ob_get_clean() );

