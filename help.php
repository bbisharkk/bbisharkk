<?php
session_start();

// — ĐA NGÔN NGỮ (vi / en) —
$supported = ['vi','en'];
$lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? 'vi');
if (!in_array($lang, $supported)) $lang = 'vi';
setcookie('lang', $lang, time()+30*24*3600, '/');

$trans = [
  'vi'=>[
    'page_title'    => '🚨 Mất Thẻ ProID',
    'page_subtitle' => 'Thẻ ProID của bạn đã thất lạc – Cần giúp đỡ!',
    'call_now'      => 'Gọi ngay',
    'send_email'    => 'Gửi Email',
    'download_pdf'  => 'Tải PDF',
    'report_found'  => 'Tôi nhặt được thẻ',
    'modal_title'   => 'Thông báo đã nhặt thẻ ProID',
    'field_name'    => 'Họ tên',
    'field_phone'   => 'Số điện thoại',
    'field_location'=> 'Nơi nhặt',
    'field_note'    => 'Ghi chú',
    'submit_report' => 'Gửi báo',
    'alert_success' => 'Cảm ơn bạn đã báo nhặt thẻ. Chủ thẻ sẽ liên hệ ngay!',
    'thank_you'     => 'Xin chân thành cảm ơn!',
    'updated_at'    => '⏱ Cập nhật lúc:',
    'lang_toggle'   => 'EN',
  ],
  'en'=>[
    'page_title'    => '🚨 ProID Card Lost',
    'page_subtitle' => 'Your ProID card is lost – Please help!',
    'call_now'      => 'Call Now',
    'send_email'    => 'Send Email',
    'download_pdf'  => 'Download PDF',
    'report_found'  => 'I Found Card',
    'modal_title'   => 'I Found ProID Card',
    'field_name'    => 'Full Name',
    'field_phone'   => 'Phone Number',
    'field_location'=> 'Location Found',
    'field_note'    => 'Note',
    'submit_report' => 'Submit',
    'alert_success' => 'Thanks for reporting! The owner will contact you shortly.',
    'thank_you'     => 'Thank you very much!',
    'updated_at'    => '⏱ Updated at:',
    'lang_toggle'   => 'VI',
  ],
];
$t = $trans[$lang];

// — Thông tin chủ thẻ —
$cardOwner  = "Trần Văn Thành";
$ownerPhone = "0394454056";
$ownerEmail = "vanwthanhh47@gmail.com";
$lostTime   = "13/04/2025, 10:30";

// — Cấu hình Telegram —
define('TELEGRAM_BOT_TOKEN', '7820574352:AAHs0MihAw0v-M-r4M1YHANSV5png4sCEw8');
define('TELEGRAM_CHAT_ID', '7817786580');

