<?php

include "../model/m_koneksi.php";

/* AMBIL DATA LOG AKTIVITAS */
$query = mysqli_query(
    $conn,
    "SELECT 
        l.id_log,
        l.id_user,
        l.aktivitas,
        l.waktu_aktivitas,
        u.nama_lengkap
     FROM tb_log_aktivitas l
     LEFT JOIN tb_user u 
        ON l.id_user = u.id_user
     ORDER BY l.id_log ASC"
);

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$data_log = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_log[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Log Aktivitas - ParkirKu</title>

    <link rel="stylesheet" href="../asset/tarif.css">

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


        <a href="area_parkir.php">
            🅿️ <span>Area Parkir</span>
        </a>


        <a href="data_kendaraan.php">
            🚗 <span>Data Kendaraan</span>
        </a>


        <a href="log_aktivitas.php" class="active">
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
                Log Aktivitas
            </h1>

            <p>
                Melihat riwayat aktivitas pengguna sistem
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
                    Riwayat Aktivitas
                </h2>

                <p>
                    Daftar aktivitas yang dilakukan dalam sistem
                </p>

            </div>

        </div>



        <!-- TABLE -->

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            ID User
                        </th>

                        <th>
                            Nama User
                        </th>

                        <th>
                            Aktivitas
                        </th>

                        <th>
                            Waktu Aktivitas
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (count($data_log) > 0): ?>

                    <?php $no = 1; ?>


                    <?php foreach ($data_log as $log): ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>


                            <td>

                                <?php if ($log['id_user'] != NULL): ?>

                                    <span class="badge-user">
                                        <?= htmlspecialchars($log['id_user']); ?>
                                    </span>

                                <?php else: ?>

                                    <span class="badge-system">
                                        Sistem
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?php if (!empty($log['nama_lengkap'])): ?>

                                    <strong>
                                        <?= htmlspecialchars($log['nama_lengkap']); ?>
                                    </strong>

                                <?php else: ?>

                                    <span class="system-user">
                                        Sistem
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <span class="activity">
                                    📝
                                    <?= htmlspecialchars($log['aktivitas']); ?>
                                </span>

                            </td>


                            <td>

                                <span class="time">

                                    🕐

                                    <?= date(
                                        'd-m-Y H:i',
                                        strtotime($log['waktu_aktivitas'])
                                    ); ?>

                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>


                <?php else: ?>

                    <tr>

                        <td colspan="5" class="empty">

                            Belum ada aktivitas.

                        </td>

                    </tr>

                <?php endif; ?>


                </tbody>

            </table>

        </div>

    </section>

</main>


</body>

</html>