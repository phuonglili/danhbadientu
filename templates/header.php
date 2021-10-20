<head>
  <title>Danh bạ điện tử</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/app.css">


  <link rel="shortcut icon" href="images/logo/logo.png">
</head>

<body class="bg-light">
  <!--/.Navbar -->
  <!--Navbar -->
  <div class="header">
    <nav class="navbar navbar-expand-lg navbar-light " style="background-color: #e3f2fd;">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="images/logo/logo.png" height="30px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <?php if (isset($_SESSION['level'])) : ?>
              <?php if ($_SESSION['level'] == 1 or $_SESSION['level'] == 2) : ?>
                <li class="nav-item">
                  <a class="nav-link" href="admin.php">Admin</a>
                </li>
              <?php endif; ?>
              <?php if ($_SESSION['level'] == 2) : ?>
                <li class="nav-item">
                  <a class="nav-link" href="manager.php">Manager Users</a>
                </li>
              <?php endif; ?>
            <?php endif ?>

          </ul>
          <form class="d-flex me-auto">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
          <?php if (isset($_SESSION['email'])) : ?>
            <div class="auth d-flex">
              <p>Xin chào, <b><?php echo $_SESSION['name']; ?></b></p>
              <a class="px-1" href="logout.php">Logout</a>
            </div>
          <?php else : ?>
            <div class="auth">
              <a class="btn btn-primary m-1" href="login.php">Đăng nhập</a>
              <a class="btn btn-primary" href="register.php">Đăng ký</a>
            </div>
          <?php endif ?>


        </div>
      </div>
    </nav>
  </div>




  </div>