<?php
class Tienda
{
    private PDO $db;
    private string $id_tienda = '';
    private string $nombre_tienda = '';
    private string $direcc_tienda = '';
    private string $ciudad = '';
    private string $estado = '';
    private string $pais = '';
    private string $cod_postal = '';
    private string $terminos = '';
    private array $errores = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    private function setDatos(array $d): void
    {
        foreach (['id_tienda', 'nombre_tienda', 'direcc_tienda', 'ciudad', 'estado', 'pais', 'cod_postal', 'terminos'] as $campo) {
            $this->$campo = trim($d[$campo] ?? '');
        }
    }

    private function validar(bool $esNuevo): bool
    {
        $this->errores = [];

        if ($esNuevo) {
            if ($this->id_tienda === '') {
                $this->errores[] = 'El ID de la tienda no puede estar vacío.';
            } elseif (mb_strlen($this->id_tienda) > 4) {
                $this->errores[] = 'El ID de la tienda no puede pasar de 4 caracteres.';
            } elseif ($this->existe($this->id_tienda)) {
                $this->errores[] = 'Ya existe una tienda con ese ID.';
            }
        }

        if ($this->nombre_tienda === '') {
            $this->errores[] = 'El nombre de la tienda no puede estar vacío.';
        }

        $limites = [
            'nombre_tienda' => ['Nombre', 40],
            'direcc_tienda' => ['Dirección', 40],
            'ciudad'        => ['Ciudad', 15],
            'estado'        => ['Estado', 2],
            'pais'          => ['País', 3],
            'cod_postal'    => ['Código postal', 5],
            'terminos'      => ['Términos', 6],
        ];
        foreach ($limites as $campo => [$etiqueta, $max]) {
            if (mb_strlen($this->$campo) > $max) {
                $this->errores[] = "$etiqueta no puede pasar de $max caracteres.";
            }
        }

        return empty($this->errores);
    }

    public function getErrores(): array
    {
        return $this->errores;
    }

    public function existe(string $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tiendas WHERE id_tienda = :id");
        $stmt->execute([':id' => $id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tiendas ORDER BY nombre_tienda");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(string $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM tiendas WHERE id_tienda = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $datos): bool
    {
        $this->setDatos($datos);
        if (!$this->validar(true)) return false;

        $stmt = $this->db->prepare(
            "INSERT INTO tiendas (id_tienda, nombre_tienda, direcc_tienda, ciudad, estado, pais, cod_postal, terminos)
             VALUES (:id, :nombre, :direccion, :ciudad, :estado, :pais, :cp, :terminos)"
        );
        return $stmt->execute([
            ':id'        => $this->id_tienda,
            ':nombre'    => $this->nombre_tienda,
            ':direccion' => $this->direcc_tienda,
            ':ciudad'    => $this->ciudad,
            ':estado'    => $this->estado,
            ':pais'      => $this->pais,
            ':cp'        => $this->cod_postal,
            ':terminos'  => $this->terminos,
        ]);
    }

    public function update(string $id, array $datos): bool
    {
        $this->setDatos($datos);
        $this->id_tienda = $id;
        if (!$this->validar(false)) return false;

        $stmt = $this->db->prepare(
            "UPDATE tiendas
             SET nombre_tienda = :nombre, direcc_tienda = :direccion, ciudad = :ciudad,
                 estado = :estado, pais = :pais, cod_postal = :cp, terminos = :terminos
             WHERE id_tienda = :id"
        );
        return $stmt->execute([
            ':nombre'    => $this->nombre_tienda,
            ':direccion' => $this->direcc_tienda,
            ':ciudad'    => $this->ciudad,
            ':estado'    => $this->estado,
            ':pais'      => $this->pais,
            ':cp'        => $this->cod_postal,
            ':terminos'  => $this->terminos,
            ':id'        => $id,
        ]);
    }

    public function delete(string $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM ventas WHERE id_tienda = :id");
        $stmt->execute([':id' => $id]);
        if ((int)$stmt->fetchColumn() > 0) {
            $this->errores = ['No se puede eliminar la tienda porque tiene ventas registradas.'];
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM tiendas WHERE id_tienda = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tiendas");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
