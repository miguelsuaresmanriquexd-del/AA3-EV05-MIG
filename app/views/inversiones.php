<?php
$uid = $_SESSION['usuario']['id'];
$planes = Inversion::planes();
$lista = Inversion::listar($uid);
$activas = array_values(array_filter($lista, fn($i) => $i['estado'] === 'Activa'));
?>
<div class="mb-8">
    <h1 class="text-2xl font-extrabold tracking-tight">Inversiones</h1>
    <p class="text-sm text-zinc-400 mt-1">Cree nuevas inversiones y administre las existentes.</p>
</div>

<?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Inversión registrada correctamente.</div><?php endif; ?>

<form data-sim action="index.php?page=inversiones" method="POST" class="bg-white border border-zinc-200 rounded-2xl p-6 mb-8 grid md:grid-cols-4 gap-4 items-end">
    <input type="hidden" name="accion" value="invertir">
    <div class="md:col-span-2">
        <label class="<?= $label ?>">Plan</label>
        <select name="plan_id" class="<?= $input ?>">
            <?php foreach ($planes as $p): ?>
                <option value="<?= $p['id'] ?>"><?= e($p['nombre']) ?> — <?= $p['rendimiento'] ?>% anual, <?= $p['plazo_meses'] ?> meses, mínimo <?= dinero($p['minimo']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="<?= $label ?>">Monto</label>
        <input type="number" name="monto" min="1" step="0.01" placeholder="0.00" required class="<?= $input ?>">
    </div>
    <button type="submit" class="<?= $btn ?>">Invertir</button>
    <p id="estimado" class="md:col-span-4 text-xs text-zinc-500 pt-4 border-t border-zinc-100">Ingrese un monto para ver la ganancia estimada.</p>
</form>

<div class="bg-white border border-zinc-200 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-bold">Historial de inversiones</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-50 text-xs uppercase tracking-wider text-zinc-500">
                <tr>
                    <th class="<?= $th ?>">Plan</th>
                    <th class="<?= $th ?>">Monto</th>
                    <th class="<?= $th ?>">Rendimiento</th>
                    <th class="<?= $th ?>">Plazo</th>
                    <th class="<?= $th ?>">Ganancia est.</th>
                    <th class="<?= $th ?>">Fecha</th>
                    <th class="<?= $th ?>">Estado</th>
                    <th class="<?= $th ?>"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                <?php foreach ($lista as $i): ?>
                    <tr class="hover:bg-zinc-50/60 transition-colors">
                        <td class="<?= $td ?> font-bold"><?= e($i['plan']) ?></td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero($i['monto']) ?></td>
                        <td class="<?= $td ?> tabular-nums text-zinc-500"><?= $i['rendimiento'] ?>% anual</td>
                        <td class="<?= $td ?> text-zinc-500"><?= $i['plazo_meses'] ?> meses</td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero($i['ganancia']) ?></td>
                        <td class="<?= $td ?> text-zinc-500"><?= date('d/m/Y', strtotime($i['creado'])) ?></td>
                        <td class="<?= $td ?>"><?= badge($i['estado']) ?></td>
                        <td class="<?= $td ?> text-right">
                            <?php if ($i['estado'] === 'Activa'): ?>
                                <form action="index.php?page=inversiones" method="POST" onsubmit="return confirm('¿Cancelar esta inversión?')">
                                    <input type="hidden" name="accion" value="cancelar">
                                    <input type="hidden" name="id" value="<?= $i['id'] ?>">
                                    <button class="text-xs font-bold text-zinc-400 hover:text-zinc-900 transition-colors">Cancelar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$lista): ?>
                    <tr><td colspan="8" class="px-6 py-12 text-center text-xs text-zinc-400">Aún no tiene inversiones. Elija un plan y un monto para comenzar.</td></tr>
                <?php endif; ?>
            </tbody>
            <?php if ($lista): ?>
                <tfoot class="bg-zinc-50 text-xs font-bold border-t border-zinc-200">
                    <tr>
                        <td class="<?= $td ?>">Total activas (<?= count($activas) ?>)</td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero(array_sum(array_column($activas, 'monto'))) ?></td>
                        <td colspan="2"></td>
                        <td class="<?= $td ?> tabular-nums"><?= dinero(array_sum(array_column($activas, 'ganancia'))) ?></td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="mt-8 grid sm:grid-cols-3 gap-5">
    <?php foreach ($planes as $p): ?>
        <div class="bg-white border border-zinc-200 rounded-2xl p-6">
            <p class="text-sm font-bold"><?= e($p['nombre']) ?></p>
            <p class="text-2xl font-extrabold mt-3 tabular-nums"><?= $p['rendimiento'] ?>%</p>
            <p class="text-xs text-zinc-400">rendimiento anual</p>
            <dl class="mt-5 pt-5 border-t border-zinc-100 text-xs space-y-2">
                <div class="flex justify-between"><dt class="text-zinc-400">Plazo</dt><dd class="font-bold"><?= $p['plazo_meses'] ?> meses</dd></div>
                <div class="flex justify-between"><dt class="text-zinc-400">Mínimo</dt><dd class="font-bold tabular-nums"><?= dinero($p['minimo']) ?></dd></div>
                <div class="flex justify-between"><dt class="text-zinc-400">Riesgo</dt><dd class="font-bold"><?= e($p['riesgo']) ?></dd></div>
            </dl>
        </div>
    <?php endforeach; ?>
</div>

<script>
const planes = <?= json_encode(array_column($planes, null, 'id')) ?>;
const f = document.querySelector('form[data-sim]');
const out = document.getElementById('estimado');
const fmt = n => '$' + n.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
f.addEventListener('input', () => {
    const p = planes[f.plan_id.value];
    const m = parseFloat(f.monto.value);
    if (!p || !m) {
        out.textContent = 'Ingrese un monto para ver la ganancia estimada.';
        return;
    }
    const g = m * p.rendimiento / 100 * p.plazo_meses / 12;
    out.textContent = 'Ganancia estimada: ' + fmt(g) + '. Total al vencimiento: ' + fmt(m + g) + '.';
});
</script>
