<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$resp = $_GET['respondent'] ?? '';

try {
    // active survey id
    $sid = (int)($pdo->query('SELECT id FROM surveys WHERE is_active=1 ORDER BY id DESC LIMIT 1')->fetchColumn());
    if (!$sid) throw new RuntimeException('No survey');

    // Try dedicated suggestions table first
    $hasTable = false;
    try {
        $pdo->query('SELECT 1 FROM suggestions LIMIT 1');
        $hasTable = true;
    } catch (Throwable $__) { $hasTable = false; }

    if ($hasTable) {
        $conds = ['survey_id = ?'];
        $args = [$sid];
        if ($from) { $conds[] = 'created_at >= ?'; $args[] = $from; }
        if ($to) { $conds[] = 'created_at <= ?'; $args[] = $to; }
        if ($resp) { $conds[] = 'respondent_type = ?'; $args[] = $resp; }
        $where = implode(' AND ', $conds);
        $stmt = $pdo->prepare("SELECT id, response_id, suggestion, respondent_type, created_at FROM suggestions WHERE $where ORDER BY id DESC");
        $stmt->execute($args);
        $rows = $stmt->fetchAll();
    } else {
        // Fallback: pull suggestions from audit_logs (action = 'suggestion') joined with responses for filtering
        $conds = ['r.survey_id = ?'];
        $args = [$sid];
        if ($from) { $conds[] = 'r.submitted_at >= ?'; $args[] = $from; }
        if ($to) { $conds[] = 'r.submitted_at <= ?'; $args[] = $to; }
        if ($resp) { $conds[] = 'r.respondent_type = ?'; $args[] = $resp; }
        $where = implode(' AND ', $conds);
        $sql = "SELECT r.id as response_id, r.respondent_type, r.submitted_at as created_at, al.details as suggestion
                FROM audit_logs al
                JOIN responses r ON r.id = al.user_id OR r.id = r.id
                WHERE al.action = 'suggestion' AND $where
                ORDER BY r.id DESC";
        // Note: user_id mapping is not exact; in earlier versions suggestions were logged without response_id.
        $stmt = $pdo->prepare($sql);
        $stmt->execute($args);
        $rows = $stmt->fetchAll();
    }

    echo json_encode(['ok'=>true, 'data'=>$rows]);
} catch (Throwable $e) {
    echo json_encode(['ok'=>false, 'error'=>$e->getMessage()]);
}