function sendTelegramNotification($message) {
    $url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage";
    $data = [
        'chat_id'    => TELEGRAM_CHAT_ID,
        'text'       => $message,
        'parse_mode' => 'HTML'
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

// — Xử lý báo nhặt thẻ —
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_form'])) {
    $n  = htmlspecialchars($_POST['report_name']);
    $p  = htmlspecialchars($_POST['report_phone']);
    $l  = htmlspecialchars($_POST['report_location']);
    $o  = htmlspecialchars($_POST['report_note']);
    $ts = date('Y-m-d H:i:s');

    // Append to CSV
    $line = implode(",", [$ts, $n, $p, $l, $o]) . PHP_EOL;
    file_put_contents(__DIR__ . '/reports.csv', $line, FILE_APPEND);

    // Telegram notification
    $msg  = "📣 <b>New ProID report</b>\n";
    $msg .= "<b>Time:</b> {$ts}\n";
    $msg .= "<b>Name:</b> {$n}\n";
    $msg .= "<b>Phone:</b> {$p}\n";
    $msg .= "<b>Location:</b> {$l}\n";
    if (strlen(trim($o))) {
        $msg .= "<b>Note:</b> {$o}";
    }
    sendTelegramNotification($msg);

    $_SESSION['report_success'] = true;
    header('Location: ' . $_SERVER['PHP_SELF'] . "?lang={$lang}");
    exit;
}
$success = $_SESSION['report_success'] ?? false;
unset($_SESSION['report_success']);

// — Đọc CSV để hiển thị danh sách báo nhặt —
$reports = [];
if (file_exists(__DIR__ . '/reports.csv')) {
    if (($fh = fopen(__DIR__ . '/reports.csv','r')) !== false) {
        while (($row = fgetcsv($fh)) !== false) {
            if (count($row) >= 4) $reports[] = $row;
        }
        fclose($fh);
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= $t['page_title'] ?> | <?= $cardOwner ?></title>

  <!-- Google Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Spike + AOS -->
  <link href="https://cdn.jsdelivr.net/gh/wrappixel/spike-bootstrap-free@main/src/assets/css/styles.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root { --accent1:#4f46e5;--accent2:#6366f1;--bg-light:#f5f7fa;--bg-dark:#1f2937;--text-light:#1f2937;--text-dark:#f3f4f6;--font:'Poppins',sans-serif; }
    body { font-family:var(--font);margin:0;padding:0;transition:background .5s,color .5s;background:var(--bg-light);color:var(--text-light); }
    body[data-bs-theme="dark"]{ background:var(--bg-dark);color:var(--text-dark); }
    .header { position:fixed;top:0;width:100%;z-index:1001;display:flex;justify-content:flex-end;padding:1rem;background:rgba(255,255,255,0.6); }
    body[data-bs-theme="dark"] .header{ background:rgba(31,41,55,0.7); }
    .header .btn,.header a{ margin-left:.75rem;font-weight:600;width:2.75rem;height:2.75rem;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.8);border-radius:50%;border:none;box-shadow:0 4px 16px rgba(0,0,0,0.1);transition:background .3s;color:inherit; }
    .header .btn:hover,.header a:hover{ background:rgba(255,255,255,1); }
    .container{ max-width:800px;margin:6rem auto 2rem;padding:0 1rem; }
    .alert-success{ margin:1rem auto;max-width:800px;border-radius:1rem; }
    .card{ background:rgba(255,255,255,0.9);border-radius:1.5rem;box-shadow:0 16px 48px rgba(0,0,0,0.1);overflow:hidden;transition:transform .3s; }
    body[data-bs-theme="dark"] .card{ background:rgba(31,41,55,0.85); }
    .card:hover{ transform:translateY(-5px); }
    .hero{ position:relative;background:url('https://img.upanh.tv/2025/04/13/proid.jpg') center/cover no-repeat;height:60vh;display:flex;align-items:center;justify-content:center;color:#fff; }
    .hero-text{ background:rgba(0,0,0,0.6);padding:1.5rem 2rem;border-radius:1rem;text-align:center;max-width:400px; }
    .hero-text h1{ font-size:2.25rem;font-weight:800;margin-bottom:.5rem; }
    .hero-text p{ font-size:1.1rem;margin-bottom:1rem; }
    .btn-modern{ background:linear-gradient(135deg,var(--accent1),var(--accent2));color:#fff;border:none;border-radius:50px;padding:.75rem 1.5rem;box-shadow:0 8px 24px rgba(0,0,0,0.15);transition:transform .3s,box-shadow .3s;font-size:1rem; }
    .btn-modern:hover{ transform:translateY(-3px);box-shadow:0 12px 32px rgba(0,0,0,0.2); }
    .info-list li{ margin-bottom:1rem;display:flex;align-items:center; }
    .info-list i{ margin-right:.5rem; }
    .qr-row{ display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;margin-bottom:1.5rem; }
    .qr-card{ background:rgba(255,255,255,0.8);padding:6px;border-radius:1rem;box-shadow:0 4px 16px rgba(0,0,0,0.1); }
    .qr-card img{ width:80px!important;height:80px!important;border-radius:.75rem; }
    .ratio iframe{ border-radius:1rem; }
    .card-footer{ background:transparent; }
    .card-footer small{ display:block;margin-top:.5rem;color:rgba(0,0,0,0.6); }
    body[data-bs-theme="dark"] .card-footer small{ color:rgba(255,255,255,0.6); }
  </style>
</head>
<body data-bs-theme="<?= $_COOKIE['theme'] ?? 'light' ?>" data-lang="<?= $lang ?>">

  <div class="header">
    <button id="themeToggle" class="btn" title="Chuyển giao diện">
      <i class="bi bi-<?= ($_COOKIE['theme']??'light')==='light'?'brightness-high-fill':'moon-fill'; ?> fs-5"></i>
    </button>
    <a href="?lang=<?= $lang==='vi'?'en':'vi' ?>" class="btn" title="Toggle Language"><?= $t['lang_toggle'] ?></a>
  </div>

  <div class="container">
    <div class="card" data-aos="fade-up">
      <div class="hero" data-aos="zoom-in">
        <div class="hero-text">
          <h1><?= $t['page_title'] ?></h1>
          <p><?= $t['page_subtitle'] ?></p>
          <button class="btn-modern" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="bi bi-flag-fill me-2"></i><?= $t['report_found'] ?>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="row gy-4 align-items-start">
          <div class="col-md-6" data-aos="fade-right">
            <ul class="list-unstyled info-list">
              <li><i class="bi bi-person-fill text-success"></i><strong><?= $t['field_name'] ?>:</strong>&nbsp;<?= $cardOwner ?></li>
              <li><i class="bi bi-telephone-fill text-primary"></i><strong><?= $t['field_phone'] ?>:</strong>&nbsp;<a href="tel:<?= $ownerPhone ?>"><?= $ownerPhone ?></a></li>
              <li><i class="bi bi-envelope-fill text-danger"></i><strong><?= $t['send_email'] ?>:</strong>&nbsp;<a href="mailto:<?= $ownerEmail ?>"><?= $ownerEmail ?></a></li>
              <li><i class="bi bi-clock-fill text-warning"></i><strong><?= $t['updated_at'] ?> </strong><?= $lostTime ?></li>
            </ul>
            <div class="d-flex flex-wrap gap-3 mt-4">
              <a href="tel:<?= $ownerPhone ?>" class="btn-modern flex-grow-1 flex-md-grow-0"><i class="bi bi-telephone-fill me-2"></i><?= $t['call_now'] ?></a>
              <a href="mailto:<?= $ownerEmail ?>" class="btn-modern flex-grow-1 flex-md-grow-0"><i class="bi bi-envelope-fill me-2"></i><?= $t['send_email'] ?></a>
              <button onclick="downloadPDF()" class="btn-modern flex-grow-1 flex-md-grow-0"><i class="bi bi-file-earmark-pdf-fill me-2"></i><?= $t['download_pdf'] ?></button>
            </div>
          </div>

          <div class="col-md-6 text-center" data-aos="fade-left">
            <div class="qr-row">
              <?php foreach ([
                "https://zalo.me/{$ownerPhone}",
                "https://www.facebook.com/tochaocaunha",
                "BEGIN:VCARD%0AVERSION:3.0%0AN:Thành;Trần Văn;;;%0AFN:Trần Văn Thành%0ATEL:{$ownerPhone}%0AEMAIL:{$ownerEmail}%0AEND:VCARD"
              ] as $data): ?>
                <div class="qr-card">
                  <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?=urlencode($data)?>&size=80x80&margin=10&color=79,70,229" alt="QR code">
                </div>
              <?php endforeach; ?>
            </div>
            <div class="ratio ratio-16x9 mt-3" data-aos="zoom-in">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59450.23311721925!2d106.14993857985998!3d21.36470755937533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31356b129ceb44b5%3A0xd06475b7cb350808!2zRMawxqFuZyDEkOG7qWMsIEzhuqFuZyBHaWFuZywgQuG6r2MgR2lhbmcsIFZp4buHdCBOYW0!5e0!3m2!1svi!2sus!4v1745072033600!5m2!1svi!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer text-center" data-aos="fade-up">
        <p class="mb-1"><?= $t['thank_you'] ?></p>
        <small><?= $t['updated_at'] ?> <span id="timestamp"></span></small>
      </div>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success text-center mt-4" role="alert" data-aos="fade-down"><?= $t['alert_success'] ?></div>
    <?php endif; ?>

    <?php if (count($reports) > 0): ?>
      <h3 class="mt-5" data-aos="fade-up"><?= $lang==='vi'?'Danh sách báo nhặt thẻ':'Report List' ?></h3>
      <div class="table-responsive" data-aos="fade-up">
        <table class="table table-striped">
          <thead><tr><th>Thời gian</th><th><?= $t['field_name'] ?></th><th><?= $t['field_phone'] ?></th><th><?= $t['field_location'] ?></th><th><?= $t['field_note'] ?></th></tr></thead>
          <tbody><?php foreach ($reports as $r): ?><tr><td><?=htmlspecialchars($r[0])?></td><td><?=htmlspecialchars($r[1])?></td><td><?=htmlspecialchars($r[2])?></td><td><?=htmlspecialchars($r[3])?></td><td><?=htmlspecialchars($r[4]??'')?></td></tr><?php endforeach; ?></tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

  <!-- Modal Báo nhặt thẻ -->
  <div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title"><?= $t['modal_title'] ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <form method="POST">
            <input type="hidden" name="report_form" value="1">
            <div class="mb-3"><label class="form-label"><?= $t['field_name'] ?></label><input type="text" name="report_name" class="form-control" required></div>
            <div class="mb-3"><label class="form-label"><?= $t['field_phone'] ?></label><input type="tel" name="report_phone" class="form-control" required></div>
            <div class="mb-3"><label class="form-label"><?= $t['field_location'] ?></label><input type="text" name="report_location" class="form-control" required></div>
            <div class="mb-3"><label class="form-label"><?= $t['field_note'] ?></label><textarea name="report_note" class="form-control" rows="3"></textarea></div>
            <button type="submit" class="btn-modern w-100"><?= $t['submit_report'] ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/gh/wrappixel/spike-bootstrap-free@main/src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/wrappixel/spike-bootstrap-free@main/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/wrappixel/spike-bootstrap-free@main/src/assets/js/app.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ once:true });
    function updateTimestamp(){ const now=new Date(); const opts={weekday:'long',day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'}; document.getElementById('timestamp').textContent=now.toLocaleString('<?= $lang==='vi'?'vi-VN':'en-US' ?>',opts);} updateTimestamp();
    function downloadPDF(){ const card=document.querySelector('.card').outerHTML; const orig=document.body.innerHTML; document.body.innerHTML=card; window.print(); document.body.innerHTML=orig; updateTimestamp(); location.reload(); }
    document.getElementById('themeToggle').addEventListener('click',()=>{ const cur=document.body.getAttribute('data-bs-theme'); const nxt=cur==='light'?'dark':'light'; document.body.setAttribute('data-bs-theme',nxt); document.cookie='theme='+nxt+'; path=/; max-age='+30*24*3600; document.querySelector('#themeToggle i').className=`bi bi-${nxt==='light'?'brightness-high-fill':'moon-fill'} fs-5`; });
  </script>
</body>
</html>
