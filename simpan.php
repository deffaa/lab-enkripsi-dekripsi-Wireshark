<?php
$key = hash('sha256', 'KunciRahasiaLab2026', true); // kunci 256-bit
$iv  = random_bytes(16);
$plain = $_POST['isi'] ?? '';

$cipher = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
$c = base64_encode($cipher);
$i = base64_encode($iv);

$conn = new mysqli('localhost', 'root', '', 'lab_enkripsi');
$stmt = $conn->prepare("INSERT INTO data_rahasia (isi_terenkripsi, iv) VALUES (?, ?)");
$stmt->bind_param('ss', $c, $i);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Tersimpan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="top">
    <strong>Lab Enkripsi AES-256</strong>
    <nav><a href="index.html">Simpan data</a><a href="baca.php">Lihat data</a></nav>
  </header>
  <main>
    <h1>Data tersimpan</h1>
    <p class="lead">Server mengenkripsi data Anda dengan AES-256-CBC. Ini yang tersimpan di database:</p>
    <section class="card">
      <div class="result mono"><?= htmlspecialchars($c) ?></div>
      <div class="actions">
        <a class="btn" href="baca.php">Lihat hasil dekripsi</a>
        <a class="btn ghost" href="index.html">Simpan data lain</a>
      </div>
    </section>
  </main>
</body>
</html>
