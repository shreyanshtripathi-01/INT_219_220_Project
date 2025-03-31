<?php
require_once '../../Backend/PHP/auth.php';  // This will handle the session
requireLogin();

// Ensure user is candidate
if ($_SESSION['user_role'] !== 'candidate') {
    header('Location: admin-dashboard.php');
    exit();
}

$userName = $_SESSION['user_name'];
$userUID = $_SESSION['user_uid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Candidate Dashboard - HackProctor</title>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="/Frontend/index.php" class="text-2xl font-bold text-blue-600">HackProctor</a>
                    <a href="candidate-dashboard.php" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    <a href="available-tests.php" class="text-gray-700 hover:text-blue-600">Available Tests</a>
                    <a href="my-results.php" class="text-gray-700 hover:text-blue-600">My Results</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($userName); ?></span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Candidate</span>
                    <a href="/Backend/PHP/logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Tests Completed</div>
                <div class="text-3xl font-bold text-gray-800">0</div>
                <div class="text-green-500 text-sm">View Results →</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Average Score</div>
                <div class="text-3xl font-bold text-gray-800">0%</div>
                <div class="text-blue-500 text-sm">Your Performance</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-500 text-sm">Available Tests</div>
                <div class="text-3xl font-bold text-gray-800">0</div>
                <div class="text-blue-500 text-sm">Take Test →</div>
            </div>
        </div>

        <!-- Available Tests Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Available Tests</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Test Card -->
                    <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-semibold mb-2">Data Structures Test</h3>
                        <div class="text-sm text-gray-500 mb-4">
                            <p>Duration: 30 minutes</p>
                            <p>Questions: 20</p>
                            <p>Status: Not Started</p>
                        </div>
                        <a href="take-test.php?id=1" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Start Test
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Your Performance</h2>
            <canvas id="performanceChart" height="100"></canvas>
        </div>
    </div>

    <!-- Initialize Charts -->
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Test 1', 'Test 2', 'Test 3', 'Test 4', 'Test 5'],
                datasets: [{
                    label: 'Score %',
                    data: [85, 75, 90, 80, 95],
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
    </script>
</body>
</html> 