<?php

include "../model/m_koneksi.php";

/* =========================
   CEK ID TARIF
========================= */

if (!isset($_GET['id_tarif']) || empty($_GET['id_tarif'])) {
    die("ID tarif tidak ditemukan. Kembali ke halaman Tarif Parkir.");
}

$id_tarif = intval($_GET['id_tarif']);


/* =========================
   AMBIL DATA TARIF
========================= */

$query = mysqli_query(
    $conn,
    "SELECT * FROM tb_tarif WHERE id_tarif = $id_tarif"
);

if (!$query || mysqli_num_rows($query) == 0) {
    die("Data tarif tidak ditemukan.");
}

$tarif = mysqli_fetch_assoc($query);


/* =========================
   PROSES UPDATE
========================= */

if (isset($_POST['update'])) {

    $jenis_kendaraan = mysqli_real_escape_string(
        $conn,
        $_POST['jenis_kendaraan']
    );

    $tarif_per_jam = intval($_POST['tarif_per_jam']);

    $update = mysqli_query(
        $conn,
        "
        UPDATE tb_tarif SET
            jenis_kendaraan = '$jenis_kendaraan',
            tarif_per_jam = '$tarif_per_jam'
        WHERE id_tarif = $id_tarif
        "
    );

    if ($update) {

        header("Location: tarif_parkir.php");
        exit;

    } else {

        die("Gagal mengupdate tarif: " . mysqli_error($conn));

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Tarif - ParkirKu</title>

    <link rel="stylesheet" href="../asset/tarif.css">

    <style>

        /* =========================
           FORM EDIT TARIF
        ========================= */

        .edit-form {
            width: 100%;
            max-width: 650px;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;

            font-size: 14px;
            font-weight: 600;

            color: #374151;
        }

        .form-group select,
        .form-group input {
            display: block;

            width: 100%;
            height: 45px;

            padding: 0 14px;

            border: 1px solid #dfe4ea;
            border-radius: 8px;

            background: white;
            color: #1f2937;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .form-group select {
            cursor: pointer;
        }

        .form-group select:focus,
        .form-group input:focus {
            border-color: #2f80ed;

            box-shadow:
                0 0 0 3px rgba(47,128,237,.10);
        }


        /* =========================
           BUTTON
        ========================= */

        .form-actions {
            display: flex;

            justify-content: flex-end;
            align-items: center;

            gap: 10px;

            margin-top: 28px;
        }

        .btn-cancel {
            display: inline-block;

            padding: 11px 18px;

            border-radius: 8px;

            background: #f1f3f6;
            color: #667085;

            text-decoration: none;

            font-size: 13px;
            font-weight: bold;

            transition: 0.2s;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-save {
            display: inline-block;

            border: none;

            padding: 11px 18px;

            border-radius: 8px;

            background: #2f80ed;
            color: white;

            font-size: 13px;
            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-save:hover {
            background: #216bd0;
        }

    </style>

</head>

<body>


<!-- =========================
     SIDEBAR
========================= -->

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


        <a href="tarif_parkir.php" class="active">
            💰 <span>Tarif Parkir</span>
        </a>


        <a href="area_parkir.php">
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



<!-- =========================
     MAIN
========================= -->

<main class="main">


    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>
                Edit Tarif
            </h1>

            <p>
                Ubah tarif parkir kendaraan
            </p>

        </div>


        <div class="profile">
            👤 Admin
        </div>

    </header>



    <!-- =========================
         CARD
    ========================= -->

    <section class="card">


        <div class="card-header">

            <div>

                <h2>
                    Edit Data Tarif
                </h2>

                <p>
                    Silakan ubah jenis kendaraan dan tarif parkir
                </p>

            </div>

        </div>



        <!-- =========================
             FORM EDIT
        ========================= -->

        <form method="POST" class="edit-form">


            <!-- JENIS KENDARAAN -->

            <div class="form-group">

                <label for="jenis_kendaraan">
                    Jenis Kendaraan
                </label>

                <select
                    name="jenis_kendaraan"
                    id="jenis_kendaraan"
                    required
                >

                    <option value="">
                        -- Pilih Kendaraan --
                    </option>


                    <option
                        value="motor"
                        <?= $tarif['jenis_kendaraan'] == 'motor' ? 'selected' : ''; ?>
                    >
                        🏍️ Motor
                    </option>


                    <option
                        value="mobil"
                        <?= $tarif['jenis_kendaraan'] == 'mobil' ? 'selected' : ''; ?>
                    >
                        🚗 Mobil
                    </option>


                    <option
                        value="lainnya"
                        <?= $tarif['jenis_kendaraan'] == 'lainnya' ? 'selected' : ''; ?>
                    >
                        🚙 Lainnya
                    </option>

                </select>

            </div>



            <!-- TARIF PER JAM -->

            <div class="form-group">

                <label for="tarif_per_jam">
                    Tarif Per Jam
                </label>

                <input
                    type="number"
                    name="tarif_per_jam"
                    id="tarif_per_jam"
                    value="<?= htmlspecialchars($tarif['tarif_per_jam']); ?>"
                    placeholder="Contoh: 3000"
                    min="0"
                    required
                >

            </div>



            <!-- BUTTON -->

            <div class="form-actions">

                <a
                    href="tarif_parkir.php"
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