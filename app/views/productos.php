<?php
$productos = Producto::listar();
$proveedores = Proveedor::listar();
$inventario = array_sum(array_map(fn($p) => $p['precio'] * $p['stock'], $productos));
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Productos</h1>
    <p class="text-sm text-zinc-400 mt-1">Catálogo de productos de inversión y su disponibilidad.</p>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Producto registrado correctamente.</div><?php endif; ?>

<form action="index.php?page=productos" method="POST" class="bg-white border border-zinc-200 rounded-2xl p-6 mb-8 grid md:grid-cols-4 gap-4 items-end">
    <input type="hidden" name="accion" value="guardar_producto">
    <div><label class="<?= $label ?>">Nombre</label><input type="text" name="nombre" value="<?= e($_POST['nombre'] ?? '') ?>" required class="<?= $input ?>"></div>
    <div><label class="<?= $label ?>">Precio</label><input type="number" name="precio" min="0.01" step="0.01" required class="<?= $input ?>"></div>
    <div><label class="<?= $label ?>">Stock</label><input type="number" name="stock" min="0" value="0" required class="<?= $input ?>"></div>
    <div>
        <label class="<?= $label ?>">Proveedor</label>
        <select name="proveedor" class="<?= $input ?>">
            <option value="">Sin proveedor</option>
            <?php foreach ($proveedores as $v): ?><option value="<?= $v['id'] ?>"><?= e($v['razon_social']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="<?= $btn ?> md:col-span-4">Guardar producto</button>
</form>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-bold">Inventario de productos</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Producto</th>
                    <th class="<?= $th ?>">Proveedor</th>
                    <th class="<?= $th ?>">Precio</th>
                    <th class="<?= $th ?>">Stock</th>
                    <th class="<?= $th ?>">Valor en inventario</th>
                    <th class="<?= $th ?>"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($productos as $p): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($p['nombre']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($p['proveedor'] ?: '-') ?></td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero($p['precio']) ?></td>
                        <td class="<?= $td ?> tabular-nums">
                            <?= $p['stock'] ?>
                            <?php if ($p['stock'] <= 5): ?><span class="ml-2 px-2 py-0.5 rounded-full bg-zinc-100 text-zinc-400 text-[10px] font-bold uppercase tracking-wider">Bajo</span><?php endif; ?>
                        </td>
                        <td class="<?= $td ?> tabular-nums text-zinc-500"><?= dinero($p['precio'] * $p['stock']) ?></td>
                        <td class="<?= $td ?> text-right">
                            <form action="index.php?page=productos" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                <input type="hidden" name="accion" value="eliminar_producto">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$productos): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no hay productos. Registre el primero con el formulario.</td></tr>
                <?php endif; ?>
            </tbody>
            <?php if ($productos): ?>
                <tfoot class="bg-zinc-50 text-xs font-bold border-t border-zinc-200">
                    <tr>
                        <td class="<?= $td ?>" colspan="4">Valor total del inventario</td>
                        <td class="<?= $td ?> tabular-nums" colspan="2"><?= dinero($inventario) ?></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>