<?php
session_start();
require_once '../../Backend/PHP/auth.php';
requireLogin();

if ($_SESSION['user_role'] !== 'candidate') {
    header('Location: admin-dashboard.php');
    exit();
}

// Get test ID from URL
$test_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$test_id) {
    header('Location: candidate-dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <title>Take Test - HackProctor</title>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Test Header -->
            <div class="border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold">Data Structures Test</h1>
                <div class="flex justify-between items-center mt-4">
                    <div class="text-gray-600">
                        <p>Time Remaining: <span id="timer" class="font-semibold">30:00</span></p>
                        <p>Questions: <span class="font-semibold">1/20</span></p>
                    </div>
                    <button id="submit-test" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Submit Test
                    </button>
                </div>
            </div>

            <!-- Question -->
            <form id="test-form">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">1. What is the time complexity of binary search?</h2>
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="q1" value="A" class="h-4 w-4 text-blue-600">
                            <span>O(n)</span>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="q1" value="B" class="h-4 w-4 text-blue-600">
                            <span>O(log n)</span>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="q1" value="C" class="h-4 w-4 text-blue-600">
                            <span>O(n²)</span>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="q1" value="D" class="h-4 w-4 text-blue-600">
                            <span>O(1)</span>
                        </label>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between">
                    <button type="button" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Previous
                    </button>
                    <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Timer functionality
        let timeLeft = 30 * 60; // 30 minutes in seconds
        const timerDisplay = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft === 0) {
                clearInterval(timerInterval);
                alert('Time is up! Submitting test...');
                document.getElementById('test-form').submit();
            }
            timeLeft--;
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    </script>
</body>
</html> 