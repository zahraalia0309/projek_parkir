<?php

include "m_koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY id_user ASC");

$data_user = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>