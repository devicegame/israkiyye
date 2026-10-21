<?php
$nav_items = [
    'index.php'        => 'Anasayfa',
    'kavramlar.php'    => 'Kavramlar',
    'suhreverdi.php'   => 'Sühreverdî',
    'eserler.php'      => 'Eserler',
    'karsilastirma.php'=> 'Karşılaştırma',
    'medya.php'        => 'Medya',
];
$active_key = (isset($current_page) && $current_page === 'medya-detay.php') ? 'medya.php' : ($current_page ?? 'index.php');
?>
<header class="site-header">
    <div class="shell">
        <div class="nav">
            <a class="brand" href="index.php" aria-label="İşrâkiyye — anasayfa">
                <span class="brand__mark"><?php echo nur_star_svg('', 20); ?></span>
                <span class="brand__words">
                    <span class="brand__word">İŞRÂKİYYE</span>
                    <span class="brand__sub">Nûr &amp; Hikmet</span>
                </span>
            </a>

            <nav class="nav__links" aria-label="Ana gezinme">
                <?php foreach ($nav_items as $href => $label): ?>
                    <a class="nav__link<?php echo $active_key === $href ? ' is-active' : ''; ?>"
                       href="<?php echo $href; ?>"
                       <?php echo $active_key === $href ? 'aria-current="page"' : ''; ?>><?php echo $label; ?></a>
                <?php endforeach; ?>
            </nav>

            <div class="nav__end">
                <a class="nav__cta" href="login.php">
                    <span>Kanal Girişi</span>
                </a>
                <button class="nav__toggle" type="button" id="menuBtn"
                        aria-label="Menüyü aç" aria-expanded="false" aria-controls="mobileMenu">
                    <span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="mobile-menu" id="mobileMenu">
    <div>
        <p class="mobile-menu__label">Fihrist</p>
        <nav class="mobile-menu__nav" aria-label="Mobil gezinme">
            <?php $n = 1; foreach ($nav_items as $href => $label): ?>
                <a class="mobile-menu__link<?php echo $active_key === $href ? ' is-active' : ''; ?>"
                   href="<?php echo $href; ?>" style="--i:<?php echo $n; ?>">
                    <span><?php echo $label; ?></span>
                    <span class="num"><?php echo str_pad((string)$n, 2, '0', STR_PAD_LEFT); ?></span>
                </a>
            <?php $n++; endforeach; ?>
        </nav>
    </div>
    <div class="mobile-menu__foot">
        <span class="arabic" style="font-size:1.1rem;opacity:.7;">الحكمة الإشراقية</span>
        <a href="login.php">Kanal Girişi &rarr;</a>
    </div>
</div>
