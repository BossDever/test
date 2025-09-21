<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$resp = $_GET['respondent'] ?? '';

try {
    $sid = (int)($pdo->query('SELECT id FROM surveys WHERE is_active=1 ORDER BY id DESC LIMIT 1')->fetchColumn());
    if (!$sid) throw new RuntimeException('No survey');

    $conds = ['r.survey_id = ?'];
    $args = [$sid];
    if ($from) { $conds[] = 'r.submitted_at >= ?'; $args[] = $from; }
    if ($to) { $conds[] = 'r.submitted_at <= ?'; $args[] = $to; }
    if ($resp) { $conds[] = 'r.respondent_type = ?'; $args[] = $resp; }
    $where = implode(' AND ', $conds);

    // average per day using likert values only
    $sql = "SELECT DATE(r.submitted_at) as d, AVG(a.value_likert) as avgv, COUNT(DISTINCT r.id) as n
            FROM responses r
            JOIN answers a ON a.response_id = r.id
            JOIN questions q ON q.id = a.question_id
            WHERE $where AND q.q_type='likert' AND a.value_likert IS NOT NULL
            GROUP BY DATE(r.submitted_at)
            ORDER BY d";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    $rows = $stmt->fetchAll();
    echo json_encode(['ok'=>true,'data'=>$rows]);
} catch (Throwable $e) {
    echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}
