
<?php

include "../model/m_koneksi.php";

/* =====================================================
   AMBIL DATA KENDARAAN
===================================================== */

$query_kendaraan = mysqli_query(
    $conn,
    "SELECT
        id_kendaraan,
        plat_nomor,
        jenis_kendaraan,
        warna,
        pemilik
     FROM tb_kendaraan
     ORDER BY plat_nomor ASC"
);

if (!$query_kendaraan) {
    die("Query kendaraan gagal: " . mysqli_error($conn));
}


/* =====================================================
   AMBIL DATA AREA PARKIR YANG AKTIF
===================================================== */

$query_area = mysqli_query(
    $conn,
    "SELECT
        id_area,
        nama_area,
        kapasitas,
        terisi
     FROM tb_area_parkir
     WHERE status_area = 'aktif'
     ORDER BY id_area ASC"
);

if (!$query_area) {
    die("Query area gagal: " . mysqli_error($conn));
}


/* =====================================================
   AMBIL DATA PETUGAS AKTIF
===================================================== */

$query_petugas = mysqli_query(
    $conn,
    "SELECT
        id_user,
        nama_lengkap
     FROM tb_user
     WHERE role = 'petugas'
     AND status_aktif = 1
     ORDER BY nama_lengkap ASC"
);

if (!$query_petugas) {
    die("Query petugas gagal: " . mysqli_error($conn));
}


/* =====================================================
   AMBIL DATA TARIF
===================================================== */

$query_tarif = mysqli_query(
    $conn,
    "SELECT
        id_tarif,
        jenis_kendaraan,
        tarif_per_jam
     FROM tb_tarif
     ORDER BY id_tarif ASC"
);

if (!$query_tarif) {
    die("Query tarif gagal: " . mysqli_error($conn));
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

    <title>Tambah Transaksi - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/tambah_transaksi.css"
    >

</head>

<body>

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        🚗 <span>ParkirKu</span>
    </div>

    <div class="admin">

        <div class="avatar">
            👤
        </div>

        <div>
            <strong>Petugas</strong>

            <small>
                Petugas Parkir
            </small>
        </div>

    </div>

    <nav>

        <a href="dasboard_petugas.php">
            🏠
            <span>Dashboard</span>
        </a>

        <a
            href="transaksi.php"
            class="active"
        >
            🧾
            <span>Transaksi</span>
        </a>

    </nav>

    <a
        href="../controller/c_logout.php"
        class="logout"
    >
        ↪
        <span>Logout</span>
    </a>

</aside>


<!-- MAIN -->

<main class="main">

    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>
                Tambah Transaksi
            </h1>

            <p>
                Tambahkan kendaraan yang masuk parkir
            </p>

        </div>

        <div class="profile">
            👤 Petugas
        </div>

    </header>


    <!-- CARD -->

    <section class="card">

        <div class="card-header">

            <div>

                <h2>
                    Form Transaksi Parkir
                </h2>

                <p>
                    Silakan isi data kendaraan yang masuk
                </p>

            </div>

        </div>


        <!-- FORM -->

        <form
            action="../controller/c_transaksi.php"
            method="POST"
        >

            <!-- KENDARAAN -->

            <div class="form-group">

                <label for="id_kendaraan">
                    Kendaraan
                </label>

                <select
                    name="id_kendaraan"
                    id="id_kendaraan"
                    required
                >

                    <option value="">
                        -- Pilih Kendaraan --
                    </option>

                    <?php while ($kendaraan = mysqli_fetch_assoc($query_kendaraan)): ?>

                        <option
                            value="<?= $kendaraan['id_kendaraan']; ?>"
                        >

                            <?= htmlspecialchars($kendaraan['plat_nomor']); ?>
                            -
                            <?= htmlspecialchars($kendaraan['jenis_kendaraan']); ?>
                            -
                            <?= htmlspecialchars($kendaraan['pemilik']); ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <!-- AREA PARKIR AKTIF -->

            <div class="form-group">

                <label for="id_area">
                    Area Parkir
                </label>

                <select
                    name="id_area"
                    id="id_area"
                    required
                >

                    <option value="">
                        -- Pilih Area Parkir --
                    </option>

                    <?php while ($area = mysqli_fetch_assoc($query_area)): ?>

                        <option
                            value="<?= $area['id_area']; ?>"
                            <?= ((int) $area['terisi'] >= (int) $area['kapasitas']) ? 'disabled' : ''; ?>
                        >

                            <?= htmlspecialchars($area['nama_area']); ?>
                            -
                            Kapasitas:
                            <?= (int) $area['kapasitas']; ?>
                            -
                            Terisi:
                            <?= (int) $area['terisi']; ?>

                            <?= ((int) $area['terisi'] >= (int) $area['kapasitas']) ? '- PENUH' : ''; ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <!-- PETUGAS -->

            <div class="form-group">

                <label for="id_user">
                    Petugas
                </label>

                <select
                    name="id_user"
                    id="id_user"
                    required
                >

                    <option value="">
                        -- Pilih Petugas --
                    </option>

                    <?php while ($petugas = mysqli_fetch_assoc($query_petugas)): ?>

                        <option
                            value="<?= $petugas['id_user']; ?>"
                        >

                            <?= htmlspecialchars(
                                $petugas['nama_lengkap']
                            ); ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <!-- INFO WAKTU -->

            <div class="info-box">

                <div>

                    <span>
                        Waktu Masuk
                    </span>

                    <strong>
                        Otomatis saat transaksi disimpan
                    </strong>

                </div>

                <div>

                    <span>
                        Status
                    </span>

                    <strong class="status">
                        Masuk
                    </strong>

                </div>

            </div>


            <!-- BUTTON -->

            <div class="form-actions">

                <a
                    href="transaksi.php"
                    class="btn-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    name="tambah"
                    class="btn-save"
                >
                    Simpan Transaksi
                </button>

            </div>

        </form>

    </section>

</main>

</body>

</html>
