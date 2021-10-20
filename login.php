<?php

include('config/db_connect.php');

session_start();

$email = $password  = null;
$errors = array('all' => '');
$noti = "";
if (isset($_GET['status']))  $noti = $_GET['status'] == 0 ? "Đăng ký thành công, vui lòng kiểm tra email để kích hoạt tài khoản" : "Kích hoạt tài khoản thành công";
if (isset($_POST['submit-login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * From users where email = '$email'";
    $res = mysqli_query($conn, $query);
    $row = mysqli_num_rows($res);

    if ($row > 0) {
        $user = mysqli_fetch_assoc($res);
        $pass_saved = $user['password'];
        if ($user['status'] == 0) {
            $errors['all'] = "Tài khoản chưa được kích hoạt";
        } else {
            if (password_verify($password, $pass_saved)) {

                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['last_name'] . ' ' . $user['first_name'];
                $_SESSION['level'] = $user['user_level'];
                $_SESSION['id'] = $user['userid'];
                $_SESSION['image'] = $user['image'];
                header('Location: admin.php');
            } else {
                $errors['all'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
                $email = $password  = "";
            }
        }
    } else {
        $errors['all'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
        $email = $password  = "";
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
                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign in</p>
                                    <?php if (isset($_GET['status'])) : ?>
                                        <div class="alert alert-success text-center " role="alert">
                                            <?php echo $noti ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="mx-1 mx-md-4 form-login" method="POST">
                                        <?php if (isset($_POST['submit-login'])) : ?>
                                            <div class="alert alert-danger text-center" role="alert">
                                                <?php echo $errors['all'] ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-floating flex-fill mb-0">
                                                <input type="email" name="email" id="form3Example3c" placeholder="Your Email" class="form-control" required />
                                                <label>Email</label>

                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-floating flex-fill mb-0">
                                                <input type="password" name="password" id="form3Example4c" placeholder="Password" class="form-control" required />
                                                <label>Password</label>

                                            </div>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p>Don't have an account? <a href="register.php" class="link-info">Register here</a></p>

                                        <div class="pt-1 mb-4 ">
                                            <button class="btn btn-dark btn-lg w-100" name="submit-login" type="submit">Log in</button>
                                        </div>

                                        <div class="divider d-flex align-items-center my-4">
                                            <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
                                        </div>

                                        <button class="btn btn-outline-danger w-100 mb-3" type="button"><i class="fab fa-google me-2"></i> Sign in with google</button>
                                        <button class="btn btn-outline-primary w-100" type="button"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button>

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