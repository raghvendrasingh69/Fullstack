<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="images/emblem-dark.png" alt="Logo" class="h-12">
                <h1 class="text-2xl font-bold text-gray-800">Pension Management System</h1>
            </div>
            <nav class="flex space-x-6">
                <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
                <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium">About</a>
                <a href="#faqs" class="text-gray-700 hover:text-indigo-600 font-medium">FAQs</a>
                <a href="#contact" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>
                <a href="login.php" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Login</a>
                <a href="register.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Register</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-20 mt-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4">Welcome to PensionPro</h2>
            <p class="text-lg mb-6">Your trusted platform for managing pension details with ease and security.</p>
            <div class="space-x-4">
                <a href="register.php" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100">Get Started</a>
                <a href="#about" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Our Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-user-shield text-indigo-600 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Secure Access</h3>
                    <p class="text-gray-600">Access your pension details securely with our state-of-the-art platform.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-chart-line text-indigo-600 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Updates</h3>
                    <p class="text-gray-600">Stay updated with real-time information about your pension status.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-tools text-indigo-600 text-4xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Easy Management</h3>
                    <p class="text-gray-600">Manage your pension details effortlessly with our user-friendly tools.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:underline">Home</a></li>
                        <li><a href="#about" class="hover:underline">About</a></li>
                        <li><a href="#faqs" class="hover:underline">FAQs</a></li>
                        <li><a href="#contact" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <p>Email: support@pensionpro.com</p>
                    <p>Phone: +1 234 567 890</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <p>&copy; 2025 PensionPro. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<script>
    const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = (i === index) ? 'block' : 'none';
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 3000); // Change slide every 3 seconds
    </script>