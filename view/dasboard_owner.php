<?php

include "../model/m_koneksi.php";


/* =====================================================
   JUMLAH KENDARAAN YANG SEDANG PARKIR
===================================================== */

$query_parkir = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi
     WHERE status = 'masuk'"
);

$data_parkir = mysqli_fetch_assoc($query_parkir);
$total_parkir = $data_parkir['total'];


/* =====================================================
   JUMLAH TRANSAKSI SELESAI
===================================================== */

$query_selesai = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi
     WHERE status = 'keluar'"
);

$data_selesai = mysqli_fetch_assoc($query_selesai);
$total_selesai = $data_selesai['total'];


/* =====================================================
   TOTAL PENDAPATAN
===================================================== */

$query_pendapatan = mysqli_query(
    $conn,
    "SELECT SUM(biaya_total) AS total
     FROM tb_transaksi
     WHERE status = 'keluar'"
);

$data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $data_pendapatan['total'] ?? 0;


/* =====================================================
   JUMLAH AREA
===================================================== */

$query_area = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_area_parkir"
);

$data_area = mysqli_fetch_assoc($query_area);
$total_area = $data_area['total'];


/* =====================================================
   TOTAL KENDARAAN TERDAFTAR
===================================================== */

$query_kendaraan = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_kendaraan"
);

$data_kendaraan = mysqli_fetch_assoc($query_kendaraan);
$total_kendaraan = $data_kendaraan['total'];


/* =====================================================
   DATA AREA PARKIR
===================================================== */

$query_area_list = mysqli_query(
    $conn,
    "SELECT
        id_area,
        nama_area,
        kapasitas,
        terisi
     FROM tb_area_parkir
     ORDER BY id_area ASC"
);

if (!$query_area_list) {
    die("Query area gagal: " . mysqli_error($conn));
}


/* =====================================================
   TRANSAKSI TERBARU
===================================================== */

$query_transaksi = mysqli_query(
    $conn,
    "SELECT
        t.id_parkir,
        t.waktu_masuk,
        t.waktu_keluar,
        t.biaya_total,
        t.status,
        k.plat_nomor,
        k.jenis_kendaraan,
        a.nama_area
     FROM tb_transaksi t

     LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan

     LEFT JOIN tb_area_parkir a
        ON t.id_area = a.id_area

     ORDER BY t.id_parkir DESC
     LIMIT 5"
);

