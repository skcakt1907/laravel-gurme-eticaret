<?php
/**
 * AEGEA RESERVE — Tek Tiklamalik Kurulum Sihirbazi
 * Bu dosyayi sitenin ana dizinine koy, tarayicidan ac, formu doldur, bitir.
 * Kurulum bitince kendini siler.
 */
@set_time_limit(300);
@ini_set('display_errors', '1');
error_reporting(E_ALL);

/* ---------- Laravel kokunu bul ---------- */
function find_root() {
    $c = [__DIR__, dirname(__DIR__), dirname(__DIR__, 2)];
    foreach (glob(__DIR__ . '/*', GLOB_ONLYDIR) ?: [] as $d) { $c[] = $d; }
    foreach ($c as $p) {
        if (is_file($p . '/artisan') && is_file($p . '/vendor/autoload.php')) return realpath($p);
    }
    return null;
}
$ROOT = find_root();

/* ---------- yardimcilar ---------- */
function env_q($v) {
    if ($v === '' ) return '';
    if (preg_match('/[\s#"\'$\\\\]/', $v)) return '"' . str_replace(['\\', '"'], ['\\\\', '\\"'], $v) . '"';
    return $v;
}
function split_sql($sql) {
    $out = []; $buf = ''; $in = false; $q = ''; $esc = false; $n = strlen($sql);
    for ($i = 0; $i < $n; $i++) {
        $ch = $sql[$i];
        if ($in) {
            $buf .= $ch;
            if ($esc) { $esc = false; continue; }
            if ($ch === '\\') { $esc = true; continue; }
            if ($ch === $q) { $in = false; }
            continue;
        }
        if ($ch === "'" || $ch === '"' || $ch === '`') { $in = true; $q = $ch; $buf .= $ch; continue; }
        if ($ch === '/' && $i + 1 < $n && $sql[$i+1] === '*') {
            $e = strpos($sql, '*/', $i + 2); if ($e === false) break; $i = $e + 1; continue;
        }
        if (($ch === '-' && $i + 1 < $n && $sql[$i+1] === '-') || $ch === '#') {
            $e = strpos($sql, "\n", $i); if ($e === false) break; $i = $e; $buf .= "\n"; continue;
        }
        if ($ch === ';') { $t = trim($buf); if ($t !== '') $out[] = $t; $buf = ''; continue; }
        $buf .= $ch;
    }
    $t = trim($buf); if ($t !== '') $out[] = $t;
    return $out;
}
function chmod_r($dir, $mode = 0775) {
    if (!is_dir($dir)) return;
    @chmod($dir, $mode);
    foreach (@scandir($dir) ?: [] as $f) {
        if ($f === '.' || $f === '..') continue;
        $p = $dir . '/' . $f;
        is_dir($p) ? chmod_r($p, $mode) : @chmod($p, 0664);
    }
}
function rm_glob($pat) { foreach (glob($pat) ?: [] as $f) { if (is_file($f)) @unlink($f); } }

$LOG = []; $OK = false; $ERR = null;
$post = ($_SERVER['REQUEST_METHOD'] === 'POST');

/* ---------- sistem kontrolu ---------- */
$phpOk   = version_compare(PHP_VERSION, '8.2.0', '>=');
$exts    = ['pdo_mysql', 'mbstring', 'openssl', 'fileinfo', 'ctype', 'json'];
$extMiss = array_values(array_filter($exts, fn($e) => !extension_loaded($e)));
$sqlFile = $ROOT ? $ROOT . '/veritabani.sql' : null;
$hasSql  = $sqlFile && is_file($sqlFile);
$writable = $ROOT ? is_writable($ROOT) : false;

