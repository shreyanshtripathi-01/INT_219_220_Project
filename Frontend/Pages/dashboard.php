<?php
session_start();
require_once '../../Backend/PHP/auth.php';
requireLogin();

$userRole = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <!-- Add Chart.js for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard - HackProctor</title>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/Frontend/index.php" class="text-2xl font-bold text-blue-600">HackProctor</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                        <?php echo ucfirst($_SESSION['user_role']); ?>
                    </span>
                    <a href="/Backend/PHP/logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <?php if($userRole === 'admin'): ?>
            <!-- Admin Dashboard -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Admin Controls</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Create Question Form -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Create New Question</h3>
                        <form action="/Backend/PHP/create_question.php" method="POST">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                    <textarea name="question_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Option A</label>
                                        <input type="text" name="option_a" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Option B</label>
                                        <input type="text" name="option_b" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Option C</label>
                                        <input type="text" name="option_c" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Option D</label>
                                        <input type="text" name="option_d" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                                    <select name="correct_answer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        <option value="A">Option A</option>
                                        <option value="B">Option B</option>
                                        <option value="C">Option C</option>
                                        <option value="D">Option D</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Create Question
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Question Statistics -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Question Statistics</h3>
                        <canvas id="questionStats"></canvas>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Candidate Dashboard -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Your Progress</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Test Statistics -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Available Tests</h3>
                        <div class="space-y-4">
                            <a href="/Frontend/Pages/take-test.php" class="block bg-blue-50 p-4 rounded-lg hover:bg-blue-100">
                                <h4 class="font-semibold">Data Structures Test</h4>
                                <p class="text-sm text-gray-600">20 questions • 30 minutes</p>
                            </a>
                            <!-- Add more tests here -->
                        </div>
                    </div>

                    <!-- Performance Chart -->
                    <div class="bg-white rounded-lg shadow p-6 col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Your Performance</h3>
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Charts Initialization -->
    <script>
        // Performance Chart
        const performanceCtx = document.getElementById('performanceChart').getContext('2d');
        new Chart(performanceCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Test Scores',
                    data: [75, 82, 78, 85, 88, 92],
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
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

        // Skills Chart
        const skillsCtx = document.getElementById('skillsChart').getContext('2d');
        new Chart(skillsCtx, {
            type: 'radar',
            data: {
                labels: [
                    'Problem Solving',
                    'Data Structures',
                    'Algorithms',
                    'Database',
                    'System Design',
                    'Coding'
                ],
                datasets: [{
                    label: 'Your Skills',
                    data: [85, 92, 88, 75, 82, 90],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgb(59, 130, 246)',
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                }]
            },
            options: {
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html> 