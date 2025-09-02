<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welfare Kenya</title>

    <!-- Laravel Vite Resources -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Logo and buttons with solid colors */
        .logo-bg {
            background-color: #2563eb;
            /* Tailwind blue-600 */
        }

        .btn-primary {
            background-color: #2563eb;
            /* blue-600 */
            transition: background-color 0.3s, box-shadow 0.3s, transform 0.3s;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            /* blue-700 */
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4), 0 4px 6px -2px rgba(37, 99, 235, 0.2);
            transform: scale(1.05);
        }

        .btn-secondary {
            border-color: #9ca3af;
            /* gray-400 */
            color: #4b5563;
            /* gray-700 */
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-secondary:hover {
            border-color: #2563eb;
            background-color: #e0e7ff;
            /* blue-100 */
            color: #2563eb;
        }

        /* Social icons in footer */
        .social-icon {
            color: #6b7280;
            /* gray-500 */
            transition: color 0.3s;
            font-size: 1.25rem;
        }

        .social-icon:hover {
            color: #2563eb;
            /* blue-600 */
        }

        /* Floating animation */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 logo-bg rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <span class="font-bold text-xl text-blue-600">
                    Welfare Kenya
                </span>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium transition">
                    Sign In
                </a>
                <a href="{{ route('filament.admin.auth.register') }}"
                    class="px-6 py-2.5 btn-primary text-white rounded-full font-medium flex items-center justify-center">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center px-6 pt-20">
        <div class="max-w-5xl mx-auto text-center pt-10">

            <!-- Trust Badge with Stars -->
            <div
                class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-full text-blue-700 text-sm font-medium mb-8 space-x-3">
                <i class="fas fa-shield-alt"></i>
                <span>Trusted by 150+ Educational Institutions</span>
                <div class="flex space-x-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star-half-alt text-yellow-400"></i>
                </div>
            </div>

            <!-- Main Heading -->
            <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                <span class="text-blue-600">
                    Welfare
                </span>
                <br />
                <span class="text-gray-900">Made Simple</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-12 leading-relaxed">
                Transform your institution's welfare management with transparency, automation, and trust.
                <span class="text-blue-600 font-medium">Join thousands</span> already managing welfare the smart way.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="/register"
                    class="btn-primary px-8 py-4 text-white rounded-full font-semibold flex items-center">
                    Start Your Welfare Group
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>

                <a href="#demo" class="btn-secondary px-8 py-4 border-2 rounded-full font-semibold flex items-center">
                    <i class="fas fa-play mr-2"></i>
                    Watch Demo
                </a>
            </div>

            <!-- Key Features Grid -->
            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div
                    class="p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-eye text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">100% Transparent</h3>
                    <p class="text-gray-600 text-sm">Every contribution and benefit tracked in real-time</p>
                </div>

                <div
                    class="p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-mobile-alt text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Mobile First</h3>
                    <p class="text-gray-600 text-sm">Manage welfare from anywhere, anytime</p>
                </div>

                <div
                    class="p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 mx-auto">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Instant Setup</h3>
                    <p class="text-gray-600 text-sm">Launch your welfare group in under 5 minutes</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap justify-center items-center gap-8 mt-16 pt-8 border-t border-gray-200">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">25K+</div>
                    <div class="text-gray-600 text-sm">Active Members</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">KSh 50M+</div>
                    <div class="text-gray-600 text-sm">Funds Managed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">150+</div>
                    <div class="text-gray-600 text-sm">Institutions</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900">99.9%</div>
                    <div class="text-gray-600 text-sm">Uptime</div>
                </div>
            </div>

        </div>
    </section>

    <!-- Floating Elements -->
    <div class="fixed top-20 right-10 w-20 h-20 bg-blue-400 rounded-full opacity-10 floating"
        style="animation-delay: -2s;"></div>
    <div class="fixed bottom-20 left-10 w-16 h-16 bg-purple-400 rounded-full opacity-10 floating"
        style="animation-delay: -4s;"></div>

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-700 py-8 mt-20">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm">&copy; 2025 Welfare Kenya. All rights reserved.</p>

            <div class="flex space-x-6 text-sm">
                <a href="/terms" class="hover:text-blue-600 transition">Terms of Service</a>
                <a href="/privacy" class="hover:text-blue-600 transition">Privacy Policy</a>
                <a href="/rights" class="hover:text-blue-600 transition">User Rights</a>
            </div>

            <div class="flex space-x-6">
                <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter" class="social-icon">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook" class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="LinkedIn" class="social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </footer>

</body>

</html>