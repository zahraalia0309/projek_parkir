<?php

include "../model/m_koneksi.php";


/* =====================================================
   CEK ID TRANSAKSI
===================================================== */

if (!isset($_GET['id_parkir']) || empty($_GET['id_parkir'])) {
    die("ID transaksi tidak ditemukan.");
}

$id_parkir = intval($_GET['id_parkir']);


/* =====================================================
   AMBIL DATA TRANSAKSI
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT
        t.id_parkir,
        t.waktu_masuk,
        t.waktu_keluar,
        t.durasi_jam,
        t.biaya_total,
        t.status,

        k.plat_nomor,
        k.jenis_kendaraan,
        k.warna,
        k.pemilik,

        a.nama_area,

        u.nama_lengkap,

        tr.tarif_per_jam

    FROM tb_transaksi t

    LEFT JOIN tb_kendaraan k
        ON t.id_kendaraan = k.id_kendaraan

    LEFT JOIN tb_area_parkir a
        ON t.id_area = a.id_area

    LEFT JOIN tb_user u
        ON t.id_user = u.id_user

    LEFT JOIN tb_tarif tr
        ON t.id_tarif = tr.id_tarif

    WHERE t.id_parkir = $id_parkir

    LIMIT 1"
);


if (!$query) {
    die(
        "Query gagal: " .
        mysqli_error($conn)
    );
}


if (mysqli_num_rows($query) == 0) {
    die("Data transaksi tidak ditemukan.");
}


$transaksi = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cetak Struk - ParkirKu</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;
            padding: 30px;
            background: #f1f5f9;
            font-family: Arial, sans-serif;
            color: #172b4d;
        }


        .struk {
            width: 400px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }


        .header {
            text-align: center;
            border-bottom: 1px dashed #999;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }


        .header h1 {
            margin: 0;
            font-size: 25px;
        }


        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 13px;
        }


        .judul {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 20px;
        }


        .row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 14px;
        }


        .label {
            color: #64748b;
        }


        .value {
            font-weight: bold;
            text-align: right;
        }


        .status {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: #dcfce7;
            border-radius: 6px;
            font-weight: bold;
            color: #15803d;
        }


        .total {
            border-top: 1px dashed #999;
            margin-top: 15px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }


        .footer {
            border-top: 1px dashed #999;
            margin-top: 20px;
            padding-top: 15px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }


        .btn-print {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #287be8;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }


        .btn-back {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            border-radius: 7px;
            background: #e9eef5;
            color: #334155;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }


        @media print {

            body {
                background: white;
                padding: 0;
            }


            .struk {
                width: 100%;
                box-shadow: none;
                border-radius: 0;
            }


            .btn-print,
            .btn-back {
                display: none;
            }

        }

    </style>

</head>


<body>


<div class="struk">


    <!-- HEADER -->

    <div class="header">

        <h1>
            🚗 ParkirKu
        </h1>

        <p>
            Sistem Informasi Parkir
        </p>

    </div>


    <div class="judul">
        STRUK PARKIR
    </div>


    <!-- NOMOR TRANSAKSI -->

    <div class="row">

        <span class="label">
            No. Transaksi
        </span>

        <span class="value">
            #<?= $transaksi['id_parkir']; ?>
        </span>

    </div>


    <!-- PLAT -->

    <div class="row">

        <span class="label">
            Plat Nomor
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['plat_nomor'] ?? '-'); ?>
        </span>

    </div>


    <!-- JENIS -->

    <div class="row">

        <span class="label">
            Jenis Kendaraan
        </span>

        <span class="value">

            <?php

            if ($transaksi['jenis_kendaraan'] == 'motor') {

                echo "🏍️ Motor";

            } elseif ($transaksi['jenis_kendaraan'] == 'mobil') {

                echo "🚗 Mobil";

            } else {

                echo "🚙 Lainnya";

            }

            ?>

        </span>

    </div>


    <!-- WARNA -->

    <div class="row">

        <span class="label">
            Warna
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['warna'] ?? '-'); ?>
        </span>

    </div>


    <!-- PEMILIK -->

    <div class="row">

        <span class="label">
            Pemilik
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['pemilik'] ?? '-'); ?>
        </span>

    </div>


    <!-- AREA -->

    <div class="row">

        <span class="label">
            Area Parkir
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['nama_area'] ?? '-'); ?>
        </span>

    </div>


    <!-- PETUGAS -->

    <div class="row">

        <span class="label">
            Petugas
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['nama_lengkap'] ?? '-'); ?>
        </span>

    </div>


    <!-- WAKTU MASUK -->

    <div class="row">

        <span class="label">
            Waktu Masuk
        </span>

        <span class="value">
            <?= htmlspecialchars($transaksi['waktu_masuk'] ?? '-'); ?>
        </span>

    </div>


    <!-- WAKTU KELUAR -->

    <div class="row">

        <span class="label">
            Waktu Keluar
        </span>

        <span class="value">

            <?php

            if (empty($transaksi['waktu_keluar'])) {

                echo "-";

            } else {

                echo htmlspecialchars(
                    $transaksi['waktu_keluar']
                );

            }

            ?>

        </span>

    </div>


    <!-- STATUS -->

    <div class="status">

        STATUS:

        <?= strtoupper(
            htmlspecialchars($transaksi['status'])
        ); ?>

    </div>


    <!-- TARIF -->

    <div class="row">

        <span class="label">
            Tarif / Jam
        </span>

        <span class="value">

            Rp
            <?= number_format(
                $transaksi['tarif_per_jam'] ?? 0,
                0,
                ',',
                '.'
            ); ?>

        </span>

    </div>


    <!-- DURASI -->

    <div class="row">

        <span class="label">
            Durasi Parkir
        </span>

        <span class="value">

            <?= htmlspecialchars(
                $transaksi['durasi_jam'] ?? 0
            ); ?>

            jam

        </span>

    </div>


    <!-- TOTAL -->

    <div class="row total">

        <span>
            Total Biaya
        </span>

        <span>

            Rp
            <?= number_format(
                $transaksi['biaya_total'] ?? 0,
                0,
                ',',
                '.'
            ); ?>

        </span>

    </div>


    <!-- FOOTER -->

    <div class="footer">

        Terima kasih telah menggunakan
        <strong>ParkirKu</strong>.

        <br>

        Simpan struk ini sebagai bukti parkir.

    </div>


    <!-- CETAK -->

    <button
        class="btn-print"
        onclick="window.print()"
    >
        🖨️ Cetak Struk
    </button>


    <!-- KEMBALI -->

    <a
        href="transaksi.php"
        class="btn-back"
    >
        ← Kembali ke Transaksi
    </a>


</div>


</body>

</html>