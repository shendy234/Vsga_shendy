<?php
    include '../koneksi.php';
    session_start();

    // Cek jika belum login
    if (empty($_SESSION['email']) && empty($_SESSION['role'])) {
        echo "<script type='text/javascript'> alert('Anda belum login! Harap login terlebih dahulu!'); document.location.href = '../login.php'; </script>";
    }

    // Array agama
    $agama = [
        'Islam', 'Katolik', 'Protestan', 'Hindu', 'Budha'
    ];

    // Function untuk set aktif radio
    function active_radio_btn($value, $input) {
        $result = $value == $input ? 'checked' : '';
        return $result;
    }

    // Query untuk mengambil data user
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE user_id = '{$_SESSION['user_id']}'");
    $data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />

    <title>Registrasi Akun | PSB</title>

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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
                            <a class="nav-link active" href="#">
                            <span><i class="fas fa-user"></i></span>
                            Registrasi Akun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pendaftaran.php">
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
                    <h3>Registrasi Akun</h3>
                </div>
                <div id="content">
                    <div class="text-center align-items-center">
                        <h3>Silahkan melengkapi form untuk registrasi akun!</h3>
                    </div>
                    <hr>
                    <form action="../process.php" method="post">
                        <input type="hidden" name="type" value="registrasi_akun">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <td>
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                        <input class="form-control" readonly type="text" name="nama" id="nama" placeholder="Nama Lengkap" value="<?= !empty($data['nama']) ? $data['nama'] : '-' ?>">
                                    </td>
                                    <td>
                                        <label class="form-label" for="nisn">No. Identitas (NISN)</label>
                                        <input class="form-control" readonly type="text" name="nisn" id="nisn" placeholder="No. Identitas (NISN)" value="<?= !empty($data['nisn']) ? $data['nisn'] : '-' ?>">
                                    </td>
                                    <td>
                                        <label class="form-label" for="no_telpon">No. Handphone</label>
                                        <input class="form-control" readonly type="number" name="no_telpon" id="no_telpon" placeholder="No. Handphone" value="<?= !empty($data['no_telepon']) ? $data['no_telepon'] : '-' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" readonly type="email" name="email" id="email" placeholder="Email" value="<?= !empty($data['email']) ? $data['email'] : '-' ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin <b>*</b></label>
                                        <div class="form-check">
                                            <input required class="form-check-input" type="radio" name="jenis_kelamin" value="L" <?= active_radio_btn("L", $data['jenis_kelamin']) ?>>
                                            <label class="form-check-label">
                                                Laki - laki
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" <?= active_radio_btn("P", $data['jenis_kelamin']) ?>>
                                            <label class="form-check-label">
                                                Perempuan
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="form-label" for="agama">Agama <b>*</b></label>
                                        <select name="agama" id="agama" class="form-select" required>
                                            <?php foreach($agama as $agm) : ?>
                                                <option value="<?= $agm ?>" <?= $data['agama'] == $agm ? ' selected="selected"' : ''?>><?= $agm ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label" for="tempat_lahir">Tempat Lahir <b>*</b></label>
                                        <input required class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= !empty($data['tempat_lahir']) ? $data['tempat_lahir'] : ''?>">
                                    </td>
                                    <td>
                                        <label class="form-label" for="tempat_lahir">Tanggal Lahir <b>*</b></label>
                                        <input required class="form-control" type="date" name="tgl_lahir" id="tgl_lahir" value="<?= !empty($data['tgl_lahir']) ? $data['tgl_lahir'] : ''?>" max="2004-12-31">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label class="form-label" for="alamat">Alamat <b>*</b></label>
                                        <textarea required class="form-control" name="alamat" id="alamat" cols="100" rows="3" placeholder="Alamat"><?= !empty($data['alamat']) ? $data['alamat'] : ''?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="form-label" for="nama_ortu">Nama Orang Tua/Wali <b>*</b></label>
                                        <input required class="form-control" type="text" name="nama_ortu" id="nama_ortu" placeholder="Nama Orang Tua/Wali" value="<?= !empty($data['nama_ortu']) ? $data['nama_ortu'] : ''?>">
                                    </td>
                                    <td>
                                        <label class="form-label" for="no_telepon_ortu">Nomor Telepon Orang Tua/Wali <b>*</b></label>
                                        <input required class="form-control" type="number" name="no_telepon_ortu" id="no_telepon_ortu" placeholder="Nomor Telepon Orang Tua/Wali" value="<?= !empty($data['no_telepon_ortu']) ? $data['no_telepon_ortu'] : ''?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="index.php" class="btn btn-outline-dark">Kembali</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
