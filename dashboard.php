<?php
require_once __DIR__ . '/includes/media_lib.php';

$user = require_user();
$uid  = (int)$user['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check()) {
        flash_set('err', 'Güvenlik doğrulaması başarısız. Tekrar deneyin.');
        redirect('dashboard.php');
    }
    $action = $_POST['action'] ?? '';

    /* ---- Yeni post ---- */
    if ($action === 'create_post') {
        $title   = trim((string)($_POST['title'] ?? ''));
        $content = trim((string)($_POST['content'] ?? ''));
        $err = null;

        if (str_len($title) < 2 || str_len($title) > 120) {
            $err = 'Başlık 2-120 karakter arasında olmalı.';
        } elseif (str_len($content) < 1 || str_len($content) > 5000) {
            $err = 'Açıklama metni 1-5000 karakter arasında olmalı.';
        }

        $image = null;
        if ($err === null) {
            $image = handle_image_upload($_FILES['image'] ?? ['error' => UPLOAD_ERR_NO_FILE], $upErr);
            if ($upErr) {
                $err = $upErr;
            }
        }

        if ($err !== null) {
            flash_set('err', $err);
        } else {
            json_update(POSTS_FILE, function (&$posts) use ($uid, $title, $content, $image) {
                $posts[] = [
                    'id'         => next_id($posts),
                    'user_id'    => $uid,
                    'title'      => $title,
                    'content'    => $content,
                    'image_url'  => $image ?: '',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            });
            flash_set('ok', 'Post yayınlandı.');
        }
        redirect('dashboard.php');
    }

    /* ---- Post sil (yalnızca kendi postu) ---- */
    if ($action === 'delete_post') {
        $pid = (int)($_POST['id'] ?? 0);
        $deleted = json_update(POSTS_FILE, function (&$posts) use ($pid, $uid) {
            $found = false;
            $posts = array_values(array_filter($posts, function ($p) use ($pid, $uid, &$found) {
                if ((int)$p['id'] === $pid && (int)$p['user_id'] === $uid) {
                    delete_upload($p['image_url'] ?? '');
                    $found = true;
                    return false;
                }
                return true;
            }));
            return $found;
        });
        flash_set($deleted ? 'ok' : 'err', $deleted ? 'Post silindi.' : 'Post bulunamadı.');
        redirect('dashboard.php');
    }

    /* ---- Profil güncelle ---- */
    if ($action === 'update_profile') {
        $channel = trim((string)($_POST['channel_name'] ?? ''));
        $bio     = trim((string)($_POST['bio'] ?? ''));
        $err = null;

        if (str_len($channel) < 2 || str_len($channel) > 60) {
            $err = 'Kanal adı 2-60 karakter arasında olmalı.';
        } elseif (str_len($bio) > 280) {
            $err = 'Kısa açıklama en fazla 280 karakter olabilir.';
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
            $oldAvatar = json_update(USERS_FILE, function (&$users) use ($uid, $channel, $bio, $avatar) {
                $old = null;
                foreach ($users as &$u) {
                    if ((int)$u['id'] === $uid) {
                        $u['channel_name'] = $channel;
                        $u['bio'] = $bio;
                        if ($avatar) {
                            $old = $u['avatar_url'] ?? '';
                            $u['avatar_url'] = $avatar;
                        }
                    }
                }
                unset($u);
                return $old;
            });
            if ($avatar) {
                delete_upload($oldAvatar);
            }
            flash_set('ok', 'Profil güncellendi.');
        }
        redirect('dashboard.php');
    }

    /* ---- Şifre değiştir ---- */
    if ($action === 'change_password') {
        $cur = (string)($_POST['current'] ?? '');
        $new = (string)($_POST['new'] ?? '');
        if (!password_verify($cur, $user['password_hash'])) {
            flash_set('err', 'Mevcut şifre hatalı.');
        } elseif (strlen($new) < 8) {
            flash_set('err', 'Yeni şifre en az 8 karakter olmalı.');
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            json_update(USERS_FILE, function (&$users) use ($uid, $hash) {
                foreach ($users as &$u) {
                    if ((int)$u['id'] === $uid) {
                        $u['password_hash'] = $hash;
                    }
                }
                unset($u);
            });
            flash_set('ok', 'Şifre güncellendi.');
        }
        redirect('dashboard.php');
    }

    redirect('dashboard.php');
}

$posts = posts_of_user($uid);
$site_title = "Panel | " . $user['channel_name'];
$admin_area = true;
require __DIR__ . '/includes/header.php';
?>

