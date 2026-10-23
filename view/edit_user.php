<?php

include "../model/m_koneksi.php";

/* CEK ID USER */
if (!isset($_GET['id_user']) || empty($_GET['id_user'])) {
    die("ID user tidak ditemukan. Kembali ke halaman Kelola User.");
}

$id_user = intval($_GET['id_user']);

/* AMBIL DATA USER */
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = $id_user");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Data user tidak ditemukan.");
}

$user = mysqli_fetch_assoc($query);


/* PROSES UPDATE */
if (isset($_POST['update'])) {

    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $role         = mysqli_real_escape_string($conn, $_POST['role']);
    $status_aktif = intval($_POST['status_aktif']);

    $update = mysqli_query($conn, "
        UPDATE tb_user SET
            nama_lengkap = '$nama_lengkap',
            username = '$username',
            role = '$role',
            status_aktif = '$status_aktif'
        WHERE id_user = $id_user
    ");

    if ($update) {
        header("Location: kelola_user.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User - ParkirKu</title>

    <link rel="stylesheet" href="../asset/user.css?v=2">
</head>

<body>

<aside class="sidebar">

    <div class="logo">
        🚗 <span>ParkirKu</span>
    </div>

    <div class="admin">
        <div class="avatar">👤</div>

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


<main class="main">

    <header class="header">

        <div>
            <h1>Edit User</h1>
            <p>Ubah data pengguna sistem parkir</p>
        </div>

        <div class="profile">
            👤 Admin
        </div>

    </header>


    <section class="card">

        <div class="card-header">

            <div>
                <h2>Edit Data User</h2>
                <p>Silakan ubah data pengguna</p>
            </div>

        </div>


        <form method="POST">

            <div class="form-group">
                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="nama_lengkap"
                    value="<?= htmlspecialchars($user['nama_lengkap']); ?>"
                    required
                >
            </div>


            <div class="form-group">
                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    value="<?= htmlspecialchars($user['username']); ?>"
                    required
                >
            </div>


            <div class="form-group">
                <label>Role</label>

                <select name="role" required>

                    <option value="admin"
                        <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>
                        Admin
                    </option>

                    <option value="petugas"
                        <?= $user['role'] == 'petugas' ? 'selected' : ''; ?>>
                        Petugas
                    </option>

                    <option value="owner"
                        <?= $user['role'] == 'owner' ? 'selected' : ''; ?>>
                        Owner
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Status</label>

                <select name="status_aktif" required>

                    <option value="1"
                        <?= $user['status_aktif'] == 1 ? 'selected' : ''; ?>>
                        Aktif
                    </option>

                    <option value="0"
                        <?= $user['status_aktif'] == 0 ? 'selected' : ''; ?>>
                        Nonaktif
                    </option>

                </select>

            </div>


            <div class="form-actions">

                <a href="kelola_user.php" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" name="update" class="btn-save">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>