<?php
class Titulo
{
    private PDO $db;
    private string $id_titulo = '';
    private string $titulo = '';
    private string $tipo = '';
    private string $id_pub = '';
    private string $precio = '';
    private string $notas = '';
    private string $fecha_pub = '';
    private string $contrato = '1';
    private array $errores = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    private function setDatos(array $d): void
    {
        foreach (['id_titulo', 'titulo', 'tipo', 'id_pub', 'precio', 'notas', 'fecha_pub', 'contrato'] as $campo) {
            $this->$campo = trim((string)($d[$campo] ?? ''));
        }
    }

    private function validar(bool $esNuevo): bool
    {
        $this->errores = [];

        if ($esNuevo) {
            if ($this->id_titulo === '') {
                $this->errores[] = 'El ID del título no puede estar vacío.';
            } elseif (mb_strlen($this->id_titulo) > 6) {
                $this->errores[] = 'El ID del título no puede pasar de 6 caracteres.';
            } elseif ($this->existe($this->id_titulo)) {
                $this->errores[] = 'Ya existe un título con ese ID.';
            }
        }

        if ($this->titulo === '') {
            $this->errores[] = 'El título no puede estar vacío.';
        }
        if ($this->tipo === '') {
            $this->errores[] = 'El tipo no puede estar vacío.';
        }

        if ($this->id_pub === '') {
            $this->errores[] = 'Debes seleccionar una editorial.';
        } elseif (!$this->existePublicador($this->id_pub)) {
            $this->errores[] = 'La editorial seleccionada no existe.';
        }

        if ($this->precio === '' || !is_numeric($this->precio)) {
            $this->errores[] = 'El precio debe ser un número.';
        } elseif ((float)$this->precio < 0) {
            $this->errores[] = 'El precio no puede ser negativo.';
        }

        $fecha = DateTime::createFromFormat('Y-m-d', $this->fecha_pub);
        if (!$fecha || $fecha->format('Y-m-d') !== $this->fecha_pub) {
            $this->errores[] = 'La fecha de publicación no es válida.';
        }

        if (!in_array($this->contrato, ['0', '1'], true)) {
            $this->errores[] = 'El valor de contrato no es válido.';
        }

        $limites = [
            'titulo' => ['Título', 60],
            'tipo'   => ['Tipo', 15],
            'notas'  => ['Notas', 255],
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
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM titulos WHERE id_titulo = :id");
        $stmt->execute([':id' => $id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    private function existePublicador(string $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM publicadores WHERE id_pub = :id");
        $stmt->execute([':id' => $id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare(
            "SELECT t.*, p.nombre_pub
             FROM titulos t
             LEFT JOIN publicadores p ON t.id_pub = p.id_pub
             ORDER BY t.titulo"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(string $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM titulos WHERE id_titulo = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getPublicadores(): array
    {
        $stmt = $this->db->prepare("SELECT id_pub, nombre_pub FROM publicadores ORDER BY nombre_pub");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(array $datos): bool
    {
        $this->setDatos($datos);
        if (!$this->validar(true)) return false;

        $stmt = $this->db->prepare(
            "INSERT INTO titulos (id_titulo, titulo, tipo, id_pub, precio, notas, fecha_pub, contrato)
             VALUES (:id, :titulo, :tipo, :id_pub, :precio, :notas, :fecha, :contrato)"
        );
        return $stmt->execute([
            ':id'       => $this->id_titulo,
            ':titulo'   => $this->titulo,
            ':tipo'     => $this->tipo,
            ':id_pub'   => $this->id_pub,
            ':precio'   => $this->precio,
            ':notas'    => $this->notas,
            ':fecha'    => $this->fecha_pub . ' 12:00:00',
            ':contrato' => $this->contrato,
        ]);
    }

    public function update(string $id, array $datos): bool
    {
        $this->setDatos($datos);
        $this->id_titulo = $id;
        if (!$this->validar(false)) return false;

        $stmt = $this->db->prepare(
            "UPDATE titulos
             SET titulo = :titulo, tipo = :tipo, id_pub = :id_pub, precio = :precio,
                 notas = :notas, fecha_pub = :fecha, contrato = :contrato
             WHERE id_titulo = :id"
        );
        return $stmt->execute([
            ':titulo'   => $this->titulo,
            ':tipo'     => $this->tipo,
            ':id_pub'   => $this->id_pub,
            ':precio'   => $this->precio,
            ':notas'    => $this->notas,
            ':fecha'    => $this->fecha_pub . ' 12:00:00',
            ':contrato' => $this->contrato,
            ':id'       => $id,
        ]);
    }

    public function delete(string $id): bool
    {
        foreach (['detalle_venta' => 'ventas', 'titulo_autor' => 'autores'] as $tabla => $nombre) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM $tabla WHERE id_titulo = :id");
            $stmt->execute([':id' => $id]);
            if ((int)$stmt->fetchColumn() > 0) {
                $this->errores = ["No se puede eliminar el título porque tiene registros en $nombre."];
                return false;
            }
        }

        $stmt = $this->db->prepare("DELETE FROM titulos WHERE id_titulo = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM titulos");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
