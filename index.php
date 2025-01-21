<?php
include_once('connection.php');
session_start();
?>

<!doctype html>
<html lang="en">
<head>
  <title>VMS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    

  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<div class="site-wrap">
  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close mt-3">
        <span class="icon-close2 js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <!-- Header -->
  <?php include_once('include/header.php');?>

  <!-- Hero Section -->
  <div class="hero-v1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mr-auto text-center text-lg-left">
        <span class="d-block subheading">Child Health Matters</span>
<h1 class="heading mb-3">Protect. Prevent. Vaccinate.</h1>
<p class="mb-5">Ensure a healthy future for your child with timely vaccinations. Stay informed, stay proactive, and safeguard their well-being with our trusted vaccination management system.</p>

          <p class="mb-4"><a href="appointments.php" class="btn btn-primary">Book Appointment</a></p>
        </div>
        <div class="col-lg-6">
          <figure class="illustration">
            <img src="./assets/images/rb_1622.png" alt="Image" class="img-fluid">
          </figure>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Section -->
  <div class="site-section stats">
  <div class="container">
    <div class="row mb-3">
      <div class="col-lg-7 text-center mx-auto">
        <h2 class="section-heading">Vaccination Statistics</h2>
        <p>Track the progress of child immunization and ensure healthier communities.</p>
      </div>
    </div>
    <div class="row">
      <?php
      // fetching dynamic counts from the database
      $vaccinatedCountQuery = "SELECT COUNT(*) AS vaccinated_count FROM tbl_appointment WHERE status = 'done'";
      $appointmentCountQuery = "SELECT COUNT(*) AS appointment_count FROM tbl_appointment WHERE status = 'approved'";
      $hospitalCountQuery = "SELECT COUNT(*) AS hospital_count FROM tbl_hospital WHERE status = 'activated'";

      $vaccinatedCountResult = mysqli_query($connection, $vaccinatedCountQuery);
      $appointmentCountResult = mysqli_query($connection, $appointmentCountQuery);
      $hospitalCountResult = mysqli_query($connection, $hospitalCountQuery);

      $vaccinatedCount = mysqli_fetch_assoc($vaccinatedCountResult)['vaccinated_count'] ?? 0;
      $appointmentCount = mysqli_fetch_assoc($appointmentCountResult)['appointment_count'] ?? 0;
      $hospitalCount = mysqli_fetch_assoc($hospitalCountResult)['hospital_count'] ?? 0;
      ?>

      <!-- Vaccinated Children -->
      <div class="col-lg-4">
        <div class="data">
          <span class="icon text-primary">
            <span class="flaticon-vaccine"></span>
          </span>
          <strong class="d-block number"><?= htmlspecialchars($vaccinatedCount) ?></strong>
          <span class="label">Children Vaccinated</span>
        </div>
      </div>

      <!-- Upcoming Appointments -->
      <div class="col-lg-4">
        <div class="data">
          <span class="icon text-primary">
            <span class="flaticon-appointment"></span>
          </span>
          <strong class="d-block number"><?= htmlspecialchars($appointmentCount) ?></strong>
          <span class="label">Upcoming Appointments</span>
        </div>
      </div>

      <!-- Partnered Hospitals -->
      <div class="col-lg-4">
        <div class="data">
          <span class="icon text-primary">
            <span class="flaticon-hospital"></span>
          </span>
          <strong class="d-block number"><?= htmlspecialchars($hospitalCount) ?></strong>
          <span class="label">Partnered Hospitals</span>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Article Section -->
  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <figure class="img-play-vid">
            <img src="./assets/images/rb_2937.png" alt="Image" class="img-fluid">
            <div class="absolute-block d-flex">
                <span class="icon-play"></span>
              </a>
            </div>
          </figure>
        </div>
        <div class="col-lg-5 ml-auto">
  <h2 class="mb-4 section-heading">Why Are Vaccinations Important for Children?</h2>
  <p>Vaccinations protect children from serious diseases and ensure a healthier future. By immunizing children, we help prevent the spread of infections and protect entire communities.</p>
  <ul class="list-check list-unstyled mb-5">
    <li>Protects against life-threatening diseases</li>
    <li>Helps build herd immunity</li>
    <li>Minimizes healthcare costs in the long term</li>
  </ul>
  <p><a href="blog1.php" class="btn btn-primary">Learn more</a></p>
</div>
      </div>
    </div>
  </div>

<!-- hospitals -->
<div class="site-section bg-primary-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="row">
                    <?php

                    $query = "SELECT tbl_hospital.*, tbl_city.name as cname 
                              FROM tbl_hospital 
                              INNER JOIN tbl_city ON tbl_hospital.cid = tbl_city.id 
                              WHERE tbl_hospital.status = 'activated'";
                    $result = mysqli_query($connection, $query);
                    
                    $hospitalCards = '';
                    if ($result && mysqli_num_rows($result) > 0) {
                        foreach ($result as $row) {
                            $hospitalCards .= '
                                <div class="col-6 col-lg-6 mt-lg-5">
                                    <div class="media-v1 bg-1">
                                        <div class="icon-wrap">
                                            <img src="./assets/images/hospital.png" class="flaticon-stay-at-home"></span>
                                        </div>
                                        <div class="body">
                                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                                            <p>' . htmlspecialchars($row['cname']) . '</p>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        $hospitalCards = '<p>No activated hospitals found.</p>';
                    }
                    echo $hospitalCards;
                    ?>
                </div>
            </div>
            <div class="col-lg-5 ml-auto">
  <h2 class="section-heading mb-4">Partner Hospitals</h2>
  <p>Our vaccination program is supported by a network of trusted hospitals dedicated to providing top-notch immunization services for children.</p>
  <p class="mb-4">These hospitals ensure safe and effective administration of vaccines while maintaining the highest healthcare standards.</p>

  <ul class="list-check list-unstyled mb-5">
    <li>State-of-the-art vaccination facilities</li>
    <li>Highly trained healthcare professionals</li>
    <li>Accessible locations for convenience</li>
  </ul>
</div>
        </div>
    </div>
</div>

<!-- How to Protect Your Child Section -->
<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-7 mx-auto text-center">
        <span class="subheading">What every parent needs to know</span>
        <h2 class="mb-4 section-heading">How to Protect Your Child</h2>
        <p>Ensure your child stays safe and healthy by following essential vaccination and hygiene guidelines. Protect them from preventable diseases with simple yet effective measures.</p>
      </div>
    </div>
  </div>
</div>

  <!-- Footer -->
  <?php include_once('include/footer.php');?>

</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
