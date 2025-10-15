<?php
session_start();
include 'config.php'; // Assuming you have a config.php for database connection

$login_error = '';
$register_error = '';
$register_success = '';

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $login_error = "Please fill in both fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
        $login_error = "Only Gmail addresses are allowed.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $login_error = "Password must contain at least one capital letter.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['fullname'] = $user['fullname'] ?? '';
                $_SESSION['role'] = $user['role'] ?? 'user';

                if ($_SESSION['role'] === 'admin') {
                    header("Location: Dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $login_error = "Wrong password!";
            }
        } else {
            $login_error = "Email not found!";
        }
        $stmt->close();
    }
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $confirm  = $_POST['confirm_password'] ?? '';

    if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $register_error = "Full name must contain only letters and spaces.";
    } elseif (!preg_match("/^[\w\.\-]+@(gmail\.com|email\.com)$/", $email)) {
        $register_error = "Email must be either @gmail.com or @email.com.";
    } elseif (!preg_match("/^(?=.*[A-Z]).{8,}$/", $password)) {
        $register_error = "Password must be at least 8 characters and have a capital letter.";
    } elseif ($password !== $confirm) {
        $register_error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $fullname, $email);

        if ($stmt->execute()) {
            $register_success = "Registration successful! You can now login.";
        } else {
            $register_error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Saplot de Manila</title>
  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <img src="assets/Media (2) 1.png">
      <span class="brand-name">SAPLOT de MANILA</span>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php" class="active">HOME</a></li>
        <li><a href="product.php">SHOP</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="contact.php">CONTACT</a></li>
      </ul>
    </nav>
    <div class="nav-icons">
      <a href="#" class="icon-btn" id="search-icon"><img src="assets/search (1) 1.png" alt="Search"></a>
      <a href="cart.php" class="icon-btn">
        <img src="assets/shopping-cart 1.png" alt="Cart" id="cartBtn">
      </a>
      <?php if (isset($_SESSION['user_id']) && isset($_SESSION['fullname'])): ?>
        <div class="profile-dropdown">
            <div class="profile-info">
                <i class="fa fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                <i class="fa fa-caret-down"></i>
            </div>
            <div class="dropdown-content">
                <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Log Out</a>
            </div>
        </div>
      <?php else: ?>
        <button id="loginModalBtn" class="login-btn">Log In / Sign Up</button>
      <?php endif; ?>
    </div>
  </header>

  <section class="hero">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    
    <div class="hero-content">
      <h1 class="hero-heading">
        Saplot New<br>
        Collection!
      </h1>
      <p class="hero-subtext">
        Discover our latest arrivals. Fresh styles, premium quality, and the iconic comfort you love. Shop the new collection today and define your look.
      </p>
      <a href="product.php" class="buy-now-btn">BUY NOW</a>
    </div>
    
    <div class="hero-image-container">
        <img src="assets/logo.png" alt="New Shoe Collection" class="hero-product-img">
    </div>
  </section>

  <section class="features-section">
    <div class="features-container">
      <div class="feature-item">
        <i class="fa-solid fa-truck-fast"></i>
        <h4>Free Delivery</h4>
        <p>Free Shipping on all order</p>
      </div>
      <div class="feature-item">
        <i class="fa-solid fa-arrows-rotate"></i>
        <h4>Return Policy</h4>
        <p>Free Shipping on all order</p>
      </div>
      <div class="feature-item">
        <i class="fa-solid fa-headset"></i>
        <h4>24/7 Support</h4>
        <p>Free Shipping on all order</p>
      </div>
      <div class="feature-item">
        <i class="fa-solid fa-shield-halved"></i>
        <h4>Secure Payment</h4>
        <p>Free Shipping on all order</p>
      </div>
    </div>
  </section>


  <div class="new" id="arrivals">

    <section class="whats-new" >
        <a href="product.php?category=running" class="category-card">
            <img src="assets/running.png" />
            <span class="category-label">RUNNING</span>
        </a>
        <a href="product.php?category=basketball" class="category-card">
            <img src="assets/Basketball.png" />
            <span class="category-label">BASKETBALL</span>
        </a>
    </section>

    <section class="new-arrivals" >
      <h2>New Arrivals</h2>
      <div class="product-grid-container">
        <?php
          $products = [
              ['image' => 'assets/Nike-removebg-preview-removebg-preview.png', 'name' => 'Nike P6000', 'price' => '5,500'],
              ['image' => 'assets/new_balance_removebg-preview-removebg-preview.png', 'name' => 'New Balance', 'price' => '4,800'],
              ['image' => 'assets/KD-removebg-preview.png', 'name' => 'KD 17', 'price' => '7,200'],
              ['image' => 'assets/Immortality_4-removebg-preview.png', 'name' => 'Immortality 4', 'price' => '4,500'],
              ['image' => 'assets/Kobe-removebg-preview.png', 'name' => 'Kobe 6', 'price' => '8,000'],
              ['image' => 'assets/Nike_running-removebg-preview.png', 'name' => 'Nikezoom X', 'price' => '6,300']
          ];

          $card_action = 'class="product-card" onclick="goToProduct()"';

          foreach ($products as $product) {
              echo '
              <article ' . $card_action . ' data-name="' . strtolower($product['name']) . '">
                  <div class="product-image-container">
                      <img src="' . $product['image'] . '" loading="lazy"/>
                      <div class="product-overlay"><button class="shop-button">Shop Now</button></div>
                  </div>
                  <div class="product-info">
                      <h4 class="product-name">' . $product['name'] . '</h4>
                      <p class="product-price">₱' . $product['price'] . '</p>
                  </div>
              </article>
              ';
          }
        ?>
      </div>
      <div class="view-all-container">
          <a href="product.php" class="view-all-btn">View All Products</a>
      </div>
    </section>
  </div>


  <section class="about-section" id="about">
    <div class="about-container">
        <div class="about-image">
            <img src="assets/sapsap.jpg" alt="About Us Image">
        </div>
        <div class="about-content">
            <h2 class="section-title">About Saplot de Manila</h2>
            <p>Welcome to Saplot De Manila, your go-to destination for exquisite footwear. With a passion for quality craftsmanship and timeless style, we pride ourselves on curating a collection that blends modern trends with classic elegance.</p>
            <p>Our journey began with a simple idea: to provide shoe lovers with high-quality, comfortable, and stylish footwear that doesn't break the bank. Every pair in our collection is handpicked to ensure it meets our high standards of excellence. We believe that the right pair of shoes can transform your look and boost your confidence.</p>
            <a href="product.php" class="about-button">Discover Our Collection</a>
        </div>
    </div>
  </section>

<footer>
    <div class="footer-main">
        <div class="footer-left">
            <h3>Saplot<span>De Manila</span></h3>
            <p class="footer-links">
                <a href="#" class="link-1">Home</a>
                <a href="#">Blog</a>
                <a href="#">Pricing</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </p>
        </div>
        <div class="footer-center">
            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>Fortuna, Floridablanca</span> Pampanga</p>
            </div>
            <div>
                <i class="fa fa-phone"></i>
                <p>+639 131 019 6878</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:support@company.com">Saplot09209@gmail.com</a></p>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>About the company</span>
                Welcome to Saplot De Manila, your go to destination for exquisite footwear. With a passion for quality and timeless style, we pride ourselves with this.
            </p>
            <div class="footer-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>Copyright ©2025 All rights reserved</p>
    </div>
</footer>

  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeLoginModal">&times;</span>
      <h2>Login to Saplot</h2>
      <?php if ($login_error): ?><p style="color:red;"><?php echo $login_error; ?></p><?php endif; ?>
      <form id="loginFormModal" method="POST" action="index.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" name="login">Login</button>
        <p class="register">Don't you have an account? <a href="#" id="showRegisterModal">Register</a></p>
      </form>
    </div>
  </div>

  <div id="registerModal" class="modal">
      <div class="modal-content">
          <span class="close-btn" id="closeRegisterModal">&times;</span>
          <h2>Register to Saplot</h2>
          <?php if ($register_error): ?><p style="color:red;"><?php echo $register_error; ?></p><?php endif; ?>
          <?php if ($register_success): ?><p style="color:green;"><?php echo $register_success; ?></p><?php endif; ?>
          <form method="POST" action="index.php">
              <input type="text" name="fullname" placeholder="Full Name" required minlength="8">
              <input type="text" name="username" placeholder="Username" required minlength="4">
              <input type="email" name="email" placeholder="Email" required>
              <input type="password" name="password" placeholder="Password" required minlength="8" pattern="^(?=.*[A-Z]).{8,}$" title="Password must be at least 8 characters and contain one capital letter">
              <input type="password" name="confirm_password" placeholder="Confirm Password" required>
              <button type="submit" name="register">Register</button>
              <p class="login">Have an account? <a href="#" id="showLoginModal">Login</a></p>
          </form>
      </div>
  </div>

  <div id="search-overlay" class="search-overlay">
    <span class="close-search-btn" id="close-search">&times;</span>
    <div class="search-overlay-content">
        <input type="search" id="search-input" placeholder="Search for products..." autocomplete="off">
    </div>
  </div>

<script>
    function goToProduct() {
      window.location.href = "product.php";
    }

    document.addEventListener("DOMContentLoaded", function() {
        const loginModal = document.getElementById("loginModal");
        const registerModal = document.getElementById("registerModal");
        const loginBtn = document.getElementById("loginModalBtn");
        const closeLoginModal = document.getElementById("closeLoginModal");
        const closeRegisterModal = document.getElementById("closeRegisterModal");
        const showRegisterModal = document.getElementById("showRegisterModal");
        const showLoginModal = document.getElementById("showLoginModal");

        // --- FIXED: Check for login action from URL to auto-open modal ---
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('action') === 'login') {
            if (loginModal) {
                loginModal.style.display = "block";
            }
        }

        // --- MODAL CONTROLS ---
        if(loginBtn) loginBtn.onclick = () => { loginModal.style.display = "block"; }
        if(closeLoginModal) closeLoginModal.onclick = () => { loginModal.style.display = "none"; }
        if(closeRegisterModal) closeRegisterModal.onclick = () => { registerModal.style.display = "none"; }
        
        window.onclick = (event) => {
            if (event.target == loginModal) loginModal.style.display = "none";
            if (event.target == registerModal) registerModal.style.display = "none";
        }

        if(showRegisterModal) showRegisterModal.onclick = (e) => { e.preventDefault(); loginModal.style.display = "none"; registerModal.style.display = "block"; }
        if(showLoginModal) showLoginModal.onclick = (e) => { e.preventDefault(); registerModal.style.display = "none"; loginModal.style.display = "block"; }

        // --- SEARCH ---
        const searchIcon = document.getElementById('search-icon');
        const searchOverlay = document.getElementById('search-overlay');
        const closeSearchBtn = document.getElementById('close-search');
        const searchInput = document.getElementById('search-input');

        searchIcon.addEventListener('click', (e) => { e.preventDefault(); searchOverlay.style.display = 'flex'; searchInput.focus(); });
        closeSearchBtn.addEventListener('click', () => { searchOverlay.style.display = 'none'; });
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            document.querySelectorAll('.product-grid-container .product-card').forEach(card => {
                const productName = card.dataset.name;
                card.style.display = productName.includes(searchTerm) ? 'flex' : 'none';
            });
        });

        // --- PROFILE DROPDOWN ---
        const profileDropdown = document.querySelector('.profile-dropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
                this.classList.toggle('active');
            });
            window.addEventListener('click', function() {
                if(profileDropdown.classList.contains('active')) {
                    profileDropdown.classList.remove('active');
                }
            });
        }
    });
</script>

</body>
</html>