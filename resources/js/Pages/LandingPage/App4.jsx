import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { ChevronDownIcon, CheckIcon, PhoneIcon, EnvelopeIcon, MapPinIcon, ArrowUpIcon, Bars3Icon, XMarkIcon, SparklesIcon, ShieldCheckIcon, RocketLaunchIcon, ClockIcon, UserGroupIcon, ChartBarIcon } from '@heroicons/react/24/outline';

// Reusable Button Component
const Button = ({ children, className, ...props }) => (
    <button
        className={`px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${className}`}
        {...props}
    >
        {children}
    </button>
);

// Reusable Section Wrapper
const Section = ({ id, children, className }) => (
    <section id={id} className={`py-24 ${className}`}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">{children}</div>
    </section>
);

// Navigation Component
const Navigation = ({ activeSection, scrollToSection, mobileMenuOpen, setMobileMenuOpen }) => {
    const navigation = [
        { name: 'Home', id: 'home' },
        { name: 'About', id: 'about' },
        { name: 'Pricing', id: 'pricing' },
        { name: 'Contact', id: 'contact' },
    ];

    return (
        <nav className="fixed top-0 w-full bg-white/95 backdrop-blur-md z-50 border-b border-gray-100 shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16">
                    <div className="flex items-center">
                        <div className="flex-shrink-0 flex items-center space-x-2">
                            <div className="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                                <SparklesIcon className="w-6 h-6 text-white" />
                            </div>
                            <span className="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Nexus
                            </span>
                        </div>
                    </div>

                    {/* Desktop Navigation */}
                    <div className="hidden md:flex items-center space-x-8">
                        {navigation.map((item) => (
                            <Link
                                key={item.id}
                                href={`#${item.id}`}
                                onClick={() => scrollToSection(item.id)}
                                className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 ${activeSection === item.id
                                    ? 'text-indigo-600 bg-indigo-50'
                                    : 'text-gray-700 hover:text-indigo-600 hover:bg-indigo-50'
                                    }`}
                            >
                                {item.name}
                            </Link>
                        ))}
                        <Button className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg">
                            Get Started
                        </Button>
                    </div>

                    {/* Mobile Menu Button */}
                    <div className="md:hidden">
                        <button
                            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                            className="text-gray-700 hover:text-indigo-600 p-2"
                        >
                            {mobileMenuOpen ? <XMarkIcon className="h-6 w-6" /> : <Bars3Icon className="h-6 w-6" />}
                        </button>
                    </div>
                </div>

                {/* Mobile Navigation */}
                {mobileMenuOpen && (
                    <div className="md:hidden bg-white border-t border-gray-100">
                        <div className="px-4 py-3 space-y-2">
                            {navigation.map((item) => (
                                <Link
                                    key={item.id}
                                    href={`#${item.id}`}
                                    onClick={() => scrollToSection(item.id)}
                                    className={`block w-full text-left px-4 py-2 rounded-lg text-base font-medium transition-all duration-300 ${activeSection === item.id
                                        ? 'text-indigo-600 bg-indigo-50'
                                        : 'text-gray-700 hover:text-indigo-600 hover:bg-indigo-50'
                                        }`}
                                >
                                    {item.name}
                                </Link>
                            ))}
                            <Button className="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700">
                                Get Started
                            </Button>
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
};

// Hero Section
const HeroSection = ({ scrollToSection, isLoaded }) => (
    <Section id="home" className="min-h-screen flex items-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 relative">
        <div className="absolute inset-0 opacity-10 pointer-events-none">
            <div className="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full mix-blend-multiply filter blur-2xl animate-pulse"></div>
            <div className="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full mix-blend-multiply filter blur-2xl animate-pulse delay-1000"></div>
        </div>

        <div className={`text-center transition-all duration-1000 ${isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
            <h1 className="text-5xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                Empower Your
                <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Future</span>
            </h1>
            <p className="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                Unleash your business potential with innovative solutions designed for growth and efficiency.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button
                    onClick={() => scrollToSection('pricing')}
                    className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    Start Free Trial
                </Button>
                <Button
                    onClick={() => scrollToSection('about')}
                    className="border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400"
                >
                    Learn More
                </Button>
            </div>
            <button
                onClick={() => scrollToSection('about')}
                className="mt-16 text-gray-400 hover:text-indigo-600 transition-colors"
            >
                <ChevronDownIcon className="h-8 w-8 mx-auto animate-bounce" />
            </button>
        </div>
    </Section>
);

// About Section
const AboutSection = () => {
    const features = [
        {
            icon: RocketLaunchIcon,
            title: 'Blazing Performance',
            description: 'Optimized for speed with cutting-edge technology for instant results.',
        },
        {
            icon: ShieldCheckIcon,
            title: 'Robust Security',
            description: 'Enterprise-grade encryption and compliance to safeguard your data.',
        },
        {
            icon: UserGroupIcon,
            title: 'Seamless Collaboration',
            description: 'Real-time tools to enhance teamwork across distributed teams.',
        },
        {
            icon: ChartBarIcon,
            title: 'Insightful Analytics',
            description: 'Actionable insights to drive strategic business decisions.',
        },
    ];


    return (
        <Section id="about" className="bg-white">
            <div className="text-center mb-16">
                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Why Choose
                    <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Nexus</span>
                </h2>
                <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're your partner in innovation, delivering transformative solutions for success.
                </p>
            </div>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                {features.map((feature, index) => (
                    <div
                        key={index}
                        className="p-6 rounded-2xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-gray-100"
                    >
                        <div className="bg-gradient-to-br from-indigo-500 to-purple-600 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <feature.icon className="h-6 w-6 text-white" />
                        </div>
                        <h3 className="text-lg font-bold text-gray-900 mb-2">{feature.title}</h3>
                        <p className="text-gray-600">{feature.description}</p>
                    </div>
                ))}
            </div>
        </Section>
    );
};

// Pricing Section
const PricingSection = ({ billingCycle, setBillingCycle }) => {
    const pricingPlans = [
        {
            name: 'Starter',
            monthlyPrice: 29,
            yearlyPrice: 290,
            description: 'Ideal for startups and small teams.',
            features: ['5 Users', 'Basic Analytics', 'Email Support', '10GB Storage'],
            popular: false,
        },
        {
            name: 'Pro',
            monthlyPrice: 79,
            yearlyPrice: 790,
            description: 'Perfect for growing businesses.',
            features: ['25 Users', 'Advanced Analytics', 'Priority Support', '100GB Storage', 'API Access'],
            popular: true,
        },
        {
            name: 'Enterprise',
            monthlyPrice: 199,
            yearlyPrice: 1990,
            description: 'Tailored for large organizations.',
            features: ['Unlimited Users', 'Full Analytics Suite', 'Dedicated Support', 'Unlimited Storage', 'SLA'],
            popular: false,
        },
    ];

    return (
        <Section id="pricing" className="bg-gray-50">
            <div className="text-center mb-16">
                <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Flexible
                    <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Pricing</span>
                </h2>
                <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                    Transparent pricing with no hidden fees. Scale anytime.
                </p>
                <div className="flex justify-center space-x-4 mt-8">
                    <button
                        onClick={() => setBillingCycle('monthly')}
                        className={`px-4 py-2 rounded-lg font-medium ${billingCycle === 'monthly' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                    >
                        Monthly
                    </button>
                    <button
                        onClick={() => setBillingCycle('yearly')}
                        className={`px-4 py-2 rounded-lg font-medium ${billingCycle === 'yearly' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                    >
                        Yearly <span className="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full ml-2">Save 20%</span>
                    </button>
                </div>
            </div>
            <div className="grid lg:grid-cols-3 gap-8">
                {pricingPlans.map((plan) => (
                    <div
                        key={plan.name}
                        className={`relative bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300 ${plan.popular ? 'ring-2 ring-indigo-600' : ''}`}
                    >
                        {plan.popular && (
                            <span className="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                                Popular
                            </span>
                        )}
                        <h3 className="text-2xl font-bold text-gray-900 mb-2">{plan.name}</h3>
                        <p className="text-gray-600 mb-6">{plan.description}</p>
                        <div className="mb-6">
                            <span className="text-4xl font-bold text-gray-900">
                                ${billingCycle === 'monthly' ? plan.monthlyPrice : plan.yearlyPrice}
                            </span>
                            <span className="text-gray-600">/{billingCycle === 'monthly' ? 'month' : 'year'}</span>
                        </div>
                        <ul className="space-y-3 mb-6">
                            {plan.features.map((feature, index) => (
                                <li key={index} className="flex items-center">
                                    <CheckIcon className="h-5 w-5 text-green-500 mr-2" />
                                    <span className="text-gray-700">{feature}</span>
                                </li>
                            ))}
                        </ul>
                        <Button className={`w-full ${plan.popular ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200'}`}>
                            Get Started
                        </Button>
                    </div>
                ))}
            </div>
        </Section>
    );
};

// Contact Section
const ContactSection = () => (
    <Section id="contact" className="bg-white">
        <div className="text-center mb-16">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Connect With
                <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Us</span>
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                Ready to transform your business? Reach out to our team today.
            </p>
        </div>
        <div className="grid lg:grid-cols-2 gap-12">
            <div className="bg-gray-50 rounded-2xl p-8">
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Contact Us</h3>
                <div className="space-y-6">
                    <div className="grid md:grid-cols-2 gap-4">
                        <div>
                            <label htmlFor="firstName" className="block text-sm font-medium text-gray-700 mb-2">
                                First Name
                            </label>
                            <input
                                type="text"
                                id="firstName"
                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
                                placeholder="First Name"
                            />
                        </div>
                        <div>
                            <label htmlFor="lastName" className="block text-sm font-medium text-gray-700 mb-2">
                                Last Name
                            </label>
                            <input
                                type="text"
                                id="lastName"
                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
                                placeholder="Last Name"
                            />
                        </div>
                    </div>
                    <div>
                        <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
                            placeholder="you@example.com"
                        />
                    </div>
                    <div>
                        <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea
                            id="message"
                            rows={4}
                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500"
                            placeholder="Your message..."
                        />
                    </div>
                    <Button className="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700">
                        Send Message
                    </Button>
                </div>
            </div>
            <div className="space-y-8">
                <div className="space-y-4">
                    <div className="flex items-center p-4 bg-gray-50 rounded-xl">
                        <PhoneIcon className="h-6 w-6 text-indigo-600 mr-4" />
                        <div>
                            <p className="font-semibold text-gray-900">Phone</p>
                            <p className="text-gray-600">+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div className="flex items-center p-4 bg-gray-50 rounded-xl">
                        <EnvelopeIcon className="h-6 w-6 text-indigo-600 mr-4" />
                        <div>
                            <p className="font-semibold text-gray-900">Email</p>
                            <p className="text-gray-600">support@nexus.com</p>
                        </div>
                    </div>
                    <div className="flex items-center p-4 bg-gray-50 rounded-xl">
                        <MapPinIcon className="h-6 w-6 text-indigo-600 mr-4" />
                        <div>
                            <p className="font-semibold text-gray-900">Office</p>
                            <p className="text-gray-600">123 Innovation Drive, San Francisco, CA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>
);

// Footer Component
const Footer = () => (
    <footer className="bg-gray-900 text-white py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid md:grid-cols-4 gap-8">
                <div>
                    <div className="flex items-center space-x-2 mb-6">
                        <div className="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                            <SparklesIcon className="w-6 h-6 text-white" />
                        </div>
                        <span className="text-2xl font-bold">Nexus</span>
                    </div>
                    <p className="text-gray-400 mb-6">Innovative solutions for modern businesses.</p>
                    <div className="flex space-x-4">
                        {['Twitter', 'LinkedIn', 'GitHub'].map((platform) => (
                            <a key={platform} href="#" className="text-gray-400 hover:text-white">
                                <span className="sr-only">{platform}</span>
                                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    {/* Simplified icon paths for brevity */}
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                                </svg>
                            </a>
                        ))}
                    </div>
                </div>
                <div>
                    <h4 className="font-semibold text-lg mb-6">Product</h4>
                    <ul className="space-y-3 text-gray-400">
                        {['Features', 'Pricing', 'Support'].map((item) => (
                            <li key={item}>
                                <Link href="#" className="hover:text-white">
                                    {item}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>
                <div>
                    <h4 className="font-semibold text-lg mb-6">Company</h4>
                    <ul className="space-y-3 text-gray-400">
                        {['About', 'Careers', 'Blog'].map((item) => (
                            <li key={item}>
                                <Link href="#" className="hover:text-white">
                                    {item}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>
                <div>
                    <h4 className="font-semibold text-lg mb-6">Support</h4>
                    <ul className="space-y-3 text-gray-400">
                        {['Help Center', 'Contact', 'Status'].map((item) => (
                            <li key={item}>
                                <Link href="#" className="hover:text-white">
                                    {item}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
            <div className="border-t border-gray-800 pt-8 mt-8 text-center text-gray-400">
                © 2025 Nexus. All rights reserved.
            </div>
        </div>
    </footer>
);

// Main App Component
export default function App4() {
    const [activeSection, setActiveSection] = useState('home');
    const [showScrollTop, setShowScrollTop] = useState(false);
    const [billingCycle, setBillingCycle] = useState('monthly');
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        setIsLoaded(true);
    }, []);

    useEffect(() => {
        const handleScroll = () => {
            setShowScrollTop(window.scrollY > 500);
            const sections = ['home', 'about', 'pricing', 'contact'];
            const scrollPosition = window.scrollY + 100;

            for (const section of sections) {
                const element = document.getElementById(section);
                if (element) {
                    const { offsetTop, offsetHeight } = element;
                    if (scrollPosition >= offsetTop && scrollPosition < offsetTop + offsetHeight) {
                        setActiveSection(section);
                        break;
                    }
                }
            }
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const scrollToSection = (sectionId) => {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            setActiveSection(sectionId);
            setMobileMenuOpen(false);
        }
    };

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    return (
        <div className="min-h-screen bg-white font-sans">
            <Navigation
                activeSection={activeSection}
                scrollToSection={scrollToSection}
                mobileMenuOpen={mobileMenuOpen}
                setMobileMenuOpen={setMobileMenuOpen}
            />
            <HeroSection scrollToSection={scrollToSection} isLoaded={isLoaded} />
            <AboutSection />
            <PricingSection billingCycle={billingCycle} setBillingCycle={setBillingCycle} />
            <ContactSection />
            <Footer />
            {showScrollTop && (
                <Button
                    onClick={scrollToTop}
                    className="fixed bottom-6 right-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
                >
                    <ArrowUpIcon className="h-6 w-6" />
                </Button>
            )}
        </div>
    );
}