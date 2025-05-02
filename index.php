<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pension Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/src/output.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(45deg, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #4F46E5;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-lime-100 via-blue-100 to-violet-200 shadow-2xl fixed w-full z-50 transition-all duration-300 rounded-b-xl" id="navbar">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center py-6">
            <div class="flex items-center space-x-8">
                <a href="index.php" class="text-3xl font-bold gradient-text flex items-center gap-2">
                    <img src="images/gov.in-removebg-preview.png" alt="Logo" class="w-18 h-20 mr-3">
                    <div>
                        <span class="text-4xl font-extrabold text-indigo-700 tracking-wide font-sans ">ONE ID PENSION SYSTEM</span>
                        <br>
                        <span class="text-lg font-medium text-gray-600 tracking-wide">Government of India</span>
                    </div>
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="login.php" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors duration-300 flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </a>
                <a href="register.php" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Register
                </a>
            </div>
        </div>
        <!-- Navigation Links Section -->
        <div class="    ">
            <div class="container   flex justify-end gap-8">
                <a href="#about" class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">About</a>
                <a href="#faqs" class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">FAQs</a>
                <a href="#Team " class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">Team</a>
            </div>
        </div>
    </div>
</nav>

   

    <!-- Hero Section -->
    <div class="hero-gradient min-h-screen flex items-center pt-20">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8" data-aos="fade-right">
                    <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight">
                        Secure Your Future with Smart Pension Management
                    </h1>
                    <p class="text-xl text-indigo-100 leading-relaxed">
                        Experience hassle-free pension management with our state-of-the-art platform. Track, manage, and optimize your pension benefits all in one place.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="register.php" class="bg-white text-indigo-600 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-indigo-50 transition-all duration-300 transform hover:scale-105 flex items-center justify-center group">
                            Get Started
                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#about" class="bg-indigo-700 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-indigo-800 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </a>
                    </div>
                </div>
                <!-- <div class="relative" data-aos="fade-left">
                    <div class="float-animation relative z-10">
                        <img src="images/imggov.jpg" 
                             alt="Pension Management" 
                             class="w-full h-auto rounded-2xl shadow-2xl">
                    </div>
                    <div class="absolute top-0 right-0 w-72 h-72 bg-indigo-400 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-400 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
                </div> -->
                <!-- Slider Section -->
<div id="slider" class="relative w-full h-96 overflow-hidden float-animation relative z-10 w-full rounded-2xl shadow-2xl" data-aos="fade-left"></div>

<script>
    // Slider functionality
    const sliderImages = [
        'images/imggov.jpg',
        'images/Features-Benefits-of-Pension-Plans-in-India.jpg',
        'images/pension1200-sixteen_nine.avif',
        'images/Schemes-To-Systems-4.jpg',
        'images/H20241202172142.jpg'
    ];

    const slider = document.getElementById('slider');
    let currentSlide = 0;

    function createSlider() {
        sliderImages.forEach((image, index) => {
            const img = document.createElement('img');
            img.src = image;
            img.classList.add('absolute', 'w-full', 'h-full', 'object-cover', 'transition-opacity', 'duration-500');
            img.style.opacity = index === 0 ? '1' : '0';
            slider.appendChild(img);
        });
    }

    function nextSlide() {
        const slides = slider.getElementsByTagName('img');
        slides[currentSlide].style.opacity = '0';
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].style.opacity = '1';
    }

    createSlider();
    setInterval(nextSlide, 2000); 
</script>
            </div>
        </div>
    </div>
    <section id="features" class="py-16 bg-gray-100 opacity-0 transform translate-y-10 transition-all duration-700">    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Our Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-user-shield text-indigo-600 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Secure Access</h3>
                <p class="text-gray-600">Access your pension details securely with our state-of-the-art platform.</p>
                <button onclick="openPopup()" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Learn More</button>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-chart-line text-indigo-600 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Updates</h3>
                <p class="text-gray-600">Stay updated with real-time information about your pension status.</p>
                <button onclick="openPopup()" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Learn More</button>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-tools text-indigo-600 text-4xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Easy Management</h3>
                <p class="text-gray-600">Manage your pension details effortlessly with our user-friendly tools.</p>
                <button onclick="openPopup()" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Learn More</button>
            </div>
        </div>
    </div>
</section>

<script>
    const featuresSection = document.getElementById('features');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
              
                
                featuresSection.classList.remove('opacity-0', 'translate-y-10');
                featuresSection.classList.add('opacity-100', 'translate-y-0');
            }
        });
    }, { threshold: 0.2 });

    observer.observe(featuresSection);
</script>



    <!-- About Section -->
    <section id="about" class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold gradient-text inline-block mb-4">Why Choose Us</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Experience the next generation of pension management with our comprehensive platform.</p>
            </div>


            <div class="mt-16 text-center" data-aos="fade-up">
                <a href="register.php" class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-90 transition-all duration-300 transform hover:scale-105">
                    <span>Join Now</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-indigo-50 rounded-full filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-50 rounded-full filter blur-3xl opacity-30"></div>
    </section>

    <!-- FAQs Section -->
    <section id="faqs" class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl font-bold gradient-text inline-block mb-4">Common Questions</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Find answers to frequently asked questions about our pension management system.</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-6" id="faqAccordion">
                <!-- FAQ Items -->
                <div class="card-hover bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-gray-800">How do I register for the pension portal?</span>
                            <i class="fas fa-chevron-down text-indigo-600 transform transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600">Registration is simple! Click on the 'Register' button, fill in your personal details, upload required documents, and submit. Our team will verify your information and activate your account within 24-48 hours.</p>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-gray-800">How secure is my pension data?</span>
                            <i class="fas fa-chevron-down text-indigo-600 transform transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600">We employ bank-grade security measures including end-to-end encryption, two-factor authentication, and regular security audits to ensure your data is always protected.</p>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <button class="w-full px-6 py-4 text-left focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-gray-800">How can I track my pension payments?</span>
                            <i class="fas fa-chevron-down text-indigo-600 transform transition-transform duration-300"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600">Once logged in, you can view your payment history, upcoming payments, and download statements from your dashboard. We also send email notifications for every transaction.</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="absolute top-0 right-0 w-72 h-72 bg-indigo-50 rounded-full filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-50 rounded-full filter blur-3xl opacity-30"></div>
    </section>

    <!-- Navigation Links Section -->
