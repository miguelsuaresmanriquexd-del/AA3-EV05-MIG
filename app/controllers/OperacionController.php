<?php
class OperacionController
{
    public static function registrar(string $tipo): string
    {
        $tercero = (int) ($_POST['tercero_id'] ?? 0);
        $unidades = (int) ($_POST['unidades'] ?? 0);
        $p = Producto::obtener((int) ($_POST['producto_id'] ?? 0));
        if (!$tercero || !$p || $unidades < 1) {
            return 'Seleccione el tercero y el producto, e indique las unidades.';
        }
        if ($tipo === 'venta') {
            if ($p['stock'] < $unidades) {
                return 'Stock insuficiente. Disponible: ' . $p['stock'] . ' unidades.';
            }
            $unitario = (float) $p['precio'];
        } else {
            $unitario = (float) ($_POST['valor_unitario'] ?? 0);
            if ($unitario <= 0) {
                return 'Ingrese un valor unitario válido.';
            }
        }
        Operacion::registrar($tipo, $_SESSION['usuario']['id'], $tercero, (int) $p['id'], $unidades, $unitario);
        header('Location: index.php?page=' . $tipo . 's&ok=1');
        exit;
    }
}