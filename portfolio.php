<?php
require_once 'db.php';
require_once 'lang.php';

$stmt = $db->query("SELECT * FROM portfolio");
$portfolioItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('portfolio_title') ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <!-- Стили и скрипт для слайдера До/После -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/styles.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js"></script>
    <style>
        .portfolio-header {
            text-align: center;
            padding: 40px 0;
            background-color: var(--bg-color);
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--accent);
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Навигация -->
    <nav class="top-nav">
        <div class="nav-links">
            <a href="/"><?= t('nav_home') ?></a>
            <a href="/portfolio.php"><?= t('nav_portfolio') ?></a>
        </div>
        <div class="lang-switch">
            <a href="?lang=ru" class="<?= $current_lang === 'ru' ? 'active' : '' ?>">RU</a>
            <a href="?lang=en" class="<?= $current_lang === 'en' ? 'active' : '' ?>">EN</a>
        </div>
    </nav>

    <header class="portfolio-header">
        <div class="container">
            <h1 class="section-title" style="margin-bottom: 10px;"><?= t('portfolio_h1') ?></h1>
            <p style="color: var(--text-muted);"><?= t('portfolio_subtitle') ?></p>
            <a href="/" class="back-link"><?= t('portfolio_back') ?></a>
        </div>
    </header>

    <!-- Секция портфолио -->
    <section class="portfolio" style="padding-top: 20px;">
        <div class="container">
            <div class="portfolio-grid">
                <?php if ($portfolioItems && count($portfolioItems) > 0): ?>
                    <?php foreach ($portfolioItems as $item): ?>
                        <div class="portfolio-card">
                            <img-comparison-slider>
                                <img slot="first" src="<?= htmlspecialchars($item['before']) ?>" alt="До" width="100%" />
                                <img slot="second" src="<?= htmlspecialchars($item['after']) ?>" alt="После" width="100%" />
                            </img-comparison-slider>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; grid-column: 1 / -1; color: var(--text-muted);"><?= t('portfolio_empty') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

</body>
</html>
