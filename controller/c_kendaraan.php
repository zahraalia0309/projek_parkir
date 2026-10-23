
<?php

include "../model/m_koneksi.php";


/* =====================================================
   NONAKTIFKAN / AKTIFKAN KENDARAAN
===================================================== */

if (isset($_GET['aksi'], $_GET['id_kendaraan'])) {

    $aksi = $_GET['aksi'];
    $id_kendaraan = intval($_GET['id_kendaraan']);

    if ($id_kendaraan <= 0) {
        header("Location: ../view/data_kendaraan.php");
        exit;
    }

    try {

        // CEK APAKAH KENDARAAN ADA
        $query_kendaraan = mysqli_query(
            $conn,
            "SELECT id_kendaraan, status_kendaraan
             FROM tb_kendaraan
             WHERE id_kendaraan = $id_kendaraan
             LIMIT 1"
        );

        if (
            !$query_kendaraan ||
            mysqli_num_rows($query_kendaraan) == 0
        ) {
            throw new Exception("Kendaraan tidak ditemukan.");
        }

        $kendaraan = mysqli_fetch_assoc($query_kendaraan);


        // NONAKTIFKAN KENDARAAN
        if ($aksi == 'nonaktif') {

            // CEK TRANSAKSI YANG MASIH BERLANGSUNG
            $query_transaksi = mysqli_query(
                $conn,
                "SELECT id_parkir
                 FROM tb_transaksi
                 WHERE id_kendaraan = $id_kendaraan
                 AND status = 'masuk'
                 LIMIT 1"
            );

            if (!$query_transaksi) {
                throw new Exception(
                    "Gagal memeriksa transaksi kendaraan."
                );
            }

            if (mysqli_num_rows($query_transaksi) > 0) {
                throw new Exception(
                    "Kendaraan masih berada di area parkir. " .
                    "Proses keluar kendaraan terlebih dahulu."
                );
            }

            if ($kendaraan['status_kendaraan'] == 'nonaktif') {
                throw new Exception(
                    "Kendaraan sudah berstatus nonaktif."
                );
            }

            $query_update = mysqli_query(
                $conn,
                "UPDATE tb_kendaraan
                 SET status_kendaraan = 'nonaktif'
                 WHERE id_kendaraan = $id_kendaraan"
            );

            if (!$query_update) {
                throw new Exception(
                    "Gagal menonaktifkan kendaraan."
                );
            }

            echo "<script>
                alert('Kendaraan berhasil dinonaktifkan.');
                window.location.href = '../view/data_kendaraan.php';
            </script>";
            exit;
        }


        // AKTIFKAN KEMBALI KENDARAAN
        elseif ($aksi == 'aktifkan') {

            if ($kendaraan['status_kendaraan'] == 'aktif') {
                throw new Exception(
                    "Kendaraan sudah berstatus aktif."
                );
            }

            $query_update = mysqli_query(
                $conn,
                "UPDATE tb_kendaraan
                 SET status_kendaraan = 'aktif'
                 WHERE id_kendaraan = $id_kendaraan"
            );

            if (!$query_update) {
                throw new Exception(
                    "Gagal mengaktifkan kembali kendaraan."
                );
            }

            echo "<script>
                alert('Kendaraan berhasil diaktifkan kembali.');
                window.location.href = '../view/data_kendaraan.php';
            </script>";
            exit;
        }

        else {
            header("Location: ../view/data_kendaraan.php");
            exit;
        }

    } catch (Exception $e) {

        echo "<script>
            alert(" . json_encode($e->getMessage()) . ");
            window.location.href = '../view/data_kendaraan.php';
        </script>";
        exit;
    }
}


/* =====================================================
   TAMBAH KENDARAAN
===================================================== */

