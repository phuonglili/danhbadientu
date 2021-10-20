<?php

session_start();
include('config/db_connect.php');

$query = "SELECT * FROM db_donvi";
$res = mysqli_query($conn, $query);
$units = mysqli_fetch_all($res, MYSQLI_ASSOC);
$name = $email  = $phone = $location = $website =  $selectunit = "";
$errors = array('name' => '', 'init' => '', 'location' => '', 'phone' => '', 'email' => '', 'website' => '');
if (isset($_GET['submit_unit'])) {

    if (empty($_GET['email'])) {
        $errors['email'] = 'Hãy nhập email người dùng';
    } else {
        $email = $_GET['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
    }

    if (empty($_GET['name'])) {
        $errors['name'] = 'Hãy nhập tên người dùng';
    } else {
        $name = $_GET['name'];
    }
    if (empty($_GET['website'])) {
        $errors['website'] = 'Hãy nhập website';
    } else {
        $website = $_GET['website'];
    }
    if (empty($_GET['location'])) {
        $errors['location'] = 'Hãy chọn đơn vị';
    } else {
        $location = $_GET['location'];
    }
    if (empty($_GET['phone'])) {
        $errors['phone'] = 'Hãy nhập số điện thoại';
    } else {

        $phone = $_GET['phone'];
    }
    $selectunit = $_GET['selectunit'];

    if (array_filter($errors)) {
        echo 'errors in form';
    } else {
        $sql = "INSERT INTO db_donvi (tendv, diachi,  email,website, dienthoai, madv_cha) VALUES ('$name', '$location', '$email', '$website', '$phone', NULLIF('$selectunit', 'NULL'))";

        $res = mysqli_query($conn, $sql);
        header("Location: admin.php");
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <h2 class="text-center mt-2">Thêm Đơn vị</h2>
    <form class="form-add" method="get" action="addUnit.php">
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Tên Đơn vị</label>
            <input name="name" type="text" value="<?php echo htmlspecialchars($name); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['name']; ?> </div>
        <div class="form-group mt-2">
            <label for=" exampleFormControlInput1">Địa chỉ</label>
            <input name="location" type="text" value="<?php echo htmlspecialchars($location); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['location']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Số điện thoại</label>
            <input name="phone" type="text" value="<?php echo htmlspecialchars($phone); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['phone']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Email</label>
            <input name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" id="exampleFormControlInput1" placeholder="email">
        </div>
        <div class="text-primary"> <?php echo $errors['email']; ?> </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Website</label>
            <input name="website" type="text" value="<?php echo htmlspecialchars($website); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
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
        <div class="text-primary"> <?php echo $errors['website']; ?> </div>
        <div class="text-center mt-4">
            <button name="submit_unit" type="submit" class="btn btn-primary"> Submit </button>
        </div>
    </form>
</div>
<?php include('templates/footer.php'); ?>

</html>