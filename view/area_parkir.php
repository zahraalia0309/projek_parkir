
<?php
include "../model/m_koneksi.php";

$cari = trim($_GET['cari'] ?? '');

$query = mysqli_query(
    $conn,
    "SELECT * FROM tb_area_parkir ORDER BY id_area ASC"
);

$data_area = [];

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        if (
            $cari === '' ||
            stripos($row['nama_area'], $cari) !== false
        ) {
            $data_area[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Parkir - ParkirKu</title>
    <link rel="stylesheet" href="../asset/area.css">
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

        <a href="area_parkir.php" class="active">
            🅿️ <span>Area Parkir</span>
        </a>

        <a href="data_kendaraan.php">
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

    <!-- HEADER -->
    <header class="header">
        <div>
            <h1>Area Parkir</h1>
            <p>Kelola area dan kapasitas parkir</p>
        </div>

        <div class="profile">
            👤 Admin
        </div>
    </header>

    <!-- CARD -->
    <section class="card">

        <div class="card-header">
            <div>
                <h2>Data Area Parkir</h2>
                <p>Daftar area parkir dan status penggunaannya</p>
            </div>

            <a href="tambah_area.php" class="btn-add">
                + Tambah Area
            </a>
        </div>

        <!-- PENCARIAN PHP -->
        <form method="GET" action="area_parkir.php" class="search">

            <input
                type="text"
                name="cari"
                placeholder="Cari nama area..."
                value="<?= htmlspecialchars($cari); ?>"
            >

            <button type="submit">Cari</button>

            <?php if ($cari !== '') : ?>
                <a href="area_parkir.php">Reset</a>
            <?php endif; ?>

        </form>

        <!-- TABEL AREA -->
        <div class="table-wrapper">

            <table id="areaTable">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Area</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Tersedia</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($data_area)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data_area as $area) : ?>

                        <?php
                        $id_area = (int) $area['id_area'];
                        $kapasitas = (int) $area['kapasitas'];
                        $terisi = (int) $area['terisi'];

                        $tersedia = max(0, $kapasitas - $terisi);

                        $status_area = $area['status_area'] ?? 'aktif';

                        if ($status_area === 'nonaktif') {
                            $status = 'Nonaktif';
                            $status_class = 'nonaktif';
                        } elseif ($tersedia <= 0) {
                            $status = 'Penuh';
                            $status_class = 'penuh';
                        } elseif ($tersedia <= 2) {
                            $status = 'Hampir Penuh';
                            $status_class = 'hampir';
                        } else {
                            $status = 'Tersedia';
                            $status_class = 'tersedia';
                        }
                        ?>

                        <tr>
                            <td><?= $no++; ?></td>

                            <td>
                                <span class="area-name">
                                    🅿️
                                    <?= htmlspecialchars($area['nama_area']); ?>
                                </span>
                            </td>

                            <td><?= $kapasitas; ?> slot</td>

                            <td><?= $terisi; ?> slot</td>

                            <td>
                                <span class="available">
                                    <?= $tersedia; ?> slot
                                </span>
                            </td>

                            <td>
                                <span class="status <?= $status_class; ?>">
                                    ● <?= $status; ?>
                                </span>
                            </td>

                            <td class="aksi">

                                <a
                                    href="edit_area.php?id_area=<?= $id_area; ?>"
                                    class="edit"
                                >
                                    Edit
                                </a>

                                <?php if ($status_area === 'aktif') : ?>

                                    <a
                                        href="../controller/c_area.php?aksi=nonaktif&id_area=<?= $id_area; ?>"
                                        class="delete"
                                        onclick="return confirm('Yakin ingin menonaktifkan area ini?');"
                                    >
                                        Nonaktifkan
                                    </a>

                                <?php else : ?>

                                    <a
                                        href="../controller/c_area.php?aksi=aktifkan&id_area=<?= $id_area; ?>"
                                        class="edit"
                                        onclick="return confirm('Aktifkan kembali area ini?');"
                                    >
                                        Aktifkan Kembali
                                    </a>

                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="7" class="empty">
                            <?php if ($cari !== '') : ?>
                                Area dengan nama "<?= htmlspecialchars($cari); ?>" tidak ditemukan.
                            <?php else : ?>
                                Belum ada data area parkir.
                            <?php endif; ?>
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
