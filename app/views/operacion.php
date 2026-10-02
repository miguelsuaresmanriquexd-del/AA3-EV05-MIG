<?php
$esVenta = $tipo === 'venta';
$uid = $_SESSION['usuario']['id'];
$terceros = $esVenta ? Cliente::listar($uid) : Proveedor::listar();
$productos = Producto::listar();
$lista = Operacion::listar($tipo, $uid);
$ruta = 'index.php?page=' . $tipo . 's';
$tarjetas = [
    [$esVenta ? 'Total vendido' : 'Total comprado', dinero(array_sum(array_column($lista, 'valor')))],
    ['IVA acumulado (19%)', dinero(array_sum(array_column($lista, 'iva')))],
    ['Operaciones', count($lista)],
];
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight"><?= $esVenta ? 'Ventas' : 'Compras' ?></h1>
    <p class="text-sm text-zinc-400 mt-1"><?= $esVenta ? 'Registre ventas a clientes. El stock se descuenta automáticamente.' : 'Registre compras a proveedores. El stock se incrementa automáticamente.' ?></p>
</div>

<div class="grid sm:grid-cols-3 gap-5 mb-8">
    <?php foreach ($tarjetas as [$t, $v]): ?>
        <div class="bg-white border border-zinc-200 rounded-2xl p-6">
            <p class="text-xs font-bold tracking-wider text-zinc-400 uppercase"><?= $t ?></p>
            <p class="text-2xl font-extrabold mt-3 tabular-nums"><?= $v ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>"><?= $esVenta ? 'Venta' : 'Compra' ?> registrada correctamente.</div><?php endif; ?>

<form action="<?= $ruta ?>" method="POST" class="bg-white border border-zinc-200 rounded-2xl p-6 mb-8 grid md:grid-cols-<?= $esVenta ? 4 : 5 ?> gap-4 items-end">
    <input type="hidden" name="accion" value="registrar_<?= $tipo ?>">
    <div>
        <label class="<?= $label ?>"><?= $esVenta ? 'Cliente' : 'Proveedor' ?></label>
        <select name="tercero_id" required class="<?= $input ?>">
            <option value="">Seleccione</option>
            <?php foreach ($terceros as $t): ?><option value="<?= $t['id'] ?>"><?= e($esVenta ? $t['nombre'] : $t['razon_social']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="<?= $label ?>">Producto</label>
        <select name="producto_id" required class="<?= $input ?>">
            <option value="">Seleccione</option>
            <?php foreach ($productos as $p): ?><option value="<?= $p['id'] ?>"><?= e($p['nombre']) ?> (stock <?= $p['stock'] ?><?= $esVenta ? ', ' . dinero($p['precio']) : '' ?>)</option><?php endforeach; ?>
        </select>
    </div>
    <div><label class="<?= $label ?>">Unidades</label><input type="number" name="unidades" min="1" required class="<?= $input ?>"></div>
    <?php if (!$esVenta): ?>
        <div><label class="<?= $label ?>">Valor unitario</label><input type="number" name="valor_unitario" min="0.01" step="0.01" required class="<?= $input ?>"></div>
    <?php endif; ?>
    <button type="submit" class="<?= $btn ?>">Registrar</button>
</form>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-bold">Historial de <?= $esVenta ? 'ventas' : 'compras' ?></h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Nº</th>
                    <th class="<?= $th ?>">Fecha</th>
                    <th class="<?= $th ?>"><?= $esVenta ? 'Cliente' : 'Proveedor' ?></th>
                    <th class="<?= $th ?>">Producto</th>
                    <th class="<?= $th ?>">Unidades</th>
                    <th class="<?= $th ?>">Valor unitario</th>
                    <th class="<?= $th ?>">IVA</th>
                    <th class="<?= $th ?>">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($lista as $o): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> tabular-nums text-zinc-500">#<?= $o['id'] ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y H:i', strtotime($o['fecha'])) ?></td>
                        <td class="<?= $td ?> font-bold"><?= e($o['tercero']) ?></td>
                        <td class="<?= $td ?>"><?= e($o['producto']) ?></td>
                        <td class="<?= $td ?> tabular-nums"><?= $o['unidades'] ?></td>
                        <td class="<?= $td ?> tabular-nums text-zinc-500"><?= dinero($o['valor_unitario']) ?></td>
                        <td class="<?= $td ?> tabular-nums text-zinc-500"><?= dinero($o['iva']) ?></td>
                        <td class="<?= $td ?> tabular-nums font-bold"><?= dinero($o['valor']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$lista): ?>
                    <tr><td colspan="8" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no hay registros. Complete el formulario para crear el primero.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
