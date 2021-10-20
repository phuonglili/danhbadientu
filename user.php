<?php
session_start();
include('config/db_connect.php');
$errors = [];
$success = [];
if (!isset($_SESSION['email']) or !isset($_GET['id'])) header('Location:index.php');

$id = $_GET['id'] ?? null;
$level =  $_SESSION['level'];
if (($id == $_SESSION['id']) or ($level == 2)) {

    $query = "SELECT * from users where userid = '$id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $email = $user['email'];
    $userid = $user['userid'];

    // Đổi mật khẩu

    if (isset($_POST['change-pass'])) {

        $sql = "SELECT * FROM users where email = '$email'";
        $res = mysqli_query($conn, $sql);
        $pass = $user['user_level'] != 2 ? $_POST['password'] : null;
        $newpass = $_POST['newpassword'];
        $cpass = $_POST['cpassword'];
        $pass_saved = $user['password'];
        if (!password_verify($pass, $pass_saved) and $level != 2) $errors[] = 'Mật khẩu hiện tại không chính xác';


        if ($newpass != $cpass) $errors[] = 'Mật khẩu không khớp';
        if (empty($errors)) {
            $pass_hash = password_hash($newpass, PASSWORD_DEFAULT);
            $sql = "UPDATE users set password = '$pass_hash' where email = '$email'";
            $res = mysqli_query($conn, $sql);
            if ($res) $success[] = 'Thay đổi mật khẩu thành công';
        }
    }

    // Chỉnh sửa thông tin
    if (isset($_POST['edit-profile'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $birthday = $_POST['birthday'];
        $selectLevel = $_POST['selectLevel'];
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone_number='$phone_number', birthday = '$birthday', user_level = '$selectLevel' where userid = '$id'";

        $res = mysqli_query($conn, $sql);
        if ($res) {
            header("Location: user.php?id=$id");
        }
    }
} else {

    header('Location: admin.php');
}





?>


<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>
<div class="container">

    <div class="row mt-3">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?php echo $user['image']; ?>" id="img-file" alt="avatar" style="width: 150px; height: 150px" class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="mt-3 mb-4"> <?php echo  $user['last_name'] . ' ' . $user['first_name'] ?> </h5>
                    <div id="status-fail" class="status alert alert-danger d-none"></div>
                    <div id="status-success" class="status alert alert-success d-none"></div>

                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="file" id="fileUpload" name="fileUpload" class="form-control" id="inputGroupFile02">
                        <input type="hidden" id="userid" value="<?php echo $id ?>">
                    </form>
                    <button type="button" name="upload" id="upload" class="btn btn-primary my-4">Save changes</button>

                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?php foreach ($errors as $error) : ?>
                                    <div> <?php echo $error; ?> </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($success)) : ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?php foreach ($success as $noti) : ?>
                                    <div> <?php echo $noti; ?> </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-3">

                            <!-- Button trigger modal -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                Chỉnh sửa thông tin
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel">
                                                <i class="fas fa-user-edit"></i> Chỉnh sửa thông tin
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <section>
                                                <p class="text-center text-primary h2 fw-bold mb-4 mx-1 mx-md-4 mt-4">Chỉnh sửa</p>

                                                <form class="mx-1 mx-md-4 form-login" action="user.php?id=<?php echo $id ?>" method="POST">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form-group mt-2 flex-fill">
                                                                    <label for="exampleFormControlInput1" class="text-muted mb-1">Họ</label>
                                                                    <input name="last_name" type="text" value="<?php echo $user['last_name'] ?>" required class="form-control" id="exampleFormControlInput1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="d-flex flex-row align-items-center mb-4">
                                                                <div class="form-group mt-2 flex-fill">
                                                                    <label for="exampleFormControlInput1" class="text-muted mb-1">Tên</label>
                                                                    <input name="first_name" type="text" value="<?php echo $user['first_name'] ?>" required class="form-control" id="exampleFormControlInput1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form-group flex-fill mt-2">
                                                            <label for="exampleFormControlInput1" class="text-muted mb-1">Email</label>
                                                            <input name="email" type="email" disabled value="<?php echo $user['email'] ?>" required class="form-control" id="exampleFormControlInput1">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form-group flex-fill mt-2">
                                                            <label for="exampleFormControlInput1" class="text-muted mb-1">Sô điện thoại</label>
                                                            <input name="phone_number" type="text" value="<?php echo $user['phone_number'] ?>" required class="form-control" id="exampleFormControlInput1">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <div class="form-group flex-fill mt-2">
                                                            <label for="exampleFormControlInput1" class="text-muted mb-1">Ngày sinh</label>
                                                            <input name="birthday" value="<?php echo $user['birthday']; ?>" type="date" id="example" class="form-control">

                                                        </div>
                                                    </div>
                                                    <?php if ($level == 2) : ?>
                                                        <div class="d-flex flex-row align-items-center mb-4">

                                                            <div class="form-group flex-fill mt-2">
                                                                <label for="exampleFormControlSelect1" class="text-muted mb-1">Vai trò</label>
                                                                <select name="selectLevel" class="form-select" id="exampleFormControlSelect1">

                                                                    <option <?php if ($level == 0) echo 'selected'; ?> value="0">Người dùng</option>
                                                                    <option <?php if ($level == 1) echo 'selected'; ?> value="1">Admin</option>
                                                                    <option <?php if ($level == 2) echo 'selected'; ?> value="2">Manager</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="text-center">

                                                        <button type="submit" name="edit-profile" class=" btn btn-primary">Lưu thay đổi</button>
                                                    </div>


                                                </form>

                                            </section>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Họ và tên</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> <?php echo $user['last_name'] . ' ' . $user['first_name'] ?> </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> <?php echo $user['email']  ?> </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Số điện thoại</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo $user['phone_number'] ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Ngày sinh</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> <?php echo $user['birthday'] ?> </p>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Đổi mật khẩu
                            </button>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="mx-1 mx-md-4 form-login" action="user.php?id=<?php echo $id ?>" method="POST">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-floating flex-fill mb-0">

                                                <input type="email" value="<?php echo htmlspecialchars($email) ?>" name="email" id="form3Example3c" disabled placeholder="Your Email" class="form-control" />
                                                <label>Email</label>

                                            </div>
                                        </div>
                                        <?php if ($level != 2) : ?>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-floating flex-fill mb-0">
                                                    <input type="password" required name="password" id="form3Example4cd" placeholder="Repeat your password" class="form-control" />
                                                    <label>Mật khẩu hiện tại</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
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
                                            <button type="submit" name="change-pass" class="btn btn-primary btn-lg">Thay Đổi</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<?php include('templates/footer.php'); ?>

</html>