if (!$query_transaksi) {
    die("Query transaksi gagal: " . mysqli_error($conn));
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

    <title>Dashboard Owner - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/dasboard_owner.css"
    >

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">


    <div class="logo">

        🚗
        <span>ParkirKu</span>

    </div>


    <div class="admin">

        <div class="avatar">
            👤
        </div>

        <div>

            <strong>
                Owner
            </strong>

            <small>
                Pemilik Parkir
            </small>

        </div>

    </div>


    <nav>


        <a
            href="dashboard_owner.php"
            class="active"
        >

            🏠
            <span>Dashboard</span>

        </a>


        <a href="laporan_owner.php">

            📊
            <span>Laporan</span>

        </a>


        <a href="transaksi_owner.php">

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



<!-- =====================================================
     MAIN
===================================================== -->

<main class="main">


    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>
                Dashboard Owner
            </h1>

            <p>
                Ringkasan kondisi dan aktivitas parkir
            </p>

        </div>


        <div class="profile">

            👤 Owner

        </div>

    </header>



    <!-- =====================================================
         STATISTIK
    ===================================================== -->

    <section class="stats">


        <!-- PARKIR -->

        <div class="stat-card">

            <div class="stat-icon blue">
                🚗
            </div>

            <div>

                <span>
                    Sedang Parkir
                </span>

                <strong>
                    <?= $total_parkir; ?>
                </strong>

                <small>
                    kendaraan
                </small>

            </div>

        </div>



        <!-- TRANSAKSI -->

        <div class="stat-card">

            <div class="stat-icon green">
                🧾
            </div>

            <div>

                <span>
                    Transaksi Selesai
                </span>

                <strong>
                    <?= $total_selesai; ?>
                </strong>

                <small>
                    transaksi
                </small>

            </div>

        </div>



        <!-- PENDAPATAN -->

        <div class="stat-card">

            <div class="stat-icon orange">
                💰
            </div>

            <div>

                <span>
                    Total Pendapatan
                </span>

                <strong>
                    Rp <?= number_format(
                        $total_pendapatan,
                        0,
                        ',',
                        '.'
                    ); ?>
                </strong>

                <small>
                    transaksi selesai
                </small>

            </div>

        </div>



        <!-- AREA -->

        <div class="stat-card">

            <div class="stat-icon purple">
                🅿️
            </div>

            <div>

                <span>
                    Area Parkir
                </span>

                <strong>
                    <?= $total_area; ?>
                </strong>

                <small>
                    area
                </small>

            </div>

        </div>


    </section>



    <!-- =====================================================
         AREA PARKIR
    ===================================================== -->

    <section class="content-card">


        <div class="card-header">

            <div>

                <h2>
                    Kondisi Area Parkir
                </h2>

                <p>
                    Kondisi slot parkir saat ini
                </p>

            </div>

        </div>



        <div class="area-grid">


            <?php while ($area = mysqli_fetch_assoc($query_area_list)): ?>

                <?php

                $kapasitas = (int) $area['kapasitas'];
                $terisi = (int) $area['terisi'];

                $tersedia = $kapasitas - $terisi;


                if ($tersedia <= 0) {

                    $status_area = "Penuh";
                    $status_class = "penuh";

                } elseif ($tersedia <= 1) {

                    $status_area = "Hampir Penuh";
                    $status_class = "hampir";

                } else {

                    $status_area = "Tersedia";
                    $status_class = "tersedia";

                }

                ?>

                <div class="area-card">


                    <div class="area-top">

                        <strong>
                            🅿️
                            <?= htmlspecialchars(
                                $area['nama_area']
                            ); ?>
                        </strong>

                        <span class="<?= $status_class; ?>">

                            <?= $status_area; ?>

                        </span>

                    </div>


                    <div class="area-info">

                        <div>

                            <small>
                                Kapasitas
                            </small>

                            <strong>
                                <?= $kapasitas; ?> slot
                            </strong>

                        </div>


                        <div>

                            <small>
                                Terisi
                            </small>

                            <strong>
                                <?= $terisi; ?> slot
                            </strong>

                        </div>


                        <div>

                            <small>
                                Tersedia
                            </small>

                            <strong class="tersedia-text">
                                <?= $tersedia; ?> slot
                            </strong>

                        </div>

                    </div>


                </div>

            <?php endwhile; ?>


        </div>


    </section>



    <!-- =====================================================
         TRANSAKSI TERBARU
    ===================================================== -->

    <section class="content-card">


        <div class="card-header">

            <div>

                <h2>
                    Transaksi Terbaru
                </h2>

                <p>
                    Lima transaksi terakhir
                </p>

            </div>

        </div>



        <div class="table-wrapper">


            <table>


                <thead>

                    <tr>

                        <th>No</th>

                        <th>Plat Nomor</th>

                        <th>Jenis</th>

                        <th>Area</th>

                        <th>Waktu Masuk</th>

                        <th>Status</th>

                        <th>Biaya</th>

                    </tr>

                </thead>


                <tbody>


                <?php

                $no = 1;

                if (mysqli_num_rows($query_transaksi) > 0):

                ?>

                    <?php while ($transaksi = mysqli_fetch_assoc($query_transaksi)): ?>

                        <tr>


                            <td>
                                <?= $no++; ?>
                            </td>


                            <td>

                                <span class="plat">

                                    <?= htmlspecialchars(
                                        $transaksi['plat_nomor'] ?? '-'
                                    ); ?>

                                </span>

                            </td>


                            <td>

                                <?php

                                if (
                                    $transaksi['jenis_kendaraan']
                                    == 'motor'
                                ) {

                                    echo "🏍️ Motor";

                                } elseif (
                                    $transaksi['jenis_kendaraan']
                                    == 'mobil'
                                ) {

                                    echo "🚗 Mobil";

                                } else {

                                    echo "🚙 Lainnya";

                                }

                                ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['nama_area'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['waktu_masuk'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <?php if (
                                    $transaksi['status']
                                    == 'masuk'
                                ): ?>

                                    <span class="status masuk">
                                        Masuk
                                    </span>

                                <?php else: ?>

                                    <span class="status keluar">
                                        Keluar
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                Rp
                                <?= number_format(
                                    $transaksi['biaya_total'] ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </td>


                        </tr>

                    <?php endwhile; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="7"
                            class="empty"
                        >

                            Belum ada transaksi.

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