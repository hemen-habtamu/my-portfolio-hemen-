<?php
date_default_timezone_set('Africa/Addis_Ababa');

$studentName = 'Firtuna';
$studentEmail = 'firtuna@gimal.com';
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

$errors = [];
$sent = isset($_GET['sent']);
$form = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = trim($_POST['name'] ?? '');
    $form['email'] = trim($_POST['email'] ?? '');
    $form['message'] = trim($_POST['message'] ?? '');

    if ($form['name'] === '' || mb_strlen($form['name']) > 80) {
        $errors[] = 'Please write your name, up to 80 characters.';
    }

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 120) {
        $errors[] = 'Please write a valid email address.';
    }

    if ($form['message'] === '' || mb_strlen($form['message']) > 1000) {
        $errors[] = 'Please write a message, up to 1000 characters.';
    }

    if (!$errors) {
        if ($pdo) {
            $statement = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
            $statement->execute([$form['name'], $form['email'], $form['message']]);
            header('Location: index.php?sent=1#contact');
            exit;
        }

        $errors[] = 'Messages cannot be saved while the database is offline.';
    }
}

$count = $pdo ? (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn() : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Firtuna's student portfolio, learning and building for the web.">
<title><?= e($studentName) ?> | Student Portfolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="ambient ambient-one"></div>
<div class="ambient ambient-two"></div>

<header class="site-header">
    <a class="brand" href="#home" aria-label="Firtuna home">F<span>.</span></a>
    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open navigation" aria-expanded="false" aria-controls="nav"><span></span><span></span><span></span></button>
    <nav class="nav" id="nav">
        <a class="nav-link" href="#home">Home</a>
        <a class="nav-link" href="#about">About</a>
        <a class="nav-link" href="#skills">Skills</a>
        <a class="nav-link" href="#contact">Contact</a>
        <a class="nav-link" href="messages.php">Inbox</a>
    </nav>
    <a class="header-cta" href="#contact">Let's talk <span>&#8599;</span></a>
</header>

<main>

<section class="hero section-wrap" id="home">
    <div class="hero-copy">
        <p class="eyebrow"><span class="status-dot"></span>Student &middot; Future developer</p>
        <h1>Hi, I'm<br><span class="gradient-text">Firtuna.</span></h1>
        <h2>Learning today. Building tomorrow.</h2>
        <p class="hero-description">
            I am a 12th-grade student preparing for my national examination. I enjoy learning new
            things, exploring technology and creating beautiful things with code.
        </p>
        <div class="hero-actions">
            <a class="button button-primary" href="#contact">Contact me <span>&#8599;</span></a>
            <a class="text-link" href="#about">Discover my story <span>&darr;</span></a>
        </div>
        <div class="hero-note"><span class="note-line"></span>Curious mind. Creative heart. Big dreams.</div>
    </div>
    <div class="hero-visual">
        <div class="orbit orbit-one"></div>
        <div class="orbit orbit-two"></div>
        <div class="photo-frame">
            <span class="monogram">F</span>
            <span class="monogram-name">Firtuna</span>
            <span class="monogram-meta">Grade 12 &middot; Web learner</span>
        </div>
        <div class="floating-tag tag-top"><span>&#10022;</span>Always learning</div>
        <div class="floating-tag tag-bottom"><span>&#8984;</span>Future web developer</div>
        <span class="spark spark-one">&#10022;</span>
        <span class="spark spark-two">&#10023;</span>
        <span class="spark spark-three">&middot;</span>
    </div>
</section>

<section class="about section-wrap section-block" id="about">
    <div class="section-kicker">01 / About me</div>
    <div class="section-heading">
        <h2>A little about <span class="gradient-text">me.</span></h2>
        <p>Every expert was once a beginner. This is where my journey begins.</p>
    </div>
    <div class="about-grid">
        <div class="glass-card about-card">
            <div class="card-icon">&#10035;</div>
            <h3>My story</h3>
            <p>
                My name is Firtuna. I am currently a 12th-grade student, working hard and preparing
                for my national examination. I believe that learning is a journey, and every day is a
                chance to improve.
            </p>
            <p>
                I am interested in technology and web development. My dream is to become a skilled
                developer and create useful, creative websites that make a positive difference.
            </p>
        </div>
        <div class="about-side">
            <div class="quote-card">
                <span class="quote-mark">&ldquo;</span>
                <p>Small steps every day lead to big achievements.</p>
                <span class="quote-by">&mdash; My daily reminder</span>
            </div>
            <div class="mini-stats">
                <div><strong>12<sup>th</sup></strong><span>Grade student</span></div>
                <div><strong>&infin;</strong><span>Curiosity to learn</span></div>
            </div>
        </div>
    </div>
</section>

<section class="skills section-wrap section-block" id="skills">
    <div class="section-kicker">02 / What I'm learning</div>
    <div class="section-heading">
        <h2>My creative <span class="gradient-text">toolkit.</span></h2>
        <p>Three foundational skills I am developing on my web journey.</p>
    </div>
    <div class="skill-grid">
        <article class="glass-card skill-card">
            <div class="skill-top"><span class="skill-number">01</span><span class="skill-symbol html-symbol">5</span></div>
            <h3>HTML</h3>
            <p>Building the structure and meaningful content of web pages.</p>
            <div class="skill-track"><span style="width: 78%"></span></div>
            <small>Structure &amp; content</small>
        </article>
        <article class="glass-card skill-card">
            <div class="skill-top"><span class="skill-number">02</span><span class="skill-symbol css-symbol">3</span></div>
            <h3>CSS</h3>
            <p>Designing attractive layouts, colors and responsive experiences.</p>
            <div class="skill-track"><span style="width: 68%"></span></div>
            <small>Style &amp; layout</small>
        </article>
        <article class="glass-card skill-card">
            <div class="skill-top"><span class="skill-number">03</span><span class="skill-symbol js-symbol">JS</span></div>
            <h3>JavaScript</h3>
            <p>Making websites interactive with dynamic behavior and logic.</p>
            <div class="skill-track"><span style="width: 48%"></span></div>
            <small>Logic &amp; interaction</small>
        </article>
    </div>
    <p class="skills-footnote">Skill bars are illustrative learning progress, not formal test scores.</p>
</section>

<section class="contact section-wrap section-block" id="contact">
    <div class="contact-panel">
        <div class="section-kicker">03 / Get in touch</div>
        <h2>Have a good idea?<br><span class="gradient-text">Let's connect.</span></h2>
        <p>I would love to hear from you. Send me a message and let's start a conversation.</p>

        <a class="email-link" href="mailto:<?= e($studentEmail) ?>">
            <span class="email-icon">&#9993;</span>
            <span><small>Email me at</small><strong><?= e($studentEmail) ?></strong></span>
            <span class="email-arrow">&#8599;</span>
        </a>

        <a class="inbox-link" href="messages.php">
            <span class="inbox-icon">&#128229;</span>
            <span><small>Message inbox</small><strong><?= $count ?> saved message<?= $count === 1 ? '' : 's' ?></strong></span>
            <span class="email-arrow">&rarr;</span>
        </a>

        <?php if ($dbError): ?>
            <div class="notice bad"><?= e($dbError) ?></div>
        <?php endif; ?>

        <?php if ($sent): ?>
            <div class="notice ok">Thank you. Your message is saved. <a href="messages.php">Open the inbox</a>.</div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="notice bad">
                <strong>Please check the form.</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="contact-form" method="post" action="index.php#contact">
            <div class="form-row">
                <label>Your name
                    <input type="text" name="name" placeholder="Enter your name" maxlength="80" value="<?= e($form['name']) ?>" required>
                </label>
                <label>Your email
                    <input type="email" name="email" placeholder="you@example.com" maxlength="120" value="<?= e($form['email']) ?>" required>
                </label>
            </div>
            <label>Your message
                <textarea name="message" rows="4" maxlength="1000" placeholder="Write your message..." required><?= e($form['message']) ?></textarea>
            </label>
            <div class="form-actions">
                <button class="button button-primary" type="submit">Send message <span>&#8599;</span></button>
                <span class="form-status">Saved to MySQL and shown in the inbox.</span>
            </div>
        </form>
    </div>
</section>

</main>

<footer class="footer section-wrap">
    <a class="brand" href="#home">F<span>.</span></a>
    <p>Designed with curiosity by <strong>Firtuna</strong>.</p>
    <a href="#home" class="back-top">Back to top &uarr;</a>
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
