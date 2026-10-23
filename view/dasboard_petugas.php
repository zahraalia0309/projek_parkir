<?php

include "../model/m_koneksi.php";


/* =====================================================
   STATISTIK TRANSAKSI
===================================================== */

/* KENDARAAN MASUK */
$query_masuk = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi
     WHERE status = 'masuk'"
);

$total_masuk = mysqli_fetch_assoc($query_masuk)['total'];


/* KENDARAAN KELUAR */
$query_keluar = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi
     WHERE status = 'keluar'"
);

$total_keluar = mysqli_fetch_assoc($query_keluar)['total'];


/* TOTAL TRANSAKSI */
$query_transaksi = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi"
);

$total_transaksi = mysqli_fetch_assoc($query_transaksi)['total'];


/* TOTAL STRUK PARKIR */
/* Struk tersedia untuk transaksi yang sudah keluar */
$query_struk = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM tb_transaksi
     WHERE status = 'keluar'"
);

$total_struk = mysqli_fetch_assoc($query_struk)['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Petugas - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/dasboard_petugas.css"
    >

</head>

<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<aside class="sidebar">


    <!-- LOGO -->

    <div class="logo">

        🚗 <span>ParkirKu</span>

    </div>



    <!-- PROFIL PETUGAS -->

    <div class="petugas">

        <div class="avatar">
            👤
        </div>

        <div>

            <strong>
                Petugas
            </strong>

            <small>
                Petugas Parkir
            </small>

        </div>

    </div>



    <!-- MENU -->

    <nav>


        <a
            href="dashboard_petugas.php"
            class="active"
        >

            🏠
            <span>Dashboard</span>

        </a>


        <a href="transaksi.php">

            🅿️
            <span>Transaksi</span>

        </a>



    </nav>



    <!-- LOGOUT -->

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
                Dashboard Petugas
            </h1>

            <p>
                Selamat datang di sistem manajemen parkir
            </p>

        </div>


        <div class="profile">

            👤 Petugas

        </div>


    </header>



    <!-- =================================================
         STATISTIK
    ================================================= -->

    <section class="dashboard-grid">


        <!-- KENDARAAN MASUK -->

        <div class="stat-card">

            <div class="stat-icon">
                🚗
            </div>

            <div>

                <p>
                    Kendaraan Masuk
                </p>

                <h2>
                    <?= $total_masuk; ?>
                </h2>

            </div>

        </div>



        <!-- KENDARAAN KELUAR -->

        <div class="stat-card">

            <div class="stat-icon">
                🚙
            </div>

            <div>

                <p>
                    Kendaraan Keluar
                </p>

                <h2>
                    <?= $total_keluar; ?>
                </h2>

            </div>

        </div>



        <!-- TOTAL TRANSAKSI -->

        <div class="stat-card">

            <div class="stat-icon">
                🅿️
            </div>

            <div>

                <p>
                    Total Transaksi
                </p>

                <h2>
                    <?= $total_transaksi; ?>
                </h2>

            </div>

        </div>



        </div>


    </section>



    <!-- =================================================
         INFORMASI
    ================================================= -->

    <section class="card">


        <div class="card-header">

            <h2>
                Informasi Petugas
            </h2>

            <p>
                Menu yang dapat digunakan oleh petugas parkir
            </p>

        </div>



        <div class="menu-grid">


            <!-- TRANSAKSI -->

            <a
                href="transaksi.php"
                class="menu-card"
            >

                <div class="menu-icon">
                    🅿️
                </div>

                <div>

                    <strong>
                        Transaksi Parkir
                    </strong>

                    <small>
                        Kelola transaksi kendaraan masuk dan keluar
                    </small>

                </div>

            </a>



    
                     

                </div>

            </a>


        </div>


    </section>


</main>


</body>

</html>