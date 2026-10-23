
<?php

include "../model/m_koneksi.php";


/* =====================================================
   TAMBAH TRANSAKSI / KENDARAAN MASUK
===================================================== */

if (isset($_POST['tambah'])) {

    $id_kendaraan = intval($_POST['id_kendaraan'] ?? 0);
    $id_area      = intval($_POST['id_area'] ?? 0);
    $id_user      = intval($_POST['id_user'] ?? 0);

    if (
        $id_kendaraan <= 0 ||
        $id_area <= 0 ||
        $id_user <= 0
    ) {
        echo "<script>
            alert('Data transaksi belum lengkap.');
            window.location.href = '../view/transaksi.php';
        </script>";
        exit;
    }

    try {

        mysqli_begin_transaction($conn);

        // CEK KENDARAAN
        $query_kendaraan = mysqli_query(
            $conn,
            "SELECT id_kendaraan, jenis_kendaraan
             FROM tb_kendaraan
             WHERE id_kendaraan = $id_kendaraan
             LIMIT 1"
        );

        if (
            !$query_kendaraan ||
            mysqli_num_rows($query_kendaraan) == 0
        ) {
            throw new Exception("Data kendaraan tidak ditemukan.");
        }

        $kendaraan = mysqli_fetch_assoc($query_kendaraan);
        $jenis_kendaraan = $kendaraan['jenis_kendaraan'];


        // CEK KENDARAAN MASIH PARKIR
        $cek_transaksi = mysqli_query(
            $conn,
            "SELECT id_parkir
             FROM tb_transaksi
             WHERE id_kendaraan = $id_kendaraan
             AND status = 'masuk'
             LIMIT 1"
        );

        if (!$cek_transaksi) {
            throw new Exception("Gagal memeriksa transaksi kendaraan.");
        }

        if (mysqli_num_rows($cek_transaksi) > 0) {
            throw new Exception(
                "Kendaraan tersebut masih berada di area parkir."
            );
        }


        // CEK PETUGAS
        $query_user = mysqli_query(
            $conn,
            "SELECT id_user
             FROM tb_user
             WHERE id_user = $id_user
             AND role = 'petugas'
             AND status_aktif = 1
             LIMIT 1"
        );

        if (
            !$query_user ||
            mysqli_num_rows($query_user) == 0
        ) {
            throw new Exception(
                "Petugas tidak ditemukan atau sudah tidak aktif."
            );
        }


        // AMBIL TARIF
        $jenis_db = mysqli_real_escape_string(
            $conn,
            $jenis_kendaraan
        );

        $query_tarif = mysqli_query(
            $conn,
            "SELECT id_tarif, tarif_per_jam
             FROM tb_tarif
             WHERE jenis_kendaraan = '$jenis_db'
             LIMIT 1"
        );

        if (
            !$query_tarif ||
            mysqli_num_rows($query_tarif) == 0
        ) {
            throw new Exception(
                "Tarif untuk kendaraan tersebut belum tersedia."
            );
        }

        $tarif = mysqli_fetch_assoc($query_tarif);
        $id_tarif = intval($tarif['id_tarif']);


        // CEK AREA PARKIR DAN KUNCI BARISNYA
        $query_area = mysqli_query(
            $conn,
            "SELECT
                id_area,
                kapasitas,
                terisi,
                status_area
             FROM tb_area_parkir
             WHERE id_area = $id_area
             LIMIT 1
             FOR UPDATE"
        );

        if (
            !$query_area ||
            mysqli_num_rows($query_area) == 0
        ) {
            throw new Exception("Area parkir tidak ditemukan.");
        }

        $area = mysqli_fetch_assoc($query_area);


        // CEK STATUS AREA
        if ($area['status_area'] !== 'aktif') {
            throw new Exception(
                "Area parkir sudah nonaktif dan tidak dapat digunakan."
            );
        }


        // CEK KAPASITAS AREA
        if (
            intval($area['terisi']) >=
            intval($area['kapasitas'])
        ) {
            throw new Exception("Area parkir sudah penuh.");
        }


        // SIMPAN TRANSAKSI MASUK
        $query_insert = mysqli_query(
            $conn,
            "INSERT INTO tb_transaksi
            (
                id_kendaraan,
                waktu_masuk,
                waktu_keluar,
                id_tarif,
                durasi_jam,
                biaya_total,
                status,
                id_user,
                id_area
            )
            VALUES
            (
                $id_kendaraan,
                NOW(),
                NULL,
                $id_tarif,
                0,
                0,
                'masuk',
                $id_user,
                $id_area
            )"
        );

        if (!$query_insert) {
            throw new Exception(
                "Gagal menyimpan transaksi: " .
                mysqli_error($conn)
            );
        }


        // TAMBAH JUMLAH TERISI AREA
        $query_update_area = mysqli_query(
            $conn,
            "UPDATE tb_area_parkir
             SET terisi = terisi + 1
             WHERE id_area = $id_area
             AND status_area = 'aktif'
             AND terisi < kapasitas"
        );

        if (
            !$query_update_area ||
            mysqli_affected_rows($conn) != 1
        ) {
            throw new Exception(
                "Gagal memperbarui area parkir."
            );
        }


        // SIMPAN PERUBAHAN
        mysqli_commit($conn);

        echo "<script>
            alert('Transaksi kendaraan masuk berhasil.');
            window.location.href = '../view/transaksi.php';
        </script>";
        exit;

    } catch (Exception $e) {

        mysqli_rollback($conn);

        echo "<script>
            alert(" . json_encode($e->getMessage()) . ");
            window.location.href = '../view/transaksi.php';
        </script>";
        exit;
    }
}


