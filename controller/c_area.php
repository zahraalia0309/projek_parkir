
<?php
include "../model/m_koneksi.php";

mysqli_report(MYSQLI_REPORT_OFF);

$halaman_area = "../view/area_parkir.php";

/* ==============================
   FUNGSI PESAN
============================== */
function pesan($teks, $tujuan)
{
    echo "<script>
        alert(" . json_encode($teks) . ");
        window.location.href = " . json_encode($tujuan) . ";
    </script>";
    exit;
}

/* ==============================
   TAMBAH AREA PARKIR
============================== */
if (isset($_POST['tambah'])) {

    $nama_area = trim($_POST['nama_area'] ?? '');
    $kapasitas = intval($_POST['kapasitas'] ?? 0);

    if ($nama_area === '' || $kapasitas <= 0) {
        pesan("Nama area dan kapasitas wajib diisi.", $halaman_area);
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO tb_area_parkir
         (nama_area, kapasitas, terisi, status_area)
         VALUES (?, ?, 0, 'aktif')"
    );

    if (!$stmt) {
        pesan("Gagal menyiapkan data area.", $halaman_area);
    }

    mysqli_stmt_bind_param($stmt, "si", $nama_area, $kapasitas);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        pesan("Area parkir berhasil ditambahkan.", $halaman_area);
    } else {
        mysqli_stmt_close($stmt);
        pesan("Gagal menambahkan area parkir.", $halaman_area);
    }
}

/* ==============================
   EDIT AREA PARKIR
============================== */
elseif (isset($_POST['edit'])) {

    $id_area = intval($_POST['id_area'] ?? 0);
    $nama_area = trim($_POST['nama_area'] ?? '');
    $kapasitas = intval($_POST['kapasitas'] ?? 0);

    if ($id_area <= 0 || $nama_area === '' || $kapasitas <= 0) {
        pesan("Data area parkir tidak valid.", $halaman_area);
    }

    // Pastikan kapasitas baru tidak lebih kecil dari jumlah kendaraan
    $stmt = mysqli_prepare(
        $conn,
        "SELECT terisi
         FROM tb_area_parkir
         WHERE id_area = ?"
    );

    if (!$stmt) {
        pesan("Gagal memeriksa data area.", $halaman_area);
    }

    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $terisi_saat_ini);

    $ditemukan = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$ditemukan) {
        pesan("Area parkir tidak ditemukan.", $halaman_area);
    }

    if ($kapasitas < intval($terisi_saat_ini)) {
        pesan(
            "Kapasitas tidak boleh lebih kecil dari jumlah kendaraan yang sedang parkir.",
            $halaman_area
        );
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE tb_area_parkir
         SET nama_area = ?, kapasitas = ?
         WHERE id_area = ?"
    );

    if (!$stmt) {
        pesan("Gagal menyiapkan perubahan area.", $halaman_area);
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sii",
        $nama_area,
        $kapasitas,
        $id_area
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        pesan("Area parkir berhasil diubah.", $halaman_area);
    } else {
        mysqli_stmt_close($stmt);
        pesan("Gagal mengubah area parkir.", $halaman_area);
    }
}

/* ==============================
   NONAKTIFKAN / AKTIFKAN AREA
============================== */
elseif (
    isset($_GET['aksi']) &&
    in_array($_GET['aksi'], ['nonaktif', 'aktifkan'], true)
) {

    $id_area = intval($_GET['id_area'] ?? 0);
    $aksi = $_GET['aksi'];

    if ($id_area <= 0) {
        pesan("ID area tidak valid.", $halaman_area);
    }

    // Pastikan area memang ada
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id_area
         FROM tb_area_parkir
         WHERE id_area = ?"
    );

    if (!$stmt) {
        pesan("Gagal memeriksa area parkir.", $halaman_area);
    }

    mysqli_stmt_bind_param($stmt, "i", $id_area);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $area_ditemukan = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    if (!$area_ditemukan) {
        pesan("Area parkir tidak ditemukan.", $halaman_area);
    }

    // Area tidak boleh dinonaktifkan jika masih ada kendaraan masuk
    if ($aksi === 'nonaktif') {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id_parkir
             FROM tb_transaksi
             WHERE id_area = ?
               AND status = 'masuk'
             LIMIT 1"
        );

        if (!$stmt) {
            pesan("Gagal memeriksa kendaraan di area.", $halaman_area);
        }

        mysqli_stmt_bind_param($stmt, "i", $id_area);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $masih_terisi = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);

        if ($masih_terisi) {
            pesan(
                "Area tidak bisa dinonaktifkan karena masih ada kendaraan yang parkir.",
                $halaman_area
            );
        }
    }

    $status_area = ($aksi === 'nonaktif')
        ? 'nonaktif'
        : 'aktif';

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE tb_area_parkir
         SET status_area = ?
         WHERE id_area = ?"
    );

    if (!$stmt) {
        pesan("Gagal menyiapkan perubahan status area.", $halaman_area);
    }

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status_area,
        $id_area
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        if ($aksi === 'nonaktif') {
            pesan(
                "Area parkir berhasil dinonaktifkan.",
                $halaman_area
            );
        } else {
            pesan(
                "Area parkir berhasil diaktifkan kembali.",
                $halaman_area
            );
        }
    } else {
        mysqli_stmt_close($stmt);
        pesan("Gagal mengubah status area parkir.", $halaman_area);
    }
}

/* ==============================
   AKSI TIDAK DIKENALI
============================== */
else {
    header("Location: " . $halaman_area);
    exit;
}
?>
