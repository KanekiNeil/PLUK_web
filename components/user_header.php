
<?php $current_page = basename($_SERVER['PHP_SELF']);
// compute $basePath = '/pluk_web' locally, or '' when site is served at root (Render)
$projectRootFs = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$docRootFs     = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
$basePath      = str_replace($docRootFs, '', $projectRootFs);
$basePath      = $basePath === '' ? '' : '/' . trim($basePath, '/');

// optional base URL when you need absolute links in emails
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; ?>
<header>
  <div class="header-container">
    <div class="logo-title">
      <img src="<?= htmlspecialchars($basePath . '/assets/logo.jpg', ENT_QUOTES) ?>" alt="Alpha Aquila Logo" class="logo">
      <h1>ALPHA AQUILA</h1>
    </div>

    <nav class="top-nav">
      <ul>
        <li><a href="<?= htmlspecialchars($basePath . '/index.php', ENT_QUOTES) ?>">Home</a></li>

        <li class="dropdown">
          <a href="#">Work with Us</a>
          <ul class="dropdown-menu">
            <li><a href="<?= htmlspecialchars($basePath . '/user/sales_application.php', ENT_QUOTES) ?>">Sales</a></li>
            <li><a href="<?= htmlspecialchars($basePath . '/user/fa_application.php', ENT_QUOTES) ?>">Career</a></li>
          </ul>
        </li>

        <li>
          <a href="<?= htmlspecialchars($basePath . '/user/appointments.php', ENT_QUOTES) ?>">View Appointments</a>
        </li>

        <li><a href="<?= htmlspecialchars($basePath . '/user/services.php', ENT_QUOTES) ?>">Claim and Services</a></li>
        <li><a href="<?= htmlspecialchars($basePath . '/user/contactus.php', ENT_QUOTES) ?>">Contact Us</a></li>
      </ul>
    </nav>
  </div>
</header>