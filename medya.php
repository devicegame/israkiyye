<?php
$site_title = "Medya | İşrâkiyye";
$site_desc  = "İşrâkî hikmet çevresinde içerik üreten medya hesapları ve kanalları.";
require_once __DIR__ . '/includes/media_lib.php';
require __DIR__ . '/includes/header.php';

$users = get_users();
$counts = [];
foreach (get_posts() as $p) {
    $counts[(int)$p['user_id']] = ($counts[(int)$p['user_id']] ?? 0) + 1;
}
?>

<section class="pagehead" style="padding-top:1rem;">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow">Kanallar</p>
    <h1>Medya</h1>
    <p class="lede">İşrâkî hikmet çevresinde içerik üreten medya hesapları ve kanalları.</p>
</section>

<section class="section section--tight">
    <?php if (!$users): ?>
        <div class="form-card center" style="max-width:32rem;">
            <span class="medallion medallion--lg" style="margin-bottom:1.2rem;"><?php echo nur_star_svg('', 26); ?></span>
            <h2 style="font-size:1.6rem;">Henüz yayında bir kanal yok</h2>
            <p class="muted small">Kanallar site yöneticisi tarafından tanımlanır; yazılar kanal sahiplerince paylaşılır.</p>
        </div>
    <?php else: ?>
        <div class="grid grid--3">
            <?php $n = 0; foreach ($users as $u): ?>
                <a class="card card--link channel" href="medya-detay.php?id=<?php echo (int)$u['id']; ?>"
                   data-reveal style="--delay:<?php echo ($n % 3) * 0.07; ?>s">
                    <span class="card__corner card__corner--tl" aria-hidden="true"></span>
                    <span class="card__corner card__corner--br" aria-hidden="true"></span>
                    <div style="margin-bottom:1.4rem;"><?php echo avatar_medallion($u, ''); ?></div>
                    <h2 class="card__title"><?php echo e($u['channel_name']); ?></h2>
                    <?php if (!empty($u['bio'])): ?>
                        <p class="card__text"><?php echo e($u['bio']); ?></p>
                    <?php endif; ?>
                    <span class="card__foot" style="justify-content:center;">
                        <span class="channel-stats"><?php echo (int)($counts[(int)$u['id']] ?? 0); ?> yazı</span>
                        <span class="card__link">Kanala Git <?php echo nur_arrow_svg(); ?></span>
                    </span>
                </a>
            <?php $n++; endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
