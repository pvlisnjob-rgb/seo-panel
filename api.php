<?php
header('Content-Type: application/json');
require_once 'db.php';

$action = $_POST['action'] ?? '';

try {
    if ($action === 'get_data') {
        // Получаем проекты
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
        $projects = $stmt->fetchAll();

        // Получаем задачи
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
        $tasks = $stmt->fetchAll();

        // Получаем настройки (GSC, XP)
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
        $settingsRows = $stmt->fetchAll();
        $settings = [];
        foreach ($settingsRows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        echo json_encode([
            'success' => true,
            'projects' => $projects,
            'tasks' => $tasks,
            'settings' => $settings
        ]);

    } elseif ($action === 'save_project') {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'];
        $priority = $_POST['priority'];
        $revenue = $_POST['revenue'];
        $expenses = $_POST['expenses'];
        $hours = $_POST['hours'];

        if ($id) {
            $stmt = $pdo->prepare("UPDATE projects SET name=?, priority=?, revenue=?, expenses=?, hours=? WHERE id=?");
            $stmt->execute([$name, $priority, $revenue, $expenses, $hours, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (name, priority, revenue, expenses, hours) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $priority, $revenue, $expenses, $hours]);
        }
        echo json_encode(['success' => true]);

    } elseif ($action === 'delete_project') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);

    } elseif ($action === 'save_task') {
        $id = $_POST['id'] ?? null;
        $projectId = $_POST['projectId'];
        $desc = $_POST['desc'];
        $category = $_POST['category'];
        $time = $_POST['time'];
        $done = $_POST['done'] ?? 0;

        if ($id) {
            $stmt = $pdo->prepare("UPDATE tasks SET project_id=?, description=?, category=?, time_spent=?, is_done=? WHERE id=?");
            $stmt->execute([$projectId, $desc, $category, $time, $done, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO tasks (project_id, description, category, time_spent, is_done) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$projectId, $desc, $category, $time, $done]);
            
            // Начисляем XP за новую задачу
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = setting_value + 5 WHERE setting_key = 'user_xp'");
            $stmt->execute();
        }
        echo json_encode(['success' => true]);

    } elseif ($action === 'toggle_task') {
        $id = $_POST['id'];
        $isDone = $_POST['isDone'];
        
        $stmt = $pdo->prepare("UPDATE tasks SET is_done=? WHERE id=?");
        $stmt->execute([$isDone, $id]);

        // Начисляем/снимаем XP
        $xpChange = $isDone ? 10 : -10;
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = setting_value + ? WHERE setting_key = 'user_xp'");
        $stmt->execute([$xpChange]);

        echo json_encode(['success' => true]);

    } elseif ($action === 'delete_task') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);

    } elseif ($action === 'save_settings') {
        $key = $_POST['key'];
        $value = $_POST['value'];
        
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                               ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
        echo json_encode(['success' => true]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>