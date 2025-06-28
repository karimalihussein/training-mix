import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import {
    ChevronDownIcon,
    CheckIcon,
    StarIcon,
    PhoneIcon,
    EnvelopeIcon,
    MapPinIcon,
    ArrowUpIcon,
} from '@heroicons/react/24/outline';

// --- Reusable UI Components ---

const Navigation = ({ activeSection, scrollToSection, navigationItems }) => (
    <nav className="fixed top-0 w-full bg-white/90 backdrop-blur-md z-50 border-b border-gray-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between items-center h-16">
                <div className="flex items-center">
                    <div className="flex-shrink-0">
                        <h1 className="text-2xl font-bold text-indigo-600">BrandName</h1>
                    </div>
                </div>
                <div className="hidden md:block">
                    <div className="ml-10 flex items-baseline space-x-4">
                        {navigationItems.map((item) => (
                            <button
                                key={item.id}
                                onClick={() => scrollToSection(item.id)}
                                className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${activeSection === item.id
                                    ? 'text-indigo-600 bg-indigo-50'
                                    : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50'
                                    }`}
                            >
                                {item.name}
                            </button>
                        ))}
                    </div>
                </div>
                <div className="md:hidden">
                    {/* Mobile menu button - consider implementing a proper mobile menu here */}
                    <button className="text-gray-600 hover:text-indigo-600" aria-label="Open mobile menu">
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
);

const Footer = ({ navigationItems }) => (
    <footer className="bg-gray-900 text-white py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 className="text-xl font-bold mb-4">BrandName</h3>
                    <p className="text-gray-400">
                        Transforming businesses through innovative technology solutions.
                    </p>
                </div>
                <div>
                    <h4 className="font-semibold mb-4">Company</h4>
                    <ul className="space-y-2 text-gray-400">
                        {navigationItems.map(item => (
                            <li key={item.id}><a href={`#${item.id}`} onClick={(e) => { e.preventDefault(); document.getElementById(item.id).scrollIntoView({ behavior: 'smooth' }); }} className="hover:text-white transition-colors">{item.name}</a></li>
                        ))}
                    </ul>
                </div>
                <div>
                    <h4 className="font-semibold mb-4">Support</h4>
                    <ul className="space-y-2 text-gray-400">
                        <li><a href="#" className="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" className="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" className="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 className="font-semibold mb-4">Connect</h4>
                    <div className="flex space-x-4">
                        <a href="#" className="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                            <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" className="text-gray-400 hover:text-white transition-colors" aria-label="LinkedIn">
                            <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 BrandName. All rights reserved.</p>
            </div>
        </div>
    </footer>
);

const ScrollToTopButton = ({ showScrollTop, scrollToTop }) => (
    showScrollTop && (
        <button
            onClick={scrollToTop}
            className="fixed bottom-8 right-8 bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:bg-indigo-700 transition-colors z-50"
            aria-label="Scroll to top"
        >
            <ArrowUpIcon className="h-6 w-6" />
        </button>
    )
);

const PricingCard = ({ plan, billingCycle }) => (
    <div
        className={`relative bg-white rounded-2xl shadow-lg p-8 ${plan.popular ? 'ring-2 ring-indigo-600' : ''
            }`}
    >
        {plan.popular && (
            <div className="absolute -top-4 left-1/2 transform -translate-x-1/2">
                <span className="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                    Most Popular
                </span>
            </div>
        )}

        <div className="text-center mb-8">
            <h3 className="text-2xl font-bold text-gray-900 mb-2">{plan.name}</h3>
            <p className="text-gray-600 mb-6">{plan.description}</p>
            <div className="mb-4">
                <span className="text-4xl font-bold text-gray-900">
                    ${billingCycle === 'monthly' ? plan.monthlyPrice : plan.yearlyPrice}
                </span>
                <span className="text-gray-600">/{billingCycle === 'monthly' ? 'month' : 'year'}</span>
            </div>
        </div>

        <ul className="space-y-4 mb-8">
            {plan.features.map((feature, index) => (
                <li key={index} className="flex items-center">
                    <CheckIcon className="h-5 w-5 text-green-500 mr-3 flex-shrink-0" />
                    <span className="text-gray-700">{feature}</span>
                </li>
            ))}
        </ul>

        <button
            className={`w-full py-3 px-6 rounded-lg font-semibold transition-colors ${plan.popular
                ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                : 'bg-gray-100 text-gray-900 hover:bg-gray-200'
                }`}
        >
            Get Started
        </button>
    </div>
);

// --- Section Components ---

