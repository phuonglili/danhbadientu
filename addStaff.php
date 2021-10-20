<?php

session_start();
include('config/db_connect.php');
$errors = array('name' => '', 'unit' => '', 'posison' => '', 'phone' => '', 'email' => '');

$query = "SELECT * FROM db_donvi";
$res = mysqli_query($conn, $query);
$units = mysqli_fetch_all($res, MYSQLI_ASSOC);
$name = $email = $phone = $posison = $selectunit = "";
if (isset($_POST['submit_staff'])) {

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
    if (empty($_POST['selectunit'])) {
        $errors['unit'] = 'Hãy chọn đơn vị';
    } else {
        $selectunit = $_POST['selectunit'];
    }
    if (empty($_POST['posison'])) {
        $errors['posison'] = 'Hãy chọn đơn vị';
    } else {
        $posison = $_POST['posison'];
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Hãy nhập số điện thoại';
    } else {
        $phone = $_POST['phone'];
    }

    if (array_filter($errors)) {
    } else {
        $sql = "INSERT INTO db_nhanvien (tennv, chucvu, email, sodidong, madv) VALUES ('$name', '$posison', '$email', '$phone', '$selectunit')";
        $res = mysqli_query($conn, $sql);
        header("Location: admin.php");
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <h2 class="text-center mt-2">Thêm Nhân Viên</h2>
    <form class="form-add" method="post" action="addStaff.php">
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Tên nhân viên</label>
            <input name="name" type="text" value="<?php echo htmlspecialchars($name); ?>" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['name'] ?></div>
        <div class="form-group  mt-2">
            <label for="exampleFormControlSelect1">Đơn vị</label>
            <select name="selectunit" class="form-select" id="exampleFormControlSelect1">
                <option value="">---Chọn Đơn vị---</option>
                <?php foreach ($units as $unit) : ?>
                    <option <?php if ($unit['madv'] == $selectunit) echo "selected" ?> value="<?php echo $unit['madv']; ?>"> <?php echo $unit['tendv']; ?> </option>
                <?php endforeach; ?>

            </select>
        </div>
        <div class="text-primary"> <?php echo $errors['unit'] ?></div>

        <div class="form-group mt-2">
            <label for=" exampleFormControlInput1">Chức vụ</label>
            <input name="posison" value="<?php echo htmlspecialchars($posison); ?>" type="text" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['posison'] ?></div>

        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Số điện thoại</label>
            <input name="phone" value="<?php echo htmlspecialchars($phone); ?>" type="tel" pattern="[0-9]{10}" class=" form-control" id="exampleFormControlInput1">
        </div>
        <div class="text-primary"> <?php echo $errors['phone'] ?></div>

        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Email</label>
            <input name="email" value="<?php echo htmlspecialchars($email); ?> " type="email" class="form-control" id="exampleFormControlInput1" placeholder="email">
        </div>
        <div class="text-primary"> <?php echo $errors['email'] ?></div>
        <div class="text-center mt-4">
            <button name="submit_staff" type="submit" class="btn btn-primary"> Submit </button>
        </div>
    </form>
</div>
<?php include('templates/footer.php'); ?>

</html>