<div class="container flex justify-end gap-8">
    <a href="#about" class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">About</a>
    <a href="#faqs" class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">FAQs</a>
    <a href="#team" class="nav-link text-gray-600 hover:text-indigo-600 transition-colors duration-300">Team</a> <!-- Updated -->
</div>


<section id="Team" class="py-24 bg-gray-50 relative overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold gradient-text inline-block mb-4">Meet Our Team</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Introducing the dedicated team behind the Pension Management System.</p>
        </div>
        
    


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="Project/images/abc.jpg" alt="Member 1" class="w-24 h-24 rounded-full mx-auto mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Ganesh Kumar Gupta</h3>
                <p class="text-gray-600">Frontend Developer</p>
                <p class="text-gray-500">Reg No: 12321000</p>
            </div>

           
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="Project/images/abc.jpg" alt="Member 2" class="w-24 h-24 rounded-full mx-auto mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Om Prakash</h3>
                <p class="text-gray-600">Backend Developer</p>
                <p class="text-gray-500">Reg No: 12316999</p>
            </div>

            
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="Project/images/abc.jpg" alt="Member 3" class="w-24 h-24 rounded-full mx-auto mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Raghvendra Singh</h3>
                <p class="text-gray-600">UI/UX Designer</p>
                <p class="text-gray-500">Reg No: 12306530</p>
            </div>

            
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <img src="Project/images/abc.jpg" alt="Member 4" class="w-24 h-24 rounded-full mx-auto mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Shiv Naresh</h3>
                <p class="text-gray-600">Database Creator</p>
                <p class="text-gray-500">Reg No: 12310639</p>
            </div>
        </div>
    </div>
</section>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('py-4');
                navbar.classList.remove('py-6');
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('py-4');
                navbar.classList.add('py-6');
                navbar.classList.remove('shadow-md');
            }
        });

        // FAQ Accordion
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.fa-chevron-down');
            const allContents = document.querySelectorAll('.faq-content');
            const allIcons = document.querySelectorAll('.fa-chevron-down');

            // Close all other FAQs
            allContents.forEach(item => {
                if (item !== content && !item.classList.contains('hidden')) {
                    item.classList.add('hidden');
                }
            });

            allIcons.forEach(item => {
                if (item !== icon) {
                    item.classList.remove('rotate-180');
                }
            });

            // Toggle current FAQ
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Contact Form Submission
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg animate-fade-in';
            toast.textContent = 'Message sent successfully! We\'ll get back to you soon.';
            document.body.appendChild(toast);
            
            // Clear form
            this.reset();
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        });

        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <script>
       
        const sliderImages = [
            'images/img1.jpeg',
            'images/village-girl-pictures-3jn1kpvjbuf3j2y3.webp',
            'images/H20241202172142.jpg',
            'images/man-8043010_640.webp',
            'images/Azure-OpenAI-Service-India-blog-volunteer-with-farmers.jpg'
            
        ];

        const slider = document.getElementById('slider');
        let currentSlide = 0;

        function createSlider() {
            sliderImages.forEach((image, index) => {
                const img = document.createElement('img');
                img.src = image;
                img.classList.add('absolute', 'w-full', 'h-full', 'object-cover', 'transition-opacity', 'duration-500');
                img.style.opacity = index === 0 ? '1' : '0';
                slider.appendChild(img);
            });
        }

        function nextSlide() {
            const slides = slider.getElementsByTagName('img');
            slides[currentSlide].style.opacity = '0';
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].style.opacity = '1';
        }

        createSlider();
        setInterval(nextSlide, 3000);

        // FAQ Data
        const faqs = [
            {
                question: 'How do I register for the pension portal?',
                answer: 'You can register by clicking the "Register" button and following the simple registration process using your One ID.'
            },
            {
                question: 'What is One ID?',
                answer: 'One ID is your unique identifier for accessing the pension portal. It\'s provided by the government and ensures secure access to your pension details.'
            },
            {
                question: 'How can I view my pension details?',
                answer: 'After logging in with your One ID, you can access your pension details from the dashboard, including payment history and current status.'
            }
        ];

        // Populate FAQs
        const faqsContainer = document.querySelector('#faqs .space-y-4');
        faqs.forEach(faq => {
            const faqItem = document.createElement('div');
            faqItem.className = 'bg-white p-6 rounded-lg shadow-md';
            faqItem.innerHTML = `
                <h3 class="text-lg font-semibold text-gray-800 mb-2">${faq.question}</h3>
                <p class="text-gray-600">${faq.answer}</p>
            `;
            faqsContainer.appendChild(faqItem);
        });

        // Form validation
        const contactForm = document.querySelector('#contact form');
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (!name || !email || !message) {
                alert('Please fill in all fields');
                return;
            }

            if (!email.includes('@')) {
                alert('Please enter a valid email address');
                return;
            }

            alert('Message sent successfully!');
            contactForm.reset();
        });
    </script>
</body>
</html>
