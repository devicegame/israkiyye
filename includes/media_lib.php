<?php
/**
 * Medya / Kanallar modülü - ortak kütüphane
 * Veritabanı yok: tüm veri data/*.json dosyalarında tutulur.
 */

define('MEDIA_ROOT', dirname(__DIR__));
define('DATA_DIR', MEDIA_ROOT . '/data');
define('UPLOAD_DIR', MEDIA_ROOT . '/uploads');
define('UPLOAD_URL', 'uploads');
define('USERS_FILE', DATA_DIR . '/users.json');
define('POSTS_FILE', DATA_DIR . '/posts.json');
define('ADMIN_FILE', DATA_DIR . '/admin.json');
define('LOCK_FILE', DATA_DIR . '/.lock');
define('MAX_UPLOAD_BYTES', 3 * 1024 * 1024); // 3 MB
define('ALLOWED_IMAGE_TYPES', serialize([
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif',
    'image/webp' => 'webp',
]));

/* ---------- Session ---------- */
if (session_status() === PHP_SESSION_NONE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);
    session_name('NURSESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/* ---------- Genel yardımcılar ---------- */
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function str_len(string $s): int
{
    return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen($s);
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function flash_set(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function flash_render(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $cls = $f['type'] === 'ok' ? 'flash--ok' : 'flash--err';
    echo '<div class="flash ' . $cls . '" role="status">' . e($f['msg']) . '</div>';
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): bool
{
    $sent = $_POST['csrf'] ?? '';
    return is_string($sent) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $sent);
}

/* ---------- JSON okuma / yazma ---------- */
function json_read(string $file): array
{
    if (!is_file($file)) {
        return [];
    }
    $raw = file_get_contents($file);
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw); // BOM temizle
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function json_write(string $file, array $data): bool
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    $tmp = $file . '.' . bin2hex(random_bytes(4)) . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }
    if (!@rename($tmp, $file)) {           // bazı sunucularda rename başarısız olabilir
        $ok = file_put_contents($file, $json, LOCK_EX) !== false;
        @unlink($tmp);
        return $ok;
    }
    return true;
}

/**
 * Oku-değiştir-yaz işlemini kilit altında yapar (eşzamanlı yazma çakışmasını önler).
 * $fn(array &$data) şeklinde çağrılır; dönüş değeri aynen döndürülür.
 */
function json_update(string $file, callable $fn)
{
    $lock = fopen(LOCK_FILE, 'c');
    if ($lock === false) {
        throw new RuntimeException('Kilit dosyası açılamadı. data/ klasörü yazılabilir olmalı.');
    }
    flock($lock, LOCK_EX);
    try {
        $data = json_read($file);
        $ret  = $fn($data);
        if (!json_write($file, $data)) {
            throw new RuntimeException('JSON dosyasına yazılamadı: ' . basename($file));
        }
        return $ret;
    } finally {
        flock($lock, LOCK_UN);
        fclose($lock);
    }
}

function next_id(array $rows): int
{
    $max = 0;
    foreach ($rows as $r) {
        if (isset($r['id']) && (int)$r['id'] > $max) {
            $max = (int)$r['id'];
        }
    }
    return $max + 1;
}

/* ---------- Kullanıcı / post sorguları ---------- */
function get_users(): array { return json_read(USERS_FILE); }
function get_posts(): array { return json_read(POSTS_FILE); }

function find_user_by_id(int $id): ?array
{
    foreach (get_users() as $u) {
        if ((int)$u['id'] === $id) {
            return $u;
        }
    }
    return null;
}

function find_user_by_username(string $username): ?array
{
    foreach (get_users() as $u) {
        if (strcasecmp($u['username'], $username) === 0) {
            return $u;
        }
    }
    return null;
}

function posts_of_user(int $userId): array
{
    $list = array_values(array_filter(get_posts(), fn($p) => (int)$p['user_id'] === $userId));
    usort($list, fn($a, $b) => strcmp($b['created_at'], $a['created_at']) ?: ((int)$b['id'] <=> (int)$a['id']));
    return $list;
}

function fmt_date(string $dt): string
{
    $ts = strtotime($dt);
    return $ts ? date('d.m.Y H:i', $ts) : $dt;
}

/* ---------- Yetkilendirme ---------- */
function is_admin(): bool
{
    return !empty($_SESSION['is_admin']);
}

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    $u = find_user_by_id((int)$_SESSION['user_id']);
    if ($u === null) {                       // hesap admin tarafından silinmiş olabilir
        unset($_SESSION['user_id']);
    }
    return $u;
}

function require_user(): array
{
    $u = current_user();
    if ($u === null) {
        redirect('login.php');
    }
    return $u;
}

/** Basit giriş denemesi sınırlaması (oturum bazlı): 5 hatalı denemede 5 dk kilit. */
function login_locked(): int
{
    $until = (int)($_SESSION['lock_until'] ?? 0);
    return $until > time() ? $until - time() : 0;
}