if (isset($_POST['tambah'])) {

    $plat_nomor = strtoupper(trim($_POST['plat_nomor'] ?? ''));

    $jenis_kendaraan = mysqli_real_escape_string(
        $conn,
        $_POST['jenis_kendaraan'] ?? ''
    );

    $warna = mysqli_real_escape_string(
        $conn,
        $_POST['warna'] ?? ''
    );

    $pemilik = mysqli_real_escape_string(
        $conn,
        $_POST['pemilik'] ?? ''
    );

    // SEMENTARA MENGGUNAKAN ID USER 1
    $id_user = 1;


    // VALIDASI PLAT NOMOR
    if (!preg_match(
        '/^[A-Z]{1,2} [0-9]{1,4} [A-Z]{1,3}$/',
        $plat_nomor
    )) {

        echo "<script>
            alert('Format plat nomor tidak valid! Contoh: B 1234 ABC');
            window.history.back();
        </script>";
        exit;
    }

    $plat_nomor = mysqli_real_escape_string(
        $conn,
        $plat_nomor
    );


    // TAMBAH DENGAN STATUS AKTIF
    $query = "INSERT INTO tb_kendaraan
              (
                  plat_nomor,
                  jenis_kendaraan,
                  warna,
                  pemilik,
                  id_user,
                  status_kendaraan
              )
              VALUES
              (
                  '$plat_nomor',
                  '$jenis_kendaraan',
                  '$warna',
                  '$pemilik',
                  '$id_user',
                  'aktif'
              )";

    try {

        if (mysqli_query($conn, $query)) {
            header("Location: ../view/data_kendaraan.php");
            exit;
        }

        throw new Exception(
            "Gagal menambahkan kendaraan: " .
            mysqli_error($conn)
        );

    } catch (mysqli_sql_exception $e) {

        die(
            "Gagal menambahkan kendaraan: " .
            $e->getMessage()
        );

    } catch (Exception $e) {

        die($e->getMessage());

    }
}


/* =====================================================
   UPDATE KENDARAAN
===================================================== */

if (isset($_POST['update'])) {

    $id_kendaraan = intval($_POST['id_kendaraan'] ?? 0);

    $plat_nomor = strtoupper(
        trim($_POST['plat_nomor'] ?? '')
    );

    $jenis_kendaraan = mysqli_real_escape_string(
        $conn,
        $_POST['jenis_kendaraan'] ?? ''
    );

    $warna = mysqli_real_escape_string(
        $conn,
        $_POST['warna'] ?? ''
    );

    $pemilik = mysqli_real_escape_string(
        $conn,
        $_POST['pemilik'] ?? ''
    );


    // VALIDASI PLAT NOMOR
    if (
        $id_kendaraan <= 0 ||
        !preg_match(
            '/^[A-Z]{1,2} [0-9]{1,4} [A-Z]{1,3}$/',
            $plat_nomor
        )
    ) {

        echo "<script>
            alert('Data kendaraan atau format plat nomor tidak valid!');
            window.history.back();
        </script>";
        exit;
    }

    $plat_nomor = mysqli_real_escape_string(
        $conn,
        $plat_nomor
    );


    // UPDATE DATA KENDARAAN
    $query = "UPDATE tb_kendaraan SET
                plat_nomor = '$plat_nomor',
                jenis_kendaraan = '$jenis_kendaraan',
                warna = '$warna',
                pemilik = '$pemilik'
              WHERE id_kendaraan = $id_kendaraan";

    try {

        if (mysqli_query($conn, $query)) {
            header("Location: ../view/data_kendaraan.php");
            exit;
        }

        throw new Exception(
            "Gagal mengubah kendaraan: " .
            mysqli_error($conn)
        );

    } catch (mysqli_sql_exception $e) {

        die(
            "Gagal mengubah kendaraan: " .
            $e->getMessage()
        );

    } catch (Exception $e) {

        die($e->getMessage());

    }
}


/* =====================================================
   AKSI TIDAK DIKENALI
===================================================== */

else {

    if (!isset($_GET['aksi'])) {
        header("Location: ../view/data_kendaraan.php");
        exit;
    }
}

?>
