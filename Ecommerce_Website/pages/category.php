<?php
session_start();
include '../db_connection.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Aniyah</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            color: #111;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #fff;
            color: #111;
            border-radius: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            border: 2px solid #111;
            box-shadow: none;
        }

        /* Header actions styling */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart {
            position: relative;
            margin-right: 10px;
        }

        /* Enhanced Category Grid Styling */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            padding: 40px 0;
        }

        .category-card {
            background: #fff;
            border-radius: 0;
            padding: 30px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #d1d1d1;
            box-shadow: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
            color: #111;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: none;
            border-color: #111;
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            margin-top: 0.5rem;
            color: #111;
        }

        .category-card h3 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            color: #111;
        }

        .category-card p {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 1rem;
        }

        .category-link {
            margin-top: auto;
            display: inline-block;
            padding: 0.5rem 1rem;
            color: #111;
            font-weight: 500;
            border-radius: 0;
            background-color: transparent;
            transition: background-color 0.3s ease;
            border: 1px solid #d1d1d1;
            }

        .category-link:hover {
            background-color: #f5f5f5;
        }

        /* Updated profile button styling to match index.php */
        .btn-secondary.user-profile-btn {
            background-color: #6c757d;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-secondary.user-profile-btn:hover {
            background-color: #5a6268;
        }

        .btn-secondary.user-profile-btn i {
            font-size: 1rem;
        }

        /* Login button styling */
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        /* Header actions alignment */
        .auth-link {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="logo">
                <a href="../index.php">
                    <h1>Aniyah</h1>
                </a>
            </div>
            <div class="search-bar" style="flex: 1; margin: 0 20px;">
                <form action="products.php" method="get">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products..." name="q">
                </form>
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
                <button class="cart-toggle" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cart-count">0</span>
                </button>
                <div class="auth-link">
                    <?php
                    if ($loggedIn) {
                        echo '<a href="../profile.php" class="btn btn-secondary user-profile-btn">';
                        echo '<i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['username']);
                        echo '</a>';
                    } else {
                        echo '<a href="../login.php" class="btn btn-primary">';
                        echo '<i class="fas fa-user"></i> Login / Sign Up →';
                        echo '</a>';
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php" class="active">Categories</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <main>
        <!-- Page Banner -->
        <section class="page-banner">
            <div class="container">
                <h1>Browse Categories</h1>
                <div class="breadcrumbs">
                    <a href="../index.php">Home</a> / <span>Categories</span>
                </div>
            </div>
        </section>

        <!-- Hero Banner -->
        <section class="hero animate-in">
            <div class="container hero-flex">
                <div class="hero-content">
                    <h2>Shop by Category</h2>
                    <p>Explore our curated categories of pure cotton fashion—dresses, tops, bottoms, and more.</p>
                    <div class="hero-buttons">
                        <a href="#collections" class="btn btn-primary">Shop Collections</a>
                        </div>
                        </div>
                <div class="hero-image">
                    <img src="../images/cotton-category-hero.jpg" alt="Cotton fashion categories">
                </div>
            </div>
        </section>

        <!-- Modern Categories Section -->
        <section class="categories animate-in">
            <div class="container">
                <div class="section-header">
                    <h2>Shop by Category</h2>
                    <p>Find your perfect style—explore our curated categories of pure cotton fashion for every occasion.</p>
                </div>
                <div class="category-grid">
                    <div class="category-card glass">
                        <div class="category-icon">👗</div>
                        <h3>Dresses</h3>
                        <p>Elegant, flowy, and comfortable cotton dresses for every mood.</p>
                        <a href="products.php?category=dresses" class="btn btn-primary btn-sm">Shop Now</a>
                        </div>
                    <div class="category-card glass">
                        <div class="category-icon">👚</div>
                        <h3>Tops & Kurtis</h3>
                        <p>Trendy tops and kurtis in soft, breathable cotton.</p>
                        <a href="products.php?category=tops" class="btn btn-secondary btn-sm">Shop Now</a>
                    </div>
                    <div class="category-card glass">
                        <div class="category-icon">👖</div>
                        <h3>Bottoms</h3>
                        <p>Palazzos, pants, and skirts for effortless style and comfort.</p>
                        <a href="products.php?category=bottoms" class="btn btn-primary btn-sm">Shop Now</a>
                        </div>
                    <div class="category-card glass">
                        <div class="category-icon">👜</div>
                        <h3>Accessories</h3>
                        <p>Complete your look with bags, scarves, and more.</p>
                        <a href="products.php?category=accessories" class="btn btn-secondary btn-sm">Shop Now</a>
                    </div>
                    <div class="category-card glass">
                        <div class="category-icon">🌟</div>
                        <h3>New Arrivals</h3>
                        <p>Discover the latest trends and fresh styles in cotton fashion.</p>
                        <a href="products.php?category=new" class="btn btn-primary btn-sm">Shop Now</a>
                        </div>
                    <div class="category-card glass">
                        <div class="category-icon">🔥</div>
                        <h3>Best Sellers</h3>
                        <p>Our most-loved pieces, chosen by women like you.</p>
                        <a href="products.php?category=best-sellers" class="btn btn-secondary btn-sm">Shop Now</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Shop by Collection -->
        <section id="collections" class="featured-collections animate-in">
            <div class="container">
                <div class="section-header"><h2>Featured Collections</h2></div>
                <div class="collections-grid">
                    <div class="collection-card glass"><h3>Summer Cotton</h3><p>Light, breezy styles for sunny days.</p></div>
                    <div class="collection-card glass"><h3>Workwear</h3><p>Chic and comfortable for the office.</p></div>
                    <div class="collection-card glass"><h3>Everyday Essentials</h3><p>Soft, durable cotton for daily wear.</p></div>
                </div>
            </div>
        </section>

        <!-- Why Choose Cotton? -->
        <section class="why-shop animate-in">
            <div class="container">
                <div class="section-header"><h2>Why Choose Cotton?</h2></div>
                <div class="benefits-grid">
                    <div class="benefit-card glass"><div class="benefit-icon">🌱</div><h3>Natural & Breathable</h3><p>Stay cool and comfortable all day.</p></div>
                    <div class="benefit-card glass"><div class="benefit-icon">🌸</div><h3>Gentle on Skin</h3><p>Perfect for sensitive skin and all-day wear.</p></div>
                    <div class="benefit-card glass"><div class="benefit-icon">🌞</div><h3>Perfect for Summer</h3><p>Lightweight, airy, and stylish.</p></div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-about">
                    <h3>Aniyah</h3>
                    <p>Your one-stop shop for the latest women's fashion, clothing, and outfits from around the world, delivered right to your doorstep.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Fashion Avenue</p>
                    <p>City, State 12345</p>
                    <p><i class="fas fa-envelope"></i> info@Aniyah.com</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                </div>
                
                <div class="footer-newsletter">
                    <h3>Subscribe to our newsletter</h3>
                    <form id="newsletter-form">
                        <input type="email" placeholder="Your email" required>
                        <button type="submit" class="btn">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Aniyah. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="js/language.js"></script>
    <script src="../js/categories.js"></script>
    <script src="../js/gTranslate.js"></script>
</body>
</html>

