<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Aniyah</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="../index.php">
                    <h1>Aniyah</h1>
                </a>
            </div>
            <div class="search-bar">
                <form action="products.php" method="get">
                    <input type="text" placeholder="Search for products..." name="q">
                    <i class="fas fa-search"></i>
                </form>
            </div>
            <div class="header-actions">
                <button class="cart-toggle" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </button>
                <div class="auth-link">
    <?php
        session_start();
        if (isset($_SESSION['username'])) {
            echo '<a href="profile.php" class="btn btn-secondary"><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']) . '</a>';
        } else {
            echo '<a href="../login.php" class="btn btn-primary"><i class="fas fa-user"></i> Login / Sign Up →</a>';
        }
    ?>
</div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Banner -->
    <section class="hero animate-in">
      <div class="container hero-flex">
        <div class="hero-content">
          <h2>Your Cart</h2>
          <p>Review your selected pure cotton products and get ready for a comfortable, stylish experience.</p>
          <div class="hero-buttons">
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
          </div>
        </div>
        <div class="hero-image">
          <img src="../images/cotton-cart-hero.jpg" alt="Your cotton cart">
        </div>
      </div>
    </section>
    <!-- Why Shop With Us -->
    <section class="why-shop animate-in">
      <div class="container">
        <div class="section-header"><h2>Why Shop With Us?</h2></div>
        <div class="benefits-grid">
          <div class="benefit-card glass"><div class="benefit-icon">🌱</div><h3>100% Pure Cotton</h3><p>Soft, breathable, and skin-friendly fabrics.</p></div>
          <div class="benefit-card glass"><div class="benefit-icon">🚚</div><h3>Free Shipping</h3><p>On all orders above ₹999.</p></div>
          <div class="benefit-card glass"><div class="benefit-icon">🔄</div><h3>Easy Returns</h3><p>7-day hassle-free returns on all products.</p></div>
        </div>
      </div>
    </section>

    <!-- Cart Page Content -->
    <section class="cart-section">
        <div class="container">
        <div id="cart-empty" style="display:none;text-align:center;padding:80px 0;">
          <div style="font-size:5rem;color:#111;margin-bottom:1.5rem;"><i class="fas fa-shopping-cart"></i></div>
          <div style="font-size:1.2rem;color:#222;margin-bottom:1.5rem;">No items found in cart</div>
          <a href="products.php" class="btn btn-dark" style="padding:0.75rem 2.5rem;font-weight:600;">Shop Now</a>
                </div>
        <div id="cart-filled" style="display:none;">
          <h2 style="font-weight:700;font-size:2rem;margin-bottom:2rem;">Your Cart</h2>
          <div class="cart-table-wrapper" style="overflow-x:auto;">
            <table class="cart-table" style="width:100%;border-collapse:collapse;min-width:600px;">
              <thead>
                <tr style="border-bottom:2px solid #eee;font-size:1.1rem;">
                  <th style="text-align:left;padding:1rem 0;">Product</th>
                  <th style="text-align:left;">Name</th>
                  <th style="text-align:center;">Price</th>
                  <th style="text-align:center;">Quantity</th>
                  <th style="text-align:center;">Total</th>
                  <th style="text-align:center;"></th>
                </tr>
              </thead>
              <tbody id="cart-items-table"></tbody>
            </table>
                    </div>
          <div class="cart-summary" style="margin-top:2.5rem;text-align:right;">
            <div style="font-size:1.1rem;margin-bottom:0.5rem;">Subtotal: <span id="cart-subtotal">₹0.00</span></div>
            <div style="font-size:1.1rem;margin-bottom:0.5rem;">Shipping: <span>Free</span></div>
            <div style="font-size:1.3rem;font-weight:700;margin-bottom:1.5rem;">Total: <span id="cart-total">₹0.00</span></div>
            <button class="btn btn-dark" id="checkout-btn" style="padding:0.75rem 2.5rem;font-weight:600;">Proceed to Checkout</button>
            <button class="btn btn-outline-dark" id="clear-cart-btn" style="margin-left:1rem;padding:0.75rem 2.5rem;font-weight:600;">Clear Cart</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="cart-total-amount">₹0.00</span>
            </div>
            <a href="cart.html" class="btn btn-primary btn-block">View Cart</a>
            <button onclick="window.location.href='checkout.html'" class="btn btn-primary btn-block">Checkout</button>
        </div>
    </div>
    
    <!-- Overlay -->
    <div class="overlay"></div>

    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/language.js"></script>
    <script>
    function renderCartPage() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const emptyDiv = document.getElementById('cart-empty');
      const filledDiv = document.getElementById('cart-filled');
      if (!cart.length) {
        emptyDiv.style.display = '';
        filledDiv.style.display = 'none';
        return;
      }
      emptyDiv.style.display = 'none';
      filledDiv.style.display = '';
      const tbody = document.getElementById('cart-items-table');
      tbody.innerHTML = cart.map(item => `
        <tr style="border-bottom:1px solid #eee;">
          <td style="padding:1rem 0;"><img src="${item.imageUrl || item.image}" alt="${item.name}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;"></td>
          <td style="font-weight:500;">${item.name}</td>
          <td style="text-align:center;">₹${item.price.toFixed(2)}</td>
          <td style="text-align:center;">
            <button onclick="updateQuantity('${item.id}',-1)" style="border:none;background:none;font-size:1.2rem;padding:0 8px;">-</button>
            <span style="min-width:32px;display:inline-block;">${item.quantity}</span>
            <button onclick="updateQuantity('${item.id}',1)" style="border:none;background:none;font-size:1.2rem;padding:0 8px;">+</button>
          </td>
          <td style="text-align:center;">₹${(item.price*item.quantity).toFixed(2)}</td>
          <td style="text-align:center;">
            <button onclick="removeFromCart('${item.id}')" style="border:none;background:none;color:#c00;font-size:1.2rem;"><i class="fas fa-trash"></i></button>
          </td>
        </tr>
      `).join('');
      // Update summary
      const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
      document.getElementById('cart-subtotal').textContent = `₹${subtotal.toFixed(2)}`;
      document.getElementById('cart-total').textContent = `₹${subtotal.toFixed(2)}`;
    }
    // Quantity and remove handlers
    function updateQuantity(id, change) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const idx = cart.findIndex(i => i.id === id);
      if (idx === -1) return;
      cart[idx].quantity += change;
      if (cart[idx].quantity < 1) cart.splice(idx,1);
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCartPage();
    }
    function removeFromCart(id) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart = cart.filter(i => i.id !== id);
      localStorage.setItem('cart', JSON.stringify(cart));
      renderCartPage();
    }
    document.getElementById('clear-cart-btn')?.addEventListener('click', function() {
      localStorage.removeItem('cart');
      renderCartPage();
    });
    document.getElementById('checkout-btn')?.addEventListener('click', function() {
      window.location.href = 'checkout.php';
    });
    document.addEventListener('DOMContentLoaded', renderCartPage);
    window.renderCartPage = renderCartPage;
    window.updateQuantity = updateQuantity;
    window.removeFromCart = removeFromCart;
    </script>
</body>
</html> 