<?php
$site_title = "Kavramlar | İşrâkiyye";
$site_desc  = "Nûrü'l-Envâr, berzah, işrâk, huzûrî ilim ve kahr-mahabbet: İşrâkî hikmetin temel kavramları.";
require __DIR__ . "/includes/header.php";
require __DIR__ . "/data/content.php";

$roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'];
?>

<section class="pagehead">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow">Sözlük</p>
    <h1>İşrâkî Kavramlar</h1>
    <p class="lede">
        Sühreverdî'nin nûr metafiziğini ve epistemolojisini kuran temel kavramlar;
        varlıktan bilgiye, kozmik sevgiden nefsin arınmasına uzanan bir hiyerarşi.
    </p>
    <p class="pagehead__arabic arabic" aria-hidden="true">المصطلحات الإشراقية</p>
</section>

<section class="section section--tight">
    <nav class="chips" aria-label="Kavramlar arasında geçiş">
        <?php foreach ($kavramlar as $k): ?>
            <a class="chip" href="#<?php echo htmlspecialchars($k['slug'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo $k["baslik"]; ?></a>
        <?php endforeach; ?>
    </nav>

    <div class="grid grid--2">
        <?php $i = 0; foreach ($kavramlar as $k): ?>
            <article id="<?php echo htmlspecialchars($k['slug'], ENT_QUOTES, 'UTF-8'); ?>"
                     class="card card--concept" data-reveal style="--delay:<?php echo ($i % 2) * 0.08; ?>s">
                <span class="card__corner card__corner--tl" aria-hidden="true"></span>
                <span class="card__corner card__corner--br" aria-hidden="true"></span>
                <span class="card__index" aria-hidden="true"><?php echo $roman[$i] ?? ''; ?></span>
                <p class="card__kicker">Kavram &middot; <?php echo str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); ?></p>
                <h2 class="card__title" style="font-size:clamp(1.35rem,2.2vw,1.7rem);"><?php echo $k["baslik"]; ?></h2>
                <p class="card__text" style="color:var(--gold-soft);font-style:italic;"><?php echo $k["kisa"]; ?></p>
                <div class="nur-divider" style="margin:0.2rem 0 1.2rem;"></div>
                <p class="card__text" style="color:var(--paper-soft);font-size:0.94rem;line-height:1.9;"><?php echo $k["detay"]; ?></p>
            </article>
        <?php $i++; endforeach; ?>
    </div>
</section>

<section class="section section--ruled">
    <div class="cta" data-reveal>
        <span class="cta__arabic" aria-hidden="true">نور</span>
        <p class="eyebrow eyebrow--plain">Devam</p>
        <h2>Kavramdan esere, eserden hayata</h2>
        <p>Bu kavramların işlendiği risaleleri ve Sühreverdî'nin hayat hikâyesini birlikte okuyun.</p>
        <div style="display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap;margin-top:1.9rem;">
            <a href="eserler.php" class="btn btn--solid">Eserler &amp; Risaleler <?php echo nur_arrow_svg(); ?></a>
            <a href="suhreverdi.php" class="btn btn--ghost">Hayatı</a>
        </div>
    </div>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