const HeroSection = ({ scrollToSection }) => (
    <section id="home" className="pt-16 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div className="text-center">
                <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Transform Your Business
                    <span className="text-indigo-600"> Today</span>
                </h1>
                <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Discover innovative solutions that drive growth and efficiency.
                    Join thousands of businesses that trust us to deliver results.
                </p>
                <div className="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        onClick={() => scrollToSection('pricing')}
                        className="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors"
                    >
                        Get Started
                    </button>
                    <button
                        onClick={() => scrollToSection('about')}
                        className="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors"
                    >
                        Learn More
                    </button>
                </div>
            </div>
            <div className="mt-16 text-center">
                <button
                    onClick={() => scrollToSection('about')}
                    className="text-gray-400 hover:text-indigo-600 transition-colors"
                    aria-label="Scroll to about section"
                >
                    <ChevronDownIcon className="h-8 w-8 mx-auto animate-bounce" />
                </button>
            </div>
        </div>
    </section>
);

const AboutSection = () => (
    <section id="about" className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16">
                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    About Our Company
                </h2>
                <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                    We're passionate about helping businesses succeed through innovative technology solutions.
                </p>
            </div>
            <div className="grid md:grid-cols-3 gap-8">
                <div className="text-center">
                    <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <StarIcon className="h-8 w-8 text-indigo-600" />
                    </div>
                    <h3 className="text-xl font-semibold text-gray-900 mb-2">Excellence</h3>
                    <p className="text-gray-600">
                        We strive for excellence in everything we do, delivering the highest quality solutions.
                    </p>
                </div>
                <div className="text-center">
                    <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <CheckIcon className="h-8 w-8 text-indigo-600" />
                    </div>
                    <h3 className="text-xl font-semibold text-gray-900 mb-2">Reliability</h3>
                    <p className="text-gray-600">
                        Trusted by thousands of businesses worldwide for reliable and secure solutions.
                    </p>
                </div>
                <div className="text-center">
                    <div className="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <StarIcon className="h-8 w-8 text-indigo-600" />
                    </div>
                    <h3 className="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                    <p className="text-gray-600">
                        Constantly innovating to provide cutting-edge solutions for modern businesses.
                    </p>
                </div>
            </div>
        </div>
    </section>
);

const PricingSection = () => {
    const [billingCycle, setBillingCycle] = useState('monthly');

    const pricingPlans = [
        {
            name: 'Starter',
            monthlyPrice: 29,
            yearlyPrice: 290,
            description: 'Perfect for small teams and startups',
            features: [
                'Up to 5 team members',
                'Basic analytics',
                '24/7 support',
                '1GB storage',
                'Email support',
            ],
            popular: false,
        },
        {
            name: 'Professional',
            monthlyPrice: 79,
            yearlyPrice: 790,
            description: 'Ideal for growing businesses',
            features: [
                'Up to 20 team members',
                'Advanced analytics',
                'Priority support',
                '10GB storage',
                'Phone & email support',
                'Custom integrations',
                'Advanced security',
            ],
            popular: true,
        },
        {
            name: 'Enterprise',
            monthlyPrice: 199,
            yearlyPrice: 1990,
            description: 'For large organizations',
            features: [
                'Unlimited team members',
                'Enterprise analytics',
                'Dedicated support',
                'Unlimited storage',
                '24/7 phone support',
                'Custom integrations',
                'Advanced security',
                'SLA guarantee',
                'Custom branding',
            ],
            popular: false,
        },
    ];

    return (
        <section id="pricing" className="py-24 bg-gray-50">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Simple, Transparent Pricing
                    </h2>
                    <p className="text-xl text-gray-600 mb-8">
                        Choose the plan that's right for your business
                    </p>

                    {/* Billing Toggle */}
                    <div className="flex items-center justify-center space-x-4 mb-12">
                        <span className={`text-sm font-medium ${billingCycle === 'monthly' ? 'text-gray-900' : 'text-gray-500'}`}>
                            Monthly
                        </span>
                        <button
                            onClick={() => setBillingCycle(billingCycle === 'monthly' ? 'yearly' : 'monthly')}
                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${billingCycle === 'yearly' ? 'bg-indigo-600' : 'bg-gray-200'
                                }`}
                            aria-pressed={billingCycle === 'yearly'}
                            aria-label="Toggle billing cycle"
                        >
                            <span
                                className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${billingCycle === 'yearly' ? 'translate-x-6' : 'translate-x-1'
                                    }`}
                                aria-hidden="true"
                            />
                        </button>
                        <span className={`text-sm font-medium ${billingCycle === 'yearly' ? 'text-gray-900' : 'text-gray-500'}`}>
                            Yearly
                            <span className="ml-1 text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                Save 20%
                            </span>
                        </span>
                    </div>
                </div>

                <div className="grid md:grid-cols-3 gap-8">
                    {pricingPlans.map((plan) => (
                        <PricingCard key={plan.name} plan={plan} billingCycle={billingCycle} />
                    ))}
                </div>
            </div>
        </section>
    );
};

