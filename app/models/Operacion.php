<?php
class Operacion
{
    private const T = [
        'venta' => ['ventas', 'descrip_venta', 'venta_id', 'clientes', 'nombre'],
        'compra' => ['compras', 'descrip_compra', 'compra_id', 'proveedores', 'razon_social'],
    ];

    public static function listar(string $tipo, int $uid): array
    {
        [$h, $d, $fk, $t, $col] = self::T[$tipo];
        $s = Conexion::get()->prepare(
            "SELECT h.id, h.fecha, h.iva, h.valor, t.$col tercero, p.nombre producto, d.unidades, d.valor_unitario
            FROM $h h JOIN $d d ON d.$fk = h.id JOIN $t t ON t.id = h.tercero_id
            JOIN productos p ON p.id = d.producto_id WHERE h.usuario_id = ? ORDER BY h.id DESC"
        );
        $s->execute([$uid]);
        return $s->fetchAll();
    }

    public static function registrar(string $tipo, int $uid, int $tercero, int $producto, int $unidades, float $unitario): void
    {
        [$h, $d, $fk] = self::T[$tipo];
        $pdo = Conexion::get();
        $sub = $unidades * $unitario;
        $iva = round($sub * 0.19, 2);
        $signo = $tipo === 'venta' ? '-' : '+';
        $pdo->beginTransaction();
        try {
            $pdo->prepare("INSERT INTO $h (usuario_id, tercero_id, iva, valor) VALUES (?, ?, ?, ?)")
                ->execute([$uid, $tercero, $iva, $sub + $iva]);
            $pdo->prepare("INSERT INTO $d ($fk, producto_id, unidades, valor_unitario) VALUES (?, ?, ?, ?)")
                ->execute([$pdo->lastInsertId(), $producto, $unidades, $unitario]);
            $pdo->prepare("UPDATE productos SET stock = stock $signo ? WHERE id = ?")->execute([$unidades, $producto]);
            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}