/* ---------- KURULUM ---------- */
if ($post && $ROOT) {
    $host = trim($_POST['db_host'] ?? 'localhost');
    $name = trim($_POST['db_name'] ?? '');
    $user = trim($_POST['db_user'] ?? '');
    $pass = (string)($_POST['db_pass'] ?? '');
    $url  = rtrim(trim($_POST['app_url'] ?? ''), '/');
    $mailUser = trim($_POST['mail_user'] ?? '');
    $mailPass = (string)($_POST['mail_pass'] ?? '');
    $mailHost = trim($_POST['mail_host'] ?? '');
    $doImport = !empty($_POST['do_import']);

    try {
        /* 1 — DB baglantisi */
        $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 10,
            ]);
        } catch (PDOException $e) {
            $m = $e->getMessage();
            if (strpos($m, '1045') !== false) {
                throw new Exception("Veritabani kullanici adi veya sifresi HATALI.\n\n"
                    . "cPanel > MySQL Veritabanlari sayfasinda:\n"
                    . "1) Kullanicinin gercek adini kontrol et (veritabani adiyla AYNI DEGILDIR)\n"
                    . "2) 'Kullaniciyi Veritabanina Ekle' bolumunden kullaniciyi bu veritabanina ekle\n"
                    . "   ve TUM AYRICALIKLAR'i isaretle. Bu adim atlanirsa bu hata alinir.\n\n"
                    . "Sunucu yaniti: " . $m);
            }
            if (strpos($m, '1049') !== false) {
                throw new Exception("'{$name}' adinda bir veritabani YOK.\n"
                    . "cPanel'den once bos bir veritabani olustur.\n\nSunucu yaniti: " . $m);
            }
            if (strpos($m, '2002') !== false) {
                throw new Exception("Veritabani sunucusuna baglanilamadi (host: {$host}).\n"
                    . "'localhost' yerine '127.0.0.1' dene (veya tersi).\n\nSunucu yaniti: " . $m);
            }
            throw new Exception($m);
        }
        $LOG[] = ['ok', "Veritabani baglantisi kuruldu ({$name}@{$host})"];

        /* 2 — SQL import */
        if ($doImport && $hasSql) {
            $exists = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $sql = file_get_contents($sqlFile);
            $stmts = split_sql($sql);
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
            $pdo->exec("SET NAMES utf8mb4");
            $done = 0; $fail = 0; $firstErr = null;
            foreach ($stmts as $s) {
                if ($s === '') continue;
                try { $pdo->exec($s); $done++; }
                catch (PDOException $e) { $fail++; if (!$firstErr) $firstErr = $e->getMessage(); }
            }
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            if (count($tables) < 10) {
                throw new Exception("Veritabani yuklenemedi. Ilk hata:\n" . $firstErr);
            }
            $cnt = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
            $LOG[] = ['ok', "Veritabani yuklendi — " . count($tables) . " tablo, {$cnt} urun"
                . ($fail ? " ({$fail} satir atlandi)" : "")
                . ($exists ? " [mevcut tablolar guncellendi]" : "")];
        } else {
            $t = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $LOG[] = ['warn', "SQL import atlandi — mevcut " . count($t) . " tablo kullanilacak"];
        }

        /* 3 — .env yaz */
        $key = 'base64:' . base64_encode(random_bytes(32));
        $mailer = $mailUser ? 'smtp' : 'log';
        $env = <<<ENV
APP_NAME="AEGEA RESERVE"
APP_ENV=production
APP_KEY={$key}
APP_DEBUG=false
APP_URL={$url}

APP_LOCALE=tr
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=tr_TR

APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST={$host}
DB_PORT=3306
DB_DATABASE={$name}
DB_USERNAME={$user}
DB_PASSWORD=%%PASS%%

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER={$mailer}
MAIL_HOST={$mailHost}
MAIL_PORT=587
MAIL_USERNAME={$mailUser}
MAIL_PASSWORD=%%MAILPASS%%
MAIL_SCHEME=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="{$mailUser}"
MAIL_FROM_NAME="\${APP_NAME}"

VITE_APP_NAME="\${APP_NAME}"

