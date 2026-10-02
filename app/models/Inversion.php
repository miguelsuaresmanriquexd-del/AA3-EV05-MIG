<?php
class Inversion
{
    public static function planes(): array
    {
        return Conexion::get()->query('SELECT * FROM planes ORDER BY rendimiento')->fetchAll();
    }

    public static function plan(int $id)
    {
        $s = Conexion::get()->prepare('SELECT * FROM planes WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch();
    }

    public static function listar(int $uid): array
    {
        $s = Conexion::get()->prepare(
            'SELECT i.id, i.monto, i.estado, i.creado, p.nombre plan, p.rendimiento, p.plazo_meses, p.riesgo,
            ROUND(i.monto * p.rendimiento / 100 * p.plazo_meses / 12, 2) ganancia
            FROM inversiones i JOIN planes p ON p.id = i.plan_id
            WHERE i.usuario_id = ? ORDER BY i.id DESC'
        );
        $s->execute([$uid]);
        return $s->fetchAll();
    }

    public static function resumen(int $uid): array
    {
        $s = Conexion::get()->prepare(
            "SELECT COUNT(*) total, COALESCE(SUM(i.monto), 0) invertido,
            COALESCE(SUM(i.monto * p.rendimiento / 100 * p.plazo_meses / 12), 0) ganancia
            FROM inversiones i JOIN planes p ON p.id = i.plan_id
            WHERE i.usuario_id = ? AND i.estado = 'Activa'"
        );
        $s->execute([$uid]);
        return $s->fetch();
    }

    public static function crear(int $uid, int $plan, float $monto): void
    {
        Conexion::get()->prepare('INSERT INTO inversiones (usuario_id, plan_id, monto) VALUES (?, ?, ?)')
            ->execute([$uid, $plan, $monto]);
    }

    public static function cancelar(int $uid, int $id): void
    {
        Conexion::get()->prepare("UPDATE inversiones SET estado = 'Cancelada' WHERE id = ? AND usuario_id = ?")
            ->execute([$id, $uid]);
    }

    public static function porPlan(int $uid): array
    {
        $s = Conexion::get()->prepare(
            "SELECT p.nombre plan, SUM(i.monto) total
            FROM inversiones i JOIN planes p ON p.id = i.plan_id
            WHERE i.usuario_id = ? AND i.estado = 'Activa'
            GROUP BY p.id, p.nombre ORDER BY total DESC"
        );
        $s->execute([$uid]);
        return $s->fetchAll();
    }

    public static function vencimientos(int $uid): array
    {
        $s = Conexion::get()->prepare(
            "SELECT p.nombre plan, i.monto, DATE_ADD(i.creado, INTERVAL p.plazo_meses MONTH) vence
            FROM inversiones i JOIN planes p ON p.id = i.plan_id
            WHERE i.usuario_id = ? AND i.estado = 'Activa'
            ORDER BY vence LIMIT 5"
        );
        $s->execute([$uid]);
        return $s->fetchAll();
    }
}