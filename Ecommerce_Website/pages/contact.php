<?php
session_start();

// Handle form submission
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        $to = 'yourname@email.com'; // Change to your email
        $headers = "From: $name <$email>\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
        $body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";
        if (mail($to, $subject, $body, $headers)) {
            $success = true;
        } else {
            $error = 'Sorry, your message could not be sent. Please try again later.';
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Aniyah</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f7f7; }
        .contact-section { background: #f7f7f7; padding: 40px 0; }
        .contact-card { background: #f4f4f4; border: none; border-radius: 0; padding: 40px 30px; height: 100%; }
        .contact-info-list { list-style: none; padding: 0; margin: 0 0 40px 0; }
        .contact-info-list li { display: flex; align-items: center; margin-bottom: 32px; }
        .contact-info-icon { width: 48px; height: 48px; border: 2px solid #111; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #111; margin-right: 20px; background: #fff; }
        .contact-info-text { color: #222; font-size: 1.08rem; }
        .contact-info-text span { display: block; color: #222; font-size: 1.08rem; }
        .contact-social { margin-top: 30px; }
        .contact-social-title { font-weight: 700; font-size: 1.3rem; color: #222; margin-bottom: 12px; }
        .contact-social-links a { color: #222; font-size: 1.3rem; margin-right: 18px; transition: color 0.2s; text-decoration: none !important; }
        .contact-social-links a:hover { color: #111; text-decoration: none !important; }
        .contact-form-card { background: #f4f4f4; border: none; border-radius: 0; padding: 40px 30px; }
        .contact-form-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #222; margin-bottom: 32px; }
        .form-control { border-radius: 0 !important; border: 1px solid #bbb; background: #fff; color: #111; font-size: 1.08rem; padding: 16px 18px; margin-bottom: 22px; }
        .form-control:focus { border-color: #111; box-shadow: none; background: #fff; color: #111; }
        .contact-send-btn { width: 180px; background: #222; color: #fff; border: none; border-radius: 0; font-weight: 700; font-size: 1.1rem; padding: 14px 0; margin-top: 18px; letter-spacing: 1px; transition: background 0.2s; text-decoration: none !important; }
        .contact-send-btn:hover { background: #111; color: #fff; text-decoration: none !important; }
        a, a:active, a:focus, a:hover, .btn, .btn:active, .btn:focus, .btn:hover { text-decoration: none !important; box-shadow: none !important; }
        .footer a, .footer a:active, .footer a:focus, .footer a:hover { text-decoration: none !important; }
        .contact-intro { font-size: 1.15rem; color: #444; margin-bottom: 2.5rem; max-width: 700px; }
        .support-hours { background: #fff; border: 1px solid #d1d1d1; border-radius: 0; padding: 24px 28px; margin-top: 30px; margin-bottom: 10px; }
        .support-hours-title { font-weight: 700; font-size: 1.2rem; color: #111; margin-bottom: 10px; }
        .support-hours-list { color: #333; font-size: 1.05rem; margin-bottom: 0; }
        .map-section { background: #fff; border: 1px solid #d1d1d1; border-radius: 0; padding: 32px 28px; margin-top: 40px; text-align: center; }
        .map-title { font-weight: 700; font-size: 1.2rem; color: #111; margin-bottom: 18px; }
        .map-placeholder { width: 100%; max-width: 600px; height: 280px; background: #eee; border: 2px dashed #bbb; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 1.3rem; margin: 0 auto; }
        @media (max-width: 991px) { .contact-card, .contact-form-card { padding: 30px 10px; } .map-placeholder { height: 180px; } }
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
                <div class="dropdown">
                    <button class="btn user-icon-btn p-0 d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background:none;border:none;outline:none;box-shadow:none;">
                        <span style="display:inline-block;width:40px;height:40px;border:2px solid #111;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="far fa-user" style="font-size:1.7rem;color:#111;"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 border-0 shadow-sm mt-2 p-0" aria-labelledby="userDropdown" style="min-width:180px;">
                        <li class="px-3 pt-3">
                            <a class="btn btn-outline-dark w-100 rounded-0 fw-bold mb-2" href="../login.php" style="letter-spacing:0.5px;">Login</a>
                        </li>
                        <li class="px-3 pb-3">
                            <a class="btn btn-dark w-100 rounded-0 fw-bold" href="../register.php" style="letter-spacing:0.5px;">Sign Up</a>
                        </li>
                        <li><hr class="dropdown-divider m-0"></li>
                        <li><a class="dropdown-item text-center py-2" href="../profile.php" style="color:#111;font-weight:500;">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <nav>
        <div class="container">
            <ul class="main-nav">
                <li><a href="../index.php" data-lang="home">Home</a></li>
                <li><a href="products.php" data-lang="shop">Shop</a></li>
                <li><a href="products.php" data-lang="categories">Categories</a></li>
                <li><a href="about.php" data-lang="about_us">About Us</a></li>
                <li><a href="contact.php" class="active" data-lang="contact_us">Contact Us</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-intro mx-auto text-center">
                <p>We'd love to hear from you! Whether you have a question about our products, need help with an order, or just want to share your feedback, our team is here to help. Reach out using the form below or through any of our contact methods.</p>
            </div>
            <div class="row g-0">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="contact-card h-100 d-flex flex-column justify-content-between">
                        <ul class="contact-info-list">
                            <li>
                                <span class="contact-info-icon"><i class="fas fa-phone"></i></span>
                                <div class="contact-info-text">
                                    <span>+012 345 678 102</span>
                                    <span>+012 345 678 102</span>
                                </div>
                            </li>
                            <li>
                                <span class="contact-info-icon"><i class="fas fa-globe"></i></span>
                                <div class="contact-info-text">
                                    <span>yourname@email.com</span>
                                    <span>yourwebsitename.com</span>
                                </div>
                            </li>
                            <li>
                                <span class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></span>
                                <div class="contact-info-text">
                                    <span>Address goes here, street, Crossroad 123.</span>
                                </div>
                            </li>
                        </ul>
                        <div class="support-hours mt-4">
                            <div class="support-hours-title">Customer Support Hours</div>
                            <ul class="support-hours-list list-unstyled mb-0">
                                <li>Monday - Friday: 9:00 AM – 7:00 PM</li>
                                <li>Saturday: 10:00 AM – 5:00 PM</li>
                                <li>Sunday & Holidays: Closed</li>
                            </ul>
                        </div>
                        <div class="contact-social">
                            <div class="contact-social-title">Follow Us</div>
                            <div class="contact-social-links">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-tumblr"></i></a>
                                <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form-card h-100">
                        <div class="contact-form-title">Get In Touch</div>
                        <?php if ($success): ?>
                            <div class="alert alert-success">Thank you for contacting us! We will get back to you soon.</div>
                        <?php elseif ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Name*" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email*" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>
                            </div>
                            <input type="text" name="subject" class="form-control" placeholder="Subject*" required value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                            <textarea name="message" class="form-control" rows="6" placeholder="Your Message*" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            <button type="submit" class="contact-send-btn">SEND</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="map-section mt-5">
                <div class="map-title">Map & Directions</div>
                <div class="map-placeholder">
                    [Map will appear here]
                </div>
                <!-- Example: Replace above with a real map embed if desired -->
                <!-- <iframe src="https://www.google.com/maps/embed?..." width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
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
                        <li class="mb-2"><a href="about.php" style="color:#555;">About us</a></li>
                        <li class="mb-2"><a href="#" style="color:#555;">Store location</a></li>
                        <li class="mb-2"><a href="contact.php" style="color:#555;">Contact</a></li>
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
    <script src="../js/main.js"></script>
    <script src="../js/cart.js"></script>
    <script src="../js/gTranslate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 