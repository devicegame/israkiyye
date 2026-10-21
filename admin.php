<?php
require_once __DIR__ . '/includes/media_lib.php';

$setupMode = !is_file(ADMIN_FILE);

/* ---------------- POST işlemleri ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        flash_set('err', 'Güvenlik doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.');
        redirect('admin.php');
    }
    $action = $_POST['action'] ?? '';

    // İlk kurulum: admin hesabı oluştur
    if ($action === 'setup' && $setupMode) {
        $u = trim((string)($_POST['username'] ?? ''));
        $p = (string)($_POST['password'] ?? '');
        if (!preg_match('/^[A-Za-z0-9_.-]{3,30}$/', $u)) {
            flash_set('err', 'Kullanıcı adı 3-30 karakter olmalı (harf, rakam, _ . -).');
        } elseif (strlen($p) < 10) {
            flash_set('err', 'Admin şifresi en az 10 karakter olmalı.');
        } else {
            json_write(ADMIN_FILE, ['username' => $u, 'password_hash' => password_hash($p, PASSWORD_DEFAULT)]);
            session_regenerate_id(true);
            $_SESSION['is_admin'] = true;
            flash_set('ok', 'Admin hesabı oluşturuldu.');
        }
        redirect('admin.php');
    }

    // Admin girişi
    if ($action === 'login' && !$setupMode) {
        if ($wait = login_locked()) {
            flash_set('err', "Çok fazla hatalı deneme. $wait saniye sonra tekrar deneyin.");
            redirect('admin.php');
        }
        $admin = json_read(ADMIN_FILE);
        $u = (string)($_POST['username'] ?? '');
        $p = (string)($_POST['password'] ?? '');
        if (!empty($admin['password_hash'])
            && hash_equals((string)$admin['username'], $u)
            && password_verify($p, $admin['password_hash'])) {
            login_ok();
            $_SESSION['is_admin'] = true;
            redirect('admin.php');
        }
        login_fail();
        flash_set('err', 'Kullanıcı adı veya şifre hatalı.');
        redirect('admin.php');
    }

    // Aşağıdaki işlemler yalnızca admin içindir
    if (!is_admin()) {
        redirect('admin.php');
    }

    if ($action === 'logout') {
        unset($_SESSION['is_admin']);
        session_regenerate_id(true);
        redirect('admin.php');
    }

    if ($action === 'create_user') {
        $username = trim((string)($_POST['username'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $channel  = trim((string)($_POST['channel_name'] ?? ''));
        $bio      = trim((string)($_POST['bio'] ?? ''));
        $err = null;

        if (!preg_match('/^[A-Za-z0-9_.-]{3,30}$/', $username)) {
            $err = 'Kullanıcı adı 3-30 karakter olmalı (harf, rakam, _ . -).';
        } elseif (strlen($password) < 8) {
            $err = 'Şifre en az 8 karakter olmalı.';
        } elseif (str_len($channel) < 2 || str_len($channel) > 60) {
            $err = 'Kanal adı 2-60 karakter arasında olmalı.';
        } elseif (str_len($bio) > 280) {
            $err = 'Kısa açıklama en fazla 280 karakter olabilir.';
        } elseif (find_user_by_username($username)) {
            $err = 'Bu kullanıcı adı zaten kullanılıyor.';
        }

        $avatar = null;
        if ($err === null) {
            $avatar = handle_image_upload($_FILES['avatar'] ?? ['error' => UPLOAD_ERR_NO_FILE], $upErr);
            if ($upErr) {
                $err = 'Avatar: ' . $upErr;
            }
        }

        if ($err !== null) {
            flash_set('err', $err);
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            json_update(USERS_FILE, function (&$users) use ($username, $hash, $channel, $bio, $avatar) {
                $users[] = [
                    'id'            => next_id($users),
                    'username'      => $username,
                    'password_hash' => $hash,
                    'channel_name'  => $channel,
                    'bio'           => $bio,
                    'avatar_url'    => $avatar ?: '',
                ];
            });
            flash_set('ok', "Medya hesabı oluşturuldu: $username");
        }
        redirect('admin.php');
    }

    if ($action === 'delete_user') {
        $id = (int)($_POST['id'] ?? 0);
        $user = find_user_by_id($id);
        if ($user) {
            // Hesabın postlarını ve görsellerini de sil
            json_update(POSTS_FILE, function (&$posts) use ($id) {
                $posts = array_values(array_filter($posts, function ($p) use ($id) {
                    if ((int)$p['user_id'] === $id) {
                        delete_upload($p['image_url'] ?? '');
                        return false;
                    }
                    return true;
                }));
            });
            json_update(USERS_FILE, function (&$users) use ($id) {
                $users = array_values(array_filter($users, fn($u) => (int)$u['id'] !== $id));
            });
            delete_upload($user['avatar_url'] ?? '');
            flash_set('ok', 'Hesap ve tüm postları silindi.');
        } else {
            flash_set('err', 'Hesap bulunamadı.');
        }
        redirect('admin.php');
    }

    if ($action === 'change_admin_password') {
        $admin = json_read(ADMIN_FILE);
        $cur = (string)($_POST['current'] ?? '');
        $new = (string)($_POST['new'] ?? '');
        if (!password_verify($cur, $admin['password_hash'] ?? '')) {
            flash_set('err', 'Mevcut şifre hatalı.');
        } elseif (strlen($new) < 10) {
            flash_set('err', 'Yeni şifre en az 10 karakter olmalı.');
        } else {
            $admin['password_hash'] = password_hash($new, PASSWORD_DEFAULT);
            json_write(ADMIN_FILE, $admin);
            flash_set('ok', 'Admin şifresi güncellendi.');
        }
        redirect('admin.php');
    }

    redirect('admin.php');
}

/* ---------------- Görünüm ---------------- */
$site_title = "Admin Paneli | İşrâkiyye";
$admin_area = true;
require __DIR__ . '/includes/header.php';
?>

