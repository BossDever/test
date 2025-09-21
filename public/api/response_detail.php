<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=utf-8');
$u = current_user();
if (!$u || !in_array($u['role'], ['admin','teacher','committee'], true)) { http_response_code(403); echo json_encode(['ok'=>false,'error'=>'Forbidden']); exit; }

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo json_encode(['ok'=>false,'error'=>'Invalid id']); exit; }

try {
    $r = $pdo->prepare('SELECT id, survey_id, respondent_type, respondent_other, submitted_at FROM responses WHERE id = ?');
    $r->execute([$id]);
    $resp = $r->fetch();
    if (!$resp) { echo json_encode(['ok'=>false,'error'=>'Not found']); exit; }

    $q = $pdo->prepare("SELECT q.id as qid, q.item_code, q.q_text, q.q_type, a.value_likert, a.value_text, a.value_bool
                        FROM answers a JOIN questions q ON q.id = a.question_id
                        WHERE a.response_id = ? ORDER BY q.sort_order, q.id");
    $q->execute([$id]);
    $answers = $q->fetchAll();

    // suggestion if exists
    $sug = null;
    try {
        $s = $pdo->prepare('SELECT suggestion, created_at FROM suggestions WHERE response_id = ? ORDER BY id DESC LIMIT 1');
        $s->execute([$id]);
        $sug = $s->fetch();
    } catch (Throwable $__) { $sug = null; }

    echo json_encode(['ok'=>true,'response'=>$resp,'answers'=>$answers,'suggestion'=>$sug]);
} catch (Throwable $e) {
    echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}
