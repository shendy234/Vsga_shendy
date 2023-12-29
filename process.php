<?php
    include 'koneksi.php';

    // MPdf
    require_once __DIR__ . '/vendor/autoload.php';

    if (isset($_GET['export'])) {
        exportPdf($_GET['export']);
    }

    if (isset($_POST['type'])) {
        switch ($_POST['type']) {
            case 'register' :
                register($_POST);
                break;
            case 'login' :
                login($_POST);
                break;
            case 'registrasi_akun' :
                registrasiAkun($_POST);
                break;
            case 'pendaftaran_siswa' :
                pendaftaranSiswa($_POST);
                break;
            case 'update_status' :
                updateStatus($_POST);
                break;
        }
    }

    function register($data)
    {
        global $koneksi;

        // Define variable
        $nama = $data['nama'];
        $nisn = $data['nisn'];
        $no_telpon = $data['no_telpon'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Query untuk save ke db
        $query = "INSERT INTO users (nama, nisn, no_telepon, email, password) VALUES ('$nama', '$nisn', '$no_telpon', '$email', '$password')";

        // Exec
        $process = mysqli_query($koneksi, $query);

        // Error check
        if ($process) {
            echo "<script type='text/javascript'> alert('Registrasi berhasil!'); document.location.href = 'login.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Registrasi gagal!'); document.location.href = 'register.php'; </script>";
        }
    }

    function login($data)
    {
        global $koneksi;
        session_start();

        // Define variable
        $email = $data['email'];
        $password = $data['password'];

        // Query untuk mendapatkan user
        $query = "SELECT * FROM users WHERE email = '$email'";

        // Exec
        $process = mysqli_query($koneksi, $query);

        // Fetch data
        $data_user = mysqli_fetch_assoc($process);

        // Check user
        if ($data_user) {
            if (password_verify($password, $data_user['password'])) {
                $_SESSION['user_id'] = $data_user['user_id'];
                $_SESSION['email'] = $data_user['email'];
                $_SESSION['role'] = $data_user['role'];
                if ($data_user['role'] == 1) {
                    echo "<script type='text/javascript'> alert('Login berhasil! Selamat datang admin!'); document.location.href = 'admin/index.php'; </script>";
                } else {
                    echo "<script type='text/javascript'> alert('Login berhasil! Selamat datang calon siswa!'); document.location.href = 'user/index.php'; </script>";
                }
            } else {
                echo "<script type='text/javascript'> alert('Login gagal! Harap login kembali!'); document.location.href = 'login.php'; </script>";
            }
        } else {
            echo "<script type='text/javascript'> alert('User tidak ditemukan! Harap login kembali!'); document.location.href = 'login.php'; </script>";
        }
    }

    function registrasiAkun($data)
    {
        global $koneksi;

        // Define variable
        $user_id = $data['user_id'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $agama = $data['agama'];
        $tempat_lahir = $data['tempat_lahir'];
        $tgl_lahir = $data['tgl_lahir'];
        $alamat = $data['alamat'];
        $nama_ortu = $data['nama_ortu'];
        $no_telepon_ortu = $data['no_telepon_ortu'];

        // Query update data user
        $query = "UPDATE users SET jenis_kelamin = '$jenis_kelamin', agama = '$agama', tempat_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', alamat = '$alamat', nama_ortu  = '$nama_ortu', no_telepon_ortu = '$no_telepon_ortu' WHERE user_id = '$user_id'";

        // Exec
        $process = mysqli_query($koneksi, $query);

        // Error check
        if ($process) {
            echo "<script type='text/javascript'> alert('Registrasi data berhasil!'); document.location.href = 'user/index.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Proses gagal! Silahkan coba lagi!'); document.location.href = 'user/registrasi.php'; </script>";
        }
    }

    function pendaftaranSiswa($data)
    {
        global $koneksi;

        // Define variable
        $user_id = $data['user_id'];
        $pendidikan_terakhir = $data['pendidikan_terakhir'];

        // Pengecekan tipe file PDF
        $surat_pernyataan_tipe = $_FILES['surat_pernyataan']['type'];
        $ijazah_tipe = $_FILES['ijazah']['type'];

        if ($surat_pernyataan_tipe && $ijazah_tipe == 'application/pdf') {
            $init_query = "INSERT INTO data_pendaftaran (user_id, pendidikan_terakhir) VALUES ('$user_id', '$pendidikan_terakhir')";
            // Exec init query
            mysqli_query($koneksi, $init_query);

            // Get id terakhir
            $query = mysqli_query($koneksi, "SELECT pendaftaran_id FROM data_pendaftaran ORDER BY pendaftaran_id DESC LIMIT 1");
            $data = mysqli_fetch_array($query);

            // Rename file PDF
            $pas_foto_baru = 'pas_foto_' . $data['pendaftaran_id'] . '.jpg';
            $pas_foto_tmp = $_FILES['pas_foto']['tmp_name'];

            $surat_pernyataan_baru = 'surat_pernyataan_' . $data['pendaftaran_id'] . '.pdf';
            $surat_pernyataan_tmp = $_FILES['surat_pernyataan']['tmp_name'];
            
            $ijazah_baru = 'ijazah_' . $data['pendaftaran_id'] . '.pdf'; 
            $ijazah_tmp = $_FILES['ijazah']['tmp_name'];

            $folder = '/files';

            // Memindahkan file yang diupload
            define ('SITE_ROOT', realpath(dirname(__FILE__)));
            move_uploaded_file($pas_foto_tmp, SITE_ROOT . "$folder/$pas_foto_baru");
            move_uploaded_file($surat_pernyataan_tmp, SITE_ROOT . "$folder/$surat_pernyataan_baru");
            move_uploaded_file($ijazah_tmp, SITE_ROOT . "$folder/$ijazah_baru");

            // Mengubah path file pada database
            $update = mysqli_query($koneksi, "UPDATE data_pendaftaran SET pas_foto = '$pas_foto_baru', ijazah = '$ijazah_baru', surat_pernyataan = '$surat_pernyataan_baru' WHERE pendaftaran_id = '$data[pendaftaran_id]'");

            // Error check
            if ($update) {
                echo "<script type='text/javascript'> alert('Upload berkas berhasil! Terima kasih!'); document.location.href = 'user/index.php'; </script>";
            }
        } else {
            echo "<script type='text/javascript'> alert('Gagal upload file! Pastikan file format PDF!'); document.location.href = 'user/index.php'; </script>";
        }
    }

    function updateStatus($data)
    {
        global $koneksi;

        // Define variables
        $pendaftaran_id = $data['pendaftaran_id'];
        $status_pendaftaran = $data['status_pendaftaran'];

        // Query
        $query = mysqli_query($koneksi, "UPDATE data_pendaftaran SET status_pendaftaran = '$status_pendaftaran' WHERE pendaftaran_id = '$pendaftaran_id'");

        if ($query) {
            echo "<script type='text/javascript'> alert('Status pendaftaran berhasil diubah!'); document.location.href = 'admin/index.php'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('Gagal mengubah status pendaftaran!'); document.location.href = 'admin/index.php'; </script>";
        }
    }

    function exportPdf($type)
    {
        global $koneksi;
        $html = '';
        switch ($type) {
            case 'inf-pendaftaran' :
                // Query
                $query = mysqli_query($koneksi, "SELECT * FROM data_pendaftaran INNER JOIN users ON data_pendaftaran.user_id = users.user_id");
                $html = '
                    <html>
                    <head>
                    <style>
                    body {font-family: sans-serif;
                        font-size: 10pt;
                    }
                    p {	margin: 0pt; }
                    table.items {
                        border: 0.1mm solid #000000;
                    }
                    td { vertical-align: top; }
                    .items td {
                        border-left: 0.1mm solid #000000;
                        border-right: 0.1mm solid #000000;
                    }
                    table thead td { background-color: #EEEEEE;
                        text-align: center;
                        border: 0.1mm solid #000000;
                        font-variant: small-caps;
                    }
                    .items td.blanktotal {
                        background-color: #EEEEEE;
                        border: 0.1mm solid #000000;
                        background-color: #FFFFFF;
                        border: 0mm none #000000;
                        border-top: 0.1mm solid #000000;
                        border-right: 0.1mm solid #000000;
                    }
                    .items td.totals {
                        text-align: right;
                        border: 0.1mm solid #000000;
                    }
                    .items td.cost {
                        text-align: "." center;
                    }
                    </style>
                    </head>
                    <body>
                    <!--mpdf
                    <htmlpagefooter name="myfooter">
                    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
                    Page {PAGENO} of {nb}
                    </div>
                    </htmlpagefooter>
                    <sethtmlpagefooter name="myfooter" value="on" />
                    mpdf-->
                    <div style="text-align: right">Date: ' . date('d F Y') . '</div>
                    <div style="text-align: center; font-style: italic;"><b>Informasi Pendaftaran PSB</b></div>
                    <hr />
                    <br />
                    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
                    <thead>
                    <tr>
                        <td width="15%" rowspan="2">ID Pendaftaran</td>
                        <td width="15%" rowspan="2">Nama Lengkap</td>
                        <td width="45%" colspan="3">Berkas</td>
                        <td width="15%" rowspan="2">Status Pendaftaran</td>
                    </tr>
                    <tr>
                        <td>Pas Foto</td>
                        <td>Ijazah</td>
                        <td>Surat Pernyataan</td>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- ITEMS HERE -->';
                    foreach ($query as $data) {
                        $html .= "<tr>
                                <td align='center'> $data[pendaftaran_id] </td>
                                <td> $data[nama] </td>
                                <td align='center'>". (!empty($data['pas_foto']) ? "OK" : '-') ."</td>
                                <td align='center'>". (!empty($data['ijazah']) ? "OK" : "-") ."</td>
                                <td align='center'>". (!empty($data['surat_pernyataan']) ? "OK" : "-") ."</td>
                                <td> $data[status_pendaftaran] </td>
                            </tr>";
                    } 
                    $html .= 
                    '<!-- END ITEMS HERE -->
                    </tbody>
                    </table>
                    </body>
                    </html>
                ';
                break;
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
?>