<section class="pagehead" style="padding-bottom:1.6rem;text-align:left;">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow eyebrow--plain">Yönetim</p>
    <h1 style="font-size:clamp(2rem,4vw,2.9rem);">Admin Paneli</h1>
    <p class="muted">Medya hesaplarını yönetin, kanalları denetleyin.</p>
</section>

<section class="section section--tight">
<?php flash_render(); ?>

<?php if ($setupMode): ?>
    <div class="form-card">
        <div class="center" style="margin-bottom:1.6rem;">
            <span class="medallion" style="margin-bottom:1rem;"><?php echo nur_star_svg('', 22); ?></span>
            <h2 style="font-size:1.5rem;margin-bottom:.3rem;">İlk Kurulum</h2>
            <p class="muted small">Henüz admin hesabı yok. Dosyaları yükler yüklemez hesabı siz oluşturun.</p>
        </div>
        <form method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="setup">
            <input class="field" name="username" placeholder="Admin kullanıcı adı" required autocomplete="username">
            <input class="field" type="password" name="password" placeholder="Şifre (en az 10 karakter)" required autocomplete="new-password">
            <button class="btn btn--solid" style="width:100%;margin-top:.5rem;">Admin Oluştur</button>
        </form>
    </div>

<?php elseif (!is_admin()): ?>
    <div class="form-card">
        <div class="center" style="margin-bottom:1.6rem;">
            <span class="medallion" style="margin-bottom:1rem;"><?php echo nur_star_svg('', 22); ?></span>
            <h2 style="font-size:1.5rem;margin-bottom:.3rem;">Yönetici Girişi</h2>
            <p class="muted small">Arşivin bekçisine mahsus kapı</p>
        </div>
        <form method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="login">
            <input class="field" name="username" placeholder="Kullanıcı adı" required autocomplete="username">
            <input class="field" type="password" name="password" placeholder="Şifre" required autocomplete="current-password">
            <button class="btn btn--solid" style="width:100%;margin-top:.5rem;">Giriş Yap</button>
        </form>
    </div>