/* =====================================================
   TRANSAKSI KELUAR
===================================================== */

elseif (
    isset($_GET['aksi']) &&
    $_GET['aksi'] == 'keluar'
) {

    $id_parkir = intval($_GET['id_parkir'] ?? 0);

    if ($id_parkir <= 0) {
        header("Location: ../view/transaksi.php");
        exit;
    }

    try {

        mysqli_begin_transaction($conn);

        // AMBIL TRANSAKSI YANG MASIH AKTIF
        $query = mysqli_query(
            $conn,
            "SELECT
                t.id_parkir,
                t.id_kendaraan,
                t.id_area,
                t.waktu_masuk,
                t.status,
                tr.tarif_per_jam
             FROM tb_transaksi t
             LEFT JOIN tb_tarif tr
                ON t.id_tarif = tr.id_tarif
             WHERE t.id_parkir = $id_parkir
             AND t.status = 'masuk'
             LIMIT 1"
        );

        if (
            !$query ||
            mysqli_num_rows($query) == 0
        ) {
            mysqli_rollback($conn);
            header("Location: ../view/transaksi.php");
            exit;
        }

        $transaksi = mysqli_fetch_assoc($query);

        $id_area = intval($transaksi['id_area']);

        if ($transaksi['tarif_per_jam'] === null) {
            throw new Exception(
                "Tarif transaksi tidak ditemukan."
            );
        }

        $tarif_per_jam = intval(
            $transaksi['tarif_per_jam']
        );


        // HITUNG DURASI PARKIR, PEMBULATAN KE ATAS
        $query_durasi = mysqli_query(
            $conn,
            "SELECT
                GREATEST(
                    1,
                    CEIL(
                        TIMESTAMPDIFF(
                            MINUTE,
                            waktu_masuk,
                            NOW()
                        ) / 60
                    )
                ) AS durasi_jam
             FROM tb_transaksi
             WHERE id_parkir = $id_parkir
             AND status = 'masuk'"
        );

        if (
            !$query_durasi ||
            mysqli_num_rows($query_durasi) == 0
        ) {
            throw new Exception(
                "Gagal menghitung durasi parkir."
            );
        }

        $data_durasi = mysqli_fetch_assoc($query_durasi);
        $durasi_jam = intval($data_durasi['durasi_jam']);


        // HITUNG TOTAL BIAYA
        $biaya_total = $durasi_jam * $tarif_per_jam;


        // SELESAIKAN TRANSAKSI
        $query_update = mysqli_query(
            $conn,
            "UPDATE tb_transaksi
             SET
                waktu_keluar = NOW(),
                durasi_jam = $durasi_jam,
                biaya_total = $biaya_total,
                status = 'keluar'
             WHERE id_parkir = $id_parkir
             AND status = 'masuk'"
        );

        if (
            !$query_update ||
            mysqli_affected_rows($conn) != 1
        ) {
            throw new Exception(
                "Transaksi gagal diselesaikan."
            );
        }


        // KURANGI JUMLAH TERISI AREA
        $query_update_area = mysqli_query(
            $conn,
            "UPDATE tb_area_parkir
             SET terisi = CASE
                WHEN terisi > 0 THEN terisi - 1
                ELSE 0
             END
             WHERE id_area = $id_area"
        );

        if (!$query_update_area) {
            throw new Exception(
                "Gagal memperbarui area parkir."
            );
        }


        // SIMPAN PERUBAHAN
        mysqli_commit($conn);

        echo "
        <script>
            alert(
                'Kendaraan berhasil keluar.\\n\\n' +
                'Durasi: $durasi_jam jam\\n' +
                'Biaya: Rp " .
                number_format($biaya_total, 0, ',', '.') .
                "'
            );

            window.location.href =
                '../view/cetak_struk.php?id_parkir=$id_parkir';
        </script>
        ";
        exit;

    } catch (Exception $e) {

        mysqli_rollback($conn);

        header("Location: ../view/transaksi.php");
        exit;
    }
}


/* =====================================================
   AKSI TIDAK DIKENALI
===================================================== */

else {
    header("Location: ../view/transaksi.php");
    exit;
}

?>
