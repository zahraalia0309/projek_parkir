```php
<?php

function catatAktivitas($conn, $aktivitas, $id_user = null)
{
    $id_user = $id_user !== null
        ? (int) $id_user
        : null;

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO tb_log_aktivitas
         (id_user, aktivitas, waktu_aktivitas)
         VALUES (?, ?, NOW())"
    );

    if (!$stmt) {
        error_log(
            "Gagal menyiapkan log aktivitas: " .
            mysqli_error($conn)
        );
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "is",
        $id_user,
        $aktivitas
    );

    $berhasil = mysqli_stmt_execute($stmt);

    if (!$berhasil) {
        error_log(
            "Gagal menyimpan log aktivitas: " .
            mysqli_stmt_error($stmt)
        );
    }

    mysqli_stmt_close($stmt);

    return $berhasil;
}

?>
```
