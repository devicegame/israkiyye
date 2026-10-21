<?php $yil = date('Y'); ?>
</main>

<footer class="site-footer">
    <div class="shell footer__inner">
        <div class="footer__grid">
            <div class="footer__brand">
                <a class="brand" href="index.php" aria-label="İşrâkiyye — anasayfa">
                    <span class="brand__mark"><?php echo nur_star_svg('', 20); ?></span>
                    <span class="brand__words">
                        <span class="brand__word">İŞRÂKİYYE</span>
                        <span class="brand__sub">Nûr &amp; Hikmet</span>
                    </span>
                </a>
                <p>
                    Nûr ve hikmet üzerine kurulu, zevk ile keşfi akılla birleştiren İşrâkî
                    hikmet okulunun dijital arşivi. Bilgi, karanlığın içinde parlayan bir ışıktır.
                </p>
                <p class="arabic" style="margin-top:1.2rem;font-size:1.3rem;opacity:.65;">النور يهدي إلى النور</p>
            </div>

            <div>
                <h3 class="footer__title">Fihrist</h3>
                <div class="footer__links">
                    <a href="index.php">Anasayfa</a>
                    <a href="kavramlar.php">Kavramlar</a>
                    <a href="suhreverdi.php">Şihâbüddîn Sühreverdî</a>
                    <a href="eserler.php">Eserler &amp; Risaleler</a>
                    <a href="karsilastirma.php">Karşılaştırmalı Tasnif</a>
                    <a href="medya.php">Medya &amp; Kanallar</a>
                </div>
            </div>

            <div>
                <h3 class="footer__title">Nûr'dan Bir Söz</h3>
                <p class="footer__quote">
                    &ldquo;Hikmet, karanlık bedenden sıyrılıp nûrun aslına dönmektir.&rdquo;
                </p>
                <p class="footer__quote-by">Şihâbüddîn Sühreverdî</p>
            </div>
        </div>

        <div class="footer__bottom">
            <p style="margin:0;">&copy; <?php echo $yil; ?> İşrâkiyye Arşivi &middot; Tüm hakları saklıdır.</p>
            <nav aria-label="Alt gezinme">
                <a href="medya.php">Medya</a>
                <a href="login.php">Kanal Girişi</a>
                <a href="#main">Yukarı Dön &uarr;</a>
            </nav>
            <a class="footer__seal" href="#main" aria-label="Sayfa başına dön"><?php echo nur_star_svg('', 18); ?></a>
        </div>
    </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
