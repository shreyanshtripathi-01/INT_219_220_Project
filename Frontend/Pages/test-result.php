<?php
session_start();
require_once '../../Backend/PHP/auth.php';
requireLogin();

$attempt_id = $_GET['attempt_id'] ?? null;
if (!$attempt_id) {
    header('Location: candidate-dashboard.php');
    exit();
}

// Fetch test results
try {
    $stmt = $pdo->prepare("
        SELECT ta.*, t.title, t.passing_score
        FROM test_attempts ta
        JOIN tests t ON ta.test_id = t.id
        WHERE ta.id = ? AND ta.user_id = ?
    ");
    $stmt->execute([$attempt_id, $_SESSION['user_id']]);
    $result = $stmt->fetch();

    // Fetch detailed answers
    $stmt = $pdo->prepare("
        SELECT ta.*, q.question_text, q.correct_answer
        FROM test_answers ta
        JOIN questions q ON ta.question_id = q.id
        WHERE ta.attempt_id = ?
    ");
    $stmt->execute([$attempt_id]);
    $answers = $stmt->fetchAll();
} catch(PDOException $e) {
    header('Location: candidate-dashboard.php?error=Could not fetch results');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <title>Test Results - HackProctor</title>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Result Summary -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-2xl font-bold mb-6"><?php echo htmlspecialchars($result['title']); ?> - Results</h1>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">Score</div>
                    <div class="text-2xl font-bold text-<?php echo $result['score'] >= $result['passing_score'] ? 'green' : 'red'; ?>-600">
                        <?php echo number_format($result['score'], 1); ?>%
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">Time Taken</div>
                    <div class="text-2xl font-bold">
                        <?php echo floor($result['time_taken']/60); ?>m <?php echo $result['time_taken']%60; ?>s
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">Correct Answers</div>
                    <div class="text-2xl font-bold">
                        <?php echo $result['correct_answers']; ?>/<?php echo $result['total_questions']; ?>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500">Status</div>
                    <div class="text-2xl font-bold text-<?php echo $result['score'] >= $result['passing_score'] ? 'green' : 'red'; ?>-600">
                        <?php echo $result['score'] >= $result['passing_score'] ? 'PASSED' : 'FAILED'; ?>
                    </div>
                </div>
            </div>

            <!-- Pass/Fail Message -->
            <div class="text-center p-4 mb-6 rounded-lg <?php echo $result['score'] >= $result['passing_score'] ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
                <?php if ($result['score'] >= $result['passing_score']): ?>
                    <p class="text-lg font-semibold">Congratulations! You have passed the test.</p>
                <?php else: ?>
                    <p class="text-lg font-semibold">Unfortunately, you did not meet the passing score of <?php echo $result['passing_score']; ?>%.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Detailed Review -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-6">Question Review</h2>
            <div class="space-y-6">
                <?php foreach ($answers as $index => $answer): ?>
                <div class="border-b pb-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full <?php echo $answer['selected_answer'] === $answer['correct_answer'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> font-semibold">
                            <?php echo $index + 1; ?>
                        </span>
                        <div class="ml-4">
                            <p class="font-medium"><?php echo htmlspecialchars($answer['question_text']); ?></p>
                            <div class="mt-2 text-sm">
                                <p>Your answer: <span class="font-semibold"><?php echo $answer['selected_answer']; ?></span></p>
                                <?php if ($answer['selected_answer'] !== $answer['correct_answer']): ?>
                                    <p class="text-green-600">Correct answer: <span class="font-semibold"><?php echo $answer['correct_answer']; ?></span></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
            <a href="candidate-dashboard.php" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">
                Back to Dashboard
            </a>
            <a href="available-tests.php" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Take Another Test
            </a>
        </div>
    </div>
</body>
</html> 