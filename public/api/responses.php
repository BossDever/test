<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=utf-8');
$u = current_user();
if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) { http_response_code(403); echo json_encode(['ok'=>false,'error'=>'Forbidden']); exit; }

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$resp = $_GET['respondent'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$size = min(100, max(10, (int)($_GET['size'] ?? 20)));
$offset = ($page-1)*$size;

try {
    $sid = (int)($pdo->query('SELECT id FROM surveys WHERE is_active=1 ORDER BY id DESC LIMIT 1')->fetchColumn());
    if (!$sid) throw new RuntimeException('No survey');

    $conds = ['survey_id = ?'];
    $args = [$sid];
    if ($from) { $conds[] = 'submitted_at >= ?'; $args[] = $from; }
    if ($to) { $conds[] = 'submitted_at <= ?'; $args[] = $to; }
    if ($resp) { $conds[] = 'respondent_type = ?'; $args[] = $resp; }
    $where = implode(' AND ', $conds);

    $count = $pdo->prepare("SELECT COUNT(*) FROM responses WHERE $where");
    $count->execute($args);
    $total = (int)$count->fetchColumn();

    $sql = "SELECT id, respondent_type, respondent_other, submitted_at FROM responses WHERE $where ORDER BY id DESC LIMIT $size OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    $rows = $stmt->fetchAll();
    echo json_encode(['ok'=>true,'data'=>$rows,'page'=>$page,'size'=>$size,'total'=>$total]);
} catch (Throwable $e) {
    echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}