const ContactSection = () => (
    <section id="contact" className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-16">
                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Get In Touch
                </h2>
                <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                    Ready to get started? Contact us today and let's discuss how we can help your business grow.
                </p>
            </div>

            <div className="grid md:grid-cols-2 gap-12">
                {/* Contact Form */}
                <div>
                    <form className="space-y-6">
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                                Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Your name"
                                aria-label="Your name"
                            />
                        </div>
                        <div>
                            <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="your@email.com"
                                aria-label="Your email address"
                            />
                        </div>
                        <div>
                            <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                                Message
                            </label>
                            <textarea
                                id="message"
                                rows={4}
                                className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Tell us about your project..."
                                aria-label="Your message"
                            />
                        </div>
                        <button
                            type="submit"
                            className="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition-colors"
                        >
                            Send Message
                        </button>
                    </form>
                </div>

                {/* Contact Information */}
                <div className="space-y-8">
                    <div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <div className="space-y-4">
                            <div className="flex items-center">
                                <PhoneIcon className="h-6 w-6 text-indigo-600 mr-3" />
                                <span className="text-gray-700">+1 (555) 123-4567</span>
                            </div>
                            <div className="flex items-center">
                                <EnvelopeIcon className="h-6 w-6 text-indigo-600 mr-3" />
                                <span className="text-gray-700">hello@brandname.com</span>
                            </div>
                            <div className="flex items-center">
                                <MapPinIcon className="h-6 w-6 text-indigo-600 mr-3" />
                                <span className="text-gray-700">123 Business St, City, State 12345</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-4">Business Hours</h3>
                        <div className="space-y-2 text-gray-700">
                            <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p>Saturday: 10:00 AM - 4:00 PM</p>
                            <p>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
);

// --- Main Page Component ---

export default function App3() {
    const [activeSection, setActiveSection] = useState('home');
    const [showScrollTop, setShowScrollTop] = useState(false);

    const navigation = [
        { name: 'Home', id: 'home' },
        { name: 'About', id: 'about' },
        { name: 'Pricing', id: 'pricing' },
        { name: 'Contact', id: 'contact' },
    ];

    // Smooth scroll to section
    const scrollToSection = (sectionId) => {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            // Update active section only if it's different to avoid re-renders
            if (activeSection !== sectionId) {
                setActiveSection(sectionId);
            }
        }
    };

    // Handle scroll events to update active section and show/hide scroll-to-top button
    useEffect(() => {
        const handleScroll = () => {
            setShowScrollTop(window.scrollY > 500);

            const sections = navigation.map(item => item.id);
            const scrollPosition = window.scrollY + 100; // Offset for better detection

            for (const sectionId of sections) {
                const element = document.getElementById(sectionId);
                if (element) {
                    const { offsetTop, offsetHeight } = element;
                    if (scrollPosition >= offsetTop && scrollPosition < offsetTop + offsetHeight) {
                        if (activeSection !== sectionId) {
                            setActiveSection(sectionId);
                        }
                        break;
                    }
                }
            }
        };

        window.addEventListener('scroll', handleScroll);
        // Clean up the event listener on component unmount
        return () => window.removeEventListener('scroll', handleScroll);
    }, [activeSection, navigation]); // Re-run effect if navigation or activeSection changes

    // Scroll to top
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    return (
        <>
            <Head>
                <title>Modern Landing Page - Your Business Solution</title>
                <meta name="description" content="Discover our modern business solutions with flexible pricing plans. Get started today with our comprehensive services." />
                <meta name="keywords" content="business, solutions, pricing, contact, about" />
                <meta property="og:title" content="Modern Landing Page - Your Business Solution" />
                <meta property="og:description" content="Discover our modern business solutions with flexible pricing plans." />
                <meta property="og:type" content="website" />
            </Head>

            <Navigation
                activeSection={activeSection}
                scrollToSection={scrollToSection}
                navigationItems={navigation}
            />

            <main>
                <HeroSection scrollToSection={scrollToSection} />
                <AboutSection />
                <PricingSection />
                <ContactSection />
            </main>

            <Footer navigationItems={navigation} />

            <ScrollToTopButton
                showScrollTop={showScrollTop}
                scrollToTop={scrollToTop}
            />
        </>
    );
}