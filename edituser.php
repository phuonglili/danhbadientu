<?php

include('config/db_connect.php');

session_start();

$id = $_GET['id'];
if (!$id) {
    header('Location: manager.php');
}
$sql = "SELECT * from users where userid = '$id'";
$res = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($res);
$email = $user['email'];



$pass = $cpass = "";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass = $_POST['password'];
    $newPass = $_POST['newpassword'];
    $cpass = $_POST['cpassword'];
    $pass_saved = $user['password'];
    if (!password_verify($pass, $pass_saved)) $errors[] = 'Mật khẩu hiện tại không chính xác';

    if ($newPass != $cpass) $errors[] = 'Mật khẩu không khớp';

    if (empty($errors)) {
        $pass_hash = password_hash($newPass, PASSWORD_DEFAULT);

        $sql = "UPDATE users set password = '$pass_hash'";
        $res = mysqli_query($conn, $sql);


        header("Location: manager.php");
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
                                    <?php if (!empty($errors)) : ?>
                                        <div class="alert alert-danger text-center" role="alert">
                                            <?php foreach ($errors as $error) : ?>
                                                <div> <?php echo $error; ?> </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="mx-1 mx-md-4 form-login" method="POST">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="email" value="<?php echo htmlspecialchars($email) ?>" name="email" id="form3Example3c" disabled placeholder="Your Email" class="form-control" />
                                                <label>Email</label>

                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">
                                                <input type="password" required name="password" id="form3Example4c" placeholder="Password" class="form-control" />
                                                <label>Mật khẩu hiện tại</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="password" required name="newpassword" id="form3Example4cd" placeholder="Repeat your password" class="form-control" />
                                                <label>Mật khẩu mới</label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="password" required name="cpassword" id="form3Example4cd" placeholder="Repeat your password" class="form-control" />
                                                <label>Nhập lại mật khẩu mới</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="submit-reg" class="btn btn-primary btn-lg">Thay Đổi</button>
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