<?php
require_once __DIR__ . '/includes/media_lib.php';

if (current_user()) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        flash_set('err', 'Güvenlik doğrulaması başarısız. Tekrar deneyin.');
        redirect('login.php');
    }
    if ($wait = login_locked()) {
        flash_set('err', "Çok fazla hatalı deneme. $wait saniye sonra tekrar deneyin.");
        redirect('login.php');
    }
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $user = find_user_by_username($username);

    if ($user && password_verify($password, $user['password_hash'])) {
        login_ok();
        $_SESSION['user_id'] = (int)$user['id'];
        redirect('dashboard.php');
    }
    login_fail();
    flash_set('err', 'Kullanıcı adı veya şifre hatalı.');
    redirect('login.php');
}

$site_title = "Medya Girişi | İşrâkiyye";
$site_desc  = "İşrâkiyye medya kanalı girişi.";
require __DIR__ . '/includes/header.php';
?>

<section class="pagehead" style="padding-bottom:1.4rem;">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow">Kanal</p>
    <h1 style="font-size:clamp(2rem,4.5vw,3rem);">Kanal Girişi</h1>
    <p class="lede" style="max-width:30rem;">Nûr arşivinde yazı paylaşmak için kanal hesabınızla giriş yapın.</p>
</section>

<section class="section section--tight">
    <?php flash_render(); ?>
    <div class="form-card">
        <div class="center" style="margin-bottom:1.8rem;">
            <span class="medallion" style="margin-bottom:1rem;"><?php echo nur_star_svg('', 22); ?></span>
            <h2 style="font-size:1.5rem;margin-bottom:.2rem;">Hoş geldiniz</h2>
            <p class="muted small">Hesabınızla devam edin</p>
        </div>
        <form method="post">
            <?php echo csrf_field(); ?>
            <input class="field" name="username" placeholder="Kullanıcı adı" required autocomplete="username">
            <input class="field" type="password" name="password" placeholder="Şifre" required autocomplete="current-password">
            <button class="btn btn--solid" style="width:100%;margin-top:.6rem;">Giriş Yap</button>
        </form>
        <p class="muted small center" style="margin-top:1.3rem;font-size:.78rem;">
            Hesaplar yalnızca site yöneticisi tarafından tanımlanır.
        </p>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
