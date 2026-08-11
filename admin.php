<?php
session_start();
require_once 'db.php';

$adminPassword = getenv('ADMIN_PASSWORD') ?: 'admin';

$action = $_GET['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === $adminPassword) {
        $_SESSION['loggedIn'] = true;
        header('Location: /admin.php');
        exit;
    } else {
        header('Location: /login.php');
        exit;
    }
}

if (empty($_SESSION['loggedIn'])) {
    header('Location: /login.php');
    exit;
}

if ($action === 'upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['before']) && isset($_FILES['after'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $beforeName = time() . '_before_' . basename($_FILES['before']['name']);
        $afterName = time() . '_after_' . basename($_FILES['after']['name']);

        $beforePath = '/uploads/' . $beforeName;
        $afterPath = '/uploads/' . $afterName;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $beforeExt = strtolower(pathinfo($_FILES['before']['name'], PATHINFO_EXTENSION));
        $afterExt = strtolower(pathinfo($_FILES['after']['name'], PATHINFO_EXTENSION));

        $beforeMime = mime_content_type($_FILES['before']['tmp_name']);
        $afterMime = mime_content_type($_FILES['after']['tmp_name']);

        if (in_array($beforeExt, $allowedExtensions) && in_array($afterExt, $allowedExtensions) &&
            strpos($beforeMime, 'image/') === 0 && strpos($afterMime, 'image/') === 0) {

            if (move_uploaded_file($_FILES['before']['tmp_name'], $uploadDir . $beforeName) &&
                move_uploaded_file($_FILES['after']['tmp_name'], $uploadDir . $afterName)) {

                $stmt = $db->prepare("INSERT INTO portfolio (before, after) VALUES (?, ?)");
                $stmt->execute([$beforePath, $afterPath]);
            }
        }
    }
    header('Location: /admin.php');
    exit;
}

$stmt = $db->query("SELECT * FROM requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панель</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid var(--accent);
            margin-bottom: 40px;
        }
        .admin-section {
            margin-bottom: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #2a3a3d;
        }
        th {
            background-color: #1a2a2d;
            color: var(--accent);
        }
        tr:last-child td {
            border-bottom: none;
        }
        a {
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="admin-header">
            <h2>Админ Панель</h2>
            <div>
                <a href="/" class="btn-primary" style="margin-right: 10px; padding: 10px 20px;">На сайт</a>
            </div>
        </header>

        <section class="admin-section">
            <h3 style="margin-bottom: 20px;">Добавить в портфолио</h3>
            <div class="form-wrapper" style="margin: 0; max-width: none;">
                <form action="/admin.php?action=upload" method="POST" enctype="multipart/form-data" class="custom-form" style="display: flex; flex-direction: row; align-items: flex-end; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label>Фото ДО</label>
                        <input type="file" name="before" accept="image/*" required style="padding: 10px;">
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label>Фото ПОСЛЕ</label>
                        <input type="file" name="after" accept="image/*" required style="padding: 10px;">
                    </div>
                    <button type="submit" class="btn-primary" style="padding: 12px 30px;">Загрузить</button>
                </form>
            </div>
        </section>

        <section class="admin-section">
            <h3 style="margin-bottom: 20px;">Заявки на ретушь</h3>
            <?php if ($requests && count($requests) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Email</th>
                            <th>Ссылка</th>
                            <th>Пожелания</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr>
                                <td style="color: var(--text-muted);"><?= date('d.m.Y H:i:s', strtotime($req['created_at'])) ?></td>
                                <td><?= htmlspecialchars($req['email']) ?></td>
                                <?php
                                    $safeLink = $req['link'];
                                    if (stripos(trim($safeLink), 'javascript:') === 0) {
                                        $safeLink = '#';
                                    }
                                ?>
                                <td><a href="<?= htmlspecialchars($safeLink) ?>" target="_blank" rel="noopener">Открыть</a></td>
                                <td><?= htmlspecialchars($req['comments'] ?: '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: var(--text-muted);">Заявок пока нет.</p>
            <?php endif; ?>
        </section>

    </div>
</body>
</html>
