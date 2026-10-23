<?php 
 
include "../model/m_koneksi.php"; 
 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
 
<head> 
 
    <meta charset="UTF-8"> 
 
    <meta name="viewport" 
          content="width=device-width, initial-scale=1.0"> 
 
    <title>Tambah Kendaraan - ParkirKu</title> 
 
    <link rel="stylesheet" href="../asset/tambah_kendaraan.css"> 
 
</head> 
 
<body> 
 
 
<!-- ===================================================== 
     SIDEBAR 
===================================================== --> 
 
<aside class="sidebar"> 
 
    <div class="logo"> 
        🚗 <span>ParkirKu</span> 
    </div> 
 
 
    <div class="admin"> 
 
        <div class="avatar"> 
            👤 
        </div> 
 
        <div> 
            <strong>Admin</strong> 
 
            <small> 
                Administrator 
            </small> 
        </div> 
 
    </div> 
 
 
    <nav> 
 
        <a href="dashboard_admin.php"> 
            🏠 <span>Dashboard</span> 
        </a> 
 
 
        <a href="kelola_user.php"> 
            👥 <span>Kelola User</span> 
        </a> 
 
 
        <a href="tarif_parkir.php"> 
            💰 <span>Tarif Parkir</span> 
        </a> 
 
 
        <a href="area_parkir.php"> 
            🅿️ <span>Area Parkir</span> 
        </a> 
 
 
        <a href="data_kendaraan.php" 
           class="active"> 
            🚗 <span>Data Kendaraan</span> 
        </a> 
 
 
        <a href="log_aktivitas.php"> 
            📝 <span>Log Aktivitas</span> 
        </a> 
 
    </nav> 
 
 
    <a href="../controller/c_logout.php" 
       class="logout"> 
 
        ↪ <span>Logout</span> 
 
    </a> 
 
</aside> 
 
 
 
<!-- ===================================================== 
     MAIN 
===================================================== --> 
 
<main class="main"> 
 
 
    <!-- HEADER --> 
 
    <header class="header"> 
 
        <div> 
 
            <h1> 
                Tambah Kendaraan 
            </h1> 
 
            <p> 
                Tambahkan data kendaraan baru 
            </p> 
 
        </div> 
 
 
        <div class="profile"> 
            👤 Admin 
        </div> 
 
    </header> 
 
 
 
    <!-- ===================================================== 
         CARD 
    ===================================================== --> 
 
    <section class="card"> 
 
 
        <div class="card-header"> 
 
            <div> 
 
                <h2> 
                    Form Tambah Kendaraan 
                </h2> 
 
                <p> 
                    Silakan isi data kendaraan 
                </p> 
 
            </div> 
 
        </div> 
 
 
 
        <!-- ===================================================== 
             FORM 
        ===================================================== --> 
 
        <form action="../controller/c_kendaraan.php" 
              method="POST"> 
 
 
            <!-- PLAT NOMOR --> 
 
            <div class="form-group"> 
 
                <label> 
                    Plat Nomor 
                </label> 
 
                <input 
                    type="text" 
                    name="plat_nomor" 
                    placeholder="Contoh: B 1234 ABC" 
                    maxlength="11"
                    pattern="[A-Za-z]{1,2} [0-9]{1,4} [A-Za-z]{1,3}"
                    title="Format plat: maksimal 2 huruf, 4 angka, dan 3 huruf. Contoh: B 1234 ABC"
                    required 
                > 
 
            </div> 
 
 
 
            <!-- JENIS KENDARAAN --> 
 
            <div class="form-group"> 
 
                <label> 
                    Jenis Kendaraan 
                </label> 
 
                <select 
                    name="jenis_kendaraan" 
                    required 
                > 
 
                    <option value=""> 
                        -- Pilih Kendaraan -- 
                    </option> 
 
 
                    <option value="motor"> 
                        🏍️ Motor 
                    </option> 
 
 
                    <option value="mobil"> 
                        🚗 Mobil 
                    </option> 
 
 
                    <option value="lainnya"> 
                        🚙 Lainnya 
                    </option> 
 
                </select> 
 
            </div> 
 
 
 
            <!-- WARNA --> 
 
            <div class="form-group"> 
 
                <label> 
                    Warna Kendaraan 
                </label> 
 
                <input 
                    type="text" 
                    name="warna" 
                    placeholder="Contoh: Hitam" 
                    required 
                > 
 
            </div> 
 
 
 
            <!-- PEMILIK --> 
 
            <div class="form-group"> 
 
                <label> 
                    Pemilik 
                </label> 
 
                <input 
                    type="text" 
                    name="pemilik" 
                    placeholder="Nama pemilik kendaraan" 
                    required 
                > 
 
            </div> 
 
 
 
            <!-- BUTTON --> 
 
            <div class="form-actions"> 
 
                <a 
                    href="data_kendaraan.php" 
                    class="btn-cancel" 
                > 
                    Batal 
                </a> 
 
 
                <button 
                    type="submit" 
                    name="tambah" 
                    class="btn-save" 
                > 
                    Simpan Kendaraan 
                </button> 
 
            </div> 
 
 
        </form> 
 
    </section> 
 
</main> 
 
 
</body> 
</html>