<?php else:
    $users = get_users();
    $counts = [];
    foreach (get_posts() as $p) {
        $counts[(int)$p['user_id']] = ($counts[(int)$p['user_id']] ?? 0) + 1;
    }
?>
    <div class="admin-bar">
        <p class="admin-bar__who"><?php echo nur_star_svg('', 16); ?><span>Yönetici oturumu açık</span></p>
        <form method="post" style="margin:0;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="logout">
            <button class="btn btn--quiet">Çıkış Yap <?php echo nur_arrow_svg(); ?></button>
        </form>
    </div>

    <div class="grid grid--2" style="align-items:start;">
        <div class="form-card" style="margin:0;max-width:none;">
            <h2 style="font-size:1.35rem;margin-bottom:1.2rem;">Yeni Medya Hesabı</h2>
            <form method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="create_user">
                <input class="field" name="username" placeholder="Kullanıcı adı (giriş için)" required maxlength="30" autocomplete="off">
                <input class="field" type="password" name="password" placeholder="Şifre (en az 8 karakter)" required autocomplete="new-password">
                <input class="field" name="channel_name" placeholder="Kanal adı" required maxlength="60">
                <textarea class="field" name="bio" rows="3" maxlength="280" placeholder="Kısa açıklama (en fazla 280 karakter)"></textarea>
                <label class="field-label">Avatar (isteğe bağlı, JPG/PNG/GIF/WEBP, en fazla 3 MB)
                    <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="field-file">
                </label>
                <button class="btn btn--solid" style="width:100%;margin-top:.9rem;">Hesabı Oluştur</button>
            </form>
        </div>

        <div class="form-card" style="margin:0;max-width:none;">
            <h2 style="font-size:1.35rem;margin-bottom:1.2rem;">Admin Şifresini Değiştir</h2>
            <form method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="change_admin_password">
                <input class="field" type="password" name="current" placeholder="Mevcut şifre" required autocomplete="current-password">
                <input class="field" type="password" name="new" placeholder="Yeni şifre (en az 10 karakter)" required autocomplete="new-password">
                <button class="btn btn--ghost" style="width:100%;margin-top:.5rem;">Güncelle</button>
            </form>
            <div class="nur-divider" style="margin:1.6rem 0;"></div>
            <p class="muted small" style="font-size:.78rem;">
                Kanallar yalnızca sizin tanımladığınız hesaplarla açılır; her kanal kendi panelinden yazı paylaşır.
            </p>
        </div>
    </div>

    <div class="section-head" style="margin-top:clamp(2.4rem,5vw,3.6rem);">
        <div class="section-head__text">
            <p class="eyebrow">Kanallar</p>
            <h2 style="font-size:1.6rem;">Medya Hesapları <span class="count">(<?php echo count($users); ?>)</span></h2>
        </div>
    </div>

    <?php if (!$users): ?>
        <p class="muted">Henüz hesap yok.</p>
    <?php else: ?>
        <div class="admin-rows">
        <?php foreach ($users as $u): ?>
            <div class="admin-row">
                <?php echo avatar_medallion($u, 'medallion--sm'); ?>
                <div class="admin-row__main">
                    <p class="admin-row__title"><?php echo e($u['channel_name']); ?></p>
                    <p class="admin-row__meta">@<?php echo e($u['username']); ?> &middot; <?php echo (int)($counts[(int)$u['id']] ?? 0); ?> yazı</p>
                </div>
                <a href="medya-detay.php?id=<?php echo (int)$u['id']; ?>" class="admin-row__link">Görüntüle</a>
                <form method="post" style="margin:0;" onsubmit="return confirm('Bu hesap ve tüm postları kalıcı olarak silinecek. Emin misiniz?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                    <button class="admin-row__delete">Sil</button>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
