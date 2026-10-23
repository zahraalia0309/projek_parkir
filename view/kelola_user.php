<?php
include "../model/m_user.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola User - ParkirKu</title>

    <link rel="stylesheet" href="../asset/user.css">
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


        <!-- MENU -->
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

            <a href="data_kendaraan.php">
                🚗 <span>Data Kendaraan</span>
            </a>

            <a href="log_aktivitas.php">
                📝 <span>Log Aktivitas</span>
            </a>

        </nav>


        <!-- LOGOUT -->
        <a href="login.php" class="logout">
            ↪ <span>Logout</span>
        </a>

    </aside>


    <!-- MAIN -->
    <main class="main">

        <!-- HEADER -->
        <header class="header">

            <div>

                <h1>Kelola User</h1>

                <p>
                    Kelola data pengguna sistem parkir
                </p>

            </div>

            <div class="profile">
                👤 Admin
            </div>

        </header>


        <!-- DATA USER -->
        <section class="card">

            <div class="card-header">

                <div>

                    <h2>Data User</h2>

                    <p>
                        Daftar pengguna yang terdaftar dalam sistem
                    </p>

                </div>

                <a href="tambah_user.php" class="btn-add">
                    + Tambah User
                </a>

            </div>


            <!-- SEARCH -->
            <div class="search">

                <input
                    type="text"
                    placeholder="Cari nama atau username..."
                >

                <button>
                    🔍 Cari
                </button>

            </div>


            <!-- TABLE -->
            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    $no = 1;

                    foreach ($data_user as $user) {

                    ?>

                        <tr>

                            <!-- NOMOR -->
                            <td>
                                <?= $no++; ?>
                            </td>


                            <!-- NAMA -->
                            <td class="name">
                                <?= htmlspecialchars($user['nama_lengkap']); ?>
                            </td>


                            <!-- USERNAME -->
                            <td>
                                <?= htmlspecialchars($user['username']); ?>
                            </td>


                            <!-- ROLE -->
                            <td>

                                <?php

                                $role = strtolower($user['role']);

                                if ($role == "admin") {

                                    echo '<span class="badge admin-badge">
                                            Admin
                                          </span>';

                                } elseif ($role == "user") {

                                    echo '<span class="badge user-badge">
                                            User
                                          </span>';

                                } elseif ($role == "petugas") {

                                    echo '<span class="badge petugas-badge">
                                            Petugas
                                          </span>';

                                } elseif ($role == "owner") {

                                    echo '<span class="badge owner-badge">
                                            Owner
                                          </span>';

                                } else {

                                    echo '<span class="badge">
                                            ' . htmlspecialchars($user['role']) . '
                                          </span>';

                                }

                                ?>

                            </td>


                            <!-- STATUS -->
                            <td>

                                <?php

                                if ($user['status_aktif'] == 1) {

                                    echo '<span class="status aktif">
                                            ● Aktif
                                          </span>';

                                } else {

                                    echo '<span class="status nonaktif">
                                            ● Nonaktif
                                          </span>';

                                }

                                ?>

                            </td>


                            <!-- AKSI -->
                            <td>

                                <a
                                    href="edit_user.php?id_user=<?= $user['id_user']; ?>"
                                    class="edit"
                                >
                                    Edit
                                </a>

                               <a
    href="../controller/c_user.php?aksi=hapus&id_user=<?= $user['id_user']; ?>"
    class="delete"
    onclick="return confirm('Yakin ingin menghapus user ini?');"
>
    Hapus
</a>

                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</body>

</html>