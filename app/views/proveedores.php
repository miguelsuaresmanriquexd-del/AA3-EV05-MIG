<?php
$proveedores = Proveedor::listar();
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Proveedores</h1>
    <p class="text-sm text-zinc-400 mt-1">Entidades que suministran los productos de inversión.</p>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Proveedor registrado correctamente.</div><?php endif; ?>

<form action="index.php?page=proveedores" method="POST" class="bg-white border border-zinc-200 rounded-2xl p-6 mb-8 grid md:grid-cols-3 gap-4 items-end">
    <input type="hidden" name="accion" value="guardar_proveedor">
    <div><label class="<?= $label ?>">Razón social</label><input type="text" name="razon_social" value="<?= e($_POST['razon_social'] ?? '') ?>" required class="<?= $input ?>"></div>
    <div><label class="<?= $label ?>">Nombre de contacto</label><input type="text" name="nombre" value="<?= e($_POST['nombre'] ?? '') ?>" required class="<?= $input ?>"></div>
    <div><label class="<?= $label ?>">Teléfono</label><input type="text" name="telefono" value="<?= e($_POST['telefono'] ?? '') ?>" class="<?= $input ?>"></div>
    <div class="md:col-span-2"><label class="<?= $label ?>">Dirección</label><input type="text" name="direccion" value="<?= e($_POST['direccion'] ?? '') ?>" class="<?= $input ?>"></div>
    <button type="submit" class="<?= $btn ?>">Guardar proveedor</button>
</form>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between border-b border-zinc-100">
        <h2 class="text-sm font-bold">Listado de proveedores</h2>
        <span class="text-xs text-zinc-400"><?= count($proveedores) ?> registrados</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Razón social</th>
                    <th class="<?= $th ?>">Contacto</th>
                    <th class="<?= $th ?>">Teléfono</th>
                    <th class="<?= $th ?>">Dirección</th>
                    <th class="<?= $th ?>">Registro</th>
                    <th class="<?= $th ?>"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($proveedores as $v): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($v['razon_social']) ?></td>
                        <td class="<?= $td ?>"><?= e($v['nombre']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($v['telefono'] ?: '-') ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($v['direccion'] ?: '-') ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($v['creado'])) ?></td>
                        <td class="<?= $td ?> text-right">
                            <form action="index.php?page=proveedores" method="POST" onsubmit="return confirm('¿Eliminar este proveedor?')">
                                <input type="hidden" name="accion" value="eliminar_proveedor">
                                <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                <button class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$proveedores): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no hay proveedores. Registre el primero con el formulario.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>