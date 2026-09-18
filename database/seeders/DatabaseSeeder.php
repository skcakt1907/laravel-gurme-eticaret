<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------------- Admin ---------------- */
        $admin = User::updateOrCreate(['email' => 'admin@ornek-gurme.com'], [
            'name' => 'AEGEA RESERVE Yönetici',
            'password' => Hash::make('admin123'),
            'phone' => '0232 000 00 00',
        ]);
        $admin->forceFill(['role' => 'admin'])->save();

        /* ---------------- Ayarlar ---------------- */
        $ayarlar = [
            'site_adi' => 'AEGEA RESERVE',
            'site_aciklama' => 'Ege’nin berrak sularından, vahşi kefal balığı yumurtasından; elde tuzlanıp güneşte kurutulan premium bottarga. Vahşi avlanmış, katkısız, ustaca kürlenmiş.',
            'telefon' => '0540 448 48 34',
            'whatsapp' => '905404484834',
            'eposta' => 'info@ornek-gurme.com',
            'kep' => 'ornek@kep.tr',
            'etbis_eposta' => 'info@ornek-tedarikci.com.tr',
            'adres' => 'Çıldır Mah. 107/1. Sk. No:7, Marmaris / Muğla',
            'instagram' => 'https://instagram.com',
            'facebook' => 'https://facebook.com',
            'kargo_ucreti' => '9.90',
            'havale_iban' => 'TR980001500158048022219828',
            'havale_hesaplar' => "Vakıfbank | TL | TR430001500158007312526722\nVakıfbank | EUR | TR980001500158048022219828\nVakıfbank | USD | TR770001500158048022219818\nVakıfbank | GBP | TR340001500158048022219816\nGaranti | TL | TR280006200121100006296446\nGaranti | EUR | TR670006200121100009074212\nGaranti | USD | TR400006200121100009074213\nGaranti | GBP | TR940006200121100009074211\nAkbank | TL | TR300004600615888000274497\nAkbank | EUR | TR340004600615036000082621\nAkbank | USD | TR840004600615001000082620\nAkbank | GBP | TR370004600615003000082622\nZiraat Bankası | TL | TR590001002441976294125001\nZiraat Bankası | EUR | TR750001002441976294125004\nZiraat Bankası | USD | TR050001002441976294125003\nZiraat Bankası | GBP | TR480001002441976294125005",
            'firma_unvan' => 'MARTAŞ GRANİT MERMER MADEN. İNŞ. TUR. TİC. İTH. ve İHR. LTD. ŞTİ.',
            'vergi_dairesi' => 'Marmaris',
            'vergi_no' => '6121402706',
            'mersis_no' => '0612140270600001',
            'ticaret_sicil_no' => '10937',
            'havale_hesap_adi' => 'MARTAŞ GRANİT MERMER MADEN. İNŞ. TUR. TİC. İTH. ve İHR. LTD. ŞTİ.',
            'havale_banka' => 'Vakıfbank',
            'iyzico_aktif' => '0',
            'kapida_aktif' => '1',
            'fiyat_goster' => '1',   // 1 = fiyatlar + sepet görünür (0 = katalog modu)
            'yil' => '10',
        ];
        foreach ($ayarlar as $k => $v) {
            Setting::updateOrCreate(['anahtar' => $k], ['deger' => $v]);
        }
        Setting::flush();

        /* ---------------- Kategoriler (bottarga stilleri) ---------------- */
        $cats = [
            'grated-bottarga'  => ['Rendelenmiş Bottarga', 'bi-stars'],
            'waxed-whole-bottarga'  => ['Mumlu Bütün Bottarga', 'bi-award'],
            'vacuum-sealed-bottarga'      => ['Vakumlu Bottarga', 'bi-box-seam'],
        ];
        $catModels = [];
        $i = 1;
        foreach ($cats as $slug => [$name, $icon]) {
            $catModels[$slug] = Category::updateOrCreate(['slug' => $slug], [
                'name' => $name, 'icon' => $icon, 'sira' => $i++, 'durum' => true,
            ]);
        }

        /* ---------------- Ürünler ---------------- */
        // [ad, kategori, görselNo, fiyat, indirimli, stok, açıklama, özellikler, öneÇıkan]
        $products = [
            ['Rendelenmiş Bottarga 50g', 'grated-bottarga', 1, 39, null, 40,
                'Kullanıma hazır, ince rendelenmiş bottarga. Makarna, risotto veya salatanın üzerine anında umami dokunuşu.',
                ['agirlik' => '50 g', 'form' => 'Rendelenmiş', 'kullanim' => 'Makarna / salata'], true],
            ['Rendelenmiş Bottarga 100g', 'grated-bottarga', 2, 39, null, 30,
                'Sık kullananlar için 100 gramlık cam kavanoz. Taze aromasını koruyan ağzı sıkı kapak.',
                ['agirlik' => '100 g', 'form' => 'Rendelenmiş'], false],

            ['Mumlu Bütün Bottarga', 'waxed-whole-bottarga', 3, 39, null, 25,
                'Geleneksel yöntemle balmumuyla kaplanmış bütün yumurta. Servis anında rendeleyin.',
                ['form' => 'Bütün · mumlu'], true],
            ['Vakumlu Bottarga Dilim 100g', 'vacuum-sealed-bottarga', 6, 39, null, 35,
                'Vakumlanmış, dilimlenmeye hazır saf bottarga. Katkısız, dokunulmamış lezzet.',
                ['agirlik' => '100 g', 'form' => 'Vakumlu dilim'], false],
            ['Vakumlu Bottarga 200g', 'vacuum-sealed-bottarga', 7, 79, null, 28,
                'Mutfak formatında 200 gramlık vakumlu bottarga; dilimleyin, rendeleyin, paylaşın.',
                ['agirlik' => '200 g', 'form' => 'Vakumlu'], true],
        ];

        $s = 1;
        foreach ($products as [$name, $catSlug, $imgNo, $price, $sale, $stock, $desc, $attrs, $featured]) {
            $slug = Str::slug($name);
            $cover = 'uploads/products/g' . str_pad((string) $imgNo, 2, '0', STR_PAD_LEFT) . '.jpg';
            Product::updateOrCreate(['slug' => $slug], [
                'category_id' => $catModels[$catSlug]->id,
                'name' => $name,
                'brand' => 'AEGEA RESERVE',
                'sku' => 'AR-' . str_pad((string) $s, 4, '0', STR_PAD_LEFT),
                'cover' => $cover,
                'images' => [$cover],
                'short_desc' => $desc,
                'description' => $desc . "\n\nVahşi avlanmış Ege kefal yumurtasından; elde tuzlanır, güneşte kurutulur. Katkısızdır; taze ürünler soğuk zincirle özenle gönderilir.",
                'price' => $price,
                'sale_price' => $sale,
                'stock' => $stock,
                'attributes' => $attrs,
                'featured' => $featured,
                'sira' => $s++,
                'durum' => true,
            ]);
        }

        /* ---------------- Neden AEGEA (özellik kartları) ---------------- */
        $services = [
            ['Vahşi Avlanmış', 'vahsi-avlanmis', 'bi-water', 'Ege’nin açık ve berrak sularından, mevsiminde avlanan kefal yumurtası.'],
            ['Elde Kürlenmiş', 'elde-kurlenmis', 'bi-hand-index', 'Yalnızca deniz tuzuyla, ustaların eliyle tuzlanır — katkı yok.'],
            ['Güneşte Kurutulmuş', 'gunes-te-kurutulmus', 'bi-brightness-high', 'Ege güneşi ve rüzgârıyla, amber rengini alana dek yavaşça kurutulur.'],
            ['Coğrafi Lezzet Mirası', 'cografi-lezzet', 'bi-award', 'Yüzyıllara dayanan geleneksel yöntemle hazırlanan seçkin bir delikatese.'],
            ['Soğuk Zincir Kargo', 'soguk-zincir-kargo', 'bi-truck', 'Taze ürünler soğuk zincirle, kırılganlar özel ambalajla gönderilir.'],
            ['Güvenli Ödeme', 'guvenli-odeme', 'bi-shield-check', 'Havale/EFT, kapıda ödeme ve 3D Secure kartlı ödeme seçenekleri.'],
        ];
        $n = 1;
        foreach ($services as [$t, $sl, $ic, $sum]) {
            Service::updateOrCreate(['slug' => $sl], [
                'title' => $t, 'icon' => $ic, 'summary' => $sum,
                'content' => $sum . ' AEGEA RESERVE olarak lezzeti ve geleneği bir arada, en saf haliyle sunuyoruz.',
                'sira' => $n++, 'durum' => true,
            ]);
        }

        /* ---------------- Blog / Tarifler ---------------- */
        $posts = [
            ['Bottarga Nedir, Nasıl Tüketilir?', 'bottarga-nedir', 'Rehber', 1,
                'Akdeniz’in “deniz havyarı”; bottarganın ne olduğunu, nasıl rendelenip servis edildiğini ve eşleştiği lezzetleri anlattık.'],
            ['Makarnada Bottarga: 3 Klasik Tarif', 'makarnada-bottarga-tarifleri', 'Tarif', 7,
                'Zeytinyağı ve sarımsakla spaghetti alla bottarga’dan limonlu linguine’ye, üç kolay ve etkileyici tarif.'],
            ['Bottarga Nasıl Saklanır?', 'bottarga-nasil-saklanir', 'Bilgi', 9,
                'Mumlu ve vakumlu bottarganın tazeliğini korumak için ideal saklama koşulları ve raf ömrü.'],
        ];
        $img = fn ($no) => 'uploads/products/g' . str_pad((string) $no, 2, '0', STR_PAD_LEFT) . '.jpg';
        foreach ($posts as $idx => [$t, $sl, $cat, $imgNo, $sum]) {
            Post::updateOrCreate(['slug' => $sl], [
                'title' => $t, 'category' => $cat, 'image' => $img($imgNo), 'summary' => $sum,
                'content' => $sum . "\n\nDaha fazlası ve mevsimlik önerilerimiz için bültenimize göz atın.",
                'tarih' => now()->subDays($idx * 6)->toDateString(), 'durum' => true,
            ]);
        }

        /* ---------------- Yorumlar (şefler) ---------------- */
        $testi = [
            ['Şef Murat A.', 'Restoran Sahibi', 'Menümüzde rendelenmiş bottarga kullanıyoruz; misafirler farkı hemen anlıyor. Sardinya’dan sonra tattığım en iyi bottarga.', 5],
            ['Elif D.', 'Gurme', 'Mumlu bütün bottarga tam anlatıldığı gibi. Rendelendiğinde inanılmaz bir umami veriyor, paketleme de çok özenliydi.', 5],
            ['Chef Kaan Y.', 'Gastronomi Danışmanı', 'Tutarlı, temiz ve zarif ambalajlı. AEGEA RESERVE artık mutfağımızın vazgeçilmezi.', 5],
        ];
        foreach ($testi as [$ad, $unvan, $yorum, $yildiz]) {
        }
    }
}
