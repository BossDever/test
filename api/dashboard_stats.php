<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../app/config/config.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$resp = $_GET['respondent'] ?? '';

try {
    // get active survey id
    $sid = (int)($pdo->query('SELECT id FROM surveys WHERE is_active=1 ORDER BY id DESC LIMIT 1')->fetchColumn());
    if (!$sid) throw new RuntimeException('No survey');

    $conds = ['survey_id = ?'];
    $args = [$sid];
    if ($from) { $conds[] = 'submitted_at >= ?'; $args[] = $from; }
    if ($to) { $conds[] = 'submitted_at <= ?'; $args[] = $to; }
    if ($resp) { $conds[] = 'respondent_type = ?'; $args[] = $resp; }

    $where = implode(' AND ', $conds);

    // fetch likert values joined with questions
    $sql = "SELECT q.id as qid, q.item_code, q.section_id, a.value_likert, r.id as response_id
            FROM answers a
            JOIN responses r ON a.response_id = r.id
            JOIN questions q ON a.question_id = q.id
            WHERE r.$where AND q.q_type = 'likert' AND a.value_likert IS NOT NULL";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    $byQuestion = [];
    $all = [];
    $respIds = [];
    $dims = [];
    while ($row = $stmt->fetch()) {
        $qid = (int)$row['qid'];
        $v = (int)$row['value_likert'];
        $byQuestion[$qid]['code'] = $row['item_code'];
        $byQuestion[$qid]['vals'][] = $v;
        $all[] = $v;
        $respIds[] = (int)$row['response_id'];

        // dimension: section average
        $sec = (int)$row['section_id'];
        $dims[$sec]['sum'] = ($dims[$sec]['sum'] ?? 0) + $v;
        $dims[$sec]['n'] = ($dims[$sec]['n'] ?? 0) + 1;
    }

    // helpers
    $avg = function($arr){ $n=count($arr); return $n? array_sum($arr)/$n : null; };
    $median = function($arr){ $n=count($arr); if(!$n) return null; sort($arr); $m=intval($n/2); return $n%2?$arr[$m]:(($arr[$m-1]+$arr[$m])/2); };
    $std = function($arr){ $n=count($arr); if($n<2) return 0; $mu=array_sum($arr)/$n; $v=0; foreach($arr as $x){ $v+=($x-$mu)**2; } return sqrt($v/($n-1)); };

    $items=[]; foreach($byQuestion as $qid=>$info){ $items[] = [ 'qid'=>$qid, 'code'=>$info['code'], 'avg'=>$avg($info['vals']) ]; }
    usort($items, fn($a,$b)=>strcmp($a['code'],$b['code']));

    $dimensions = [];
    if (!empty($dims)) {
        foreach ($dims as $secId=>$d) { $dimensions['section_'.$secId] = $d['n']? $d['sum']/$d['n'] : 0; }
    }

    $summary = [
        'avg' => $avg($all),
        'median' => $median($all),
        'stddev' => $std($all),
        'count' => count(array_unique($respIds))
    ];

    echo json_encode(['ok'=>true, 'summary'=>$summary, 'items'=>$items, 'dimensions'=>$dimensions]);
} catch (Throwable $e) {
    echo json_encode(['ok'=>false, 'error'=>$e->getMessage()]);
}
