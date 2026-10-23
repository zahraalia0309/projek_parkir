<?php

session_start();

include "../model/m_koneksi.php";


/* =====================================================
   AMBIL JUMLAH DATA DARI DATABASE
===================================================== */

/* TOTAL USER */
$query_user = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM tb_user"
);

$total_user = mysqli_fetch_assoc($query_user)['total'];


/* TOTAL KENDARAAN */
$query_kendaraan = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM tb_kendaraan"
);

$total_kendaraan = mysqli_fetch_assoc($query_kendaraan)['total'];


/* TOTAL AREA PARKIR */
$query_area = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM tb_area_parkir"
);

$total_area = mysqli_fetch_assoc($query_area)['total'];


/* TOTAL TRANSAKSI */
$query_transaksi = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM tb_transaksi"
);

$total_transaksi = mysqli_fetch_assoc($query_transaksi)['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Admin - ParkirKu</title>

    <link
        rel="stylesheet"
        href="../asset/dasboard.css?v=10"
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
                Admin
            </strong>

            <small>
                Administrator
            </small>

        </div>

    </div>


    <nav>


        <a
            href="dashboard_admin.php"
            class="active"
        >

            🏠
            <span>Dashboard</span>

        </a>


        <a href="kelola_user.php">

            👥
            <span>Kelola User</span>

        </a>


        <a href="tarif_parkir.php">

            💰
            <span>Tarif Parkir</span>

        </a>


        <a href="area_parkir.php">

            🅿️
            <span>Area Parkir</span>

        </a>


        <a href="data_kendaraan.php">

            🚗
            <span>Data Kendaraan</span>

        </a>


        <a href="log_aktivitas.php">

            📝
            <span>Log Aktivitas</span>

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
                Dashboard Admin
            </h1>

            <p>
                Selamat datang di sistem manajemen parkir
            </p>

        </div>


        <div class="profile">

            👤

            <?= htmlspecialchars(
                $_SESSION['nama_lengkap'] ?? 'Admin'
            ); ?>

        </div>


    </header>



    <!-- =================================================
         STATISTIK
    ================================================= -->

    <section class="dashboard-grid">


        <!-- TOTAL USER -->

        <div class="stat-card">

            <div class="stat-icon">
                👥
            </div>

            <div>

                <p>
                    Total User
                </p>

                <h2>
                    <?= $total_user; ?>
                </h2>

            </div>

        </div>



        <!-- TOTAL KENDARAAN -->

        <div class="stat-card">

            <div class="stat-icon">
                🚗
            </div>

            <div>

                <p>
                    Total Kendaraan
                </p>

                <h2>
                    <?= $total_kendaraan; ?>
                </h2>

            </div>

        </div>



        <!-- TOTAL AREA -->

        <div class="stat-card">

            <div class="stat-icon">
                🅿️
            </div>

            <div>

                <p>
                    Area Parkir
                </p>

                <h2>
                    <?= $total_area; ?>
                </h2>

            </div>

        </div>



        <!-- TOTAL TRANSAKSI -->

        <div class="stat-card">

            <div class="stat-icon">
                💰
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


    </section>



    <!-- =================================================
         INFORMASI SISTEM
    ================================================= -->

    <section class="card">


        <div class="card-header">

            <h2>
                Informasi Sistem
            </h2>

            <p>
                Ringkasan kondisi sistem parkir
            </p>

        </div>



        <div class="info-grid">


            <!-- USER -->

            <div class="info-item">


                <div class="info-icon">
                    👥
                </div>


                <div class="info-text">

                    <strong>
                        Data Pengguna
                    </strong>

                    <small>
                        Pengguna yang terdaftar
                    </small>

                    <b>
                        <?= $total_user; ?> User
                    </b>

                </div>


            </div>



            <!-- KENDARAAN -->

            <div class="info-item">


                <div class="info-icon">
                    🚗
                </div>


                <div class="info-text">

                    <strong>
                        Data Kendaraan
                    </strong>

                    <small>
                        Kendaraan yang tercatat
                    </small>

                    <b>
                        <?= $total_kendaraan; ?> Kendaraan
                    </b>

                </div>


            </div>



            <!-- AREA -->

            <div class="info-item">


                <div class="info-icon">
                    🅿️
                </div>


                <div class="info-text">

                    <strong>
                        Area Parkir
                    </strong>

                    <small>
                        Area parkir yang tersedia
                    </small>

                    <b>
                        <?= $total_area; ?> Area
                    </b>

                </div>


            </div>



            <!-- STATUS -->

            <div class="info-item">


                <div class="info-icon">
                    ✓
                </div>


                <div class="info-text">

                    <strong>
                        Status Sistem
                    </strong>

                    <small>
                        Sistem manajemen parkir
                    </small>

                    <b class="aktif">
                        Aktif
                    </b>

                </div>


            </div>


        </div>


    </section>


</main>


</body>

</html>