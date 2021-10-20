<?php

session_start();
include('config/db_connect.php');

$sql = 'SELECT * from users';
$res = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($res, MYSQLI_ASSOC);


// Edit user


?>



<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-md-6">

            <a href="register.php" class="btn btn-success my-3">Thêm người dùng</a>
            <form method="post" action="" class="d-flex me-auto mb-3">
                <input id="search_users" class="form-control me-2" type="search" placeholder="Tìm kiếm theo tên, email hoặc level" aria-label="Search">
            </form>
            <div class="table-responsive">

                <table id="table_users" class="table table-bordered m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Level</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $i => $user) : ?>
                            <tr>
                                <th scope="row"><?php echo $i + 1; ?></th>
                                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['registration_date']; ?></td>
                                <td><?php echo $user['status'] == 0 ? "Not Activated" : "Activated"; ?></td>
                                <?php
                                $status = '';
                                switch ($user['user_level']) {
                                    case 0:
                                        $status = "User";
                                        break;
                                    case 1:
                                        $status = "Admin";
                                        break;

                                    case 2:
                                        $status = "Manager";
                                        break;
                                }

                                ?>
                                <td><?php echo $status; ?></td>

                                <td><a class="text-primary" href="user.php?id=<?php echo $user['userid']; ?>"><i class="fas fa-edit "></i></a></td>

                                <td><a class="text-danger" href="deleteUser.php?id=<?php echo $user['userid']; ?>"><i class="fas fa-trash"></i></a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>

<?php include('templates/footer.php'); ?>