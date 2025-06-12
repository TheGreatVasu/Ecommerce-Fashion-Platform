<?php
session_start();
include '../db_connection.php';

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
    <title data-translate="about.pageTitle">About Us - Aniyah</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .about-section {
            padding: 80px 0;
            background-color: #fff;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-content h2 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 30px;
        }

        .about-content p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: left;
        }

        .stat-number {
            display: block;
            font-size: 2.5em;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 1.1em;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .values-section {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .values-section h2 {
            text-align: center;
            font-size: 2.5em;
            color: #333;
            margin-bottom: 50px;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .value-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .value-icon i {
            font-size: 32px;
            color: #4CAF50;
        }

        .value-card h3 {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .value-card p {
            color: #666;
            line-height: 1.6;
        }

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

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .auth-link {
            margin-left: 5px;
        }

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

        .language-selector {
            position: relative;
            cursor: pointer;
        }

        .language-selector span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .language-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 8px 0;
            min-width: 150px;
            z-index: 100;
        }

        .language-selector:hover .language-dropdown {
            display: block;
        }

        .language-dropdown a {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
        }

        .language-dropdown a:hover {
            background: #f5f5f5;
        }

        .breadcrumbs {
            margin-top: 10px;
            color: #666;
        }

        .breadcrumbs a {
            color: #4CAF50;
            text-decoration: none;
        }

        .breadcrumbs span {
            color: #999;
        }

        @media (max-width: 992px) {
            .about-grid {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .about-stats {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }
        }

        .about-section, .team-member, .stat-item, .timeline-item, .newsletter-popup, .floating-widget {
            border-radius: 0 !important;
            background: #fff !important;
            color: #111 !important;
            box-shadow: none !important;
            border: 1px solid #d1d1d1 !important;
        }
        .team-member img, .about-image img {
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .stat-icon, .stat-number, .stat-label, .timeline-item, .team-member h3, .team-member p {
            color: #111 !important;
        }
    </style>
</head>
<body>
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

    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php" data-translate="about.home">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="about.php" class="active" data-translate="about.aboutUs">About Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <section class="page-banner">
        <div class="container">
            <h1>About Us</h1>
            <div class="breadcrumbs">
                <a href="../index.html"><i style="color:rgb(0, 0, 0);">Home</i></a> / <span>About Us</span>
            </div>
        </div>
    </section>

    <main>
        <!-- Hero Banner -->
        <section class="hero animate-in">
            <div class="container hero-flex">
                <div class="hero-content">
                    <h2>About Aniyah</h2>
                    <p>Welcome to Aniyah—where pure cotton fashion meets modern technology and a passion for empowering women. Discover our story, our mission, and the people behind the brand.</p>
                    <div class="hero-buttons">
                        <a href="../pages/products.php" class="btn btn-primary">Shop Now</a>
                        <a href="#team" class="btn btn-secondary">Meet Our Team</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="../images/about-hero-cotton.jpg" alt="About Aniyah">
                </div>
            </div>
        </section>

        <!-- Brand Story -->
        <section class="about-section animate-in">
            <div class="container">
                <div class="section-header"><h2>Our Story</h2></div>
                <div class="about-grid">
                    <div class="about-content">
                        <h3>Fashion, Comfort, and Innovation</h3>
                        <p>Aniyah was founded with a simple mission: to bring the best of pure cotton fashion to women everywhere, blending timeless style with the latest in AI-driven personalization and e-commerce technology. We believe every woman deserves to feel confident, comfortable, and inspired—every day.</p>
                        <p>From our eco-friendly sourcing to our seamless online experience, we're committed to quality, sustainability, and customer delight. Join our community and experience the future of fashion shopping!</p>
                        <a href="../pages/products.php" class="btn btn-primary">Explore Our Collection</a>
                    </div>
                    <div class="about-image">
                        <img src="../images/about-story-cotton.jpg" alt="Our Story">
                    </div>
                </div>
            </div>
        </section>

        <!-- Meet Our Team -->
        <section id="team" class="team-section animate-in">
            <div class="container">
                <div class="section-header"><h2>Meet Our Team</h2></div>
                <div class="team-grid">
                    <div class="team-member glass">
                        <div class="member-image"><img src="../images/vasu-rastogi.jpg" alt="Vasu Rastogi"></div>
                        <div class="member-content">
                            <h3>Vasu Rastogi</h3>
                            <div class="member-role">Website Developer</div>
                            <p>Vasu is the creative mind and technical expert behind Aniyah's seamless, AI-powered online experience. <a href="mailto:vasu@example.com">Contact</a></p>
                        </div>
                    </div>
                    <div class="team-member glass">
                        <div class="member-image"><img src="../images/muzaffar-ashraf.jpg" alt="Muzaffar Ashraf"></div>
                        <div class="member-content">
                            <h3>Muzaffar Ashraf</h3>
                            <div class="member-role">Business Owner</div>
                            <p>Muzaffar is the visionary entrepreneur and driving force behind Aniyah's mission to empower women through fashion. <a href="mailto:muzaffar@example.com">Contact</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="newsletter animate-in">
            <div class="container">
                <h2>Join the Aniyah Community</h2>
                <p>Get exclusive offers, style tips, and early access to new collections—delivered to your inbox.</p>
                <form>
                    <input type="email" placeholder="Your email address" required>
                    <button type="submit">Subscribe</button>
                </form>
                        </div>
        </section>

     
        <!-- AI at Aniyah Section -->
        <section class="ai-section animate-in">
            <div class="container">
                <div class="section-header"><h2>AI at Aniyah</h2></div>
                <div class="about-grid">
                    <div class="about-content">
                        <h3>Personalized Shopping, Powered by AI</h3>
                        <p>Our smart algorithms recommend styles just for you, predict trends, and help you find your perfect fit—instantly. Enjoy a seamless, tailored experience every time you visit Aniyah.</p>
                        <ul>
                            <li>✨ AI-powered product recommendations</li>
                            <li>✨ Real-time inventory and smart sizing</li>
                            <li>✨ Automated style advice and chat support</li>
                        </ul>
                    </div>
                    <div class="about-image">
                        <img src="../images/ai-fashion.jpg" alt="AI at Aniyah">
                    </div>
                </div>
            </div>
        </section>

        <!-- Animated Stats Section -->
        <section class="about-stats animate-in">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item glass">
                        <div class="stat-icon">😊</div>
                        <span class="stat-number" id="stat-customers">0</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                    <div class="stat-item glass">
                        <div class="stat-icon">🛍️</div>
                        <span class="stat-number" id="stat-products">0</span>
                        <span class="stat-label">Products Sold</span>
                    </div>
                            </div>
                        </div>
        </section>

        <script>
        // Animate stats
        function animateStat(id, end, duration) {
            let el = document.getElementById(id);
            let start = 0;
            let step = Math.ceil(end / (duration / 20));
            let interval = setInterval(() => {
                start += step;
                if (start >= end) { el.textContent = end.toLocaleString(); clearInterval(interval); }
                else { el.textContent = start.toLocaleString(); }
            }, 20);
        }
        window.addEventListener('DOMContentLoaded', () => {
            animateStat('stat-customers', 5000, 1200);
            animateStat('stat-products', 12000, 1200);
           
        });
        </script>

    

        <!-- Timeline Section -->
        <section class="timeline-section animate-in">
            <div class="container">
                <div class="section-header"><h2>Our Journey</h2></div>
                <div class="timeline-grid">
                    <div class="timeline-item glass"><span class="timeline-year">2022</span><p>Founded Aniyah with a vision for AI-powered fashion.</p></div>
                    <div class="timeline-item glass"><span class="timeline-year">2023</span><p>Launched our first pure cotton collection and personalized shopping engine.</p></div>
                    <div class="timeline-item glass"><span class="timeline-year">2024</span><p>Reached 10,000+ customers and introduced real-time AI chat support.</p></div>
                    <div class="timeline-item glass"><span class="timeline-year">2025</span><p>Continuing to innovate for women everywhere!</p></div>
                    </div>
                        </div>
        </section>

        <!-- Dynamic Testimonials Section -->
        <section class="testimonials animate-in">
            <div class="container">
                <div class="section-header"><h2>What Women Are Saying</h2></div>
                <div class="testimonial-carousel">
                    <div class="testimonial-card glass">"The AI recommendations are spot on! I found my new favorite dress in seconds."<br><b>- Aarti S.</b></div>
                    <div class="testimonial-card glass">"Aniyah's chat support helped me pick the perfect size. Love the experience!"<br><b>- Priya M.</b></div>
                    <div class="testimonial-card glass">"The site feels so modern and easy to use. I'm a fan!"<br><b>- Rina D.</b></div>
                            </div>
                        </div>
        </section>

        <!-- Floating AI Chat Widget -->
        <div class="floating-widget animate-in"><i class="fas fa-robot"></i> Ask Aniyah AI: Need help or style advice?</div>

        <!-- Our Promise -->
        <section class="why-shop animate-in">
            <div class="container">
                <div class="section-header"><h2>Our Promise</h2></div>
                <div class="benefits-grid">
                    <div class="benefit-card glass"><div class="benefit-icon">🌱</div><h3>Pure Cotton</h3><p>We use only the finest, natural cotton for all our products.</p></div>
                    <div class="benefit-card glass"><div class="benefit-icon">💧</div><h3>Eco-Friendly</h3><p>Our processes are gentle on the planet and your skin.</p></div>
                    <div class="benefit-card glass"><div class="benefit-icon">💖</div><h3>Made for Women</h3><p>Designed to empower and inspire confidence.</p></div>
                </div>
            </div>
        </section>

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
    <script src="../js/gTranslate.js"></script>

</body>
</html> 