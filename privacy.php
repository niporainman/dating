<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']);
$page_title = "Privacy Policy";
$page_header = "privacy_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
<?php include("page_header.php"); ?>
<br><br>

<section class="room-service-section pb-60">
    <div class="container py-5">
  <div class="mb-4">
    <h3 class="mb-3">Privacy Policy</h3>
    <p>Your privacy is important to us at <strong><?= $company_name ?></strong>. This Privacy Policy outlines how we collect, use, and protect your personal information when you use our services.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">1. Information We Collect</h4>
    <ul class="list-unstyled">
      <li><strong>Personal Information:</strong> When you register, we collect your name, email address, age, gender, location, and any details you include in your profile.</li>
      <li><strong>Usage Data:</strong> We collect data on how you interact with the site, including pages visited, searches made, and messages sent.</li>
      <li><strong>Device & Technical Info:</strong> Your IP address, browser type, and device data may be collected for security and analytics purposes.</li>
    </ul>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">2. How We Use Your Information</h4>
    <ul class="list-unstyled">
      <li>To provide and personalize your dating experience.</li>
      <li>To recommend potential matches based on your preferences and activity.</li>
      <li>To improve site performance and user experience.</li>
      <li>To communicate with you regarding your account or updates to our terms.</li>
      <li>To monitor and prevent fraud, abuse, or violations of our terms.</li>
    </ul>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">3. Sharing of Information</h4>
    <p>We do not sell or rent your personal information to third parties. However, we may share limited data with:</p>
    <ul class="list-unstyled">
      <li>Trusted third-party service providers (e.g., payment processors, hosting services) who assist in running the platform.</li>
      <li>Law enforcement or legal authorities, if required by law or to protect user safety and rights.</li>
    </ul>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">4. Cookies and Tracking Technologies</h4>
    <p>We use cookies to enhance your experience, save preferences, and track site usage. You can manage cookie settings through your browser.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">5. Data Retention</h4>
    <p>We retain your information as long as your account is active or as necessary to provide services. You may request deletion of your data at any time.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">6. Your Privacy Choices</h4>
    <ul class="list-unstyled">
      <li>You may update or delete your profile at any time from your account settings.</li>
      <li>You can unsubscribe from marketing emails by clicking the link at the bottom of any such email.</li>
    </ul>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">7. Security</h4>
    <p>We use industry-standard security measures to protect your data. However, no online platform can guarantee absolute security. Please use caution when sharing personal details with others.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">8. Changes to This Policy</h4>
    <p>We may update this Privacy Policy occasionally. All changes will be posted on this page with an updated revision date.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">9. Contact Us</h4>
    <p>If you have any questions or concerns about your privacy, please contact us at <a href=""><?= $company_email ?></a>.</p>
  </div>
</div>

</section>
<!-- End Room section -->
<?php include("footer.php"); ?>