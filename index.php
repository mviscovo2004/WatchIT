<?php

require_once __DIR__ . "/foundation/session.php";

Session::start();

require_once __DIR__ . "/vendor/autoload.php";


if (class_exists('FBan')) {
    FBan::cleanExpiredBans();
    if (Session::isLogged()) {
        $ban = FBan::isBanned(Session::get('user_id'));
        if ($ban !== null) {
            Session::remove('user_id');
            Session::remove('ruolo');
            Session::set('login_error', "Il tuo account è sospeso fino al " . $ban->getDataFine()->format('d/m/Y H:i') . " per il seguente motivo: " . $ban->getMotivo());
            Session::set('show_login_modal', true);
            header("Location: index.php");
            exit();
        }
    }
}


$controllerName = "Contenuto";
$actionName = "homepage";

if (isset($_GET['controller']) && !empty($_GET['controller'])) {
    $controllerName = ucfirst($_GET['controller']);
}

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $actionName = $_GET['action'];
}

$controllerClass = 'C' . $controllerName;


if (
    $_SERVER['REQUEST_METHOD'] === 'GET' &&
    $controllerName !== 'Utente' &&
    !in_array($actionName, ['login', 'registrazione', 'logout'])
) {
    Session::set('previous_url', $_SERVER['REQUEST_URI']);
}


if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass();
    if (method_exists($controllerInstance, $actionName)) {
        $controllerInstance->$actionName();
    } else {
        mostra404();
    }
} else {
    mostra404();
}


function mostra404()
{
    $config = require __DIR__ . "/foundation/bootstrap.php";
    header("HTTP/1.0 404 Not Found");
    $smarty = $config['smarty'];
    $smarty->display('error404.tpl');
    exit();
}
