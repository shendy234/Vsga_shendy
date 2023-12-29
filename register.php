<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | PSB</title>

    <!-- Custom styles -->
    <link href="css/auth.css" rel="stylesheet">

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        b {
            color: red;
        }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Daftar Sekarang!</h1>
                            </div>
                            <form action="process.php" method="post" onsubmit="return formCheck();" class="user">
                                <input type="hidden" name="type" value="register"/>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap <b>*</b></label>
                                    <input class="form-control form-control-user" type="text" name="nama" id="nama" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="nisn">No. Identitas (NISN) <b>*</b></label>
                                        <input class="form-control form-control-user" type="text" name="nisn" id="nisn" placeholder="No. Identitas (NISN)" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="no_telpon">No. Handphone <b>*</b></label>
                                        <input class="form-control form-control-user" type="number" name="no_telpon" id="no_telpon" placeholder="No. Handphone" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <b>*</b></label>
                                    <input class="form-control form-control-user"type="email" name="email" id="email" placeholder="Email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="password">Password <b>*</b></label>
                                        <input class="form-control form-control-user"type="password" name="password" id="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="pw_conf">Konfirmasi Password <b>*</b></label>
                                        <input class="form-control form-control-user"type="password" name="pw_conf" id="pw_conf" placeholder="Konfirmasi Password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    

    <script>
        function formCheck() {
            var pw = document.getElementById('password');
            var conf_pw = document.getElementById('pw_conf');

            if (pw.value != conf_pw.value) {
                alert('Password tidak cocok!');
                pw.focus();
                return false;
            } else if (pw.value.length < 6) {            
                alert('Password minimal 6 karakter!');
                pw.focus();
                return false;
            } else {
                return true;
            }
        }
    </script>
</body>
</html>
