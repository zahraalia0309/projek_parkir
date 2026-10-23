<?php

include "../model/m_koneksi.php";


/* =====================================================
   AMBIL DATA TRANSAKSI SELESAI
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

    WHERE t.status = 'keluar'

    ORDER BY t.id_parkir DESC"
);


if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}


$data_transaksi = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_transaksi[] = $row;
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

    <title>Transaksi - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/transaksi_owner.css"
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

            <strong>Owner</strong>

            <small>
                Pemilik Parkir
            </small>

        </div>

    </div>


    <nav>

        <a href="dasboard_owner.php">

            🏠
            <span>Dashboard</span>

        </a>


        <a href="laporan_owner.php">

            📊
            <span>Laporan</span>

        </a>


        <a
            href="transaksi_owner.php"
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



<!-- =====================================================
     MAIN
===================================================== -->

<main class="main">


    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>
                Transaksi Parkir
            </h1>

            <p>
                Riwayat transaksi parkir yang telah selesai
            </p>

        </div>


        <div class="profile">

            👤 Owner

        </div>

    </header>



    <!-- =====================================================
         CARD
    ===================================================== -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Riwayat Transaksi
                </h2>

                <p>
                    Daftar kendaraan yang telah selesai parkir
                </p>

            </div>

        </div>



        <!-- =====================================================
             SEARCH
        ===================================================== -->

        <div class="search">

            <input
                type="text"
                placeholder="Cari plat nomor..."
            >

            <button>
                Cari
            </button>

        </div>



        <!-- =====================================================
             TABLE
        ===================================================== -->

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

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>


                <?php if (count($data_transaksi) > 0): ?>

                    <?php $no = 1; ?>


                    <?php foreach ($data_transaksi as $transaksi): ?>

                        <tr>


                            <!-- NO -->

                            <td>
                                <?= $no++; ?>
                            </td>



                            <!-- PLAT -->

                            <td>

                                <span class="plat">

                                    <?= htmlspecialchars(
                                        $transaksi['plat_nomor'] ?? '-'
                                    ); ?>

                                </span>

                            </td>



                            <!-- JENIS -->

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



                            <!-- AREA -->

                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['nama_area'] ?? '-'
                                ); ?>

                            </td>



                            <!-- WAKTU MASUK -->

                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['waktu_masuk'] ?? '-'
                                ); ?>

                            </td>



                            <!-- WAKTU KELUAR -->

                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['waktu_keluar'] ?? '-'
                                ); ?>

                            </td>



                            <!-- DURASI -->

                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['durasi_jam'] ?? 0
                                ); ?>

                                jam

                            </td>



                            <!-- PETUGAS -->

                            <td>

                                <?= htmlspecialchars(
                                    $transaksi['nama_lengkap'] ?? '-'
                                ); ?>

                            </td>



                            <!-- BIAYA -->

                            <td>

                                <strong>

                                    Rp
                                    <?= number_format(
                                        $transaksi['biaya_total'] ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                </strong>

                            </td>



                            <!-- STATUS -->

                            <td>

                                <span class="status selesai">

                                    Selesai

                                </span>

                            </td>


                        </tr>

                    <?php endforeach; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="10"
                            class="empty"
                        >

                            Belum ada transaksi yang selesai.

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