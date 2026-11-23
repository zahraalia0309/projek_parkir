<?php

function hitung_biaya_parkir($durasi_jam, $tarif_per_jam, $tarif_lebih_10_jam = 0, $tarif_24_jam = 0)
{
    $durasi_jam    = max(1, intval($durasi_jam));
    $tarif_per_jam = intval($tarif_per_jam);

    $hari  = 0;
    $sisa  = $durasi_jam;
    $biaya = 0;

    if ($tarif_24_jam > 0) {
        $hari  = intdiv($durasi_jam, 24);
        $sisa  = $durasi_jam - ($hari * 24);
        $biaya = $hari * $tarif_24_jam;
    }

    if ($sisa > 0) {

        $biaya_sisa = $sisa * $tarif_per_jam;

        if ($tarif_lebih_10_jam > 0) {
            if ($sisa > 10) {
                $biaya_sisa = $tarif_lebih_10_jam;
            } else {
                $biaya_sisa = min($biaya_sisa, $tarif_lebih_10_jam);
            }
        }

        if ($tarif_24_jam > 0) {
            $biaya_sisa = min($biaya_sisa, $tarif_24_jam);
        }

        $biaya += $biaya_sisa;
    }

    return $biaya;
}

?>