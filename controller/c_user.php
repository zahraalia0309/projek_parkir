<?php

include "../model/m_koneksi.php";


/* =====================================================
   TAMBAH USER
===================================================== */

if (isset($_POST['tambah'])) {

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

    $status_aktif = $_POST['status_aktif'];

    // Hash password
    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $query = "INSERT INTO tb_user
              (nama_lengkap, username, password, role, status_aktif)
              VALUES
              ('$nama_lengkap',
               '$username',
               '$password_hash',
               '$role',
               '$status_aktif')";

    mysqli_query($conn, $query);

    header("Location: ../view/kelola_user.php");
    exit;
}


/* =====================================================
   EDIT USER
===================================================== */

if (isset($_POST['update'])) {

    $id_user = intval($_POST['id_user']);

    $nama_lengkap = mysqli_real_escape_string(
        $conn,
        $_POST['nama_lengkap']
    );

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $role = mysqli_real_escape_string(
        $conn,
        $_POST['role']
    );

    $status_aktif = $_POST['status_aktif'];


    // Jika password diganti
    if (!empty($_POST['password'])) {

        $password = mysqli_real_escape_string(
            $conn,
            $_POST['password']
        );

        $password_hash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = "UPDATE tb_user SET
                    nama_lengkap = '$nama_lengkap',
                    username = '$username',
                    password = '$password_hash',
                    role = '$role',
                    status_aktif = '$status_aktif'
                  WHERE id_user = '$id_user'";

    } else {

        // Jika password tidak diganti
        $query = "UPDATE tb_user SET
                    nama_lengkap = '$nama_lengkap',
                    username = '$username',
                    role = '$role',
                    status_aktif = '$status_aktif'
                  WHERE id_user = '$id_user'";
    }

    mysqli_query($conn, $query);

    header("Location: ../view/kelola_user.php");
    exit;
}


/* =====================================================
   HAPUS USER
===================================================== */

if (
    isset($_GET['aksi']) &&
    $_GET['aksi'] == 'hapus' &&
    isset($_GET['id_user'])
) {

    $id_user = intval($_GET['id_user']);

    // Hapus user saja
    $query = "DELETE FROM tb_user
              WHERE id_user = '$id_user'";

    mysqli_query($conn, $query);

    header("Location: ../view/kelola_user.php");
    exit;
}

?> 