<?php
require_once __DIR__ . '/db.php';

// Création de la table si elle n'existe pas
$pdo->exec("CREATE TABLE IF NOT EXISTS items (id SERIAL PRIMARY KEY, label TEXT NOT NULL, created_at TIMESTAMP DEFAULT NOW())");

$feedback = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'insert') {
        // Insère un échantillon de données (3 lignes)
        $stmt = $pdo->prepare('INSERT INTO items (label) VALUES (?), (?), (?)');
        $labels = [
            'Valeur ' . date('H:i:s'),
            'Exemple ' . rand(100, 999),
            'Test ' . substr(sha1(uniqid('', true)), 0, 6)
        ];
        try {
            $stmt->execute($labels);
            $feedback = 'Insertion de 3 lignes réussie.';
        } catch (PDOException $e) {
            $feedback = 'Erreur insertion: ' . htmlspecialchars($e->getMessage());
        }
    }
}

// Récupération des données si demandé
$items = [];
if (isset($_GET['fetch']) && $_GET['fetch'] === '1') {
    try {
        $items = $pdo->query('SELECT id, label, created_at FROM items ORDER BY id DESC LIMIT 50')->fetchAll();
    } catch (PDOException $e) {
        $feedback = 'Erreur requête: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Mini Site PHP + PostgreSQL</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background:#f5f7fa; }
        h1 { font-size: 1.6rem; }
        form, .actions { margin-bottom: 1rem; }
        button { padding: .6rem 1rem; margin-right:.5rem; cursor:pointer; background:#2563eb; color:#fff; border: none; border-radius:4px; }
        button.secondary { background:#475569; }
        table { border-collapse: collapse; width: 100%; background:#fff; }
        th, td { border:1px solid #ddd; padding:.5rem; text-align:left; }
        th { background:#e2e8f0; }
        .feedback { margin: 1rem 0; padding:.75rem 1rem; background:#eef6ff; border-left:4px solid #3b82f6; }
        .empty { font-style: italic; color:#555; }
        .container { max-width: 860px; margin: auto; }
        .flex { display:flex; gap:.5rem; }
        a.fetch-link { text-decoration:none; }
    </style>
</head>
<body>
<div class="container">
    <h1>Mini Site: PostgreSQL (PHP)</h1>
    <p>Cet exemple insère 3 lignes de test puis permet d'afficher les dernières valeurs.</p>

    <?php if ($feedback): ?>
        <div class="feedback"><?= $feedback ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="action" value="insert" />
        <button type="submit">Insérer 3 valeurs</button>
        <a class="fetch-link" href="?fetch=1"><button class="secondary" type="button">Afficher les valeurs</button></a>
    </form>

    <?php if (isset($_GET['fetch']) && $_GET['fetch'] === '1'): ?>
        <h2>Dernières valeurs</h2>
        <?php if (empty($items)): ?>
            <div class="empty">Aucune donnée trouvée.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Label</th>
                        <th>Créé le</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['label']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
