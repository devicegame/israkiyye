<?php
require_once __DIR__ . '/ornaments.php';

if (!isset($site_title)) {
    $site_title = "İşrâkiyye | Nûr ve Hikmet Felsefesi";
}
if (!isset($site_desc)) {
    $site_desc = "Şihâbüddîn Sühreverdî ve İşrâkî hikmet okulu üzerine kurulmuş dijital bir nûr arşivi: kavramlar, eserler, sembolik risaleler ve medya.";
}
$current_page = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$page_class = 'page-' . preg_replace('/\.php$/', '', $current_page);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($site_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="theme-color" content="#05070c">
    <meta name="color-scheme" content="dark">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="İşrâkiyye">
    <meta property="og:title" content="<?php echo htmlspecialchars($site_title, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($site_desc, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="assets/img/hero-nur.jpg">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
    <link rel="apple-touch-icon" href="assets/img/hero-nur.jpg">

    <link rel="preload" href="assets/fonts/cormorant-garamond-latin-ext-300-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/lora-latin-ext-400-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="assets/fonts/manrope-latin-ext-500-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="<?php echo htmlspecialchars($page_class, ENT_QUOTES, 'UTF-8'); ?>">
<div class="cosmos" aria-hidden="true">
    <canvas id="starfield" class="cosmos__stars"></canvas>
    <div class="cosmos__nebula cosmos__nebula--a"></div>
    <div class="cosmos__nebula cosmos__nebula--b"></div>
    <div class="cosmos__nebula cosmos__nebula--c"></div>
    <div class="cosmos__grain"></div>
</div>

<div class="motes" id="motes" aria-hidden="true"></div>
<div class="scroll-progress" aria-hidden="true"></div>
<a class="skip-link" href="#main">İçeriğe geç</a>

<?php require __DIR__ . "/navbar.php"; ?>

<main id="main" class="shell">
