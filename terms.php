<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']);
$page_title = "Terms & Conditions";
$page_header = "terms_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
<?php include("page_header.php"); ?>
<br><br>

<section class="room-service-section pb-60">
 <div class="container py-5">
  <div class="mb-4">
    <h3 class="mb-3">Terms of Use</h3>
    <p>Welcome to <strong><?= $company_name ?></strong>. By using our website, you agree to the following Terms of Use. Please read them carefully to understand your rights and responsibilities as a member of our platform.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">1. Eligibility</h4>
    <p>By using <?= $company_name ?>, you confirm that you are at least 18 years old and legally able to enter into a binding agreement. Our service is intended for individuals aged 40 and above who are seeking meaningful connections.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">2. Account Responsibility</h4>
    <p>You are responsible for maintaining the confidentiality of your account login information. You agree to notify us immediately if you suspect unauthorized use of your account.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">3. Acceptable Use</h4>
    <ul class="list-unstyled">
      <li>Do not post false, misleading, or offensive content.</li>
      <li>Do not harass, threaten, or abuse other users.</li>
      <li>Do not use the site for commercial purposes, including solicitation or spam.</li>
      <li>Do not impersonate another person or create fake profiles.</li>
    </ul>
    <p>Violations may result in suspension or termination of your account without notice.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">4. User Content</h4>
    <p>You are solely responsible for the content you post. By uploading content, you grant us a non-exclusive, worldwide license to use, display, and distribute that content in connection with our services.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">5. Safety and Offline Meetings</h4>
    <p>While we strive to keep our platform safe, we cannot guarantee the behavior of other users. Use caution when sharing personal information, and always meet in public places when connecting offline.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">6. Termination</h4>
    <p>We reserve the right to suspend or delete your account at our discretion if we believe you've violated these terms or acted inappropriately on the platform.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">7. Disclaimer</h4>
    <p><?= $company_name ?> provides a platform for connection but does not guarantee compatibility or outcomes. We are not responsible for any relationship results, in-person meetings, or damages arising from use of our site.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">8. Changes to These Terms</h4>
    <p>We may update these Terms of Use from time to time. Continued use of the platform after changes are posted constitutes acceptance of those changes.</p>
  </div>

  <div class="mb-4">
    <h4 class="mb-2">9. Contact</h4>
    <p>If you have any questions about these terms, please reach out to us at <a href=""><?= $company_email ?></a>.</p>
  </div>
</div>

</section>
<!-- End Room section -->
<?php include("footer.php"); ?>