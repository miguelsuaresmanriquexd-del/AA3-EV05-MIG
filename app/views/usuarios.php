<?php
$usuarios = Usuario::todos();
$roles = Usuario::roles();
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Usuarios</h1>
    <p class="text-sm text-zinc-400 mt-1">Administre los roles y los permisos de acceso de cada usuario.</p>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Rol actualizado correctamente.</div><?php endif; ?>

<div class="grid sm:grid-cols-3 gap-5 mb-8">
    <?php foreach ($roles as $r): ?>
        <div class="bg-white border border-zinc-200 rounded-2xl p-6">
            <p class="text-sm font-bold"><?= e($r['nombre']) ?></p>
            <p class="text-xs text-zinc-500 mt-1"><?= e($r['descripcion']) ?></p>
            <p class="text-xs text-zinc-400 mt-4 pt-4 border-t border-zinc-100 leading-relaxed"><?= e($r['permisos'] ?: 'Solo inversiones propias') ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-bold">Usuarios registrados</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Nombre</th>
                    <th class="<?= $th ?>">Correo</th>
                    <th class="<?= $th ?>">Registro</th>
                    <th class="<?= $th ?>">Rol</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($usuarios as $u): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($u['nombre']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= e($u['email']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($u['creado'])) ?></td>
                        <td class="<?= $td ?>">
                            <?php if ($u['id'] === $_SESSION['usuario']['id']): ?>
                                <span class="text-xs font-bold"><?= e($u['rol']) ?></span> <span class="text-xs text-zinc-400">(usted)</span>
                            <?php else: ?>
                                <form action="index.php?page=usuarios" method="POST" class="flex items-center gap-3">
                                    <input type="hidden" name="accion" value="cambiar_rol">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <select name="rol_id" class="px-3 py-2 border border-zinc-200 rounded-lg text-xs bg-white focus:outline-none focus:border-zinc-900">
                                        <?php foreach ($roles as $r): ?><option value="<?= $r['id'] ?>" <?= $r['id'] == $u['rol_id'] ? 'selected' : '' ?>><?= e($r['nombre']) ?></option><?php endforeach; ?>
                                    </select>
                                    <button class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Guardar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>