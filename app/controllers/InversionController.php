<?php
class InversionController
{
    public static function crear(): string
    {
        $plan = Inversion::plan((int) ($_POST['plan_id'] ?? 0));
        $monto = (float) ($_POST['monto'] ?? 0);
        if (!$plan) {
            return 'Seleccione un plan válido.';
        }
        if ($monto < $plan['minimo']) {
            return 'El monto mínimo para este plan es ' . dinero($plan['minimo']) . '.';
        }
        Inversion::crear($_SESSION['usuario']['id'], (int) $plan['id'], $monto);
        header('Location: index.php?page=inversiones&ok=1');
        exit;
    }

    public static function cancelar(): void
    {
        Inversion::cancelar($_SESSION['usuario']['id'], (int) ($_POST['id'] ?? 0));
        header('Location: index.php?page=inversiones');
        exit;
    }
}