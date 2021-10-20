<?php

session_start();
include('config/db_connect.php');
$errors = array('name' => '', 'unit' => '', 'location' => '', 'phone' => '', 'email' => '', 'website' => '');
$id = $_GET['id'] ?? null;

$query = "SELECT * FROM db_donvi where madv = '$id'";
$res = mysqli_query($conn, $query);
$unit = mysqli_fetch_assoc($res);
$name = $unit['tendv'];
$email = $unit['email'];
$phone = $unit['dienthoai'];
$website = $unit['website'];
$location = $unit['diachi'];
$selectunit = $unit['madv_cha'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['email'])) {
        $errors['email'] = 'Hãy nhập email người dùng';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
    }

    if (empty($_POST['name'])) {
        $errors['name'] = 'Hãy nhập tên người dùng';
    } else {
        $name = $_POST['name'];
    }
    if (empty($_POST['website'])) {
        $errors['website'] = 'Hãy nhập website';
    } else {
        $website = $_POST['website'];
    }
    if (empty($_POST['location'])) {
        $errors['location'] = 'Hãy nhập địa chỉ';
    } else {
        $location = $_POST['location'];
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Hãy nhập số điện thoại';
    } else {

        $phone = $_POST['phone'];
    }
    $selectunit = $_POST['selectunit'];
    if (array_filter($errors)) {
        echo 'errors in form';
    } else {
        $sql = "UPDATE db_donvi set tendv = '$name', diachi = '$location', email =  '$email', website = '$website',  dienthoai = '$phone', madv_cha = NULLIF('$selectunit', 'NULL') where madv = '$id'";
        $res = mysqli_query($conn, $sql);
        header("Location: admin.php");
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <h2 class="text-center mt-2">Sửa Đơn vị</h2>
    <form class="form-add" method="POST">
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Tên Đơn vị</label>
            <input name="name" type="text" value="<?php echo htmlspecialchars($name); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-secondary"> <?php echo $errors['name']; ?> </div>
        <div class="form-group mt-2">
            <label for=" exampleFormControlInput1">Địa chỉ</label>
            <input name="location" type="text" value="<?php echo htmlspecialchars($location); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-secondary"> <?php echo $errors['location']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Số điện thoại</label>
            <input name="phone" type="text" value="<?php echo htmlspecialchars($phone); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-secondary"> <?php echo $errors['phone']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Email</label>
            <input name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" id="exampleFormControlInput1" placeholder="email">
        </div>
        <div class="text-secondary"> <?php echo $errors['email']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Website</label>
            <input name="website" type="text" value="<?php echo htmlspecialchars($website); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-secondary"> <?php echo $errors['website']; ?> </div>
        <?php
        include('config/db_connect.php');
        $query = "SELECT * FROM db_donvi";
        $res = mysqli_query($conn, $query);
        $units = mysqli_fetch_all($res, MYSQLI_ASSOC);
        ?>
        <div class="form-group mt-2">
            <label for="exampleFormControlSelect1">Thuộc đơn vị</label>
            <select name="selectunit" class="form-select" id="exampleFormControlSelect1">
                <option value="NULL">Không</option>
                <?php  ?>
                <?php foreach ($units as $unit) : ?>
                    <option <?php if ($unit['madv'] == $selectunit) echo "selected" ?> value="<?php echo $unit['madv']; ?>"> <?php echo $unit['tendv']; ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="text-center mt-4">
            <button name="submit_unit" type="submit" class="btn btn-primary"> Submit </button>
        </div>
    </form>
</div>
<?php include('templates/footer.php'); ?>

</html>