<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $er = 0;
  
  // Sanitize and validate input
  $firstName = trim($_POST['firstname']);
  if (empty($firstName)) {
    $er++;
    $firstNameErr = "Name is required";
  }

  $telephone = trim($_POST['tel']);
  if (empty($telephone) || !preg_match("/^[0-9+]*$/", $telephone)) {
    $er++;
    $telephoneErr = "Valid Telephone Number is required";
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

  $damageType = trim($_POST['damage_type']);
  if (empty($damageType)) {
    $er++;
    $damageTypeErr = "Damage type selection is required";
  }

  $roomNumber = trim($_POST['roomNum']);
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Damage Report Form</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
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
        <img class="mx-auto mb-4" src="assets/img/report_header1.jpg" alt="" width="100%" height="250"><br><br>
        <h2>Damage Report Form</h2>
        <p class="lead"></p>
      </div>

      <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <img src="assets/img/features-3.jpg" alt="" style="width: 450px; height: 450px">
        </div>

        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Personal Information</h4>

          <form method="post" action="insert_report.php" class="needs-validation" novalidate>
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
                <select class="form-select" name="floor" id="floor" required>
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
                <select class="form-select" name="damage_type" id="damageType" required>
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
                <input type="text" name="roomNum" class="form-control" id="roomNumber" placeholder="e.g., 2-88" required>
                <div class="invalid-feedback">
                  Please enter a valid room or toilet number.
                </div>
              </div>

              <div class="col-12">
                <label for="description" class="form-label">Description <span class="text-muted">(Optional)</span></label>
                <input type="text" name="description" class="form-control" id="description" placeholder="Description of the damage">
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

              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="confirmSubmission()">Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </main>

    <br><br><br><br>

    <footer id="footer" class="footer">
      <div class="container">
        <div class="copyright text-center">
          <p>© <span>Copyright</span> <strong class="px-1 sitename">Vesperr</strong> <span>All Rights Reserved</span></p>
        </div>
        <div class="social-links d-flex justify-content-center">
          <a href=""><i class="bi bi-twitter"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
    </footer>

  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

  <script>
    function confirmSubmission() {
      var isValid = document.querySelector('.needs-validation').checkValidity();

      if (isValid) {
        var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();
      } else {
        // If form is not valid, show the validation feedback
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
          .forEach(function(form) {
            form.classList.add('was-validated');
          });
      }

      return false; // Prevent form from being submitted automatically
    }

    // Function to handle form submission from modal
    function submitForm() {
      document.querySelector('.needs-validation').submit();
    }
  </script>

  <!-- Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to submit the form?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
        </div>
      </div>
    </div>
  </div>

</body>