IYZICO_API_KEY=
IYZICO_SECRET=
IYZICO_SANDBOX=false
ENV;
        $env = str_replace('%%PASS%%', env_q($pass), $env);
        $env = str_replace('%%MAILPASS%%', env_q($mailPass), $env);
        if (!$mailUser) {
            $env = str_replace('MAIL_FROM_ADDRESS=""', 'MAIL_FROM_ADDRESS="info@example.com"', $env);
        }
        if (@file_put_contents($ROOT . '/.env', $env) === false) {
            throw new Exception("'.env' dosyasi yazilamadi.\nAna dizin yazilabilir degil: {$ROOT}\n"
                . "cPanel Dosya Yoneticisi'nden bu klasore 755 izni ver, tekrar dene.");
        }
        $LOG[] = ['ok', ".env olusturuldu (yeni APP_KEY uretildi, APP_DEBUG=false)"];

        /* 4 — izinler + cache temizligi */
        chmod_r($ROOT . '/storage');
        chmod_r($ROOT . '/bootstrap/cache');
        if (is_dir($ROOT . '/public/uploads')) chmod_r($ROOT . '/public/uploads');
        $LOG[] = ['ok', "Klasor izinleri ayarlandi (storage, bootstrap/cache, uploads)"];

        rm_glob($ROOT . '/bootstrap/cache/*.php');
        rm_glob($ROOT . '/storage/framework/views/*.php');
        $LOG[] = ['ok', "Onbellek temizlendi"];

        /* 5 — dogrulama */
        $chk = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $adm = $chk->query("SELECT email FROM users WHERE role='admin' LIMIT 1")->fetchColumn();
        $set = (int)$chk->query("SELECT COUNT(*) FROM settings")->fetchColumn();
        $LOG[] = ['ok', "Dogrulama: admin={$adm}, {$set} ayar kaydi"];

        $OK = true;
        $_SESSION_ADMIN = $adm;
    } catch (Throwable $e) {
        $ERR = $e->getMessage();
    }
}

/* ---------- kendini sil ---------- */
if (isset($_GET['bitir'])) {
    $r = find_root();
    if ($r && is_file($r . '/veritabani.sql')) @unlink($r . '/veritabani.sql');
    if ($r && is_file($r . '/.env.canli')) @unlink($r . '/.env.canli');
    @unlink(__FILE__);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '../');
    echo '<meta http-equiv="refresh" content="0;url=/">Kurulum tamamlandi, dosyalar silindi.';
    exit;
}

$guessUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
          . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
