<header class="site-navbar light js-sticky-header site-navbar-target" role="banner">
  <div class="container">
    <div class="row align-items-center">

      <!-- logo section -->
      <div class="col-6 col-xl-2">
        <div class="mb-0 site-logo">
          <a href="index.php" class="mb-0">VMS</a>
        </div>
      </div>

      <!-- navigation menu -->
      <div class="col-12 col-md-10 d-none d-xl-block">
        <nav class="site-navigation position-relative text-right" role="navigation">
          <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
            <li><a href="index.php" class="nav-link">Home</a></li>
            <li><a href="blog.php" class="nav-link">Blog</a></li>
            <li><a href="faqs.php" class="nav-link">FAQs</a></li>
            <li><a href="contact.php" class="nav-link">Contact</a></li>
            <li><a href="about.php" class="nav-link">About</a></li>

            <!-- displaying child name if logged in other wise displaying 'login' -->
            <li>
              <?php 
                if (!isset($_SESSION['childName_session'])) {
                  echo '
                  <div>
                    <ul class="navbar-nav">
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Login
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                          <li><a class="dropdown-item" href="login.php">Parent</a></li>
                          <li><a class="dropdown-item" href="./admin/login.php">Admin</a></li>
                          <li><a class="dropdown-item" href="./hospital/login.php">Hospital</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>';
                } else {
                  echo '<a href="profile.php" class="nav-link">' . $_SESSION['childName_session'] . '</a>';
                }
              ?>
            </li>

            <!-- Logout button only visible if user is logged in -->
            <?php if (isset($_SESSION['childName_session']) && $_SESSION['childName_session'] !== 'Guest'): ?>
              <li><a href="logout.php" class="nav-link">Logout</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>

      <!-- Mobile Menu Toggle -->
      <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;">
        <a href="#" class="site-menu-toggle js-menu-toggle float-right" aria-label="Toggle menu">
          <span class="icon-menu h3 text-black"></span>
        </a>
      </div>

    </div>
  </div>
</header>

<!-- Add Bootstrap 5 JS for Dropdown functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
