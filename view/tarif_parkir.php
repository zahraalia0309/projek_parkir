<?php
include "../model/m_koneksi.php";

/* AMBIL DATA TARIF */
$query = mysqli_query($conn, "SELECT * FROM tb_tarif ORDER BY id_tarif ASC");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$data_tarif = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_tarif[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tarif Parkir - ParkirKu</title>

    <link rel="stylesheet" href="../asset/tarif.css">
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

        <a href="tarif_parkir.php" class="active">
            💰 <span>Tarif Parkir</span>
        </a>

        <a href="area_parkir.php">
            🅿️ <span>Area Parkir</span>
        </a>

        <a href="data_kendaraan.php">
            🚗 <span>Data Kendaraan</span>
        </a>

        <a href="#">
            📝 <span>Log Aktivitas</span>
        </a>

    </nav>

    <a href="login.php" class="logout">
        ↪ <span>Logout</span>
    </a>

</aside>


<!-- MAIN -->
<main class="main">

    <!-- HEADER -->
    <header class="header">

        <div>
            <h1>Tarif Parkir</h1>
            <p>Kelola tarif parkir berdasarkan jenis kendaraan</p>
        </div>

        <div class="profile">
            👤 Admin
        </div>

    </header>


    <!-- CARD -->
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Data Tarif Parkir</h2>
                <p>Daftar tarif parkir yang tersedia</p>
            </div>

            <a href="tambah_tarif.php" class="btn-add">
                + Tambah Tarif
            </a>

        </div>


        <!-- SEARCH -->
        <div class="search">

            <input
                type="text"
                placeholder="Cari jenis kendaraan..."
            >

            <button>
                Cari
            </button>

        </div>


        <!-- TABLE -->
        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kendaraan</th>
                        <th>Tarif Per Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (count($data_tarif) > 0): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data_tarif as $tarif): ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <span class="vehicle">
                                    <?php
                                    if ($tarif['jenis_kendaraan'] == 'motor') {
                                        echo "🏍️";
                                    } elseif ($tarif['jenis_kendaraan'] == 'mobil') {
                                        echo "🚗";
                                    } else {
                                        echo "🚙";
                                    }
                                    ?>

                                    <?= htmlspecialchars($tarif['jenis_kendaraan']); ?>
                                </span>
                            </td>

                            <td>
                                <span class="price">
                                    Rp <?= number_format($tarif['tarif_per_jam'], 0, ',', '.'); ?>
                                </span>
                            </td>

                            <td>

                                <a href="edit_tarif.php?id_tarif=<?= $tarif['id_tarif']; ?>" class="edit">
                                                                               Edit
                                </a>

                                <a href="../controller/c_tarif.php?aksi=hapus&id_tarif=<?= $tarif['id_tarif']; ?>"
                                                        class="delete"  onclick="return confirm('Yakin ingin menghapus tarif ini?');">
                                                                                Hapus
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="4" class="empty">
                            Belum ada data tarif parkir.
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