function login_fail(): void
{
    usleep(400000);
    $_SESSION['fails'] = (int)($_SESSION['fails'] ?? 0) + 1;
    if ($_SESSION['fails'] >= 5) {
        $_SESSION['lock_until'] = time() + 300;
        $_SESSION['fails'] = 0;
    }
}

function login_ok(): void
{
    unset($_SESSION['fails'], $_SESSION['lock_until']);
    session_regenerate_id(true);
}

/* ---------- Görsel yükleme ---------- */
/**
 * Yüklenen görseli doğrular ve /uploads/ içine rastgele isimle kaydeder.
 * Dosya seçilmediyse null döner ve $error null kalır.
 * Hata varsa null döner ve $error dolar.
 */
function handle_image_upload(array $file, ?string &$error = null): ?string
{
    $error = null;
    $allowed = unserialize(ALLOWED_IMAGE_TYPES);

    if (!isset($file['error']) || is_array($file['error'])) {
        $error = 'Geçersiz dosya yüklemesi.';
        return null;
    }
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        $error = 'Dosya çok büyük (en fazla 3 MB).';
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Dosya yüklenirken bir hata oluştu.';
        return null;
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        $error = 'Dosya çok büyük (en fazla 3 MB).';
        return null;
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        $error = 'Geçersiz dosya kaynağı.';
        return null;
    }

    // 1) Uzantı kontrolü
    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
        $error = 'Yalnızca JPG, PNG, GIF veya WEBP dosyaları yüklenebilir.';
        return null;
    }

    // 2) Gerçek MIME kontrolü
    $mime = null;
    if (class_exists('finfo')) {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    }
    $info = @getimagesize($file['tmp_name']);   // 3) Gerçekten görsel mi?
    if ($info === false) {
        $error = 'Dosya geçerli bir görsel değil.';
        return null;
    }
    if ($mime === null || $mime === false) {
        $mime = $info['mime'] ?? '';
    }
    if (!isset($allowed[$mime]) || ($info['mime'] ?? '') !== $mime) {
        $error = 'Desteklenmeyen veya uyumsuz görsel türü.';
        return null;
    }
    if ($info[0] * $info[1] > 40000000) {       // çözünürlük bombası koruması
        $error = 'Görsel boyutları çok büyük.';
        return null;
    }

    if (!is_dir(UPLOAD_DIR) && !@mkdir(UPLOAD_DIR, 0755, true)) {
        $error = 'uploads/ klasörü oluşturulamadı.';
        return null;
    }

    // 4) Rastgele isim, uzantıyı MIME'dan türet (kullanıcının uzantısına güvenme)
    $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . '/' . $name)) {
        $error = 'Dosya kaydedilemedi. uploads/ klasörü yazılabilir olmalı.';
        return null;
    }
    @chmod(UPLOAD_DIR . '/' . $name, 0644);
    return UPLOAD_URL . '/' . $name;
}

function delete_upload(?string $rel): void
{
    if (!$rel) {
        return;
    }
    $base = basename($rel);
    if (strpos($rel, UPLOAD_URL . '/') === 0 && preg_match('/^[a-f0-9]{32}\.(jpg|png|gif|webp)$/', $base)) {
        @unlink(UPLOAD_DIR . '/' . $base);
    }
}

/* ---------- Avatar bileşeni ---------- */
/**
 * Ön yüz için yuvarlak nûr madalyonu (tasarım sistemi sınıflarıyla).
 */
function avatar_medallion(array $user, string $modifier = ''): string
{
    $class = 'medallion' . ($modifier !== '' ? ' ' . $modifier : '');
    if (!empty($user['avatar_url'])) {
        return '<span class="' . e($class) . '"><img src="' . e($user['avatar_url']) . '" alt="'
            . e($user['channel_name']) . '" loading="lazy"></span>';
    }
    $name = (string)($user['channel_name'] ?? '?');
    $initial = function_exists('mb_substr') ? mb_substr($name, 0, 1, 'UTF-8') : substr($name, 0, 1);
    return '<span class="' . e($class) . '" aria-hidden="true">'
        . e(function_exists('mb_strtoupper') ? mb_strtoupper($initial, 'UTF-8') : strtoupper($initial))
        . '</span>';
}

function avatar_html(array $user, string $size = 'w-14 h-14', string $text = 'text-xl'): string
{
    if (!empty($user['avatar_url'])) {
        return '<img src="' . e($user['avatar_url']) . '" alt="' . e($user['channel_name']) . '" class="' . $size . ' rounded-full object-cover border nur-border">';
    }
    $initial = function_exists('mb_substr') ? mb_substr($user['channel_name'], 0, 1, 'UTF-8') : substr($user['channel_name'], 0, 1);
    return '<div class="' . $size . ' ' . $text . ' rounded-full flex items-center justify-center border nur-border bg-white/5 text-nur-gold font-display">' . e(strtoupper($initial)) . '</div>';
}
