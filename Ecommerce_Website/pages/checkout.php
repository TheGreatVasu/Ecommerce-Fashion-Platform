<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Aniyah</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="logo"><a href="../index.php"><h1>Aniyah</h1></a></div>
    </div>
  </header>
  <section class="checkout-section">
    <div class="container" style="max-width:600px;margin:40px auto;">
      <h2 style="font-weight:700;font-size:2rem;margin-bottom:2rem;">Checkout</h2>
      <div id="checkout-summary" style="margin-bottom:2rem;"></div>
      <form id="checkout-form" style="background:#fafafa;padding:2rem;border-radius:8px;">
        <div style="margin-bottom:1.2rem;"><input type="text" name="name" placeholder="Full Name" required style="width:100%;padding:0.75rem;"></div>
        <div style="margin-bottom:1.2rem;"><input type="email" name="email" placeholder="Email" required style="width:100%;padding:0.75rem;"></div>
        <div style="margin-bottom:1.2rem;"><input type="text" name="address" placeholder="Address" required style="width:100%;padding:0.75rem;"></div>
        <div style="margin-bottom:1.2rem;"><input type="text" name="phone" placeholder="Phone" required style="width:100%;padding:0.75rem;"></div>
        <button type="submit" class="btn btn-dark" style="width:100%;padding:0.9rem 0;font-weight:600;">Place Order</button>
      </form>
      <div id="checkout-thankyou" style="display:none;text-align:center;padding:2rem 0;font-size:1.3rem;font-weight:600;color:#111;">Thank you for your order!<br>Your order has been placed successfully.</div>
    </div>
  </section>
  <script>
    function renderCheckoutSummary() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      if (!cart.length) {
        document.getElementById('checkout-summary').innerHTML = '<div style="text-align:center;color:#888;">Your cart is empty.</div>';
        document.getElementById('checkout-form').style.display = 'none';
        return;
      }
      let html = '<table style="width:100%;margin-bottom:1.5rem;font-size:1rem;">';
      html += '<tr><th style="text-align:left;">Product</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Total</th></tr>';
      let total = 0;
      cart.forEach(item => {
        html += `<tr><td>${item.name}</td><td style="text-align:center;">${item.quantity}</td><td style="text-align:right;">₹${(item.price*item.quantity).toFixed(2)}</td></tr>`;
        total += item.price * item.quantity;
      });
      html += `<tr><td colspan="2" style="text-align:right;font-weight:700;">Total:</td><td style="text-align:right;font-weight:700;">₹${total.toFixed(2)}</td></tr>`;
      html += '</table>';
      document.getElementById('checkout-summary').innerHTML = html;
    }
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
      e.preventDefault();
      localStorage.removeItem('cart');
      document.getElementById('checkout-form').style.display = 'none';
      document.getElementById('checkout-summary').style.display = 'none';
      document.getElementById('checkout-thankyou').style.display = '';
    });
    document.addEventListener('DOMContentLoaded', renderCheckoutSummary);
  </script>
</body>
</html> 