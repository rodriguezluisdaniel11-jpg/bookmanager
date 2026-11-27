<?php
$paginaActual = $_SERVER['SCRIPT_NAME'];
if (!function_exists('esActivo')) {
    function esActivo(string $segmento): string {
        global $paginaActual;
        return str_contains($paginaActual, $segmento) ? ' active' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>BookManager</title>
        <link href="<?= BASE_URL ?>assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="<?= BASE_URL ?>index.php">BookManager</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Principal</div>
                            <a class="nav-link<?= $paginaActual === BASE_URL . 'index.php' ? ' active' : '' ?>" href="<?= BASE_URL ?>index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Inicio
                            </a>
                            <div class="sb-sidenav-menu-heading">Gestión</div>
                            <a class="nav-link<?= esActivo('/tiendas/') ?>" href="<?= BASE_URL ?>views/tiendas/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                Tiendas
                            </a>
                            <a class="nav-link<?= esActivo('/titulos/') ?>" href="<?= BASE_URL ?>views/titulos/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Títulos
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Sistema de gestión</div>
                        BookManager
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>