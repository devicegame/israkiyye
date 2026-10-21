<?php
$site_title = "Şehabeddin Sühreverdî | İşrâkiyye";
$site_desc  = "Şihâbüddîn Sühreverdî'nin hayatı, tahsili, felsefi projesi ve trajik sonu.";
require __DIR__ . "/includes/header.php";
require __DIR__ . "/data/content.php";
?>

<section class="pagehead">
    <div class="pagehead__glow" aria-hidden="true"></div>
    <p class="eyebrow">Şeyhü'l-İşrâk &middot; eş-Şeyhü'l-Maktûl</p>
    <h1><?php echo $biyografi["tam_ad"]; ?></h1>
    <p class="lede">
        <?php echo $biyografi["dogum"]; ?> &mdash; <?php echo $biyografi["vefat"]; ?>
    </p>
    <p class="pagehead__arabic arabic" aria-hidden="true">شيخ الإشراق</p>
</section>

<section class="section section--tight">
    <div class="facts" data-reveal>
        <div class="fact">
            <p class="fact__label">Lakap</p>
            <p class="fact__value"><?php echo $biyografi["lakap"]; ?></p>
        </div>
        <div class="fact">
            <p class="fact__label">Doğum</p>
            <p class="fact__value"><?php echo $biyografi["dogum"]; ?></p>
        </div>
        <div class="fact">
            <p class="fact__label">Vefat</p>
            <p class="fact__value"><?php echo $biyografi["vefat"]; ?></p>
        </div>
        <div class="fact">
            <p class="fact__label">Çağ</p>
            <p class="fact__value">XII. Yüzyıl</p>
        </div>
    </div>
    <p class="muted center" style="margin-top:1.5rem;font-size:0.9rem;"><?php echo $biyografi["ozet"]; ?></p>
</section>

<section class="section section--ruled">
    <div class="section-head">
        <div class="section-head__text">
            <p class="eyebrow">Kronoloji</p>
            <h2>Bir Ömrün Nûr Çizgisi</h2>
            <p>Doğumundan idamına, otuz yedi yıla sığan bir hikmet yolculuğu.</p>
        </div>
    </div>

    <ol class="timeline">
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1154<small>Sühreverd / İran</small></p>
            <div class="timeline__body">
                <h3>Doğum</h3>
                <p>Bugünkü İran'ın kuzeybatısındaki Sühreverd kasabasında dünyaya geldi.</p>
            </div>
        </li>
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1170'ler<small>Meraga &amp; İsfahan</small></p>
            <div class="timeline__body">
                <h3>İlk Tahsil</h3>
                <p>Dönemin önemli ilim merkezlerinde mantık, fıkıh ve felsefe okudu; Mecdüddin el-Cîlî'nin derslerine devam etti. Fahreddin er-Râzî ile birlikte öğrenim gördüğü rivayet edilir.</p>
            </div>
        </li>
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1180'ler<small>Anadolu &amp; Suriye</small></p>
            <div class="timeline__body">
                <h3>Riyazet ve Keşif</h3>
                <p>Tasavvufî çevrelerle temas kurdu; halvet ve riyazet pratikleriyle kendi ifadesiyle "içsel keşif" tecrübeleri yaşadı. Bu tecrübeler, salt akli istidlale duyduğu güvensizliğin temelini oluşturdu.</p>
            </div>
        </li>
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1183<small>Halep</small></p>
            <div class="timeline__body">
                <h3>Sarayın Yakınında</h3>
                <p>Selahaddin Eyyûbî'nin oğlu Melik ez-Zâhir'in sarayında itibar gördü; ancak cesur üslubu ve bazı fıkıh âlimleriyle girdiği tartışmalar tepki topladı.</p>
            </div>
        </li>
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1186<small>Hikmetü'l-İşrâk</small></p>
            <div class="timeline__body">
                <h3>Başyapıt</h3>
                <p>Otuz iki yaşındayken, mantık ile nûr metafiziğini birleştiren <em>Hikmetü'l-İşrâk</em>'ı tamamladı ve İşrâkî okulun kurucu metnini ortaya koydu.</p>
            </div>
        </li>
        <li class="timeline__item" data-reveal>
            <p class="timeline__year">1191<small>Halep Kalesi</small></p>
            <div class="timeline__body">
                <h3>İdam &mdash; "Maktûl"</h3>
                <p>Zındıklık ve ilhad suçlamalarıyla yürütülen fetvaların ardından, henüz otuz yedi yaşında idam edildi. Böylece İslam düşünce tarihine "eş-Şeyhü'l-Maktûl" olarak geçti.</p>
            </div>
        </li>
    </ol>
</section>

