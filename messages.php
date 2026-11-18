<?php
date_default_timezone_set('Africa/Addis_Ababa');

$studentName = 'Firtuna';
$dbHost = '127.0.0.1';
$dbName = 'firtuna_portfolio';
$dbUser = 'root';
$dbPass = '';

$pdo = null;
$dbError = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(80) NOT NULL,
        email VARCHAR(120) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch (PDOException $exception) {
    $pdo = null;
    $dbError = 'The database is not connected. Start MySQL in XAMPP, then refresh this page.';
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$messages = [];

if ($pdo) {
    $messages = $pdo->query('SELECT id, name, email, message, created_at FROM messages ORDER BY id DESC')->fetchAll();
}

$count = count($messages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inbox | <?= e($studentName) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="ambient ambient-one"></div>
<div class="ambient ambient-two"></div>

<header class="site-header">
    <a class="brand" href="index.php" aria-label="Firtuna home">F<span>.</span></a>
    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open navigation" aria-expanded="false" aria-controls="nav"><span></span><span></span><span></span></button>
    <nav class="nav" id="nav">
        <a class="nav-link" href="index.php">Home</a>
        <a class="nav-link" href="index.php#about">About</a>
        <a class="nav-link" href="index.php#skills">Skills</a>
        <a class="nav-link" href="index.php#contact">Contact</a>
        <a class="nav-link" href="messages.php">Inbox</a>
    </nav>
    <a class="header-cta" href="index.php#contact">Say hi <span>&#8599;</span></a>
</header>

<main class="section-wrap">

<div class="page-head">
    <div class="section-kicker">Saved messages</div>
    <h1>Inbox</h1>
    <p>Every hello sent from the contact form, saved in MySQL and shown newest first.</p>
    <span class="count-pill"><?= $count ?> message<?= $count === 1 ? '' : 's' ?></span>
</div>

<?php if ($dbError): ?>
    <div class="notice bad"><?= e($dbError) ?></div>
<?php endif; ?>

<?php if (!$messages && !$dbError): ?>
    <div class="empty">
        <span class="empty-icon">&#9993;</span>
        <h2>No messages yet</h2>
        <p>Be the first to say hi from the portfolio page.</p>
        <a class="button button-primary" href="index.php#contact">Send a message</a>
    </div>
<?php endif; ?>

<div class="msg-list">
    <?php foreach ($messages as $message): ?>
        <article class="msg">
            <div class="msg-avatar"><?= e(mb_substr($message['name'], 0, 1)) ?></div>
            <div class="msg-body">
                <div class="msg-head">
                    <h2><?= e($message['name']) ?></h2>
                    <time><?= date('d M Y, H:i', strtotime($message['created_at'])) ?></time>
                </div>
                <a class="msg-email" href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a>
                <p><?= nl2br(e($message['message'])) ?></p>
            </div>
        </article>
    <?php endforeach; ?>
</div>

</main>

<footer class="footer section-wrap">
    <a class="brand" href="index.php">F<span>.</span></a>
    <p>Designed with curiosity by <strong>Firtuna</strong>.</p>
    <a href="index.php" class="back-top">Back to portfolio</a>
    <small>&copy; <?= date('Y') ?> Firtuna. Keep learning, keep growing.</small>
</footer>

<script>
const menuToggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');
menuToggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
});
document.querySelectorAll('#nav a').forEach((link) => link.addEventListener('click', () => {
    nav.classList.remove('open');
    menuToggle.setAttribute('aria-expanded', 'false');
}));
</script>

</body>
</html>