<section class="pagehead" style="padding-bottom:1.4rem;text-align:left;">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow eyebrow--plain">Kanal Paneli</p>
    <div style="display:flex;align-items:center;gap:1.3rem;flex-wrap:wrap;">
        <?php echo avatar_medallion($user, 'medallion--lg'); ?>
        <div>
            <h1 style="font-size:clamp(1.9rem,4vw,2.7rem);margin-bottom:.2rem;"><?php echo e($user['channel_name']); ?></h1>
            <p class="muted small" style="margin:0;"><?php echo count($posts); ?> yazı &middot; nûr arşivinde</p>
        </div>
    </div>
    <div style="display:flex;gap:1.4rem;flex-wrap:wrap;margin-top:1.6rem;align-items:center;">
        <a href="medya-detay.php?id=<?php echo $uid; ?>" class="link-more">Kanalımı Gör <?php echo nur_arrow_svg(); ?></a>
        <form method="post" action="logout.php" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button class="btn btn--quiet">Çıkış Yap</button>
        </form>
    </div>
</section>

<section class="section section--tight">
    <?php flash_render(); ?>

    <!-- Yeni post -->
    <div class="form-card" style="max-width:none;margin-bottom:clamp(2rem,4vw,3rem);">
        <h2 style="font-size:1.35rem;margin-bottom:1.2rem;">Yeni Yazı Paylaş</h2>
        <form method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="create_post">
            <input class="field" name="title" placeholder="Başlık" required maxlength="120">
            <textarea class="field" name="content" rows="6" placeholder="Açıklama metni" required maxlength="5000"></textarea>
            <label class="field-label">Görsel (isteğe bağlı, JPG/PNG/GIF/WEBP, en fazla 3 MB)
                <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="field-file">
            </label>
            <button class="btn btn--solid" style="margin-top:.9rem;">Paylaş <?php echo nur_arrow_svg(); ?></button>
        </form>
    </div>

    <!-- Postlarım -->
    <div class="section-head">
        <div class="section-head__text">
            <p class="eyebrow">Arşiv</p>
            <h2 style="font-size:1.6rem;">Yazılarım <span class="count">(<?php echo count($posts); ?>)</span></h2>
        </div>
    </div>

    <?php if (!$posts): ?>
        <p class="muted">Henüz yazı paylaşmadınız.</p>
    <?php else: ?>
        <div class="admin-rows">
        <?php foreach ($posts as $p): ?>
            <div class="admin-row">
                <?php if (!empty($p['image_url'])): ?>
                    <img src="<?php echo e($p['image_url']); ?>" alt="" class="admin-row__thumb">
                <?php else: ?>
                    <span class="medallion medallion--sm" style="--size:3rem;"><?php echo nur_star_svg('', 16); ?></span>
                <?php endif; ?>
                <div class="admin-row__main">
                    <p class="admin-row__title"><?php echo e($p['title']); ?></p>
                    <p class="admin-row__meta"><?php echo e(fmt_date($p['created_at'])); ?></p>
                </div>
                <form method="post" style="margin:0;" onsubmit="return confirm('Bu post silinsin mi?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="action" value="delete_post">
                    <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
                    <button class="admin-row__delete">Sil</button>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="nur-divider" style="margin:clamp(2.2rem,4vw,3rem) 0;"></div>

    <div class="grid grid--2" style="align-items:start;">
        <!-- Profil -->
        <div class="form-card" style="margin:0;max-width:none;">
            <h2 style="font-size:1.35rem;margin-bottom:1.2rem;">Profili Düzenle</h2>
            <form method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="update_profile">
                <input class="field" name="channel_name" value="<?php echo e($user['channel_name']); ?>" required maxlength="60">
                <textarea class="field" name="bio" rows="3" maxlength="280" placeholder="Kısa açıklama"><?php echo e($user['bio']); ?></textarea>
                <label class="field-label">Yeni avatar (isteğe bağlı)
                    <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="field-file">
                </label>
                <button class="btn btn--solid" style="width:100%;margin-top:.9rem;">Kaydet</button>
            </form>
        </div>

        <!-- Şifre -->
        <div class="form-card" style="margin:0;max-width:none;">
            <h2 style="font-size:1.35rem;margin-bottom:1.2rem;">Şifre Değiştir</h2>
            <form method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="change_password">
                <input class="field" type="password" name="current" placeholder="Mevcut şifre" required autocomplete="current-password">
                <input class="field" type="password" name="new" placeholder="Yeni şifre (en az 8 karakter)" required autocomplete="new-password">
                <button class="btn btn--ghost" style="width:100%;margin-top:.5rem;">Güncelle</button>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