<section class="section section--ruled">
    <div class="stack">
        <article class="article article--shadow" data-reveal>
            <div class="article__head">
                <div>
                    <p class="eyebrow eyebrow--plain" style="margin-bottom:.6rem;">Hayat</p>
                    <h2>Hayatı ve Yetişmesi</h2>
                </div>
            </div>
            <p>
                Şihâbüddîn Yahyâ es-Sühreverdî, yaklaşık 1154 yılında bugünkü İran'ın kuzeybatısındaki
                Sühreverd kasabasında dünyaya geldi. Erken yaşlarda Meraga ve İsfahan gibi dönemin önemli
                ilim merkezlerinde mantık, fıkıh ve felsefe tahsil etti. Mecdüddin el-Cîlî gibi hocalardan
                ders aldığı, aynı dönemde Fahreddin er-Râzî ile birlikte öğrenim gördüğü rivayet edilir.
            </p>
            <p>
                Gençlik yıllarında Anadolu ve Suriye'yi dolaşan Sühreverdî, tasavvufî çevrelerle de temas
                kurmuş, riyazet ve halvet uygulamalarıyla kendi ifadesiyle "içsel keşif" tecrübeleri
                yaşamıştır. Bu tecrübeler, salt akli istidlale dayanan Meşşâî felsefeye duyduğu
                güvensizliğin temelini oluşturur.
            </p>
        </article>

        <article class="article article--shadow" data-reveal>
            <div class="article__head">
                <div>
                    <p class="eyebrow eyebrow--plain" style="margin-bottom:.6rem;">Proje</p>
                    <h2>Felsefi Projesi: İşrâkî Hikmetin İnşası</h2>
                </div>
            </div>
            <p>
                Sühreverdî, kendisinden önceki felsefe tarihini iki ana damar olarak okur: Meşşâî (Aristocu)
                çizgi ve "işrâkî" ya da "zevkî" çizgi. Ona göre Hermes, Pisagor, Eflatun, Zerdüşt ve eski
                İran bilgeleri (Fehlevîyyûn) hep bu ikinci çizgiye mensuptur ve hakikate hem akıl hem de
                ruhani müşahede yoluyla ulaşmışlardır.
            </p>
            <p>
                <em>Hikmetü'l-İşrâk</em> adlı başyapıtında bu iki mirası birleştirmeye çalışır: eserin ilk
                bölümü sağlam bir mantık ve epistemoloji eleştirisi sunarken, ikinci bölüm "Nûr Metafiziği"
                adını verdiği özgün varlık teorisini ortaya koyar. Bu teoride varlık, nûr (ışık) yoğunluğuna
                göre derecelenir; en tepede kendinden var olan "Nûrü'l-Envâr" bulunur.
            </p>
            <p>
                Sühreverdî'nin sembolik risaleleri (<em>Kırmızı Akıl</em>, <em>Cebrail'in Kanat Sesi</em>,
                <em>Kuşların Risalesi</em>) ise aynı felsefi içeriği şiirsel ve alegorik bir dille, geniş
                kitlelere ve mürid topluluklarına ulaştırma amacı taşır.
            </p>
        </article>

        <article class="article article--dark" data-reveal>
            <div class="article__head">
                <div>
                    <p class="eyebrow eyebrow--plain" style="margin-bottom:.6rem;color:#c98a78;">Son</p>
                    <h2>Trajik Sonu: "Maktûl" Lakabı</h2>
                </div>
            </div>
            <p>
                Sühreverdî, 1183 civarında Halep'e geldi ve burada Selahaddin Eyyûbî'nin oğlu Melik
                ez-Zâhir'in sarayında itibar gördü. Ancak cesur ve doğrudan üslubu, kendisini "peygamberlik
                benzeri bir makam"a layık görmesi ve bazı fıkıh âlimleriyle girdiği tartışmalar, dönemin
                sünni uleması arasında ciddi bir tepkiye yol açtı.
            </p>
            <p>
                Halep uleması, Sühreverdî'nin görüşlerini zındıklık ve ilhad ile itham eden fetvalar
                yayınladı. Bu baskılar karşısında, oğlunun bu genç filozofa duyduğu yakınlığı kaygıyla
                izleyen Selahaddin Eyyûbî, idam kararını onayladı.
            </p>
            <p>
                Şihâbüddîn Sühreverdî, 1191 yılında, henüz otuz yedi yaşındayken Halep kalesinde idam
                edildi. Bu trajik son, kendisine İslam düşünce tarihinde "eş-Şeyhü'l-Maktûl" (öldürülen
                şeyh) lakabını kazandırmış; onu, hakikat uğruna bedel ödeyen bir "şehid-i aşk" figürüne
                dönüştürmüştür.
            </p>
        </article>
    </div>
</section>

<section class="section section--tight">
    <figure class="quote" data-reveal>
        <span class="quote__mark" aria-hidden="true">&ldquo;</span>
        <blockquote class="quote__text">
            Nûr, kendi zatıyla görünendir;<br class="hidden-sm"> karanlık ise ancak nûrla görünür hâle gelendir.
        </blockquote>
        <figcaption class="quote__by">Nûr Metafiziği &middot; Tarif</figcaption>
    </figure>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
