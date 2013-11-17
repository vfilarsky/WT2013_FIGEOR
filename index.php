<?

namespace Figeor;

require_once 'init.php';

$parsedUrl = @(Controller\AbstractController::parseURL());

$controllerClass = __NAMESPACE__ . '\Controller\\' . ucfirst($parsedUrl['controller']) . 'Controller';
$controller = new $controllerClass;
$action = $parsedUrl['action'];

$response = $controller->doAction($action);
$ret = '';
$ret .= $response->renderToString();

$content = ob_get_contents();
ob_end_clean();
echo $content;

exit;