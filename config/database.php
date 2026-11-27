<?php
class Database
{
    private string $host;
    private string $dbname;
    private string $user;
    private string $pass;
    private bool $esLocal;

    public function __construct()
    {
        $servidor = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $this->esLocal = str_starts_with($servidor, 'localhost') || str_starts_with($servidor, '127.0.0.1');

        if ($this->esLocal) {
            // XAMPP
            $this->host   = '127.0.0.1';
            $this->dbname = 'dblibreria';
            $this->user   = 'root';
            $this->pass   = '';
        } else {
            // InfinityFree (se rellena en la Semana 3)
            $this->host   = 'sqlXXX.infinityfree.com';
            $this->dbname = 'if0_XXXXXXXX_dblibreria';
            $this->user   = 'if0_XXXXXXXX';
            $this->pass   = 'TU_CONTRASEÑA_REMOTA';
        }
    }

    public function getConnection(): PDO
    {
        try {
            return new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            $detalle = $this->esLocal ? ' Detalle: ' . $e->getMessage() : '';
            die('No se pudo conectar con la base de datos.' . $detalle);
        }
    }
}