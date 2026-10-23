
<?php
include "../model/m_koneksi.php";

// Cek ID transaksi
if (!isset($_GET['id_parkir']) || empty($_GET['id_parkir'])) {
    die("ID transaksi tidak ditemukan.");
}

$id_parkir = intval($_GET['id_parkir']);

// Ambil data transaksi
$query = mysqli_query($conn, "
    SELECT
        t.id_parkir,
        t.id_kendaraan,
        t.waktu_masuk,
        t.waktu_keluar,
        t.id_tarif,
        t.durasi_jam,
        t.biaya_total,
        t.status,
        t.id_user,
        t.id_area,
        k.plat_nomor,
        k.jenis_kendaraan,
        k.warna,
        k.pemilik,
        a.nama_area,
        u.nama_lengkap,
        tr.jenis_kendaraan AS jenis_tarif,
        tr.tarif_per_jam
    FROM tb_transaksi t
    LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan
    LEFT JOIN tb_area_parkir a
        ON t.id_area = a.id_area
    LEFT JOIN tb_user u
        ON t.id_user = u.id_user
    LEFT JOIN tb_tarif tr
        ON t.id_tarif = tr.id_tarif
    WHERE t.id_parkir = $id_parkir
");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

if (mysqli_num_rows($query) == 0) {
    die("Data transaksi tidak ditemukan.");
}

$transaksi = mysqli_fetch_assoc($query);

// Icon kendaraan
if ($transaksi['jenis_kendaraan'] == 'motor') {
    $icon_kendaraan = "🏍️";
} elseif ($transaksi['jenis_kendaraan'] == 'mobil') {
    $icon_kendaraan = "🚗";
} else {
    $icon_kendaraan = "🚙";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - ParkirKu</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #172b4d;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 243px;
            height: 100vh;
            background: #19345d;
            color: white;
            padding: 20px;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .admin {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #2c4c78;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #49698f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin strong {
            display: block;
            font-size: 15px;
        }

        .admin small {
            color: #d8e2f0;
            font-size: 12px;
        }

        nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 15px;
        }

        nav a:hover {
            background: #2c4c78;
        }

        nav a.active {
            background: #287be8;
        }

        .logout {
            position: absolute;
            bottom: 30px;
            left: 20px;
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        /* MAIN */
        .main {
            margin-left: 243px;
            padding: 25px 38px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
        }

        .header p {
            margin-top: 5px;
            color: #718096;
        }

        .profile {
            background: white;
            padding: 14px 25px;
            border-radius: 10px;
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-header h2 {
            margin: 0;
            font-size: 21px;
        }

        .card-header p {
            margin: 5px 0 0;
            color: #718096;
        }

        /* STATUS */
        .status {
            padding: 9px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-masuk {
            background: #fff3cd;
            color: #946200;
        }

        .status-keluar {
            background: #d1fae5;
            color: #087443;
        }

        /* SECTION */
        .section {
            padding: 25px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .section:last-of-type {
            border-bottom: none;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info {
            background: #f8fafc;
            padding: 17px;
            border-radius: 10px;
        }

        .label {
            display: block;
            color: #718096;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .value {
            font-size: 15px;
            font-weight: bold;
        }

        /* TOTAL BIAYA */
        .total-box {
            margin-top: 20px;
            background: #eef5ff;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 15px;
            color: #526581;
        }

        .total {
            font-size: 23px;
            font-weight: bold;
            color: #287be8;
        }

        /* TOMBOL KEMBALI */
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back {
            background: #e9eef5;
            color: #334155;
        }

        .btn-back:hover {
            background: #dce4ef;
        }

        /* RESPONSIVE */
        @media (max-width: 800px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 20px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="logo">
        🚗 ParkirKu
    </div>

    <div class="admin">
        <div class="avatar">👤</div>

        <div>
            <strong>Petugas</strong>
            <small>Petugas Parkir</small>
        </div>
    </div>

    <nav>
        <a href="dasboard_petugas.php">
            🏠 Dashboard
        </a>

        <a href="transaksi.php" class="active">
            🧾 Transaksi
        </a>

        <a href="cetak_struk.php">
            🖨️ Cetak Struk
        </a>
    </nav>

    <a href="../controller/c_logout.php" class="logout">
        ↪ Logout
    </a>

</aside>

<!-- MAIN -->
<main class="main">

    <!-- HEADER -->
    <header class="header">
        <div>
            <h1>Detail Transaksi</h1>
            <p>Informasi lengkap transaksi parkir</p>
        </div>

        <div class="profile">
            👤 Petugas
        </div>
    </header>

    <!-- DETAIL TRANSAKSI -->
    <section class="card">

        <div class="card-header">
            <div>
                <h2>
                    Transaksi #<?= $transaksi['id_parkir']; ?>
                </h2>

                <p>Detail kendaraan dan transaksi parkir</p>
            </div>

            <?php if ($transaksi['status'] == 'masuk'): ?>
                <span class="status status-masuk">
                    Masuk
                </span>
            <?php else: ?>
                <span class="status status-keluar">
                    Keluar
                </span>
            <?php endif; ?>
        </div>

        <!-- DATA KENDARAAN -->
        <div class="section">

            <div class="section-title">
                🚗 Data Kendaraan
            </div>

            <div class="grid">

                <div class="info">
                    <span class="label">Plat Nomor</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['plat_nomor'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Jenis Kendaraan</span>
                    <span class="value">
                        <?= $icon_kendaraan; ?>
                        <?= htmlspecialchars($transaksi['jenis_kendaraan'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Warna</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['warna'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Pemilik</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['pemilik'] ?? '-'); ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- DATA PARKIR -->
        <div class="section">

            <div class="section-title">
                🅿️ Data Parkir
            </div>

            <div class="grid">

                <div class="info">
                    <span class="label">Area Parkir</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['nama_area'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Petugas</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['nama_lengkap'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Waktu Masuk</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['waktu_masuk'] ?? '-'); ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Waktu Keluar</span>
                    <span class="value">
                        <?php
                        if (empty($transaksi['waktu_keluar'])) {
                            echo "-";
                        } else {
                            echo htmlspecialchars($transaksi['waktu_keluar']);
                        }
                        ?>
                    </span>
                </div>

                <div class="info">
                    <span class="label">Durasi Parkir</span>
                    <span class="value">
                        <?= htmlspecialchars($transaksi['durasi_jam'] ?? 0); ?>
                        jam
                    </span>
                </div>

                <div class="info">
                    <span class="label">Tarif Per Jam</span>
                    <span class="value">
                        Rp <?= number_format(
                            $transaksi['tarif_per_jam'] ?? 0,
                            0,
                            ',',
                            '.'
                        ); ?>
                    </span>
                </div>

            </div>

            <!-- TOTAL BIAYA -->
            <div class="total-box">
                <span class="total-label">
                    Total Biaya Parkir
                </span>

                <span class="total">
                    Rp <?= number_format(
                        $transaksi['biaya_total'] ?? 0,
                        0,
                        ',',
                        '.'
                    ); ?>
                </span>
            </div>

        </div>

        <!-- HANYA TOMBOL KEMBALI -->
        <div class="actions">
            <a href="transaksi.php" class="btn btn-back">
                ← Kembali
            </a>
        </div>

    </section>

</main>

</body>
</html>