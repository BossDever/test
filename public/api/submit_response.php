<?php
require_once __DIR__ . '/../bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

try {
    verify_csrf_or_fail();
    $surveyId = (int)($_POST['survey_id'] ?? 0);
    if ($surveyId <= 0) throw new RuntimeException('Invalid survey');

    // fetch questions for validation
    $stmt = $pdo->prepare('SELECT id, q_type, is_required FROM questions WHERE survey_id = ?');
    $stmt->execute([$surveyId]);
    $questions = $stmt->fetchAll();
    if (!$questions) throw new RuntimeException('No questions');

    // insert response
    $respType = $_POST['respondent_type'] ?? 'expert';
    $respOther = trim($_POST['respondent_other'] ?? '');
    $pdo->beginTransaction();
    $insR = $pdo->prepare('INSERT INTO responses (survey_id, respondent_type, respondent_other) VALUES (?,?,?)');
    $insR->execute([$surveyId, $respType, $respOther ?: null]);
    $responseId = (int)$pdo->lastInsertId();

    $insA = $pdo->prepare('INSERT INTO answers (response_id, question_id, value_likert, value_text, value_bool) VALUES (?,?,?,?,?)');

    foreach ($questions as $q) {
        $name = 'q_' . $q['id'];
        $valLikert = $valText = $valBool = null;
        if ($q['q_type'] === 'likert') {
            $v = isset($_POST[$name]) ? (int)$_POST[$name] : null;
            if ($q['is_required'] && ($v === null || $v < 1 || $v > 5)) throw new RuntimeException('กรอกไม่ครบ');
            if ($v !== null) $valLikert = max(1, min(5, $v));
        } elseif ($q['q_type'] === 'text') {
            $t = trim($_POST[$name] ?? '');
            if ($q['is_required'] && $t === '') throw new RuntimeException('กรอกไม่ครบ');
            if ($t !== '') $valText = $t;
        } else { // bool
            $b = isset($_POST[$name]) ? 1 : null;
            if ($q['is_required'] && $b !== 1) throw new RuntimeException('กรอกไม่ครบ');
            $valBool = $b;
        }
        $insA->execute([$responseId, (int)$q['id'], $valLikert, $valText, $valBool]);
    }

    // optional suggestion: insert into suggestions table (create if missing), fallback to audit_log
    if (!empty($_POST['suggestion'])) {
        $suggestion = substr($_POST['suggestion'], 0, 2000);
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS suggestions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                survey_id INT NOT NULL,
                response_id INT NOT NULL,
                respondent_type VARCHAR(50) NULL,
                suggestion TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX (survey_id), INDEX (response_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            $insS = $pdo->prepare('INSERT INTO suggestions (survey_id, response_id, respondent_type, suggestion) VALUES (?,?,?,?)');
            $insS->execute([$surveyId, $responseId, $respType, $suggestion]);
        } catch (Throwable $__) {
            // fallback to audit log
            audit_log($pdo, current_user()['id'] ?? null, 'suggestion', $suggestion);
        }
    }

    $pdo->commit();
    echo json_encode(['ok' => true]);
    if (function_exists('fastcgi_finish_request')) { fastcgi_finish_request(); } else { flush(); }
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    // log error for diagnosis
    try { audit_log($pdo, current_user()['id'] ?? null, 'submit_error', $e->getMessage()); } catch (Throwable $__) {}
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    if (function_exists('fastcgi_finish_request')) { fastcgi_finish_request(); } else { flush(); }
    exit;
}
