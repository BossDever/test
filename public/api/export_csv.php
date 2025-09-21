<?php
require_once __DIR__ . '/../bootstrap.php';
$u = current_user();
if (!$u || $u['role'] !== 'admin') { http_response_code(403); echo 'Forbidden'; exit; }

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$resp = $_GET['respondent'] ?? '';

// get active survey id
$sid = (int)($pdo->query('SELECT id FROM surveys WHERE is_active=1 ORDER BY id DESC LIMIT 1')->fetchColumn());
if (!$sid) { http_response_code(400); echo 'No survey'; exit; }

$conds = ['r.survey_id = ?'];
$args = [$sid];
if ($from) { $conds[] = 'r.submitted_at >= ?'; $args[] = $from; }
if ($to) { $conds[] = 'r.submitted_at <= ?'; $args[] = $to; }
if ($resp) { $conds[] = 'r.respondent_type = ?'; $args[] = $resp; }
$where = implode(' AND ', $conds);

$sql = "SELECT r.id as response_id, r.respondent_type, r.respondent_other, r.submitted_at,
               q.item_code, q.q_type, a.value_likert, a.value_text, a.value_bool
        FROM responses r
        JOIN answers a ON a.response_id = r.id
        JOIN questions q ON q.id = a.question_id
        WHERE $where
        ORDER BY r.id, q.sort_order, q.id";
$stmt = $pdo->prepare($sql);
$stmt->execute($args);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="survey_export.csv"');

// UTF-8 BOM for Excel
echo "\xEF\xBB\xBF";
$out = fopen('php://output', 'w');
fputcsv($out, ['response_id','respondent_type','respondent_other','submitted_at','item_code','q_type','value']);
while ($row = $stmt->fetch()) {
    $val = '';
    if ($row['q_type']==='likert') $val = $row['value_likert'];
    elseif ($row['q_type']==='text') $val = $row['value_text'];
    else $val = $row['value_bool'];
    fputcsv($out, [$row['response_id'],$row['respondent_type'],$row['respondent_other'],$row['submitted_at'],$row['item_code'],$row['q_type'],$val]);
}
fclose($out);
