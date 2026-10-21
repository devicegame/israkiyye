# İşrâkiyye — Nûr ve Hikmet Arşivi

Şihâbüddîn Sühreverdî ve İşrâkî hikmet okulu üzerine kurulmuş, veritabanı
kullanmayan (flat-file) bir dijital arşiv. Saf PHP + kendi barındırılan
CSS/JS/yazı tipleri.

## Sayfalar

| Dosya | İçerik |
| --- | --- |
| `index.php` | Kahraman bölümü, nûr hiyerarşisi, öne çıkan kavram ve risaleler |
| `kavramlar.php` | Kavram sözlüğü (hızlı geçiş çipleriyle) |
| `suhreverdi.php` | Biyografi, kronoloji, felsefi proje, trajik son |
| `eserler.php` | Külliyat + yapışkan fihrist sütunu |
| `karsilastirma.php` | İşrâkilik / Meşşâîlik / Tasavvuf karşılaştırması |
| `medya.php`, `medya-detay.php` | Kanallar ve kanal akışı |
| `login.php`, `dashboard.php`, `admin.php` | Kanal ve yönetici panelleri |

İçerik `data/content.php` içindeki PHP dizilerinden gelir; medya verisi
`data/*.json` dosyalarında tutulur.

## Tasarım dili

Tema: **“Karanlıkta altın bir nûr.”**

- **Renk**: mürekkep siyahı (`#04060b`–`#0d131f`), antik altın (`#d8b264`),
  fildişi metin (`#ece5d7`); nûru temsil eden sıcak vurgular.
- **Tipografi**: Cormorant Garamond (display), Lora (metin), Manrope (arayüz
  mikro-tipografyası), Amiri (Arapça). Tüm yazı tipleri `assets/fonts/`
  içinde yereldir — dış CDN bağımlılığı yoktur.
- **Atmosfer**: `<canvas>` ile çizilen yıldız alanı, yavaşça sürüklenen nûr
  bulutları, film greni ve yükselen altın zerreler.
- **Süslemeler**: sekiz köşeli nûr yıldızı (marka işareti), on altı ışınlı
  döner mühür, ince altın ayraçlar — hepsi satır içi SVG
  (`includes/ornaments.php`).

## Etkileşim

`assets/js/main.js` (bağımlılıksız):

- Okuma ilerleme çizgisi ve kaydırınca yoğunlaşan üst çubuk
- `IntersectionObserver` ile bölüm belirme animasyonları
- Kartlarda imleci takip eden nûr lekesi ve köşe süslemeleri
- Kahraman görselinde hafif paralaks
- Tam ekran, numaralandırılmış mobil menü
- `prefers-reduced-motion` tercihine tam saygı

## Kurulum

1. Dosyaları sitenin kök dizinine kopyalayın.
2. `data/` ve `uploads/` yazılabilir olmalı (Linux: `chmod 775`).
3. `/admin.php` adresinden ilk admin hesabını oluşturun.
4. Ayrıntılar için `MEDYA-KURULUM.md`.

Gereksinim: PHP 7.4+ (8.x önerilir). Tailwind CDN’i artık kullanılmıyor;
arayüz tamamen `assets/css/main.css` içindeki tasarım sisteminden beslenir.
