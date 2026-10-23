<?php

session_start();

include "../model/m_koneksi.php";
include "../model/m_log_aktivitas.php";

if (isset($_SESSION['id_user'])) {
    catatAktivitas(
        $conn,
        "Logout sebagai " . ucfirst($_SESSION['role']),
        $_SESSION['id_user']
    );
}

session_unset();
session_destroy();

header("Location: ../view/login.php");
exit;

?>
```
