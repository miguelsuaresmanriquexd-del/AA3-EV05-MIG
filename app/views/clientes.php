<?php
$clientes = Cliente::listar($_SESSION['usuario']['id']);
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Clientes</h1>
    <p class="text-sm text-zinc-400 mt-1">Registre y consulte las personas que usted asesora.</p>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Cliente registrado correctamente.</div><?php endif; ?>

<form action="index.php?page=clientes" method="POST" class="bg-white border border-zinc-200 rounded-2xl p-6 mb-8 grid md:grid-cols-3 gap-4 items-end">
    <input type="hidden" name="accion" value="guardar_cliente">
    <div>
        <label class="<?= $label ?>">Documento</label>
        <input type="text" name="documento" value="<?= e($_POST['documento'] ?? '') ?>" required class="<?= $input ?>">
    </div>
    <div>
        <label class="<?= $label ?>">Nombre completo</label>
        <input type="text" name="nombre" value="<?= e($_POST['nombre'] ?? '') ?>" required class="<?= $input ?>">
    </div>
    <div>
        <label class="<?= $label ?>">Teléfono</label>
        <input type="text" name="telefono" value="<?= e($_POST['telefono'] ?? '') ?>" class="<?= $input ?>">
    </div>
    <div>
        <label class="<?= $label ?>">Correo</label>
        <input type="email" name="correo" value="<?= e($_POST['correo'] ?? '') ?>" class="<?= $input ?>">
    </div>
    <div>
        <label class="<?= $label ?>">Dirección</label>
        <input type="text" name="direccion" value="<?= e($_POST['direccion'] ?? '') ?>" class="<?= $input ?>">
    </div>
    <button type="submit" class="<?= $btn ?>">Guardar cliente</button>
</form>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between border-b border-zinc-100">
        <h2 class="text-sm font-bold">Listado de clientes</h2>
        <span class="text-xs text-zinc-400"><?= count($clientes) ?> registrados</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Documento</th>
                    <th class="<?= $th ?>">Nombre</th>
                    <th class="<?= $th ?>">Teléfono</th>
                    <th class="<?= $th ?>">Correo</th>
                    <th class="<?= $th ?>">Dirección</th>
                    <th class="<?= $th ?>">Registro</th>
                    <th class="<?= $th ?>"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($clientes as $c): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> tabular-nums"><?= e($c['documento']) ?></td>
                        <td class="<?= $td ?> font-bold"><?= e($c['nombre']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($c['telefono'] ?: '-') ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($c['correo'] ?: '-') ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($c['direccion'] ?: '-') ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($c['creado'])) ?></td>
                        <td class="<?= $td ?> text-right">
                            <form action="index.php?page=clientes" method="POST" onsubmit="return confirm('¿Eliminar este cliente?')">
                                <input type="hidden" name="accion" value="eliminar_cliente">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$clientes): ?>
                    <tr><td colspan="7" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no tiene clientes. Complete el formulario para registrar el primero.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>