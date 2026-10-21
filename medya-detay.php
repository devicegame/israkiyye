<?php
require_once __DIR__ . '/includes/media_lib.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === null && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}
$channel = $id ? find_user_by_id($id) : null;

if (!$channel) {
    http_response_code(404);
    $site_title = "Kanal Bulunamadı | İşrâkiyye";
    require __DIR__ . '/includes/header.php';
    echo '<section class="pagehead"><div class="pagehead__glow" aria-hidden="true"></div>'
       . '<p class="eyebrow">404</p><h1>Kanal bulunamadı</h1>'
       . '<p class="lede">Aradığınız kanal taşınmış ya da hiç var olmamış olabilir.</p>'
       . '<p style="margin-top:1.6rem;"><a href="medya.php" class="btn btn--ghost">Tüm Kanallar</a></p></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$posts = posts_of_user((int)$channel['id']);   // en yeni üstte
$site_title = $channel['channel_name'] . " | Medya | İşrâkiyye";
$site_desc  = trim((string)($channel['bio'] ?? '')) ?: ($channel['channel_name'] . ' kanalındaki yazılar.');
require __DIR__ . '/includes/header.php';
?>

<section class="pagehead" style="padding-bottom:clamp(1.2rem,3vw,2rem);">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <div style="display:flex;justify-content:center;margin-bottom:1.6rem;">
        <?php echo avatar_medallion($channel, 'medallion--lg'); ?>
    </div>
    <p class="eyebrow">Kanal</p>
    <h1><?php echo e($channel['channel_name']); ?></h1>
    <?php if (!empty($channel['bio'])): ?>
        <p class="lede"><?php echo e($channel['bio']); ?></p>
    <?php endif; ?>
    <p class="channel-stats" style="margin-top:1.4rem;"><?php echo count($posts); ?> yazı &middot; Nûr arşivi</p>
</section>

<section class="section section--tight">
    <p style="margin-bottom:1.8rem;"><a href="medya.php" class="back-link">&larr; Tüm kanallar</a></p>

    <?php if (!$posts): ?>
        <div class="form-card center" style="max-width:32rem;">
            <h2 style="font-size:1.5rem;">Bu kanal henüz bir şey paylaşmadı</h2>
            <p class="muted small">İlk yazı yayınlandığında burada görünecek.</p>
        </div>
    <?php else: ?>
        <div class="stack" style="gap:clamp(1.6rem,3.5vw,2.6rem);">
            <?php foreach ($posts as $p): ?>
                <article class="post" data-reveal>
                    <?php if (!empty($p['image_url'])): ?>
                        <div class="post__media">
                            <img src="<?php echo e($p['image_url']); ?>" alt="<?php echo e($p['title']); ?>"
                                 loading="lazy" width="1200" height="800">
                        </div>
                    <?php endif; ?>
                    <div class="post__body">
                        <p class="post__date"><?php echo e(fmt_date($p['created_at'])); ?></p>
                        <h2 class="post__title"><?php echo e($p['title']); ?></h2>
                        <div class="post__content"><?php echo nl2br(e($p['content'])); ?></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
