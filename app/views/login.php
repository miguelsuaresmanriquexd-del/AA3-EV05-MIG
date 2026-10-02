<div class="fixed inset-0 flex items-center justify-center p-4 bg-[#f8f9fa]">
    <div class="w-full max-w-sm bg-white p-8 rounded-2xl border border-zinc-200/50 shadow-xl shadow-zinc-100/40 relative z-10">
        <div class="text-center mb-8">
            <div class="w-10 h-10 mx-auto mb-4 rounded-xl bg-zinc-950 text-white flex items-center justify-center font-extrabold">F</div>
            <h1 class="text-xl font-extrabold tracking-tight">Futuro Inversión</h1>
            <p class="text-xs text-zinc-400 mt-1">Acceda a su portafolio</p>
        </div>

        <?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>
        <?php if (isset($_GET['ok'])): ?><div class="<?= $aviso ?>">Cuenta creada. Ya puede ingresar.</div><?php endif; ?>

        <form action="index.php?page=login" method="POST" class="space-y-5">
            <input type="hidden" name="accion" value="login">
            <div>
                <label class="<?= $label ?>">Dirección de correo</label>
                <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" placeholder="nombre@empresa.com" required class="<?= $input ?>">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-xs font-bold tracking-wider text-zinc-500 uppercase">Clave de acceso</label>
                    <a href="#" class="text-xs font-medium text-zinc-400 hover:text-zinc-900 transition-colors">¿Olvidó su clave?</a>
                </div>
                <input type="password" name="clave" placeholder="••••••••" required class="<?= $input ?>">
            </div>

            <div class="flex items-center py-1">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-zinc-900 border-zinc-300 rounded accent-zinc-900">
                <label for="remember" class="ml-2.5 text-xs text-zinc-400 font-medium select-none cursor-pointer">Mantener sesión cifrada</label>
            </div>

            <button type="submit" class="<?= $btn ?>">Autenticar Cuenta</button>
        </form>

        <p class="text-center text-xs text-zinc-400 mt-8">
            ¿Es un nuevo inversor? <a href="index.php?page=registro" class="text-zinc-900 font-bold hover:underline">Solicitar apertura</a>
        </p>
    </div>
</div>
