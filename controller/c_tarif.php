<?php

include "../model/m_koneksi.php";


/* =====================================================
   FUNGSI BANTU
===================================================== */

function pesan($teks, $tujuan = null)
{
    echo "<script>alert(" . json_encode($teks) . ");";

    if ($tujuan) {
        echo "window.location.href = " . json_encode($tujuan) . ";";
    } else {
        echo "window.history.back();";
    }

    echo "</script>";
    exit;
}


/* =====================================================
   TAMBAH TARIF
===================================================== */

if (isset($_POST['tambah'])) {

    $jenis_kendaraan = trim($_POST['jenis_kendaraan'] ?? '');
    $tarif_per_jam   = intval($_POST['tarif_per_jam'] ?? 0);

    if ($jenis_kendaraan === '' || $tarif_per_jam <= 0) {
        pesan("Data tarif belum lengkap.");
    }

    /* Cek jenis kendaraan sudah punya tarif */
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id_tarif FROM tb_tarif WHERE jenis_kendaraan = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt, "s", $jenis_kendaraan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        pesan("Tarif untuk jenis kendaraan tersebut sudah ada.");
    }
    mysqli_stmt_close($stmt);

    /* Simpan */
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES (?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "si", $jenis_kendaraan, $tarif_per_jam);

    if (!mysqli_stmt_execute($stmt)) {
        pesan("Gagal menyimpan tarif: " . mysqli_error($conn));
    }

    pesan("Tarif berhasil ditambahkan.", "../view/tarif.php");
}


/* =====================================================
   EDIT TARIF
===================================================== */

elseif (isset($_POST['edit'])) {

    $id_tarif        = intval($_POST['id_tarif'] ?? 0);
    $jenis_kendaraan = trim($_POST['jenis_kendaraan'] ?? '');
    $tarif_per_jam   = intval($_POST['tarif_per_jam'] ?? 0);

    if ($id_tarif <= 0 || $jenis_kendaraan === '' || $tarif_per_jam <= 0) {
        pesan("Data tarif belum lengkap.");
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE tb_tarif
         SET jenis_kendaraan = ?, tarif_per_jam = ?
         WHERE id_tarif = ?"
    );
    mysqli_stmt_bind_param($stmt, "sii", $jenis_kendaraan, $tarif_per_jam, $id_tarif);

    if (!mysqli_stmt_execute($stmt)) {
        pesan("Gagal mengubah tarif: " . mysqli_error($conn));
    }

    pesan("Tarif berhasil diubah.", "../view/tarif.php");
}


/* =====================================================
   HAPUS TARIF
===================================================== */

elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {

    $id_tarif = intval($_GET['id_tarif'] ?? 0);

    if ($id_tarif <= 0) {
        pesan("ID tarif tidak valid.");
    }

    /* Cek tarif masih dipakai transaksi */
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id_parkir FROM tb_transaksi WHERE id_tarif = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($stmt, "i", $id_tarif);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        pesan("Tarif tidak bisa dihapus karena sudah dipakai transaksi.");
    }
    mysqli_stmt_close($stmt);

    /* Hapus */
    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM tb_tarif WHERE id_tarif = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id_tarif);

    if (!mysqli_stmt_execute($stmt)) {
        pesan("Gagal menghapus tarif: " . mysqli_error($conn));
    }

    pesan("Tarif berhasil dihapus.", "../view/tarif_parkir.php");
}


/* =====================================================
   AKSI TIDAK DIKENALI
===================================================== */

else {
    header("Location: ../view/tarif_parkir.php");
    exit;
}

?>