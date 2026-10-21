<?php
$site_title = "İşrâkiyye | Nûr ve Hikmet Felsefesi";
$site_desc  = "Şihâbüddîn Sühreverdî ve İşrâkî hikmet okulu: nûr metafiziği, huzûrî ilim, sembolik risaleler ve karşılaştırmalı bir tasnif.";
require __DIR__ . "/includes/header.php";
require __DIR__ . "/data/content.php";

$roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII'];
?>

<!-- ═══════════ KAHRAMAN ═══════════ -->
<section class="hero">
    <div class="hero__bg" data-parallax="0.05" aria-hidden="true">
        <img src="assets/img/hero-nur.jpg" alt="" width="1536" height="662" fetchpriority="high">
    </div>

    <div class="hero__grid">
        <div class="hero__copy">
            <p class="eyebrow">Şeyhü'l-İşrâk &middot; 1154 &mdash; 1191</p>

            <h1 class="hero__title" aria-label="Karanlıktan Nûra, Bedenden Hakikate">
                <span class="line">
                    <span class="word" style="--i:0">Karanlıktan</span>
                    <span class="word gold-text" style="--i:1"><em>Nûra</em>,</span>
                </span>
                <span class="line line--indent">
                    <span class="word" style="--i:2">Bedenden</span>
                    <span class="word" style="--i:3"><em>Hakikate</em></span>
                </span>
            </h1>

            <p class="hero__arabic arabic" aria-hidden="true">حكمة الإشراق</p>

            <p class="hero__lede">
                İşrâkiyye, Şihâbüddîn Sühreverdî'nin kurduğu; akıl ile zevki, burhan ile keşfi
                birleştiren, varlığı <span class="glow-word">nûr</span> ve
                <span class="glow-word">karanlık</span> ekseninde yeniden kuran bir hikmet geleneğidir.
            </p>

            <div class="hero__actions">
                <a href="kavramlar.php" class="btn btn--solid">Kavramları Keşfet <?php echo nur_arrow_svg(); ?></a>
                <a href="suhreverdi.php" class="btn btn--quiet">Sühreverdî'nin Hayatı <?php echo nur_arrow_svg(); ?></a>
            </div>

            <div class="hero__meta">
                <span><b><?php echo count($kavramlar); ?></b> Temel Kavram</span>
                <span><b><?php echo count($eserler); ?></b> Eser &amp; Risale</span>
                <span><b>IX.</b> Asır Hikmeti</span>
            </div>
        </div>

        <div class="hero__visual">
            <div class="hero__halo" aria-hidden="true"></div>
            <div class="hero__ring" aria-hidden="true"></div>
            <figure class="arch">
                <div class="hero__seal" aria-hidden="true"><?php echo nur_mandala_svg(); ?></div>
                <div class="arch__inner">
                    <img src="assets/img/portal-nur.jpg" alt="Karanlık taş bir kemerden içeri süzülen altın nûr" width="768" height="1344">
                    <div class="arch__veil" aria-hidden="true"></div>
                    <figcaption class="arch__caption">Nûrü'l-Envâr &middot; Işıkların Işığı</figcaption>
                </div>
            </figure>
        </div>
    </div>

    <div class="hero__scroll" aria-hidden="true">
        <i></i>
        <span>Aşağı in &middot; Hikmete doğru</span>
    </div>
</section>

<!-- ═══════════ NÛR METAFİZİĞİ ═══════════ -->
<section class="section section--ruled" id="metafizik">
    <div class="emanate">
        <figure class="emanate__art" data-reveal>
            <img src="assets/img/hero-nur.jpg" alt="Karanlıkta parlayan tek bir altın nûr ve geometrik hikmet mührü" loading="lazy" width="1536" height="662">
            <figcaption>Emanasyon &middot; Nûrun Dereceli İnişi</figcaption>
        </figure>

        <div data-reveal style="--delay:.1s">
            <p class="eyebrow">Ontoloji</p>
            <h2>Varlık, nûrun<br>dereceleridir.</h2>
            <p class="lede" style="margin-bottom:1.8rem;">
                Sühreverdî'ye göre bir şey ne kadar nûrânî ise o kadar var, ne kadar karanlık ise
                o kadar yok hükmündedir. Varlık, saf ışıktan gölgeye doğru inen bir hiyerarşidir.
            </p>

            <div class="ladder">
                <div class="ladder__node">
                    <span class="ladder__step">I. Mertebe</span>
                    <span class="ladder__title">Nûrü'l-Envâr</span>
                    <span class="ladder__desc">Kendinden kaim, hiçbir şeye muhtaç olmayan saf ışık; bütün nûrların kaynağı.</span>
                </div>
                <div class="ladder__node">
                    <span class="ladder__step">II. Mertebe</span>
                    <span class="ladder__title">Mücerred Nûrlar</span>
                    <span class="ladder__desc">Hiyerarşide birbirini seven ve aydınlatan ara nûrlar; kahr ve mahabbet ilkeleriyle düzenlenir.</span>
                </div>
                <div class="ladder__node">
                    <span class="ladder__step">III. Mertebe</span>
                    <span class="ladder__title">Berzah &middot; Karanlık Cevher</span>
                    <span class="ladder__desc">Kendi başına idrak edilemeyen, ancak üzerine nûr düştüğünde anlam kazanan cisim ve gölge âlemi.</span>
                </div>
            </div>

            <a href="kavramlar.php#nur-ul-envar" class="btn btn--quiet" style="margin-top:1.4rem;">
                Kavramları oku <?php echo nur_arrow_svg(); ?>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════ ÖNE ÇIKAN KAVRAMLAR ═══════════ -->
