<?php
require_once '../../Backend/PHP/auth.php';
requireLogin();

// Ensure user is admin
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: candidate-dashboard.php');
    exit();
}

// Get admin info
$adminName = $_SESSION['user_name'];
$adminUID = $_SESSION['user_uid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <title>Admin Dashboard - HackProctor</title>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/Frontend/index.php" class="text-2xl font-bold text-blue-600">HackProctor</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($adminName); ?></span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">Admin</span>
                    <span class="text-sm text-gray-500">ID: <?php echo htmlspecialchars($adminUID); ?></span>
                    <a href="/Backend/PHP/logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Admin Controls -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Overview</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Questions</span>
                        <span class="font-semibold">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Active Tests</span>
                        <span class="font-semibold">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Registered Candidates</span>
                        <span class="font-semibold">0</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6 col-span-2">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="location.href='create-question.php'" class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <h4 class="font-semibold text-blue-700">Create Question</h4>
                        <p class="text-sm text-gray-600">Add new questions to the pool</p>
                    </button>
                    <button onclick="location.href='manage-tests.php'" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <h4 class="font-semibold text-green-700">Manage Tests</h4>
                        <p class="text-sm text-gray-600">Create and modify tests</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                <!-- Activity list will go here -->
                <p class="text-gray-500 text-center py-4">No recent activity</p>
            </div>
        </div>
    </div>
</body>
</html> 