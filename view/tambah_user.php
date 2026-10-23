<?php
include "../model/m_koneksi.php";

$pesan = "";

if (isset($_POST['simpan'])) {

    $nama_lengkap = mysqli_real_escape_string(
        $conn,
        $_POST['nama_lengkap']
    );

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = mysqli_real_escape_string(
        $conn,
        $_POST['password']
    );

    $role = mysqli_real_escape_string(
        $conn,
        $_POST['role']
    );

    $status_aktif = intval($_POST['status_aktif']);

    // Cek username
    $cek = mysqli_query(
        $conn,
        "SELECT * FROM tb_user WHERE username='$username'"
    );

    if (mysqli_num_rows($cek) > 0) {

        $pesan = "Username sudah digunakan!";

    } else {

        $query = mysqli_query(
            $conn,
            "INSERT INTO tb_user
            (nama_lengkap, username, password, role, status_aktif)
            VALUES
            ('$nama_lengkap',
             '$username',
             '$password',
             '$role',
             '$status_aktif')"
        );

        if ($query) {

            header("Location: kelola_user.php");
            exit;

        } else {

            $pesan = "Data gagal ditambahkan!";

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

    <title>Tambah User - ParkirKu</title>

    <link rel="stylesheet"
          href="../asset/user.css">

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

        <a href="kelola_user.php" class="active">
            👥 <span>Kelola User</span>
        </a>

        <a href="tarif_parkir.php">
            💰 <span>Tarif Parkir</span>
        </a>

        <a href="#">
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

            <h1>Tambah User</h1>

            <p>
                Tambahkan pengguna baru ke dalam sistem parkir
            </p>

        </div>


        <div class="profile">
            👤 Admin
        </div>

    </header>


    <!-- FORM -->
    <section class="card form-card">

        <div class="card-header">

            <div>

                <h2>Tambah User</h2>

                <p>
                    Silakan isi data pengguna di bawah ini
                </p>

            </div>

        </div>


        <?php if ($pesan != "") { ?>

            <div class="alert">
                <?= htmlspecialchars($pesan); ?>
            </div>

        <?php } ?>


        <form method="POST">


            <!-- NAMA -->
            <div class="form-group">

                <label>
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama_lengkap"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <!-- USERNAME -->
            <div class="form-group">

                <label>
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    placeholder="Masukkan username"
                    required
                >

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label>
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <!-- ROLE -->
            <div class="form-group">

                <label>
                    Role
                </label>

                <select name="role" required>

                    <option value="">
                        -- Pilih Role --
                    </option>

                    <option value="admin">
                        Admin
                    </option>

                    <option value="petugas">
                        Petugas
                    </option>

                    <option value="owner">
                        Owner
                    </option>

                </select>

            </div>


            <!-- STATUS -->
            <div class="form-group">

                <label>
                    Status
                </label>

                <select name="status_aktif">

                    <option value="1">
                        Aktif
                    </option>

                    <option value="0">
                        Nonaktif
                    </option>

                </select>

            </div>


            <!-- BUTTON -->
            <div class="form-button">

                <a
                    href="kelola_user.php"
                    class="btn-cancel"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-save"
                >
                    Simpan User
                </button>

            </div>


        </form>

    </section>

</main>

</body>
</html>