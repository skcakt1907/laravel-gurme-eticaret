# Gurme Urun E-Ticaret

Gurme gida satisi icin cok para birimli e-ticaret sitesi.

## Ozellikler

- Urun katalogu, sepet ve odeme akisi
- Cok para birimli fiyatlandirma ve kur donusumu
- iyzico odeme surucusu, siparis ve e-posta bildirimleri
- Guvenlik basliklari middleware'i, yonetim paneli

## Kullanilan teknolojiler

Laravel 13 - PHP 8.3 - MySQL - Blade

## Bu depo hakkinda

Gercek bir musteri projesinin **portfolyo icin yayinlanmis** surumudur.
Yayina hazirlanirken canli alan adlari, gercek iletisim bilgileri, musteri
kayitlari ve uygulama anahtarlari ornek degerlerle degistirilmistir.
Kod ve mimari oldugu gibidir; veri gercek degildir.

## Kurulum

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