?><!doctype html>
<html lang="tr"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AEGEA RESERVE — Kurulum</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<style>
:root{--gold:#c9a24a;--gold2:#e7cd86;--bg:#0a0908;--card:#13100c;--line:rgba(201,162,74,.25);--cream:#ece3d0;--mut:#8b8578}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--cream);font-family:Inter,Arial,sans-serif;font-weight:300;padding:30px 16px;line-height:1.65}
.w{max-width:760px;margin:0 auto}
h1{font-family:Cinzel,serif;font-weight:600;color:var(--gold2);letter-spacing:.14em;font-size:26px;text-align:center}
.sub{text-align:center;color:var(--mut);font-size:13px;letter-spacing:.28em;margin:8px 0 26px;font-family:Cinzel,serif}
.card{background:var(--card);border:1px solid var(--line);padding:26px;margin-bottom:18px}
h2{font-family:Cinzel,serif;font-size:15px;color:var(--gold);letter-spacing:.1em;margin-bottom:16px;font-weight:600}
label{display:block;font-size:12px;letter-spacing:.08em;color:var(--gold2);margin:14px 0 5px;text-transform:uppercase}
input{width:100%;background:#0a0908;border:1px solid var(--line);color:var(--cream);padding:11px 13px;font-family:Inter;font-size:15px;border-radius:2px}
input:focus{outline:none;border-color:var(--gold)}
.hint{font-size:12px;color:var(--mut);margin-top:5px}
button{width:100%;background:var(--gold);color:#140f08;border:0;padding:15px;font-family:Cinzel,serif;font-weight:600;font-size:14px;letter-spacing:.16em;cursor:pointer;margin-top:24px;text-transform:uppercase}
button:hover{background:var(--gold2)}
.row{display:flex;gap:14px}.row>div{flex:1}
.chk{display:flex;align-items:flex-start;gap:9px;margin-top:16px;font-size:14px;color:var(--cream)}
.chk input{width:auto;margin-top:3px}
.i{display:flex;gap:10px;padding:7px 0;font-size:14px;align-items:flex-start}
.i b{font-family:monospace}
.ok{color:#7bc47b}.bad{color:#e07a5f}.warn{color:#e0a94a}
.err{background:rgba(224,122,95,.08);border:1px solid #e07a5f;padding:18px;white-space:pre-wrap;font-size:14px;color:#f0c4b4;margin-bottom:18px;border-radius:2px}
.done{background:rgba(123,196,123,.07);border:1px solid #7bc47b;padding:22px;border-radius:2px}
.cred{background:#0a0908;border:1px solid var(--line);padding:16px;margin:16px 0;font-family:monospace;font-size:15px}
.cred b{color:var(--gold2)}
a.btn{display:block;text-align:center;background:var(--gold);color:#140f08;padding:15px;text-decoration:none;font-family:Cinzel,serif;font-weight:600;letter-spacing:.14em;margin-top:16px;text-transform:uppercase}
.todo{font-size:14px;color:var(--cream);margin-top:6px}
.todo li{margin:7px 0 7px 18px}
</style></head><body><div class="w">

<h1>AEGEA RESERVE</h1>
<div class="sub">KURULUM SİHİRBAZI</div>

<?php if (!$ROOT): ?>
  <div class="err"><b>Site dosyaları bulunamadı.</b>

Bu dosya (kurulum.php), içinde <b>artisan</b> ve <b>vendor/</b> bulunan klasörün
içine ya da onun <b>public</b> klasörüne konulmalı.

Şu an bulunduğu yer:
<?= htmlspecialchars(__DIR__) ?></div>

<?php elseif ($OK): ?>
  <div class="card done">
    <h2 style="color:#7bc47b">✓ KURULUM TAMAMLANDI</h2>
    <?php foreach ($LOG as [$t, $m]): ?>
      <div class="i"><span class="<?= $t ?>"><?= $t === 'ok' ? '✓' : '!' ?></span><span><?= htmlspecialchars($m) ?></span></div>
    <?php endforeach; ?>

    <div class="cred">
      Yönetim paneli: <b><?= htmlspecialchars(rtrim($_POST['app_url'] ?? '', '/')) ?>/yonetim</b><br>
      E-posta: <b><?= htmlspecialchars($_SESSION_ADMIN ?? 'admin@ornek-gurme.com') ?></b><br>
      Şifre: <b>admin123</b>
    </div>

    <div style="color:#e0a94a;font-size:14px"><b>Şimdi sırayla şunları yap:</b></div>
    <ol class="todo">
      <li>Panele gir, <b>Profil</b>'den şifreyi değiştir</li>
      <li><b>Ayarlar</b>'dan gerçek <b>IBAN</b>'ı gir — havale ödemesi buna bağlı</li>
      <li>Telefon, e-posta, adres bilgilerini güncelle</li>
    </ol>

    <a class="btn" href="?bitir=1">KURULUMU BİTİR VE BU DOSYAYI SİL</a>
    <div class="hint" style="text-align:center">Bu butona basmadan siteyi yayında bırakma —
    kurulum dosyası ve veritabanı yedeği sunucudan silinecek.</div>
  </div>

<?php else: ?>

  <?php if ($ERR): ?><div class="err"><b>KURULUM DURDU</b>

<?= htmlspecialchars($ERR) ?></div><?php endif; ?>

  <div class="card">
    <h2>SUNUCU KONTROLÜ</h2>
    <div class="i"><span class="<?= $phpOk ? 'ok' : 'bad' ?>"><?= $phpOk ? '✓' : '✗' ?></span>
      <span>PHP sürümü <b><?= PHP_VERSION ?></b><?= $phpOk ? '' : ' — 8.2+ gerekli, hosting panelinden yükselt' ?></span></div>
    <div class="i"><span class="<?= $extMiss ? 'bad' : 'ok' ?>"><?= $extMiss ? '✗' : '✓' ?></span>
      <span>PHP eklentileri<?= $extMiss ? ' — EKSİK: <b>' . implode(', ', $extMiss) . '</b>' : ' tamam' ?></span></div>
    <div class="i"><span class="<?= $writable ? 'ok' : 'bad' ?>"><?= $writable ? '✓' : '✗' ?></span>
      <span>Ana dizin yazılabilir<?= $writable ? '' : ' — .env yazılamaz, klasöre 755 izni ver' ?></span></div>
    <div class="i"><span class="<?= $hasSql ? 'ok' : 'warn' ?>"><?= $hasSql ? '✓' : '!' ?></span>
      <span>veritabani.sql <?= $hasSql ? 'bulundu (' . round(filesize($sqlFile)/1024) . ' KB)' : 'yok — veritabanını elle kurman gerekecek' ?></span></div>
    <div class="hint">Konum: <?= htmlspecialchars($ROOT) ?></div>
  </div>

  <form method="post">
  <div class="card">
    <h2>VERİTABANI BİLGİLERİ</h2>
    <div class="hint" style="margin-bottom:6px">cPanel &gt; <b>MySQL Veritabanları</b> sayfasından alacaksın.
    <b style="color:#e0a94a">Kullanıcı adı, veritabanı adıyla aynı DEĞİLDİR.</b></div>

    <div class="row">
      <div><label>Sunucu</label>
        <input name="db_host" value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost') ?>" required></div>
      <div><label>Veritabanı adı</label>
        <input name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>" placeholder="orn: agesr_db" required></div>
    </div>
    <label>Veritabanı kullanıcı adı</label>
    <input name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" placeholder="orn: agesr_kullanici" required>
    <div class="hint">cPanel'de "Geçerli Kullanıcılar" listesinde görünen ad. Oluşturduktan sonra
    <b>"Kullanıcıyı Veritabanına Ekle"</b> ile bu veritabanına eklemeyi ve
    <b>TÜM AYRICALIKLAR</b>'ı işaretlemeyi unutma.</div>

    <label>Veritabanı şifresi</label>
    <input name="db_pass" type="text" value="<?= htmlspecialchars($_POST['db_pass'] ?? '') ?>" required>
    <div class="hint">Şifrende <b>#</b> veya boşluk olsa bile sorun değil — doğru şekilde kaydedilir.</div>

    <label>Site adresi</label>
    <input name="app_url" value="<?= htmlspecialchars($_POST['app_url'] ?? $guessUrl) ?>" required>

    <?php if ($hasSql): ?>
    <div class="chk"><input type="checkbox" name="do_import" id="imp" <?= (!$post || !empty($_POST['do_import'])) ? 'checked' : '' ?>>
      <label for="imp" style="margin:0;text-transform:none;letter-spacing:0;color:var(--cream);font-size:14px">
        Veritabanını otomatik yükle <span style="color:var(--mut)">(19 tablo, 10 ürün, ayarlar, admin)</span></label></div>
    <?php endif; ?>
  </div>

  <div class="card">
    <h2>E-POSTA <span style="color:var(--mut);font-weight:400">— isteğe bağlı</span></h2>
    <div class="hint">Boş bırakırsan site çalışır ama <b>sipariş onay maili gönderilmez</b>.
    Sonradan yönetim panelinden de ekleyebilirsin.</div>
    <div class="row">
      <div><label>SMTP sunucu</label><input name="mail_host" placeholder="mail.siteadi.com" value="<?= htmlspecialchars($_POST['mail_host'] ?? '') ?>"></div>
      <div><label>E-posta adresi</label><input name="mail_user" placeholder="info@siteadi.com" value="<?= htmlspecialchars($_POST['mail_user'] ?? '') ?>"></div>
    </div>
    <label>E-posta şifresi</label>
    <input name="mail_pass" type="text" value="<?= htmlspecialchars($_POST['mail_pass'] ?? '') ?>">
  </div>

  <button type="submit">KURULUMU BAŞLAT</button>
  </form>
<?php endif; ?>

</div></body></html>
