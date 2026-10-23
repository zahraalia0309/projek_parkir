```php
<?php

session_start();

include "../model/m_koneksi.php";

// Pastikan form login dikirim
if (isset($_POST['login'])) {

    // Ambil username dan password
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if ($username === '' || $password === '') {
        echo "<script>
                alert('Username dan password wajib diisi!');
                window.location='../view/login.php';
              </script>";
        exit;
    }

    // Cari akun berdasarkan username
    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM tb_user WHERE username = ? LIMIT 1"
    );

    if (!$stmt) {
        die("Query login gagal: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    // Periksa username
    if (!$user) {
        echo "<script>
                alert('Username tidak ditemukan!');
                window.location='../view/login.php';
              </script>";
        exit;
    }

    // Periksa status akun
    if ((int) $user['status_aktif'] !== 1) {
        echo "<script>
                alert('Akun tidak aktif!');
                window.location='../view/login.php';
              </script>";
        exit;
    }

    // Periksa password
    $passwordValid =
        ($password === $user['password']) ||
        password_verify($password, $user['password']);

    if (!$passwordValid) {
        echo "<script>
                alert('Password salah!');
                window.location='../view/login.php';
              </script>";
        exit;
    }

    // Periksa role
    $role = strtolower(trim($user['role']));

    if (!in_array($role, ['admin', 'petugas', 'owner'], true)) {
        echo "<script>
                alert('Role pengguna tidak dikenali!');
                window.location='../view/login.php';
              </script>";
        exit;
    }

    // Buat session baru
    session_regenerate_id(true);

    $_SESSION['id_user'] = (int) $user['id_user'];
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $role;

    // Catat aktivitas login
    $id_user = (int) $user['id_user'];

    $log = mysqli_prepare(
        $conn,
        "INSERT INTO tb_log_aktivitas
         (id_user, aktivitas, waktu_aktivitas)
         VALUES (?, 'Login ke sistem', NOW())"
    );

    if ($log) {
        mysqli_stmt_bind_param($log, "i", $id_user);
        mysqli_stmt_execute($log);
        mysqli_stmt_close($log);
    }

    // Arahkan pengguna sesuai role
    if ($role === 'admin') {

        header("Location: ../view/dashboard_admin.php");
        exit;

    } elseif ($role === 'petugas') {

        header("Location: ../view/dasboard_petugas.php");
        exit;

    } elseif ($role === 'owner') {

        header("Location: ../view/dashboard_owner.php");
        exit;
    }

} else {

    header("Location: ../view/login.php");
    exit;
}
?>
```
