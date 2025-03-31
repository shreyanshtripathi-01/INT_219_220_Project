<?php
session_start();
require_once '../../Backend/PHP/auth.php';
requireLogin();

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: candidate-dashboard.php');
    exit();
}

// Fetch analytics data
try {
    // Get overall statistics
    $stmt = $pdo->query("
        SELECT 
            COUNT(DISTINCT ta.user_id) as total_candidates,
            COUNT(ta.id) as total_attempts,
            AVG(ta.score) as average_score,
            COUNT(DISTINCT t.id) as total_tests
        FROM test_attempts ta
        JOIN tests t ON ta.test_id = t.id
    ");
    $stats = $stmt->fetch();

    // Get category-wise performance
    $stmt = $pdo->query("
        SELECT 
            q.category,
            COUNT(*) as total_questions,
            AVG(CASE WHEN ta.selected_answer = q.correct_answer THEN 1 ELSE 0 END) * 100 as success_rate
        FROM questions q
        LEFT JOIN test_answers ta ON q.id = ta.question_id
        GROUP BY q.category
    ");
    $categoryStats = $stmt->fetchAll();

    // Get difficulty-wise performance
    $stmt = $pdo->query("
        SELECT 
            q.difficulty,
            COUNT(*) as total_questions,
            AVG(CASE WHEN ta.selected_answer = q.correct_answer THEN 1 ELSE 0 END) * 100 as success_rate
        FROM questions q
        LEFT JOIN test_answers ta ON q.id = ta.question_id
        GROUP BY q.difficulty
    ");
    $difficultyStats = $stmt->fetchAll();

} catch(PDOException $e) {
    $error = "Failed to fetch analytics data";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Analytics Dashboard - HackProctor</title>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="/Frontend/index.php" class="text-2xl font-bold text-blue-600">HackProctor</a>
                    <a href="admin-dashboard.php" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    <a href="manage-questions.php" class="text-gray-700 hover:text-blue-600">Questions</a>
                    <a href="manage-tests.php" class="text-gray-700 hover:text-blue-600">Tests</a>
                    <a href="admin-analytics.php" class="text-gray-700 hover:text-blue-600 font-medium">Analytics</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="/Backend/PHP/logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Total Candidates</div>
                <div class="text-3xl font-bold text-gray-800"><?php echo $stats['total_candidates']; ?></div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Total Tests Taken</div>
                <div class="text-3xl font-bold text-gray-800"><?php echo $stats['total_attempts']; ?></div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Average Score</div>
                <div class="text-3xl font-bold text-gray-800"><?php echo number_format($stats['average_score'], 1); ?>%</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Active Tests</div>
                <div class="text-3xl font-bold text-gray-800"><?php echo $stats['total_tests']; ?></div>
            </div>
        </div>

        <!-- Performance Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Category Performance -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Performance by Category</h3>
                <canvas id="categoryChart" height="300"></canvas>
            </div>
            <!-- Difficulty Performance -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Performance by Difficulty</h3>
                <canvas id="difficultyChart" height="300"></canvas>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Detailed Statistics</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Questions</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Success Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($categoryStats as $stat): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($stat['category']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $stat['total_questions']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($stat['success_rate'], 1); ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Category Performance Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($categoryStats, 'category')); ?>,
                datasets: [{
                    label: 'Success Rate (%)',
                    data: <?php echo json_encode(array_column($categoryStats, 'success_rate')); ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Difficulty Performance Chart
        const difficultyCtx = document.getElementById('difficultyChart').getContext('2d');
        new Chart(difficultyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($difficultyStats, 'difficulty')); ?>,
                datasets: [{
                    label: 'Success Rate (%)',
                    data: <?php echo json_encode(array_column($difficultyStats, 'success_rate')); ?>,
                    backgroundColor: 'rgba(16, 185, 129, 0.5)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html> 