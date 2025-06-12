<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
$username = $loggedIn ? $_SESSION['username'] : '';

if ($loggedIn) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, profile_image FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['profile_image'] = $user['profile_image'];
    }
}
?>


<!-- HTML here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aniyah - Fresh Clothing Delivered</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Cart badge styling */
        .cart-toggle {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .cart-toggle i {
            font-size: 1.5rem;
            color: #333;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Header actions styling */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart {
            position: relative;
            margin-right: 10px;
        }

        .product-card, .testimonial-card, .tag, .offer-banner, .offer-card, .section-header, .products-grid, .categories, .category-card, .newsletter, .footer-top, .footer-bottom {
            border-radius: 0 !important;
            background: #fff !important;
            color: #111 !important;
            box-shadow: none !important;
            border: 1px solid #d1d1d1 !important;
        }
        .tag, .tag-hot, .tag-new, .tag-offer, .tag-trending {
            background: #fff !important;
            color: #111 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .section-header h2, .section-header p {
            color: #111 !important;
        }
        .logo a, .main-nav a, .btn, .btn:focus, .btn:active, .btn:hover, .view-all, .view-all:focus, .view-all:active, .view-all:hover {
            text-decoration: none !important;
            box-shadow: none !important;
        }
        .main-nav a.active, .main-nav a:active, .main-nav a:focus, .main-nav a:hover {
            text-decoration: none !important;
            color: #111 !important;
        }
        .hero-image img {
            filter: drop-shadow(0 8px 32px rgba(0,0,0,0.18));
        }
        .editorial-heading {
            font-family: 'Playfair Display', serif !important;
            font-size: 5rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.04em !important;
            line-height: 1.05 !important;
            color: #111 !important;
            margin-bottom: 1.5rem !important;
            text-transform: none !important;
        }
        @media (max-width: 700px) {
            .editorial-heading {
                font-size: 2.5rem !important;
            }
        }
        /* Carousel Effects */
        .carousel-item .hero-content, .carousel-item .hero-image {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: opacity 0.7s cubic-bezier(.4,0,.2,1), transform 0.7s cubic-bezier(.4,0,.2,1);
        }
        .carousel-item.active .hero-content, .carousel-item.active .hero-image {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .carousel-item .hero-image img {
            transition: transform 2.2s cubic-bezier(.4,0,.2,1), filter 0.7s;
            will-change: transform;
        }
        .carousel-item.active .hero-image img {
            transform: scale(1.08) rotate(-2deg);
            filter: drop-shadow(0 8px 32px rgba(0,0,0,0.18));
        }
        .carousel-item .hero-content h1 {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s 0.2s, transform 0.7s 0.2s;
        }
        .carousel-item.active .hero-content h1 {
            opacity: 1;
            transform: translateY(0);
        }
        /* Full-page loading overlay */
        #page-loader {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100vw; height: 100vh;
            background: rgba(255,255,255,0.98);
            z-index: 3000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s cubic-bezier(.4,0,.2,1);
        }
        #page-loader.hide {
            opacity: 0;
            pointer-events: none;
        }
        .loader-spinner {
            width: 64px; height: 64px;
            border: 6px solid #111;
            border-top: 6px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Skeleton loader for product cards */
        .skeleton-card {
            background: #f3f3f3;
            border: 2px solid #eee;
            border-radius: 0;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            animation: skeleton-pulse 1.2s infinite ease-in-out;
            margin-bottom: 1rem;
        }
        .skeleton-img {
            width: 80%;
            height: 140px;
            background: #e0e0e0;
            border-radius: 0;
            margin-bottom: 1.2rem;
        }
        .skeleton-line {
            width: 60%;
            height: 18px;
            background: #e0e0e0;
            border-radius: 0;
            margin-bottom: 0.7rem;
        }
        @keyframes skeleton-pulse {
            0% { background: #f3f3f3; }
            50% { background: #ececec; }
            100% { background: #f3f3f3; }
        }
    </style>
    <!-- SEO Meta Tags -->
    <meta name="description" content="Aniyah is your destination for modern, confident, and comfortable women's fashion. Shop curated collections, exclusive offers, and enjoy fast delivery across India.">
    <meta name="keywords" content="Aniyah, women's fashion, modern clothing, dresses, tops, accessories, shop online, India, fast delivery, exclusive offers, 2025 collections, best sellers, new arrivals, premium quality, customer reviews, style, comfort, confidence">
</head>
<body>
    <div id="page-loader"><div class="loader-spinner"></div></div>
    <!-- Header -->
    <header>
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="logo">
                <a href="index.php">
                    <h1>Aniyah</h1>
                </a>
            </div>
            <div class="search-bar" style="flex: 1; margin: 0 20px;">
                <form action="pages/products.html" method="get">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products..." name="q">
                </form>
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                <button class="cart-toggle" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </button>
                <div class="dropdown">
                    <button class="btn user-icon-btn p-0 d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background:none;border:none;outline:none;box-shadow:none;">
                        <span style="display:inline-block;width:40px;height:40px;border:2px solid #111;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="far fa-user" style="font-size:1.7rem;color:#111;"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow-sm mt-2 p-0" aria-labelledby="userDropdown" style="min-width:180px;">
                        <li class="px-3 pt-3">
                            <a class="btn btn-outline-dark w-100 rounded-0 fw-bold mb-2" href="login.php" style="letter-spacing:0.5px;">Login</a>
                        </li>
                        <li class="px-3 pb-3">
                            <a class="btn btn-dark w-100 rounded-0 fw-bold" href="register.php" style="letter-spacing:0.5px;">Sign Up</a>
                        </li>
                        <li><hr class="dropdown-divider m-0"></li>
                        <li><a class="dropdown-item text-center py-2" href="profile.php" style="color:#111;font-weight:500;">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="index.php" class="active" data-lang="home">Home</a></li>
                <li><a href="pages/products.php" data-lang="shop">Shop</a></li>
                <li><a href="pages/products.php" data-lang="categories">Categories</a></li>
                <li><a href="pages/about.php" data-lang="about_us">About Us</a></li>
                <li><a href="pages/contact.php" data-lang="contact_us">Contact Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Bootstrap Carousel Section -->
    <section class="hero-slider border-bottom" style="background:#fff;">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <!-- Slide 1 -->
          <div class="carousel-item active show">
            <div class="container py-5 d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap" style="min-height:480px;">
              <div class="hero-content" style="flex:1;max-width:600px;">
                <div class="mb-3 fw-semibold" style="font-size:1.2rem;color:#111;">Smart Products</div>
                <h1 class="fw-bold mb-4" style="font-size:3.5rem;color:#111;line-height:1.1;">Winter Elegance<br>2025 Collections</h1>
                <a href="pages/products.php" class="btn btn-outline-dark btn-lg px-5 py-3 fw-semibold border-2 rounded-0">SHOP NOW</a>
              </div>
              <div class="hero-image d-flex justify-content-end flex-grow-1">
                <img src="images/fashion-hero.jpg" alt="Winter Offer Model" class="img-fluid" style="max-width:420px;width:100%;height:auto;object-fit:contain;background:#fff;">
              </div>
            </div>
          </div>
          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="container py-5 d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap" style="min-height:480px;">
              <div class="hero-content" style="flex:1;max-width:600px;">
                <div class="mb-3 fw-semibold" style="font-size:1.2rem;color:#111;">Smart Products</div>
                <h1 class="fw-bold mb-4" style="font-size:3.5rem;color:#111;line-height:1.1;">Summer Chic<br>2025 Collections</h1>
                <a href="pages/products.php" class="btn btn-outline-dark btn-lg px-5 py-3 fw-semibold border-2 rounded-0">SHOP NOW</a>
              </div>
              <div class="hero-image d-flex justify-content-end flex-grow-1">
                <img src="images/summer-hero.jpg" alt="Summer Offer Model" class="img-fluid" style="max-width:520px;width:100%;height:auto;object-fit:contain;filter:drop-shadow(0 8px 32px rgba(0,0,0,0.18));">
              </div>
            </div>
          </div>
          <!-- Slide 3 -->
          <div class="carousel-item">
            <div class="container py-5 d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap" style="min-height:480px;">
              <div class="hero-content" style="flex:1;max-width:600px;">
                <div class="mb-3 fw-semibold" style="font-size:1.2rem;color:#111;">Smart Products</div>
                <h1 class="fw-bold mb-4" style="font-size:3.5rem;color:#111;line-height:1.1;">Fall Glam<br>2025 Collections</h1>
                <a href="pages/products.php" class="btn btn-outline-dark btn-lg px-5 py-3 fw-semibold border-2 rounded-0">SHOP NOW</a>
              </div>
              <div class="hero-image d-flex justify-content-end flex-grow-1">
                <img src="images/fall-hero.jpg" alt="Fall Offer Model" class="img-fluid" style="max-width:420px;width:100%;height:auto;object-fit:contain;background:#fff;">
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>

    <!-- Features Row Section -->
    <section class="features-row" style="width:100%;background:#fff;padding:2.5rem 0 1.5rem 0;">
        <div class="container" style="display:flex;justify-content:space-between;align-items:center;gap:2.5rem;flex-wrap:wrap;">
            <div class="feature-item" style="display:flex;align-items:center;gap:1.2rem;min-width:220px;">
                <span style="font-size:2.5rem;"><i class="fas fa-shipping-fast"></i></span>
                <div>
                    <div style="font-weight:600;font-size:1.15rem;color:#111;">Free Shipping</div>
                    <div style="font-size:0.98rem;color:#555;">Free shipping on all order</div>
                </div>
            </div>
            <div class="feature-item" style="display:flex;align-items:center;gap:1.2rem;min-width:220px;">
                <span style="font-size:2.5rem;"><i class="fas fa-history"></i></span>
                <div>
                    <div style="font-weight:600;font-size:1.15rem;color:#111;">Support 24/7</div>
                    <div style="font-size:0.98rem;color:#555;">Free shipping on all order</div>
                </div>
            </div>
            <div class="feature-item" style="display:flex;align-items:center;gap:1.2rem;min-width:220px;">
                <span style="font-size:2.5rem;"><i class="fas fa-dollar-sign"></i></span>
                <div>
                    <div style="font-weight:600;font-size:1.15rem;color:#111;">Money Return</div>
                    <div style="font-size:0.98rem;color:#555;">Free shipping on all order</div>
                </div>
                    </div>
            <div class="feature-item" style="display:flex;align-items:center;gap:1.2rem;min-width:220px;">
                <span style="font-size:2.5rem;"><i class="fas fa-percentage"></i></span>
                <div>
                    <div style="font-weight:600;font-size:1.15rem;color:#111;">Order Discount</div>
                    <div style="font-size:0.98rem;color:#555;">Free shipping on all order</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories py-5" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2" style="font-size:2rem;color:#111;">Product Categories</h2>
            </div>
            <div class="row g-4 justify-content-center align-items-stretch">
                <!-- Big Card 1 -->
                <div class="col-12 col-md-6">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-4 bg-light border-0 rounded-0" style="min-height:320px;">
                        <div class="mb-2" style="font-size:1rem;color:#888;">Dresses</div>
                        <div class="fw-bold mb-2" style="font-size:2.2rem;color:#111;">SUMMER DRESS</div>
                        <div class="mb-3"><img src="images/category-dress.png" alt="Dresses" style="max-width:120px;"></div>
                        <a href="pages/products.php?category=dresses" class="btn btn-outline-dark rounded-0 px-4 py-2 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                </div>
                <!-- Small Card 1 -->
                <div class="col-6 col-md-3">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-3 bg-light border-0 rounded-0" style="min-height:180px;">
                        <div class="mb-1" style="font-size:0.95rem;color:#888;">Tops</div>
                        <div class="fw-bold mb-1" style="font-size:1.2rem;color:#111;">TRENDY TOPS</div>
                        <div class="mb-2"><img src="images/category-top.png" alt="Tops" style="max-width:70px;"></div>
                        <a href="pages/products.php?category=tops" class="btn btn-outline-dark rounded-0 px-3 py-1 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                </div>
                <!-- Small Card 2 -->
                <div class="col-6 col-md-3">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-3 bg-light border-0 rounded-0" style="min-height:180px;">
                        <div class="mb-1" style="font-size:0.95rem;color:#888;">Bottoms</div>
                        <div class="fw-bold mb-1" style="font-size:1.2rem;color:#111;">CASUAL BOTTOMS</div>
                        <div class="mb-2"><img src="images/category-bottom.png" alt="Bottoms" style="max-width:70px;"></div>
                        <a href="pages/products.php?category=bottoms" class="btn btn-outline-dark rounded-0 px-3 py-1 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                </div>
                <!-- Small Card 3 -->
                <div class="col-6 col-md-3">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-3 bg-light border-0 rounded-0" style="min-height:180px;">
                        <div class="mb-1" style="font-size:0.95rem;color:#888;">Accessories</div>
                        <div class="fw-bold mb-1" style="font-size:1.2rem;color:#111;">BAGS & JEWELRY</div>
                        <div class="mb-2"><img src="images/category-accessory.png" alt="Accessories" style="max-width:70px;"></div>
                        <a href="pages/products.php?category=accessories" class="btn btn-outline-dark rounded-0 px-3 py-1 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                </div>
                <!-- Big Card 2 -->
                <div class="col-12 col-md-6">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-4 bg-light border-0 rounded-0" style="min-height:320px;">
                        <div class="mb-2" style="font-size:1rem;color:#888;">Sale</div>
                        <div class="fw-bold mb-2" style="font-size:2.2rem;color:#111;">BEST DEALS</div>
                        <div class="mb-3"><img src="images/category-sale.png" alt="Sale" style="max-width:120px;"></div>
                        <a href="pages/products.php?category=sale" class="btn btn-outline-dark rounded-0 px-4 py-2 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                    </div>
                <!-- Small Card 4 -->
                <div class="col-6 col-md-3">
                    <div class="category-card h-100 d-flex flex-column justify-content-between p-3 bg-light border-0 rounded-0" style="min-height:180px;">
                        <div class="mb-1" style="font-size:0.95rem;color:#888;">New Arrivals</div>
                        <div class="fw-bold mb-1" style="font-size:1.2rem;color:#111;">LATEST TRENDS</div>
                        <div class="mb-2"><img src="images/category-new.png" alt="New Arrivals" style="max-width:70px;"></div>
                        <a href="pages/products.php?category=new-arrivals" class="btn btn-outline-dark rounded-0 px-3 py-1 mt-auto align-self-start">SHOP NOW</a>
                    </div>
                    </div>
               
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products py-5" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2" style="letter-spacing:1px;font-size:2rem;color:#111;border-top:2px solid #111;border-bottom:2px solid #111;display:inline-block;padding:0.5rem 2.5rem;">DAILY DEALS!</h2>
            </div>
            <ul class="nav nav-tabs justify-content-center mb-4 border-0" style="gap:2rem;">
                <li class="nav-item"><a class="nav-link border-0 rounded-0 text-dark" href="#">New Arrivals</a></li>
                <li class="nav-item"><a class="nav-link border-0 rounded-0 text-dark active fw-bold" href="#">Best Sellers</a></li>
                <li class="nav-item"><a class="nav-link border-0 rounded-0 text-dark" href="#">Sale Items</a></li>
            </ul>
            <div class="row g-4" id="featured-skeletons">
                <div class="col-6 col-md-3"><div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line" style="width:40%"></div></div></div>
                <div class="col-6 col-md-3"><div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line" style="width:40%"></div></div></div>
                <div class="col-6 col-md-3"><div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line" style="width:40%"></div></div></div>
                <div class="col-6 col-md-3"><div class="skeleton-card"><div class="skeleton-img"></div><div class="skeleton-line"></div><div class="skeleton-line" style="width:40%"></div></div></div>
            </div>
            <div class="row g-4">
                <!-- Product Card 1 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod1.jpg" alt="Fashion Top" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-10%</span>
                        </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum fashion female top</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                        </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€25.85</div>
                    </div>
                </div>
                <!-- Product Card 2 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod2.jpg" alt="Fashion Jacket" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-10%</span>
                        </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum fashion jacket</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                        </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€28.97 <span class="text-decoration-line-through text-muted" style="font-size:0.95rem;">€32.55</span></div>
                    </div>
                </div>
                <!-- Product Card 3 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod3.jpg" alt="Kids Eight" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-10%</span>
                        </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum kids eight</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                        </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€28.97 <span class="text-decoration-line-through text-muted" style="font-size:0.95rem;">€32.55</span></div>
                    </div>
                </div>
                <!-- Product Card 4 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod4.jpg" alt="Kids Jacket" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">New</span>
                        </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum jacket</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                        </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€25.85</div>
                    </div>
                </div>
                <!-- Product Card 5 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod5.jpg" alt="Kids Six" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">New</span>
                        </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum kids six</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€25.85</div>
                    </div>
                </div>
                <!-- Product Card 6 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod6.jpg" alt="Fashion Coat" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-40%</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum fashion female coat</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€33.3 <span class="text-decoration-line-through text-muted" style="font-size:0.95rem;">€55.5</span></div>
                    </div>
                </div>
                <!-- Product Card 7 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod7.jpg" alt="Kids Seven" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-40%</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum kids seven</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€33.3 <span class="text-decoration-line-through text-muted" style="font-size:0.95rem;">€55.5</span></div>
                    </div>
                </div>
                <!-- Product Card 8 -->
                <div class="col-6 col-md-3">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod8.jpg" alt="Jacket" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">-10%</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Lorem ipsum jacket</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">€21.12 <span class="text-decoration-line-through text-muted" style="font-size:0.95rem;">€25.55</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  
    <!-- Best Sellers Section -->
    <section class="best-sellers py-5" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2" style="letter-spacing:1px;font-size:2rem;color:#111;border-top:2px solid #111;border-bottom:2px solid #111;display:inline-block;padding:0.5rem 2.5rem;">Best Sellers</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <!-- Product Card 1 -->
                <div class="col-12 col-md-4">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod1.jpg" alt="Floral Midi Dress" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">Best Seller</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Floral Midi Dress</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">₹1,499</div>
                    </div>
                </div>
                <!-- Product Card 2 -->
                <div class="col-12 col-md-4">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod2.jpg" alt="Classic White Shirt" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">New</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Classic White Shirt</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">₹899</div>
                    </div>
                </div>
                <!-- Product Card 3 -->
                <div class="col-12 col-md-4">
                    <div class="product-card h-100 d-flex flex-column align-items-center justify-content-between p-3 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="w-100 mb-2 position-relative" style="background:#fafafa;min-height:160px;display:flex;align-items:center;justify-content:center;">
                            <img src="images/prod3.jpg" alt="Statement Earrings" class="img-fluid" style="max-height:140px;object-fit:contain;">
                            <span class="badge position-absolute top-0 end-0 bg-dark text-white rounded-0" style="font-size:0.85rem;">Limited Offer</span>
                    </div>
                        <div class="fw-semibold text-center mt-2" style="color:#111;font-size:1rem;">Statement Earrings</div>
                        <div class="text-center mb-1" style="color:#aaa;font-size:1rem;">
                            <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
                    </div>
                        <div class="fw-bold text-center" style="color:#111;font-size:1.1rem;">₹499</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-5" style="background:#fff;">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2" style="letter-spacing:1px;font-size:2rem;color:#111;border-top:2px solid #111;border-bottom:2px solid #111;display:inline-block;padding:0.5rem 2.5rem;">What Our Customers Say</h2>
                    </div>
            <div class="row g-4 justify-content-center">
                <!-- Testimonial 1 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between p-4 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="mb-3" style="font-size:1.1rem;color:#111;">"Absolutely love the styles at Aniyah! The quality is amazing and delivery is super fast."</div>
                        <div class="fw-bold text-end" style="color:#111;">- Priya S.</div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between p-4 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="mb-3" style="font-size:1.1rem;color:#111;">"The Summer Edit collection is my favorite. I get compliments every time I wear Aniyah!"</div>
                        <div class="fw-bold text-end" style="color:#111;">- Riya M.</div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between p-4 border border-2 border-dark bg-white rounded-0" style="box-shadow:none;">
                        <div class="mb-3" style="font-size:1.1rem;color:#111;">"Great customer service and beautiful packaging. Will shop again!"</div>
                        <div class="fw-bold text-end" style="color:#111;">- Aarti S.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Story / Mission Section -->
    <section class="brand-story py-5" style="background:#fff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 text-center">
                    <h2 class="editorial-heading">About Us</h2>
                    <h2 class="fw-bold mb-3" style="font-size:2rem;color:#111;display:none;">Our Mission</h2>
                    <p style="color:#555;font-size:1.15rem;">At <b>Aniyah</b>, we believe every woman deserves to feel confident, comfortable, and stylish—every day. Our collections are thoughtfully curated to blend modern trends with timeless elegance, ensuring you always find something that feels uniquely you. From premium fabrics to exceptional service, we're committed to making your shopping experience seamless and inspiring. Join our community and discover fashion that celebrates you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section py-5" style="background:#fafafa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <h2 class="fw-bold mb-4 text-center" style="font-size:2rem;color:#111;">Frequently Asked Questions</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button bg-white rounded-0 fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="color:#111;">
                                    What makes Aniyah different from other fashion brands?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Aniyah stands out for its curated collections, premium quality, and a focus on comfort and confidence. We blend modern trends with timeless style, and our customer-first approach ensures a seamless shopping experience.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2" style="color:#111;">
                                    How fast is delivery and where do you ship?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    We offer fast, reliable delivery across India. Most orders are shipped within 24 hours and delivered within 2-5 business days, depending on your location.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3" style="color:#111;">
                                    Can I return or exchange items if they don't fit?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Absolutely! We offer easy returns and exchanges within 7 days of delivery. Your satisfaction is our priority—just contact our support team and we'll help you with the process.
                                </div>
                            </div>
                        </div>
                        <!-- SEO & Market-Driven FAQs -->
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4" style="color:#111;">
                                    Why should I shop at Aniyah instead of other online clothing stores?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Aniyah is dedicated exclusively to women's fashion, offering unique, editorial styles you won't find anywhere else. Our focus on quality, customer service, and exclusive collections makes us the best choice for modern, confident women. Shop with us for a truly personalized experience and discover why so many customers trust Aniyah for their wardrobe needs.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5" style="color:#111;">
                                    Are there exclusive offers or discounts for new customers?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Yes! Aniyah regularly features exclusive offers, daily deals, and special discounts for new and returning customers. Sign up for our newsletter to receive the latest updates and access members-only promotions.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq6">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6" style="color:#111;">
                                    Is Aniyah committed to sustainability and ethical fashion?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    We are passionate about responsible fashion. Aniyah partners with ethical suppliers and is committed to sustainable practices, from eco-friendly packaging to supporting fair labor. Look for our eco-conscious collections and join us in making a positive impact.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq7">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7" style="color:#111;">
                                    How can I contact Aniyah's customer support?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Our customer support team is available via our Contact Us page, email, and live chat. We pride ourselves on fast, friendly service—reach out anytime and we'll be happy to help!
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq8">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8" style="color:#111;">
                                    Does Aniyah offer international shipping?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="faq8" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Currently, Aniyah ships across India. Stay tuned for updates as we expand our shipping options to serve our global customers in the near future.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-0">
                            <h2 class="accordion-header" id="faq9">
                                <button class="accordion-button bg-white rounded-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9" style="color:#111;">
                                    How do I stay updated on new arrivals and trends at Aniyah?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="faq9" data-bs-parent="#faqAccordion">
                                <div class="accordion-body" style="color:#555;">
                                    Follow us on social media and subscribe to our newsletter for the latest on new arrivals, exclusive collections, and fashion trends. Be the first to know and never miss out on what's new at Aniyah!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer py-5" style="background:#f7f7f9;">
        <div class="container">
            <div class="row gy-4 align-items-start">
                <!-- Brand -->
                <div class="col-12 col-md-3">
                    <h2 class="fw-bold mb-2" style="font-size:2rem;color:#111;">Aniyah.</h2>
                    <div style="color:#555;font-size:1rem;">Aniyah is your destination for modern, confident, and comfortable women's fashion. Discover curated collections, exclusive offers, and a community that celebrates every woman.</div>
                    </div>
                <!-- About Us -->
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-3" style="color:#111;">ABOUT US</h6>
                    <ul class="list-unstyled" style="color:#555;">
                        <li class="mb-2"><a href="pages/about.php" style="color:#555;">About us</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Store location</a></li>
                        <li class="mb-2"><a href="pages/contact.php" style="color:#555;">Contact</a></li>
                        <li><a href="#" style="color:#555;">Orders tracking</a></li>
                    </ul>
                </div>
                <!-- Useful Links -->
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-3" style="color:#111;">USEFUL LINKS</h6>
                    <ul class="list-unstyled" style="color:#555;">
                        <li class="mb-2"><a href="#" style="color:#555;">Returns</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Support Policy</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Size guide</a></li>
                        <li><a href="#" style="color:#555;">FAQs</a></li>
                    </ul>
                </div>
                <!-- Follow Us -->
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-3" style="color:#111;">FOLLOW US</h6>
                    <ul class="list-unstyled" style="color:#555;">
                        <li class="mb-2"><a href="#" style="color:#555;">Facebook</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Twitter</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Instagram</a></li>
                        <li><a href="#" style="color:#555;">YouTube</a></li>
                    </ul>
                </div>
                <!-- Subscribe -->
                <div class="col-12 col-md-3">
                    <h6 class="fw-bold mb-3" style="color:#111;">SUBSCRIBE</h6>
                    <div class="mb-2" style="color:#555;">Get E-mail updates about our latest shop and special offers.</div>
                    <form class="d-flex flex-column gap-2">
                        <input type="email" class="form-control rounded-0 border-0 border-bottom bg-transparent" placeholder="Enter your email address..." style="font-size:1rem;">
                        <button type="submit" class="btn btn-link px-0 fw-semibold" style="color:#111;text-decoration:underline;">SUBSCRIBE</button>
                    </form>
                </div>
            </div>
            </div>
        <div class="container-fluid py-3" style="background:#f7f7f9;">
            <div class="text-center" style="color:#888;font-size:1rem;">&copy; 2025 Aniyah. All Rights Reserved</div>
        </div>
    </footer>

    <!-- Cart Drawer -->
    <div class="cart-drawer">
        <div class="cart-header">
            <h3>Your Cart</h3>
            <button class="close-cart" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically inserted here -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty</p>
                <a href="pages/products.html" class="btn btn-primary">Start Shopping</a>
            </div>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="pages/cart.php" class="btn btn-primary btn-block">View Cart</a>
            <button onclick="window.location.href='pages/checkout.html'" class="btn btn-primary btn-block">Checkout</button>
        </div>
    </div>
    

   

    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/gTranslate.js"></script>
    <!-- Bootstrap 5 JS (defer for faster load) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
      // Preload hero images for instant slide
      const heroImages = [
        'images/fashion-hero.jpg',
        'images/summer-hero.jpg',
        'images/fall-hero.jpg'
      ];
      heroImages.forEach(src => {
        const img = new Image();
        img.src = src;
      });
      // Ensure carousel is fast and auto-advances
      document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.querySelector('#heroCarousel');
        if (carousel) {
          var bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 3000, // faster
            ride: 'carousel',
            pause: false, // never pause on hover
            wrap: true
          });
        }
      });
      // Animate carousel on slide
      document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.querySelector('#heroCarousel');
        if (carousel) {
          carousel.addEventListener('slide.bs.carousel', function(e) {
            var items = carousel.querySelectorAll('.carousel-item');
            items.forEach(function(item) {
              item.classList.remove('animating');
            });
            var next = items[e.to];
            if (next) {
              setTimeout(function() {
                next.classList.add('animating');
              }, 10);
            }
          });
          // Initial animation
          var first = carousel.querySelector('.carousel-item.active');
          if (first) first.classList.add('animating');
        }
      });
      // Hide loader when page is ready
      window.addEventListener('load', function() {
        document.getElementById('page-loader').classList.add('hide');
      });
      // Remove skeletons after 1.2s (simulate loading)
      window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
          var skel = document.getElementById('featured-skeletons');
          if (skel) skel.style.display = 'none';
        }, 1200);
      });
    </script>
</body>
</html>
