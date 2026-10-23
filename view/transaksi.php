<?php

include "../model/m_koneksi.php";

/* =====================================================
   AMBIL TRANSAKSI YANG MASIH AKTIF
   HANYA STATUS = MASUK
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT
        t.id_parkir,
        t.id_kendaraan,
        t.waktu_masuk,
        t.status,
        t.id_user,
        t.id_area,

        k.plat_nomor,
        k.jenis_kendaraan,
        k.warna,

        a.nama_area

    FROM tb_transaksi t

    LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan

    LEFT JOIN tb_area_parkir a
        ON t.id_area = a.id_area

    WHERE t.status = 'masuk'

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
        href="../asset/transaksi.css"
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
                Kelola kendaraan yang sedang berada di area parkir
            </p>

        </div>


        <div class="profile">
            👤 Petugas
        </div>

    </header>



    <!-- =====================================================
         CARD
    ===================================================== -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Kendaraan Sedang Parkir
                </h2>

                <p>
                    Daftar kendaraan yang belum keluar
                </p>

            </div>


            <a
                href="tambah_transaksi.php"
                class="btn-add"
            >

                + Transaksi Baru

            </a>

        </div>



        <!-- SEARCH -->

        <div class="search">

            <input
                type="text"
                id="searchInput"
                placeholder="Cari plat nomor..."
            >

            <button
                type="button"
                onclick="cariPlat()"
            >
                Cari
            </button>

        </div>



        <!-- TABLE -->

        <div class="table-wrapper">

            <table id="tabelTransaksi">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Plat Nomor</th>

                        <th>Jenis</th>

                        <th>Area</th>

                        <th>Waktu Masuk</th>

                        <th>Status</th>

                        <th>Aksi</th>

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
                                    $transaksi['jenis_kendaraan'] == 'motor'
                                ) {

                                    echo "🏍️ Motor";

                                } elseif (
                                    $transaksi['jenis_kendaraan'] == 'mobil'
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


                            <!-- STATUS -->

                            <td>

                                <span class="status masuk">
                                    Masuk
                                </span>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <a
                                    href="detail_transaksi.php?id_parkir=<?= $transaksi['id_parkir']; ?>"
                                    class="detail"
                                >
                                    Detail
                                </a>


                                <a
                                    href="../controller/c_transaksi.php?aksi=keluar&id_parkir=<?= $transaksi['id_parkir']; ?>"
                                    class="keluar-btn"
                                    onclick="return confirm('Kendaraan ini akan dicatat keluar. Lanjutkan?');"
                                >
                                    Keluar
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="7"
                            class="empty"
                        >
                            Tidak ada kendaraan yang sedang parkir.
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</main>



<script>

function cariPlat() {

    let input =
        document.getElementById("searchInput")
        .value
        .toLowerCase();

    let rows =
        document.querySelectorAll(
            "#tabelTransaksi tbody tr"
        );

    rows.forEach(function(row) {

        let plat =
            row.cells[1]?.innerText.toLowerCase() || "";

        if (plat.includes(input)) {

            row.style.display = "";

        } else {

            row.style.display = "none";

        }

    });

}

</script>

</body>

</html>