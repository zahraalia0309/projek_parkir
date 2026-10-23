
<?php

include "../model/m_koneksi.php";

/* =====================================================
   AMBIL DATA KENDARAAN
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT *
     FROM tb_kendaraan
     ORDER BY id_kendaraan ASC"
);

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$data_kendaraan = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_kendaraan[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Kendaraan - ParkirKu</title>

    <link rel="stylesheet" href="../asset/kendaraan.css">

    <style>
        .status-kendaraan {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-kendaraan.aktif {
            color: #15803d;
            background: #dcfce7;
        }

        .status-kendaraan.nonaktif {
            color: #4b5563;
            background: #e5e7eb;
        }

        .aksi-kendaraan {
            white-space: nowrap;
        }

        .aksi-kendaraan a {
            display: inline-block;
            text-decoration: none;
            padding: 7px 10px;
            margin: 2px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .aksi-kendaraan .edit {
            color: #2563eb;
            background: #edf4ff;
        }

        .aksi-kendaraan .nonaktifkan {
            color: #dc2626;
            background: #fff0f0;
        }

        .aksi-kendaraan .aktifkan {
            color: #15803d;
            background: #dcfce7;
        }
    </style>

</head>

<body>

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        🚗 <span>ParkirKu</span>
    </div>

    <div class="admin">

        <div class="avatar">👤</div>

        <div>
            <strong>Admin</strong>
            <small>Administrator</small>
        </div>

    </div>

    <nav>

        <a href="dashboard_admin.php">
            🏠 <span>Dashboard</span>
        </a>

        <a href="kelola_user.php">
            👥 <span>Kelola User</span>
        </a>

        <a href="tarif_parkir.php">
            💰 <span>Tarif Parkir</span>
        </a>

        <a href="area_parkir.php">
            🅿️ <span>Area Parkir</span>
        </a>

        <a href="data_kendaraan.php" class="active">
            🚗 <span>Data Kendaraan</span>
        </a>

        <a href="log_aktivitas.php">
            📝 <span>Log Aktivitas</span>
        </a>

    </nav>

    <a href="login.php" class="logout">
        ↪ <span>Logout</span>
    </a>

</aside>


<!-- MAIN -->

<main class="main">

    <header class="header">

        <div>
            <h1>Data Kendaraan</h1>

            <p>
                Kelola data kendaraan yang terdaftar
            </p>
        </div>

        <div class="profile">
            👤 Admin
        </div>

    </header>


    <section class="card">

        <div class="card-header">

            <div>
                <h2>Data Kendaraan</h2>

                <p>
                    Daftar kendaraan yang terdaftar di sistem
                </p>
            </div>

            <a href="tambah_kendaraan.php" class="btn-add">
                + Tambah Kendaraan
            </a>

        </div>


        <!-- SEARCH -->

        <form method="GET" class="search">

            <input
                type="text"
                name="cari"
                placeholder="Cari plat nomor atau pemilik..."
                value="<?= htmlspecialchars($_GET['cari'] ?? ''); ?>"
            >

            <button type="submit">
                Cari
            </button>

            <?php if (!empty($_GET['cari'])): ?>
                <a href="data_kendaraan.php">Reset</a>
            <?php endif; ?>

        </form>


        <!-- TABLE -->

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Plat Nomor</th>
                        <th>Jenis Kendaraan</th>
                        <th>Warna</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $cari = trim($_GET['cari'] ?? '');
                $no = 1;
                $jumlah_data = 0;
                ?>

                <?php foreach ($data_kendaraan as $kendaraan): ?>

                    <?php
                    $plat = $kendaraan['plat_nomor'] ?? '';
                    $pemilik = $kendaraan['pemilik'] ?? '';

                    if (
                        $cari !== '' &&
                        stripos($plat, $cari) === false &&
                        stripos($pemilik, $cari) === false
                    ) {
                        continue;
                    }

                    $jumlah_data++;

                    $status = $kendaraan['status_kendaraan'] ?? 'aktif';
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td>
                            <span class="plat">
                                <?= htmlspecialchars($plat); ?>
                            </span>
                        </td>

                        <td>
                            <span class="vehicle">

                                <?php
                                if ($kendaraan['jenis_kendaraan'] == 'motor') {
                                    echo "🏍️";
                                } elseif ($kendaraan['jenis_kendaraan'] == 'mobil') {
                                    echo "🚗";
                                } else {
                                    echo "🚙";
                                }
                                ?>

                                <?= htmlspecialchars(
                                    $kendaraan['jenis_kendaraan']
                                ); ?>

                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['warna']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($pemilik); ?>
                        </td>

                        <td>
                            <span class="status-kendaraan <?= $status === 'nonaktif' ? 'nonaktif' : 'aktif'; ?>">
                                <?= $status === 'nonaktif' ? 'Nonaktif' : 'Aktif'; ?>
                            </span>
                        </td>

                        <td class="aksi-kendaraan">

                            <?php if ($status === 'aktif'): ?>

                                <a
                                    href="edit_kendaraan.php?id_kendaraan=<?= (int) $kendaraan['id_kendaraan']; ?>"
                                    class="edit"
                                >
                                    Edit
                                </a>

                                <a
                                    href="../controller/c_kendaraan.php?aksi=nonaktif&id_kendaraan=<?= (int) $kendaraan['id_kendaraan']; ?>"
                                    class="nonaktifkan"
                                    onclick="return confirm('Nonaktifkan kendaraan ini? Kendaraan tidak akan bisa digunakan untuk transaksi baru.');"
                                >
                                    Nonaktifkan
                                </a>

                            <?php else: ?>

                                <a
                                    href="../controller/c_kendaraan.php?aksi=aktifkan&id_kendaraan=<?= (int) $kendaraan['id_kendaraan']; ?>"
                                    class="aktifkan"
                                    onclick="return confirm('Aktifkan kembali kendaraan ini?');"
                                >
                                    Aktifkan Kembali
                                </a>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if ($jumlah_data === 0): ?>

                    <tr>
                        <td colspan="7" class="empty">
                            Data kendaraan tidak ditemukan.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</main>

</body>
</html>
