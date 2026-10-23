<?php

include "m_koneksi.php";

// Tampilkan semua user
function tampilUser()
{
    global $conn;

    $query = "SELECT * FROM tb_user ORDER BY id_user DESC";
    return mysqli_query($conn, $query);
}

// Tambah user
function tambahUser($nama, $username, $password, $role, $status)
{
    global $conn;

    $query = "INSERT INTO tb_user
              (nama_lengkap, username, password, role, status_aktif)
              VALUES
              ('$nama', '$username', '$password', '$role', '$status')";

    return mysqli_query($conn, $query);
}

// Ambil satu user berdasarkan ID
function ambilUser($id)
{
    global $conn;

    $query = "SELECT * FROM tb_user WHERE id_user = '$id'";
    $result = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($result);
}

// Edit user
function editUser($id, $nama, $username, $password, $role, $status)
{
    global $conn;

    if ($password != "") {
        $query = "UPDATE tb_user SET
                    nama_lengkap = '$nama',
                    username = '$username',
                    password = '$password',
                    role = '$role',
                    status_aktif = '$status'
                  WHERE id_user = '$id'";
    } else {
        $query = "UPDATE tb_user SET
                    nama_lengkap = '$nama',
                    username = '$username',
                    role = '$role',
                    status_aktif = '$status'
                  WHERE id_user = '$id'";
    }

    return mysqli_query($conn, $query);
}

// Hapus user
function hapusUser($id)
{
    global $conn;

    $query = "DELETE FROM tb_user WHERE id_user = '$id'";

    return mysqli_query($conn, $query);
}

?>