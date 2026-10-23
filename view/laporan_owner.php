<?php

include "../model/m_koneksi.php";


/* =====================================================
   FILTER TANGGAL
===================================================== */

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';


$where = "WHERE t.status = 'keluar'";


if (!empty($tanggal_mulai)) {

    $tanggal_mulai_db = mysqli_real_escape_string(
        $conn,
        $tanggal_mulai
    );

    $where .= " AND DATE(t.waktu_keluar) >= '$tanggal_mulai_db'";
}


if (!empty($tanggal_selesai)) {

    $tanggal_selesai_db = mysqli_real_escape_string(
        $conn,
        $tanggal_selesai
    );

    $where .= " AND DATE(t.waktu_keluar) <= '$tanggal_selesai_db'";
}


/* =====================================================
   TOTAL TRANSAKSI
===================================================== */

$query_total = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi t
     $where"
);

$data_total = mysqli_fetch_assoc($query_total);
$total_transaksi = $data_total['total'] ?? 0;


/* =====================================================
   TOTAL PENDAPATAN
===================================================== */

$query_pendapatan = mysqli_query(
    $conn,
    "SELECT SUM(t.biaya_total) AS total
     FROM tb_transaksi t
     $where"
);

$data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $data_pendapatan['total'] ?? 0;


/* =====================================================
   TOTAL MOTOR
===================================================== */

$query_motor = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi t
     LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan
     $where
     AND k.jenis_kendaraan = 'motor'"
);

$data_motor = mysqli_fetch_assoc($query_motor);
$total_motor = $data_motor['total'] ?? 0;


/* =====================================================
   TOTAL MOBIL
===================================================== */

$query_mobil = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi t
     LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan
     $where
     AND k.jenis_kendaraan = 'mobil'"
);

$data_mobil = mysqli_fetch_assoc($query_mobil);
$total_mobil = $data_mobil['total'] ?? 0;


/* =====================================================
   DATA TRANSAKSI
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT
        t.id_parkir,
        t.waktu_masuk,
        t.waktu_keluar,
        t.durasi_jam,
        t.biaya_total,
        t.status,

        k.plat_nomor,
        k.jenis_kendaraan,

        a.nama_area,

        u.nama_lengkap

     FROM tb_transaksi t

     LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan

     LEFT JOIN tb_area_parkir a
        ON t.id_area = a.id_area

     LEFT JOIN tb_user u
        ON t.id_user = u.id_user

     $where

     ORDER BY t.id_parkir DESC"
);


if (!$query) {

    die(
        "Query laporan gagal: "
        . mysqli_error($conn)
    );

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

    <title>Laporan - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/laporan_owner.css"
    >

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">


    <div class="logo">

        🚗 <span>ParkirKu</span>

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


        <a href="dashoard_owner.php">

            🏠
            <span>Dashboard</span>

        </a>


        <a
            href="laporan_owner.php"
            class="active"
        >

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
                Laporan Parkir
            </h1>

            <p>
                Laporan transaksi dan pendapatan parkir
            </p>

        </div>


        <div class="profile">

            👤 Owner

        </div>


    </header>



    <!-- =====================================================
         FILTER
    ===================================================== -->

    <section class="filter-card">


        <div>

            <h2>
                Filter Laporan
            </h2>

            <p>
                Pilih periode laporan
            </p>

        </div>


        <form
            method="GET"
            action="laporan_owner.php"
            class="filter-form"
        >


            <div>

                <label>
                    Dari
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="<?= htmlspecialchars($tanggal_mulai); ?>"
                >

            </div>


            <div>

                <label>
                    Sampai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="<?= htmlspecialchars($tanggal_selesai); ?>"
                >

            </div>


            <button
                type="submit"
                class="btn-filter"
            >

                Tampilkan

            </button>


            <a
                href="laporan_owner.php"
                class="btn-reset"
            >

                Reset

            </a>


            <button
                type="button"
                onclick="window.print()"
                class="btn-print"
            >

                🖨️ Cetak

            </button>


        </form>


    </section>



    <!-- =====================================================
         STATISTIK
    ===================================================== -->

    <section class="stats">


        <div class="stat-card">

            <div class="icon blue">
                🧾
            </div>

            <div>

                <span>
                    Transaksi Selesai
                </span>

                <strong>
                    <?= $total_transaksi; ?>
                </strong>

                <small>
                    transaksi
                </small>

            </div>

        </div>


        <div class="stat-card">

            <div class="icon green">
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
                    pendapatan
                </small>

            </div>

        </div>


        <div class="stat-card">

            <div class="icon orange">
                🏍️
            </div>

            <div>

                <span>
                    Motor
                </span>

                <strong>
                    <?= $total_motor; ?>
                </strong>

                <small>
                    kendaraan
                </small>

            </div>

        </div>


        <div class="stat-card">

            <div class="icon purple">
                🚗
            </div>

            <div>

                <span>
                    Mobil
                </span>

                <strong>
                    <?= $total_mobil; ?>
                </strong>

                <small>
                    kendaraan
                </small>

            </div>

        </div>


    </section>



    <!-- =====================================================
         TABEL LAPORAN
    ===================================================== -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Riwayat Transaksi
                </h2>

                <p>
                    Daftar transaksi parkir yang sudah selesai
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

                        <th>Waktu Keluar</th>

                        <th>Durasi</th>

                        <th>Petugas</th>

                        <th>Biaya</th>

                    </tr>

                </thead>


                <tbody>


                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0):

                ?>


                    <?php while ($row = mysqli_fetch_assoc($query)): ?>


                        <tr>


                            <td>
                                <?= $no++; ?>
                            </td>


                            <td>

                                <span class="plat">

                                    <?= htmlspecialchars(
                                        $row['plat_nomor'] ?? '-'
                                    ); ?>

                                </span>

                            </td>


                            <td>

                                <?php

                                if (
                                    $row['jenis_kendaraan']
                                    == 'motor'
                                ) {

                                    echo "🏍️ Motor";

                                } elseif (
                                    $row['jenis_kendaraan']
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
                                    $row['nama_area'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $row['waktu_masuk'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $row['waktu_keluar'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $row['durasi_jam'] ?? 0
                                ); ?>

                                jam

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $row['nama_lengkap'] ?? '-'
                                ); ?>

                            </td>


                            <td>

                                <strong>

                                    Rp
                                    <?= number_format(
                                        $row['biaya_total'] ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                </strong>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="9"
                            class="empty"
                        >

                            Tidak ada transaksi pada periode ini.

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