<?php
session_start();
// Pagination logic
$total_products = 200;
$per_page = 12;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$start = ($page - 1) * $per_page + 1;
$end = min($start + $per_page - 1, $total_products);
$total_pages = ceil($total_products / $per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Aniyah</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .product-card, .lookbook-card, .collection-card, .testimonial-card, .newsletter-popup, .floating-widget {
            border-radius: 0 !important;
            background: #fff !important;
            color: #111 !important;
            box-shadow: none !important;
            border: 1px solid #d1d1d1 !important;
        }
        .product-card .btn, .lookbook-card .btn, .collection-card .btn, .newsletter-popup button {
            border-radius: 0 !important;
            background: #fff !important;
            color: #111 !important;
            border: 2px solid #111 !important;
            box-shadow: none !important;
        }
        .product-card .btn.btn-primary, .lookbook-card .btn.btn-primary, .collection-card .btn.btn-primary, .newsletter-popup button {
            background: #111 !important;
            color: #fff !important;
        }
        .product-card .btn.btn-primary:hover, .lookbook-card .btn.btn-primary:hover, .collection-card .btn.btn-primary:hover, .newsletter-popup button:hover {
            background: #fff !important;
            color: #111 !important;
            border: 2px solid #111 !important;
            text-decoration: underline;
        }
        .section-header h2, .section-header p {
            color: #111 !important;
        }
        .collection-icon, .testimonial-card, .lookbook-card h3 {
            color: #111 !important;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="logo">
                <a href="../index.php" style="text-decoration:none;">
                    <h1 style="text-decoration:none;">Aniyah</h1>
                </a>
            </div>
            <div class="search-bar" style="flex: 1; margin: 0 20px;">
                <form action="products.html" method="get">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products..." name="q">
                </form>
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                <div class="cart">
                    <button class="cart-toggle" onclick="toggleCart()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cart-count">0</span>
                    </button>
                </div>
                <div class="auth-link">
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<a href="../profile.php" class="btn btn-secondary"><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']) . '</a>';
                        } else {
                            echo '<a href="../login.php" class="btn btn-primary"><i class="fas fa-user"></i> Login / Sign Up →</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Drawer -->
    <div class="cart-drawer">
        <div class="cart-header">
            <h3>Your Cart</h3>
            <button class="close-cart" onclick="closeCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="cart.php" class="btn btn-primary checkout-btn">Checkout</a>
            <button class="btn btn-secondary clear-cart-btn" onclick="clearCart()">Clear Cart</button>
        </div>
    </div>
    <div class="overlay"></div>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php" class="active" style="text-decoration:none;">Home</a></li>
                <li><a href="products.php" class="active">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <main>
        <!-- Page Banner -->
        <section class="page-banner">
            <div class="container text-center" style="padding: 24px 0 10px 0;">
                <h1 style="font-size:3.5rem;margin-bottom:0.2rem;font-weight:800;letter-spacing:-1.5px;">Products</h1>
                <div class="breadcrumbs" style="display:inline-block;font-size:0.98rem;color:#555;">
                    <span style="font-weight:500;">Home</span> / <span>Products</span>
                </div>
            </div>
        </section>

        <!-- Hero Banner -->
        <section class="hero animate-in">
            <div class="container hero-flex">
                <div class="hero-content">
                    <h2>Shop the Latest in Pure Cotton Fashion</h2>
                    <p>Discover our exclusive collection of 100% pure cotton dresses, tops, and more—crafted for comfort and style.</p>
                    <div class="hero-buttons">
                        <a href="#best-sellers" class="btn btn-primary">Best Sellers</a>
                        <a href="#offers" class="btn btn-secondary">Limited Time Offers</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="../images/cotton-fashion-hero.jpg" alt="Pure cotton women's fashion">
                </div>
            </div>
        </section>
    
     
      

        <!-- Products Section -->
        <section class="product-section py-4">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <aside class="col-12 col-md-3 col-lg-2 mb-4 mb-md-0">
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Search</h5>
                            <form class="d-flex align-items-center" style="gap:8px;">
                                <input type="text" class="form-control" placeholder="Search here..." style="border-radius:0;">
                                <button class="btn btn-outline-secondary" type="submit" style="border-radius:0;"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Categories</h5>
                            <ul class="list-unstyled" style="font-size:1rem;max-height:200px;overflow:auto;">
                                <li class="mb-2"><input type="checkbox" id="cat-all"> <label for="cat-all">All Categories</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-fashion"> <label for="cat-fashion">Fashion</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-men"> <label for="cat-men">Men</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-women"> <label for="cat-women">Women</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-electronics"> <label for="cat-electronics">Electronics</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-furniture"> <label for="cat-furniture">Furniture</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-plant"> <label for="cat-plant">Plant</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-organic"> <label for="cat-organic">Organic Food</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-flower"> <label for="cat-flower">Flower</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-book"> <label for="cat-book">Book</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-cosmetics"> <label for="cat-cosmetics">Cosmetics</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-accessories"> <label for="cat-accessories">Accessories</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-handmade"> <label for="cat-handmade">Handmade</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-kids"> <label for="cat-kids">Kids</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-auto"> <label for="cat-auto">Auto Parts</label></li>
                                <li class="mb-2"><input type="checkbox" id="cat-cakes"> <label for="cat-cakes">Cakes</label></li>
                            </ul>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Color</h5>
                            <ul class="list-unstyled" style="font-size:1rem;max-height:120px;overflow:auto;">
                                <li class="mb-2"><input type="checkbox" id="color-black"> <label for="color-black">Black</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-white"> <label for="color-white">White</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-red"> <label for="color-red">Red</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-blue"> <label for="color-blue">Blue</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-green"> <label for="color-green">Green</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-yellow"> <label for="color-yellow">Yellow</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-brown"> <label for="color-brown">Brown</label></li>
                                <li class="mb-2"><input type="checkbox" id="color-grey"> <label for="color-grey">Grey</label></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-3">Tag</h5>
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                <span class="badge bg-light text-dark border">New</span>
                                <span class="badge bg-light text-dark border">Sale</span>
                                <span class="badge bg-light text-dark border">Popular</span>
                                <span class="badge bg-light text-dark border">Organic</span>
                                <span class="badge bg-light text-dark border">Handmade</span>
                                <span class="badge bg-light text-dark border">Kids</span>
                                <span class="badge bg-light text-dark border">Auto</span>
                                <span class="badge bg-light text-dark border">Cakes</span>
                            </div>
                        </div>
                    </aside>
                    <!-- Products Grid -->
                    <div class="col-12 col-md-9 col-lg-10">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <select class="form-select" style="width:140px;">
                                    <option>Default</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                    <option>Newest</option>
                                </select>
                                <span class="ms-2" style="font-size:1rem;">Showing 1-12 of 200 results</span>
                            </div>
                            <div>
                                <button class="btn btn-light border"><i class="fas fa-th"></i></button>
                                <button class="btn btn-light border"><i class="fas fa-th-list"></i></button>
                            </div>
                        </div>
                        <div class="row g-4" id="shop-grid">
                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <div class="col-12 col-md-4">
                                    <div class="product-card modern-card p-3 h-100 d-flex flex-column align-items-center justify-content-between position-relative">
                                        <?php if ($i % 3 == 0): ?><span class="badge bg-primary position-absolute top-0 end-0 m-2">-10%</span><?php endif; ?>
                                        <?php if ($i % 2 == 0): ?><span class="badge bg-success position-absolute top-0 start-0 m-2">New</span><?php endif; ?>
                                        <div class="modern-card-img-wrap mb-3">
                                            <img src="https://via.placeholder.com/350x420?text=Product+<?= $i ?>" alt="Product <?= $i ?>" class="img-fluid modern-card-img">
                                        </div>
                                        <div class="w-100 text-center">
                                            <h5 class="mb-1" style="font-size:1.15rem;font-weight:700;letter-spacing:-0.5px;">Product <?= $i ?></h5>
                                            <div class="mb-1" style="color:#888;font-size:1.05rem;">₹<?= 499 + $i ?>.00</div>
                                            <div class="mb-2">
                                                <span class="text-warning">★★★★★</span>
                                            </div>
                                            <button class="btn btn-dark w-100" style="border-radius:8px;">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-4">
                                <li class="page-item<?= $page == 1 ? ' disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                                </li>
                                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                    <li class="page-item<?= $p == $page ? ' active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item<?= $page == $total_pages ? ' disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

      

    <!-- Scripts -->
    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/products.js"></script>
    <script src="../js/gTranslate.js"></script>

    <!-- Bootstrap Loading Spinner Overlay -->
    <div id="page-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.97);z-index:3000;display:flex;align-items:center;justify-content:center;transition:opacity 0.5s;">
      <div class="spinner-border text-dark" role="status" style="width:3rem;height:3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <script>
      window.addEventListener('load', function() {
        setTimeout(function() {
          document.getElementById('page-loader').style.opacity = '0';
          setTimeout(function(){
            document.getElementById('page-loader').style.display = 'none';
          }, 500);
        }, 300);
      });
    </script>

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

</body>
</html> 