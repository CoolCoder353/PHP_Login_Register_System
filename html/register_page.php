<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta settings -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- BootStrap references -->
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- BootStrap Icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <script src="js/fingerprint.js"></script>
  <link rel="stylesheet" href="css/gradient.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>The Underground</title>
</head>

<body class="gradient-custom">
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
              <form action="../register.php" method="post" enctype="multipart/form-data">

                <div class="row">
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" />
                      <label class="form-label" for="firstName">First Name</label>
                    </div>

                  </div>
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="text" id="lastName" name="lastName" class="form-control form-control-lg" />
                      <label class="form-label" for="lastName">Last Name</label>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4 d-flex align-items-center">

                    <div class="form-outline w-100">
                      <input type="text" name="username" class="form-control form-control-lg" id="username" />
                      <label for="username" class="form-label">Username</label>
                    </div>

                  </div>
                  <div class="form-outline">
                    <input type="email" id="emailAddress" name="email" class="form-control form-control-lg" />
                    <label class="form-label" for="emailAddress">Email</label>
                  </div>


                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" />
                      <label class="form-label" for="password">Password</label>
                    </div>

                  </div>
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="password" id="passwordRepeat" name="confirm_password" class="form-control form-control-lg" />
                      <label class="form-label" for="passwordRepeat">Confirm Password</label>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <input type="hidden" name="fingerprint" id="fingerprint" value="" />
                    <?php
                    include "../includes/php/security_functions.php";
                    insert_csrf_token();
                    ?>
                  </div>
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <label for="img">Select image:</label>
                      <input type="file" id="img" name="img" accept="image/*">

                    </div>

                  </div>
                </div>


                <div class="mt-4 pt-2">
                  <input id="submitButton" class="btn btn-primary btn-lg" type="submit" value="Submit" disabled />
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>