<?php

include('config/db_connect.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $id;
    $sql = "DELETE FROM db_nhanvien where manv = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header('Location: admin.php');
    } else {
        echo "Error";
    }
}