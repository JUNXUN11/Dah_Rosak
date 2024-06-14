<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="login-style.css">
</head>

<body>


  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <img src="assets/img/login.png" class="img-fluid" alt="Phone image" height="300px" width="600px">
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

          <form action="login.php" method="post">
            <p class="text-center h2 fw-bold mb-4 mx-1 mx-md-3 mt-3">Login </p>
            <!-- Email input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example13"> <i class="bi bi-person-circle pe-2"></i> Email Address</label>
              <input type="email" name="email" class="form-control form-control-lg py-3" name="email" autocomplete="off" placeholder="enter your e-mail" style="border-radius:25px ;" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example23"><i class="bi bi-chat-left-dots-fill pe-2"></i> Password</label>
              <input type="password" name="password" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="enter your password" style="border-radius:25px ;" />
            </div>

            <!--Choose role -->
            <div class="mb-1">
              <i class="bi bi-person-bounding-box pe-2" ></i>
		          <label class="form-label">Select User Type:</label>
		        </div>
		        <select class="form-select mb-3"
		                name="selected_role" 
                    style="border-radius:25px ;"
		                aria-label="Default select example">
			        <option selected value="user">User</option>
			        <option value="admin">Admin</option>
		        </select><br>

            <!--CHECK INPUT-->
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: smaller;">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  <small><?=$_GET['error']?></small>
                </div>
              <?php } ?>

            
            <!-- Submit button -->
            <!-- <button type="submit" class="btn btn-primary btn-lg">Login in</button> -->
            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
              <input type="submit" value="Sign in" name="login" class="btn btn-primary btn-lg text-light my-2 py-3" style="width:100% ; border-radius: 30px; font-weight:600;" />
            </div>

          </form>
          <p align="center">i don't have any account <a href="registerpage.php" class="text-primary" style="font-weight:600;text-decoration:none;">Register Here</a></p>
        </div>
      </div>
    </div>
  </section>







  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>