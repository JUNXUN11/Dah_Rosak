<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $er = 0;
  
  // Sanitize and validate input
  $firstName = trim($_POST['firstName']);
  if (empty($firstName)) {
    $er++;
    $firstNameErr = "Name is required";
  }

  $lastName = trim($_POST['lastName']);
  if (empty($lastName) || !preg_match("/^[0-9+]*$/", $lastName)) {
    $er++;
    $lastNameErr = "Valid Telephone Number is required";
  }

  $location = trim($_POST['location']);
  if (empty($location)) {
    $er++;
    $locationErr = "Location is required";
  }

  $floor = trim($_POST['floor']);
  if (empty($floor)) {
    $er++;
    $floorErr = "Floor selection is required";
  }

  $damageType = trim($_POST['damageType']);
  if (empty($damageType)) {
    $er++;
    $damageTypeErr = "Damage type selection is required";
  }

  $roomNumber = trim($_POST['roomNumber']);
  if (empty($roomNumber)) {
    $er++;
    $roomNumberErr = "Room or Toilet Number is required";
  }

  if ($er == 0) {
    // Proceed with storing the data
    // e.g., insert into database
  } else {
    echo "Please fix the errors and try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Service Details - QuickStart Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/main.css">

  <!-- Main CSS File -->
  <link href="report_style.css" rel="stylesheet">
  <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: May 18 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    
    .container {
      overflow: hidden;
    }

    .container img {
      object-fit: cover;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

<body class="bg-light">

  <div class="container">
    <main>
      <div class="py-5 text-center">
      <img class="mx-auto mb-4" src="assets/img/report_header1.jpg" alt="" width="100%" height="250px"><br><br>
        <h2>Damage Report Form</h2>
        <p class="lead"></p>
      </div>

      <div class=" row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <img src="assets/img/features-3.jpg" alt="" width=450px height=400px>
        </div>

        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Personal Information</h4>
          
          
          <form method="post" action="insert_report.php"  class="needs-validation" novalidate onsubmit="return validateForm()">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">Name</label>
                <input type="text" class="form-control" id="firstName" name="firstname" placeholder="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-sm-6">
                <label for="tel" class="form-label">No Tel</label>
                <input type="text" class="form-control" id="tel" name="tel" placeholder="" pattern="^[0-9+]*$" required>
                <div class="invalid-feedback">
                  Valid Telephone Number is required.
                </div>
              </div>

              <div class="col-12">
                <label for="location" class="form-label">Building or Damage Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Example: KTDI MA1 " required>
                <div class="invalid-feedback">
                  Please enter a valid location.
                </div>
              </div>

              <div class="col-md-5">
                <label for="floor" class="form-label">Floor</label>
                <select class="form-select"  name="floor"  id="floor" required>
                  <option value="">Choose...</option>
                  <option value="G">Floor G</option>
                  <option value="1">Floor 1</option>
                  <option value="2">Floor 2</option>
                  <option value="3">Floor 3</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid floor.
                </div>
              </div>

              <div class="col-md-5">
                <label for="damageType" class="form-label">Select Damage Type</label>
                <select class="form-select"  name="damage_type"  id="damageType" required>
                  <option value="">Choose...</option>
                  <option value="civil">Civil Damage</option>
                  <option value="electrical">Electrical Damage</option>
                  <option value="furniture">Furniture Damage</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid damage type.
                </div>
              </div>

              <div class="col-12">
                <label for="roomNumber" class="form-label">Room Number <span class="text-muted">e.g., 2-88</span></label>
                <input type="text"  name="roomNum" class="form-control" id="roomNumber" placeholder="e.g., 2-88" required>
                <div class="invalid-feedback">
                  Please enter a valid room or toilet number.
                </div>
              </div>

              <div class="col-12">
                <label for="description" class="form-label">Description <span class="text-muted">(Optional)</span></label>
                <textarea name="description" class="form-control" id="description" placeholder="Description of the damage"></textarea>
              </div>

              <hr class="my-4">

              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="certify" required>
                <label class="form-check-label" for="certify">I Certify That The Above Statements Are True</label>
                <div class="invalid-feedback">
                  You must certify that the above statements are true.
                </div>
              </div>

              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="comply" required>
                <label class="form-check-label" for="comply">I Promise To Comply With The Safety Instructions As Above</label>
                <div class="invalid-feedback">
                  You must promise to comply with the safety instructions.
                </div>
              </div>

              <hr class="my-4">

              <button class="w-100 btn btn-primary btn-lg" type="submit">Continue</button>
            </div>
          </form>
        </div>
      </div>
    </main>

    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha384-8zdfmAbP+5gC5d54WiwLF/NQblWAdcYvlmKBv+SkEul/jvlgTwnu/M24L5nJ7DjM" crossorigin="anonymous"></script>

  <script>
    // Custom JavaScript validation
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()

    function validateForm() {
      var valid = true;

      // Example custom validation logic
      var tel = document.getElementById('lastName');
      if (!/^[0-9+]*$/.test(tel.value)) {
        valid = false;
        tel.classList.add('is-invalid');
      } else {
        tel.classList.remove('is-invalid');
      }

      return valid;
    }
  </script>
</body>

</html>