<section class="section section--ruled">
    <div class="section-head">
        <div class="section-head__text">
            <p class="eyebrow">Sözlük</p>
            <h2>Öne Çıkan Kavramlar</h2>
            <p>İşrâkî hikmetin varlık, bilgi ve nefis üzerine kurduğu temel taşlar.</p>
        </div>
        <a href="kavramlar.php" class="link-more">Tümünü Gör <?php echo nur_arrow_svg(); ?></a>
    </div>

    <div class="grid grid--3">
        <?php $i = 0; foreach ($kavramlar as $k): if ($i >= 3) break; ?>
            <a class="card card--concept card--link" href="kavramlar.php#<?php echo htmlspecialchars($k['slug'], ENT_QUOTES, 'UTF-8'); ?>"
               data-reveal style="--delay:<?php echo $i * 0.08; ?>s">
                <span class="card__corner card__corner--tl" aria-hidden="true"></span>
                <span class="card__corner card__corner--br" aria-hidden="true"></span>
                <span class="card__index" aria-hidden="true"><?php echo $roman[$i]; ?></span>
                <p class="card__kicker">Kavram</p>
                <h3 class="card__title"><?php echo $k["baslik"]; ?></h3>
                <p class="card__text"><?php echo $k["kisa"]; ?></p>
                <span class="card__foot">
                    <span class="card__link">Devamını Oku <?php echo nur_arrow_svg(); ?></span>
                </span>
            </a>
        <?php $i++; endforeach; ?>
    </div>
</section>

<!-- ═══════════ ALINTI ═══════════ -->
<section class="section section--tight">
    <figure class="quote" data-reveal>
        <span class="quote__mark" aria-hidden="true">&ldquo;</span>
        <blockquote class="quote__text">
            Hikmet, karanlık bedenden sıyrılıp<br class="hidden-sm"> nûrun aslına dönmektir.
        </blockquote>
        <figcaption class="quote__by">Şihâbüddîn Sühreverdî &middot; Şeyhü'l-Maktûl</figcaption>
    </figure>
</section>

<!-- ═══════════ ÖNE ÇIKAN RİSALELER ═══════════ -->
<section class="section section--ruled">
    <div class="section-head">
        <div class="section-head__text">
            <p class="eyebrow">Külliyat</p>
            <h2>Öne Çıkan Risaleler</h2>
            <p>Akli burhanın yanında sembol, istiare ve hayal ile konuşan metinler.</p>
        </div>
        <a href="eserler.php" class="link-more">Tümünü Gör <?php echo nur_arrow_svg(); ?></a>
    </div>

    <div class="grid grid--2">
        <?php $j = 0; foreach ($eserler as $e): if ($j >= 4) break; ?>
            <a class="card card--work card--link" href="eserler.php#<?php echo htmlspecialchars($e['slug'], ENT_QUOTES, 'UTF-8'); ?>"
               data-reveal style="--delay:<?php echo $j * 0.07; ?>s">
                <span class="card__corner card__corner--tl" aria-hidden="true"></span>
                <span class="card__corner card__corner--br" aria-hidden="true"></span>
                <span class="card__index" aria-hidden="true"><?php echo $roman[$j]; ?></span>
                <p class="card__kicker"><?php echo $e["tur"]; ?></p>
                <h3 class="card__title" style="padding-right:2rem;"><?php echo $e["baslik"]; ?></h3>
                <p class="card__text"><?php echo $e["ozet"]; ?></p>
                <span class="card__foot">
                    <span class="card__link">İncele <?php echo nur_arrow_svg(); ?></span>
                </span>
            </a>
        <?php $j++; endforeach; ?>
    </div>
</section>

<!-- ═══════════ MEDYA + CTA ═══════════ -->
<section class="section section--ruled">
    <div class="cta" data-reveal>
        <span class="cta__arabic" aria-hidden="true">إشراق</span>
        <p class="eyebrow eyebrow--plain" style="margin-bottom:1rem;">Yol</p>
        <h2>Nûrun izinde bir okuma</h2>
        <p>
            Hikmetü'l-İşrâk'tan sembolik risalelere, İşrâkî hikmetin haritasını
            birlikte açalım. Ya da kanallarımızdan yeni yazıları takip edin.
        </p>
        <div style="display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap;margin-top:1.9rem;">
            <a href="eserler.php" class="btn btn--solid">Eserleri Gör <?php echo nur_arrow_svg(); ?></a>
            <a href="medya.php" class="btn btn--ghost">Medya &amp; Kanallar</a>
        </div>
    </div>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
