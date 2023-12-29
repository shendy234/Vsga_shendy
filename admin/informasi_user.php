<?php
    include '../koneksi.php';
    session_start();

    // Cek jika sudah login dan memiliki otorisasi
    if (empty($_SESSION['email']) && empty($_SESSION['role'])) {
        echo "<script type='text/javascript'> alert('Anda belum login! Harap login terlebih dahulu!'); document.location.href = '../login.php'; </script>";
    } else if ($_SESSION['role'] != 1) {
        echo "<script type='text/javascript'> alert('Anda tidak memiliki otorisasi!'); document.location.href = '../logout.php'; </script>";
    }

    // Query
    $query = mysqli_query($koneksi, "SELECT * FROM users LEFT JOIN data_pendaftaran ON users.user_id = data_pendaftaran.user_id");

    // Loop iteration
    $i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />

    <title>Beranda | PSB - Admin</title>

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css"/>

    <script src="https://kit.fontawesome.com/a3764fe608.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">PSB - Q</a>
        <ul class="navbar-nav w-100">
            <li class="nav-item">
                <p style="color:white" class="text-center mb-2">PSB Online <br> Pendaftaran Siswa Baru</p>
            </li>
        </ul>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="../logout.php" onclick="return confirm('Apakah anda yakin ingin melakukan logout?');">Sign out</a>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                            <span><i class="fas fa-home"></i></span>
                            Beranda
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                        <span>Admin</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                            <span><i class="fas fa-users"></i></span>
                            Informasi User
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3>Beranda</h3>
                </div>
                <div id="content">
                    <div class="text-center align-items-center">
                        <br>
                        <h3>Informasi User</h3>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No. Identitas (NISN)</th>
                                        <th>Email</th>
                                        <th>No. Handphone</th>
                                        <th>Berkas</th>
                                        <th>Status Pendaftaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($query as $d) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= !empty($d['nisn']) ? $d['nisn'] : '-' ?></td>
                                        <td><?= !empty($d['email']) ? $d['email'] : '-' ?></td>
                                        <td><?= !empty($d['no_telepon']) ? $d['no_telepon'] : '-' ?></td>
                                        <td><?= $d['pas_foto'] && $d['ijazah'] && $d['surat_pernyataan'] ? 'SUDAH LENGKAP' : 'BELUM MENGUMPULKAN' ?></td>
                                        <td><?= !empty($d['status_pendaftaran']) ? $d['status_pendaftaran'] : '-' ?></td>
                                    </tr>
                                <?php
                                    $i++;
                                    endforeach; 
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
