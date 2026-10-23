<?php

include "../model/m_koneksi.php";


/* =====================================================
   CEK ID KENDARAAN
===================================================== */

if (!isset($_GET['id_kendaraan']) || empty($_GET['id_kendaraan'])) {

    die("ID kendaraan tidak ditemukan.");

}

$id_kendaraan = intval($_GET['id_kendaraan']);


/* =====================================================
   AMBIL DATA KENDARAAN
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT * FROM tb_kendaraan
     WHERE id_kendaraan = $id_kendaraan"
);

if (!$query || mysqli_num_rows($query) == 0) {

    die("Data kendaraan tidak ditemukan.");

}

$kendaraan = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Kendaraan - ParkirKu</title>

    <link rel="stylesheet"
          href="../asset/edit_kendaraan.css">

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

            <strong>Admin</strong>

            <small>
                Administrator
            </small>

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


        <a href="data_kendaraan.php"
           class="active">
            🚗 <span>Data Kendaraan</span>
        </a>


        <a href="log_aktivitas.php">
            📝 <span>Log Aktivitas</span>
        </a>

    </nav>


    <a href="../controller/c_logout.php"
       class="logout">

        ↪ <span>Logout</span>

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
                Edit Kendaraan
            </h1>

            <p>
                Ubah data kendaraan yang terdaftar
            </p>

        </div>


        <div class="profile">
            👤 Admin
        </div>

    </header>



    <!-- =====================================================
         CARD
    ===================================================== -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Edit Data Kendaraan
                </h2>

                <p>
                    Silakan ubah data kendaraan
                </p>

            </div>

        </div>



        <!-- =====================================================
             FORM
        ===================================================== -->

        <form action="../controller/c_kendaraan.php"
              method="POST">


            <!-- ID KENDARAAN -->

            <input
                type="hidden"
                name="id_kendaraan"
                value="<?= $kendaraan['id_kendaraan']; ?>"
            >



            <!-- PLAT NOMOR -->

            <div class="form-group">

                <label>
                    Plat Nomor
                </label>

                <input
                    type="text"
                    name="plat_nomor"
                    value="<?= htmlspecialchars($kendaraan['plat_nomor']); ?>"
                    placeholder="Contoh: B 1234 ABC"
                    required
                >

            </div>



            <!-- JENIS KENDARAAN -->

            <div class="form-group">

                <label>
                    Jenis Kendaraan
                </label>

                <select
                    name="jenis_kendaraan"
                    required
                >

                    <option value="">
                        -- Pilih Kendaraan --
                    </option>


                    <option
                        value="motor"
                        <?= $kendaraan['jenis_kendaraan'] == 'motor' ? 'selected' : ''; ?>
                    >
                        🏍️ Motor
                    </option>


                    <option
                        value="mobil"
                        <?= $kendaraan['jenis_kendaraan'] == 'mobil' ? 'selected' : ''; ?>
                    >
                        🚗 Mobil
                    </option>


                    <option
                        value="lainnya"
                        <?= $kendaraan['jenis_kendaraan'] == 'lainnya' ? 'selected' : ''; ?>
                    >
                        🚙 Lainnya
                    </option>

                </select>

            </div>



            <!-- WARNA -->

            <div class="form-group">

                <label>
                    Warna Kendaraan
                </label>

                <input
                    type="text"
                    name="warna"
                    value="<?= htmlspecialchars($kendaraan['warna']); ?>"
                    placeholder="Contoh: Hitam"
                    required
                >

            </div>



            <!-- PEMILIK -->

            <div class="form-group">

                <label>
                    Pemilik
                </label>

                <input
                    type="text"
                    name="pemilik"
                    value="<?= htmlspecialchars($kendaraan['pemilik']); ?>"
                    placeholder="Nama pemilik kendaraan"
                    required
                >

            </div>



            <!-- BUTTON -->

            <div class="form-actions">

                <a
                    href="data_kendaraan.php"
                    class="btn-cancel"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    name="update"
                    class="btn-save"
                >
                    Simpan Perubahan
                </button>

            </div>


        </form>

    </section>

</main>


</body>
</html>