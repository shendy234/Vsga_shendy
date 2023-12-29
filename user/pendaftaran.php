<?php
    include '../koneksi.php';
    session_start();

    // Cek jika belum login
    if (empty($_SESSION['email']) && empty($_SESSION['role'])) {
        echo "<script type='text/javascript'> alert('Anda belum login! Harap login terlebih dahulu!'); document.location.href = '../login.php'; </script>";
    }

    // Array pendidikan terakhir
    $pendidikan = [
        'TK', 'SD / MI', 'SMP / MTs', 'SMA / SMK / MA'
    ];

    // Query untuk mengambil data user
    $query = mysqli_query($koneksi, "SELECT * FROM data_pendaftaran WHERE user_id = '{$_SESSION['user_id']}'");
    $data = mysqli_fetch_assoc($query);

    // Cek jika sudah submit berkas
    $sql = mysqli_query($koneksi, "SELECT * FROM data_pendaftaran WHERE user_id = '{$_SESSION['user_id']}'");
    $count = mysqli_num_rows($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />

    <title>Pendaftaran Siswa Baru | PSB</title>

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

    b {
        color: red;
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
                        <span>Menu</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="registrasi.php">
                            <span><i class="fas fa-user"></i></span>
                            Registrasi Akun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                            <span><i class="fas fa-users"></i></span>
                            Pendaftaran Siswa Baru
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="status_pendaftaran.php">
                            <span><i class="fas fa-info-circle"></i></span>
                            Lihat Status Pendaftaran
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3>Pendaftaran Siswa Baru</h3>
                </div>
                <div id="content">
                    <?php if ($count != 0) : ?>
                        <div class="alert alert-success" role="alert">
                            Anda telah mengupload semua berkas! Silahkan cek status pendaftaran Anda <a href="status_pendaftaran.php">disini.</a>
                        </div>
                        <p><a href="index.php" class="btn btn-outline-dark">Kembali</a></p>
                    <?php else : ?>
                        <div class="alert alert-danger" role="alert">
                            Anda belum memenuhi semua berkas yang diperlukan! Harap mengisi semua berkas yang diperlukan di bawah ini!
                        </div>
                        <form action="../process.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="pendaftaran_siswa">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <tr>
                                        <td>
                                            <label class="form-label" for="pendidikan_terakhir">Pendidikan Terakhir <b>*</b></label>
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <select class="form-select form-select-sm" required name="pendidikan_terakhir" id="pendidikan_terakhir">
                                                        <?php foreach($pendidikan as $pend) : ?>
                                                            <option value="<?= $pend ?>" <?= !empty($data['pendidikan_terakhir']) && $data['pendidikan_terakhir'] == $pend ? ' selected="selected"' : ''?>><?= $pend ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <label class="form-label" for="pas_foto">Pas Foto <b>*</b></label>
                                                    <input required class="form-control" type="file" name="pas_foto" id="pas_foto" accept="image/*">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <label class="form-label" for="surat_pernyataan">Surat Pernyataan <b>*</b></label>
                                                    <input required class="form-control" type="file" name="surat_pernyataan" id="surat_pernyataan" accept="application/pdf, .pdf">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <label class="form-label" for="ijazah">Ijazah Terakhir <b>*</b></label>
                                                    <input required class="form-control" type="file" name="ijazah" id="ijazah" accept="application/pdf, .pdf">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <a href="index.php" class="btn btn-outline-dark">Kembali</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
