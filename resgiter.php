<?php

include('config/db_connect.php');
session_start();
$firstName = $lastName = $pass = $cpass = $email =  '';
$errors = array('cpass' => '', 'all' => '');

if (isset($_POST['submit-reg'])) {

    $email = $_POST['email'];

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    if ($cpass == $pass) {
    } else {
        $errors['cpass'] = 'Mật khẩu không khớp';
    }

    if (array_filter($errors)) {
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($conn, $query);

        $user = mysqli_num_rows($res);
        if ($user >= 1) {
            $errors['all'] = 'Email đã tồn tại';
        } else {
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            $strRandom = rand(1000, 9999);
            $activationCode = md5($strRandom);
            $sql = "INSERT INTO users (first_name, last_name, email, password, activation_code) VALUES ('$firstName', '$lastName', '$email', '$pass_hash', '$activationCode')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // echo "<script> alert('Đăng ký thành công'); </script>";
                header("Location: login.php?status=0");
                include 'core/sendmail.php';
            } else {
                echo "Đăng ký thất bại";
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <section>
        <div class="container h-100">

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">

                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                    <form class="mx-1 mx-md-4" method="POST">
                                        <?php if (isset($_POST['submit-reg'])) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $errors['all'] ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">
                                                <input type="text" name="firstName" id="form3Example1c" class="form-control" placeholder="Fist Name" />
                                                <label>Fist Name</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="text" name="lastName" id="form3Example1c" class="form-control" placeholder="Fist Name" />
                                                <label>Last Name</label>


                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="email" name="email" id="form3Example3c" placeholder="Your Email" class="form-control" />
                                                <label>Email</label>


                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">
                                                <input type="password" name="password" id="form3Example4c" placeholder="Password" class="form-control" />
                                                <label>Password</label>

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="password" name="cpassword" id="form3Example4cd" placeholder="Repeat your password" class="form-control" />
                                                <label>Repeat your password</label>


                                            </div>
                                        </div>

                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                            <label class="form-check-label" for="form2Example3">
                                                I agree all statements in <a href="#!">Terms of service</a>
                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="submit-reg" class="btn btn-primary btn-lg">Register</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-registration/draw1.png" class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('templates/footer.php'); ?>

</html>

</html>