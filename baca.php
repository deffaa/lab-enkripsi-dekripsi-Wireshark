<?php
$key = hash('sha256', 'KunciRahasiaLab2026', true);
$conn = new mysqli('localhost', 'root', '', 'lab_enkripsi');
$res = $conn->query("SELECT * FROM data_rahasia ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Hasil Dekripsi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="top">
    <strong>Lab Enkripsi AES-256</strong>
    <nav><a href="index.html">Simpan data</a><a href="baca.php">Lihat data</a></nav>
  </header>
  <main>
    <h1>Data hasil dekripsi</h1>
    <p class="lead">Kolom kuning adalah isi database. Kolom hijau adalah hasil dekripsi di server.</p>
    <div class="table-wrap">
      <table>
        <tr><th>ID</th><th>Ciphertext (di database)</th><th>Plaintext (hasil dekripsi)</th><th>Waktu</th></tr>
        <?php if ($res->num_rows === 0): ?>
          <tr><td colspan="4" class="empty">Belum ada data. Simpan data dulu di halaman utama.</td></tr>
        <?php endif; ?>
        <?php while ($row = $res->fetch_assoc()):
          $plain = openssl_decrypt(base64_decode($row['isi_terenkripsi']), 'AES-256-CBC',
                   $key, OPENSSL_RAW_DATA, base64_decode($row['iv'])); ?>
          <tr>
            <td><?= (int)$row['id'] ?></td>
            <td class="cipher mono"><?= htmlspecialchars($row['isi_terenkripsi']) ?></td>
            <td class="plain"><?= htmlspecialchars($plain) ?></td>
            <td><?= htmlspecialchars($row['waktu']) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
    <div class="actions"><a class="btn" href="index.html">Simpan data baru</a></div>
  </main>
</body>
</html>
