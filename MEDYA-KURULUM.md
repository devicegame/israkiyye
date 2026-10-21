# Medya / Kanallar Modülü - Kurulum

1. Dosyaları sitenin köküne kopyalayın (mevcut includes/navbar.php ve footer.php güncellendi).
2. `data/` ve `uploads/` klasörleri PHP tarafından YAZILABİLİR olmalı (Linux: chmod 775 / 755 + doğru sahip).
3. Tarayıcıda `/admin.php` açın -> ilk açılışta admin hesabını siz oluşturun (dosyaları yükler yüklemez yapın).
4. Admin panelinden medya hesapları tanımlayın -> hesap sahipleri `/login.php` ile girip `/dashboard.php` üzerinden post paylaşır.

Güvenlik notları
- `data/.htaccess` JSON dosyalarını web'den kapatır. Nginx kullanıyorsanız `location /data/ { deny all; }` ekleyin.
- `uploads/.htaccess` script çalışmasını engeller. Nginx'te uploads içinde php çalıştırmayı kapatın.
- PHP 7.4+ gereklidir (8.x önerilir). `php.ini` içinde upload_max_filesize en az 3M olmalı.
