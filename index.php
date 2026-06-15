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

$controllerNameGet = Session::getGet('controller');
if (!empty($controllerNameGet)) {
    $controllerName = ucfirst($controllerNameGet);
}

$actionNameGet = Session::getGet('action');
if (!empty($actionNameGet)) {
    $actionName = $actionNameGet;
}

if (
    Session::isGet() &&
    $controllerName !== 'Utente' &&
    !in_array($actionName, ['login', 'registrazione', 'logout'])
) {
    Session::set('previous_url', Session::getServer('REQUEST_URI'));
}

$controllerClass = 'C' . $controllerName;

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
