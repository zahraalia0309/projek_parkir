<?php
include "../model/m_koneksi.php";

/* PROSES TAMBAH TARIF */
if (isset($_POST['simpan'])) {

    $jenis_kendaraan = mysqli_real_escape_string(
        $conn,
        $_POST['jenis_kendaraan']
    );

    $tarif_per_jam = intval($_POST['tarif_per_jam']);

    /* INSERT DATA */
    $query = mysqli_query($conn, "
        INSERT INTO tb_tarif
        (jenis_kendaraan, tarif_per_jam)
        VALUES
        ('$jenis_kendaraan', '$tarif_per_jam')
    ");

    if ($query) {
        header("Location: tarif_parkir.php");
        exit;
    } else {
        echo "Gagal menambahkan tarif: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Tarif - ParkirKu</title>

    <link rel="stylesheet"
          href="../asset/tarif.css">

    <style>

        .form-card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            border: 1px solid #edf0f5;
            box-shadow: 0 4px 18px rgba(23,43,77,.05);
            max-width: 700px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: bold;
            color: #344054;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dfe4ea;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2f80ed;
            box-shadow: 0 0 0 3px rgba(47,128,237,.10);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-cancel {
            text-decoration: none;
            padding: 11px 17px;
            border-radius: 8px;
            background: #f1f3f6;
            color: #667085;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-save {
            border: none;
            padding: 11px 17px;
            border-radius: 8px;
            background: #2f80ed;
            color: white;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #216bd0;
        }

    </style>

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
            <small>Administrator</small>
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

        <a href="data_kendaraan.php">
            🚗 <span>Data Kendaraan</span>
        </a>

        <a href="log_aktivitas.php">
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

            <h1>Tambah Tarif</h1>

            <p>
                Tambahkan tarif parkir kendaraan
            </p>

        </div>


        <div class="profile">
            👤 Admin
        </div>

    </header>


    <!-- FORM -->

    <section class="form-card">

        <div class="card-header">

            <div>

                <h2>Tambah Data Tarif</h2>

                <p>
                    Silakan masukkan jenis kendaraan dan tarif parkir
                </p>

            </div>

        </div>


        <form method="POST">


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

                    <option value="motor">
                        🏍️ Motor
                    </option>

                    <option value="mobil">
                        🚗 Mobil
                    </option>

                    <option value="lainnya">
                        🚙 Lainnya
                    </option>

                </select>

            </div>


            <!-- TARIF -->

            <div class="form-group">

                <label>
                    Tarif Per Jam
                </label>

                <input
                    type="number"
                    name="tarif_per_jam"
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
                    name="simpan"
                    class="btn-save"
                >
                    Simpan Tarif
                </button>

            </div>

        </form>

    </section>

</main>

</body>

</html>