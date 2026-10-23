<?php

include "../model/m_koneksi.php";

/* CEK ID AREA */
if (!isset($_GET['id_area']) || empty($_GET['id_area'])) {
    die("ID area tidak ditemukan. Kembali ke halaman Area Parkir.");
}

$id_area = intval($_GET['id_area']);


/* AMBIL DATA AREA */
$query = mysqli_query($conn, "
    SELECT * FROM tb_area_parkir
    WHERE id_area = $id_area
");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Data area parkir tidak ditemukan.");
}

$area = mysqli_fetch_assoc($query);


/* PROSES UPDATE */
if (isset($_POST['update'])) {

    $nama_area = mysqli_real_escape_string(
        $conn,
        $_POST['nama_area']
    );

    $kapasitas = intval($_POST['kapasitas']);
    $terisi = intval($_POST['terisi']);


    /* CEK TERISI TIDAK BOLEH LEBIH BESAR DARI KAPASITAS */
    if ($terisi > $kapasitas) {

        $error = "Jumlah terisi tidak boleh lebih besar dari kapasitas.";

    } else {

        $update = mysqli_query($conn, "
            UPDATE tb_area_parkir SET
                nama_area = '$nama_area',
                kapasitas = $kapasitas,
                terisi = $terisi
            WHERE id_area = $id_area
        ");


        if ($update) {

            header("Location: area_parkir.php");
            exit;

        } else {

            $error = "Gagal mengupdate data: " . mysqli_error($conn);

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Area Parkir - ParkirKu</title>

    <link rel="stylesheet" href="../asset/area.css">

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

        <a href="area_parkir.php" class="active">
            🅿️ <span>Area Parkir</span>
        </a>

        <a href="#">
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

            <h1>
                Edit Area Parkir
            </h1>

            <p>
                Ubah data area parkir
            </p>

        </div>


        <div class="profile">
            👤 Admin
        </div>

    </header>



    <!-- CARD -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Edit Data Area
                </h2>

                <p>
                    Silakan ubah informasi area parkir
                </p>

            </div>

        </div>



        <?php if (isset($error)) : ?>

            <div class="alert-error">
                <?= htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>



        <form method="POST">


            <!-- NAMA AREA -->

            <div class="form-group">

                <label>
                    Nama Area
                </label>

                <input
                    type="text"
                    name="nama_area"
                    value="<?= htmlspecialchars($area['nama_area']); ?>"
                    required
                >

            </div>



            <!-- KAPASITAS -->

            <div class="form-group">

                <label>
                    Kapasitas
                </label>

                <input
                    type="number"
                    name="kapasitas"
                    value="<?= htmlspecialchars($area['kapasitas']); ?>"
                    min="1"
                    required
                >

                <small class="form-info">
                    Masukkan jumlah maksimal slot parkir.
                </small>

            </div>



            <!-- TERISI -->

            <div class="form-group">

                <label>
                    Terisi
                </label>

                <input
                    type="number"
                    name="terisi"
                    value="<?= htmlspecialchars($area['terisi']); ?>"
                    min="0"
                    required
                >

                <small class="form-info">
                    Masukkan jumlah slot yang sedang terisi.
                </small>

            </div>



            <!-- BUTTON -->

            <div class="form-actions">

                <a
                    href="area_parkir.php"
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