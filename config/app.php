<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!defined('BASE_URL')) {
    $raiz    = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));
    $base    = ($docRoot !== '' && stripos($raiz, $docRoot) === 0) ? substr($raiz, strlen($docRoot)) : '';
    define('BASE_URL', rtrim($base, '/') . '/');
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../models/Tienda.php';
require_once __DIR__ . '/../models/Titulo.php';


function e($valor): string
{
    return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
}


function flash(string $tipo, string $mensaje): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'mensaje' => $mensaje];
}


function mostrarFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($f['tipo']) . ' alert-dismissible fade show" role="alert">'
           . e($f['mensaje'])
           . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

function redirigir(string $ruta): void
{
    header('Location: ' . $ruta);
    exit;
}


set_exception_handler(function (Throwable $ex) {
    error_log($ex->getMessage());
    require_once __DIR__ . '/../includes/header.php';
    echo '<div class="container-fluid px-4"><h1 class="mt-4">Ocurrió un problema</h1>'
       . '<div class="alert alert-danger">' . e($ex->getMessage()) . '</div>'
       . '<a href="' . e(BASE_URL) . 'index.php" class="btn btn-secondary">Volver al inicio</a></div>';
    require_once __DIR__ . '/../includes/footer.php';
});
