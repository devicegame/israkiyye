<?php
$site_title = "Eserler ve Risaleler | İşrâkiyye";
$site_desc  = "Hikmetü'l-İşrâk, Hayâkilü'n-Nûr ve sembolik risaleler: Sühreverdî'nin külliyatı.";
require __DIR__ . "/includes/header.php";
require __DIR__ . "/data/content.php";

$roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'];
?>

<section class="pagehead">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow">Külliyat &middot; <?php echo count($eserler); ?> Eser</p>
    <h1>Eserler ve Sembolik Risaleler</h1>
    <p class="lede">
        <em>Hikmetü'l-İşrâk</em>'tan sembolik hikâyelere, Sühreverdî'nin hem akli hem de
        edebî-mistik üretimine topluca bir bakış.
    </p>
    <p class="pagehead__arabic arabic" aria-hidden="true">حكمة الإشراق</p>
</section>

<section class="section section--tight">
    <div class="works">
        <aside class="works__rail" aria-label="Eser fihristi">
            <p class="works__rail-title">Fihrist</p>
            <ol>
                <?php $i = 0; foreach ($eserler as $e): ?>
                    <li>
                        <a href="#<?php echo htmlspecialchars($e['slug'], ENT_QUOTES, 'UTF-8'); ?>">
                            <span class="num"><?php echo $roman[$i] ?? ''; ?></span>
                            <span><?php echo $e["baslik"]; ?></span>
                        </a>
                    </li>
                <?php $i++; endforeach; ?>
            </ol>
        </aside>

        <div class="works__list">
            <?php $i = 0; foreach ($eserler as $e): ?>
                <article class="work" id="<?php echo htmlspecialchars($e['slug'], ENT_QUOTES, 'UTF-8'); ?>" data-reveal>
                    <div class="work__head">
                        <span class="work__index" aria-hidden="true"><?php echo $roman[$i] ?? ''; ?></span>
                        <div>
                            <p class="card__kicker" style="margin-bottom:.45rem;"><?php echo $e["tur"]; ?></p>
                            <h2><?php echo $e["baslik"]; ?></h2>
                        </div>
                    </div>
                    <p class="work__lede"><?php echo $e["ozet"]; ?></p>
                    <p class="work__text"><?php echo $e["detay"]; ?></p>
                </article>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--ruled">
    <div class="cta" data-reveal>
        <span class="cta__arabic" aria-hidden="true">حكمة</span>
        <p class="eyebrow eyebrow--plain">Okuma</p>
        <h2>Metin, ancak riyazetle açılır</h2>
        <p>
            Sühreverdî'nin eserleri yalnızca okuyarak değil, nefsi arındırarak kavranacak
            "zevk kitapları" olarak tasarlanmıştır. Kavramları tanıyarak başlayın.
        </p>
        <div style="display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap;margin-top:1.9rem;">
            <a href="kavramlar.php" class="btn btn--solid">Kavramlar Sözlüğü <?php echo nur_arrow_svg(); ?></a>
            <a href="suhreverdi.php" class="btn btn--ghost">Hayatı</a>
        </div>
    </div>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
