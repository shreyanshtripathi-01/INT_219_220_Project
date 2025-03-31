<?php
session_start();
require_once dirname(__FILE__) . '/../Backend/PHP/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <title>HackProctor - Candidate Assessment Tool</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <!-- Header/Navigation -->
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="index.php" class="text-2xl font-bold text-blue-600">HackProctor</a>
                    <!-- Navigation Links moved here -->
                    <a href="Pages/dashboard.php" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                    <a href="Pages/mock-test.php" class="text-gray-700 hover:text-blue-600">Mock Test</a>
                    <a href="Pages/about.php" class="text-gray-700 hover:text-blue-600">About</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="Backend/PHP/logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Logout</a>
                    <?php else: ?>
                        <a href="Pages/login.php" class="text-blue-600 hover:text-blue-700">Login</a>
                        <a href="Pages/register.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white py-32">
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-start max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Standardized Hackathon Assessment Platform
                </h1>
                <p class="text-xl mb-8">
                    Evaluate and shortlist hackathon candidates efficiently with our proctored examination system.
                </p>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a href="Pages/register.php" class="bg-white text-blue-600 px-8 py-3 rounded-md font-semibold hover:bg-gray-100 transform hover:scale-105 transition-transform duration-200">
                        Get Started
                    </a>
                <?php else: ?>
                    <a href="Pages/dashboard.php" class="bg-white text-blue-600 px-8 py-3 rounded-md font-semibold hover:bg-gray-100 transform hover:scale-105 transition-transform duration-200">
                        Go to Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose HackProctor?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fair Assessment</h3>
                    <p class="text-gray-600">Standardized evaluation process ensuring equal opportunity for all candidates.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure Proctoring</h3>
                    <p class="text-gray-600">Advanced monitoring system to maintain examination integrity.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Detailed Analytics</h3>
                    <p class="text-gray-600">Comprehensive reports and insights for better decision making.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">1</div>
                    <h3 class="font-semibold mb-2">Register</h3>
                    <p class="text-gray-600">Create your account as an organizer or candidate</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">2</div>
                    <h3 class="font-semibold mb-2">Setup Exam</h3>
                    <p class="text-gray-600">Configure your assessment criteria and questions</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">3</div>
                    <h3 class="font-semibold mb-2">Take Test</h3>
                    <p class="text-gray-600">Candidates complete the proctored examination</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">4</div>
                    <h3 class="font-semibold mb-2">Get Results</h3>
                    <p class="text-gray-600">Receive detailed assessment reports</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">HackProctor</h3>
                    <p class="text-gray-400">Revolutionizing hackathon candidate assessment with standardized proctored examinations.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <a href="https://github.com/shreyanshtripathi-01" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="https://linkedin.com/in/shreyanshtripathi" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html> 