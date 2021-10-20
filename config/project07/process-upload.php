<?php
$target_dir = "images/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

echo $target_file;

echo '<pre>';
echo print_r($_FILES['fileToUpload']);
echo '</pre>';
// Check if image file is a actual image or fake image
if (isset($_POST["sbmUpload"])) {
  if (file_exists($target_file)) {
    echo "Xin lỗi, file ảnh đã tồn tại ";
    $uploadOk = 0;
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "Tập tin đã tải lên thành công";
    } else {
      echo "Thất bại";
    }
  }
}
?>