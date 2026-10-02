<div class="fixed inset-0 flex items-center justify-center p-4 bg-[#f8f9fa] overflow-y-auto">
    <div class="w-full max-w-sm bg-white p-8 rounded-2xl border border-zinc-200/50 shadow-xl shadow-zinc-100/40 relative z-10">
        <div class="text-center mb-8">
            <div class="w-10 h-10 mx-auto mb-4 rounded-xl bg-zinc-950 text-white flex items-center justify-center font-extrabold">F</div>
            <h1 class="text-xl font-extrabold tracking-tight">Apertura de cuenta</h1>
            <p class="text-xs text-zinc-400 mt-1">Cree su perfil de inversor</p>
        </div>

        <?php if ($error): ?><div class="<?= $aviso ?>"><?= e($error) ?></div><?php endif; ?>

        <form action="index.php?page=registro" method="POST" class="space-y-5">
            <input type="hidden" name="accion" value="registro">
            <div>
                <label class="<?= $label ?>">Nombre completo</label>
                <input type="text" name="nombre" value="<?= e($_POST['nombre'] ?? '') ?>" required class="<?= $input ?>">
            </div>
            <div>
                <label class="<?= $label ?>">Dirección de correo</label>
                <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" placeholder="nombre@empresa.com" required class="<?= $input ?>">
            </div>
            <div>
                <label class="<?= $label ?>">Clave de acceso</label>
                <input type="password" name="clave" placeholder="Mínimo 6 caracteres" required class="<?= $input ?>">
            </div>
            <button type="submit" class="<?= $btn ?>">Crear cuenta</button>
        </form>

        <p class="text-center text-xs text-zinc-400 mt-8">
            ¿Ya tiene cuenta? <a href="index.php?page=login" class="text-zinc-900 font-bold hover:underline">Iniciar sesión</a>
        </p>
    </div>
</div>