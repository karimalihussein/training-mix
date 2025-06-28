import React, { useState, useEffect } from 'react';
import {
    ChevronDownIcon,
    CheckIcon,
    StarIcon,
    PhoneIcon,
    EnvelopeIcon,
    MapPinIcon,
    ArrowUpIcon,
    Bars3Icon,
    XMarkIcon,
    SparklesIcon,
    ShieldCheckIcon,
    RocketLaunchIcon,
    ClockIcon,
    UserGroupIcon,
    ChartBarIcon
} from '@heroicons/react/24/outline';

export default function App1() {
    const [activeSection, setActiveSection] = useState('home');
    const [showScrollTop, setShowScrollTop] = useState(false);
    const [billingCycle, setBillingCycle] = useState('monthly');
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [isLoaded, setIsLoaded] = useState(false);

    // Animation on mount
    useEffect(() => {
        setIsLoaded(true);
    }, []);

    // Smooth scroll to section
    const scrollToSection = (sectionId) => {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            setActiveSection(sectionId);
            setMobileMenuOpen(false);
        }
    };

    // Handle scroll events
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

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const navigation = [
        { name: 'Home', id: 'home' },
        { name: 'About', id: 'about' },
        { name: 'Pricing', id: 'pricing' },
        { name: 'Contact', id: 'contact' },
    ];

    const features = [
        {
            icon: RocketLaunchIcon,
            title: 'Lightning Fast',
            description: 'Built for speed with cutting-edge technology that delivers instant results and seamless performance.'
        },
        {
            icon: ShieldCheckIcon,
            title: 'Enterprise Security',
            description: 'Bank-grade security protocols protect your data with advanced encryption and compliance standards.'
        },
        {
            icon: UserGroupIcon,
            title: 'Team Collaboration',
            description: 'Seamless teamwork with real-time collaboration tools designed for modern distributed teams.'
        },
        {
            icon: ChartBarIcon,
            title: 'Advanced Analytics',
            description: 'Deep insights and actionable data visualization to drive informed business decisions.'
        },
        {
            icon: SparklesIcon,
            title: 'AI-Powered',
            description: 'Intelligent automation and smart recommendations that adapt to your workflow patterns.'
        },
        {
            icon: ClockIcon,
            title: '24/7 Support',
            description: 'Round-the-clock expert support with dedicated account managers for enterprise clients.'
        }
    ];

    const pricingPlans = [
        {
            name: 'Starter',
            monthlyPrice: 29,
            yearlyPrice: 290,
            description: 'Perfect for small teams and startups getting started',
            features: [
                'Up to 5 team members',
                'Basic analytics dashboard',
                '24/7 email support',
                '10GB secure storage',
                'Standard integrations',
                'Mobile app access'
            ],
            popular: false,
            color: 'gray'
        },
        {
            name: 'Professional',
            monthlyPrice: 79,
            yearlyPrice: 790,
            description: 'Ideal for growing businesses and established teams',
            features: [
                'Up to 25 team members',
                'Advanced analytics & reporting',
                'Priority support & phone',
                '100GB secure storage',
                'Custom integrations',
                'Advanced security features',
                'API access',
                'White-label options'
            ],
            popular: true,
            color: 'indigo'
        },
        {
            name: 'Enterprise',
            monthlyPrice: 199,
            yearlyPrice: 1990,
            description: 'For large organizations with complex needs',
            features: [
                'Unlimited team members',
                'Enterprise analytics suite',
                'Dedicated account manager',
                'Unlimited storage',
                '24/7 phone & chat support',
                'Custom integrations',
                'Advanced security & compliance',
                'SLA guarantee',
                'Custom branding',
                'On-premise deployment'
            ],
            popular: false,
            color: 'purple'
        },
    ];

    const stats = [
        { number: '50K+', label: 'Active Users' },
        { number: '99.9%', label: 'Uptime' },
        { number: '24/7', label: 'Support' },
        { number: '150+', label: 'Countries' }
    ];

    return (
        <div className="min-h-screen bg-white">
            {/* Navigation */}
            <nav className="fixed top-0 w-full bg-white/80 backdrop-blur-xl z-50 border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 flex items-center space-x-2">
                                <div className="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                                    <SparklesIcon className="w-5 h-5 text-white" />
                                </div>
                                <span className="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Nexus
                                </span>
                            </div>
                        </div>

                        {/* Desktop Navigation */}
                        <div className="hidden md:block">
                            <div className="ml-10 flex items-baseline space-x-8">
                                {navigation.map((item) => (
                                    <button
                                        key={item.id}
                                        onClick={() => scrollToSection(item.id)}
                                        className={`px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${activeSection === item.id
                                            ? 'text-indigo-600 bg-indigo-50'
                                            : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50'
                                            }`}
                                    >
                                        {item.name}
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div className="hidden md:block">
                            <button
                                onClick={() => scrollToSection('contact')}
                                className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                Get Started
                            </button>
                        </div>

                        {/* Mobile menu button */}
                        <div className="md:hidden">
                            <button
                                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                                className="text-gray-600 hover:text-indigo-600 p-2"
                            >
                                {mobileMenuOpen ? (
                                    <XMarkIcon className="h-6 w-6" />
                                ) : (
                                    <Bars3Icon className="h-6 w-6" />
                                )}
                            </button>
                        </div>
                    </div>
                </div>

                {/* Mobile Navigation */}
                {mobileMenuOpen && (
                    <div className="md:hidden bg-white border-t border-gray-100">
                        <div className="px-2 pt-2 pb-3 space-y-1">
                            {navigation.map((item) => (
                                <button
                                    key={item.id}
                                    onClick={() => scrollToSection(item.id)}
                                    className={`block w-full text-left px-3 py-2 rounded-md text-base font-medium transition-colors ${activeSection === item.id
                                        ? 'text-indigo-600 bg-indigo-50'
                                        : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50'
                                        }`}
                                >
                                    {item.name}
                                </button>
                            ))}
                            <button
                                onClick={() => scrollToSection('contact')}
                                className="w-full mt-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg font-medium"
                            >
                                Get Started
                            </button>
                        </div>
                    </div>
                )}
            </nav>

            {/* Hero Section */}
            <section id="home" className="pt-16 min-h-screen flex items-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 relative overflow-hidden">
                {/* Background Pattern */}
                <div className="absolute inset-0 opacity-10">
                    <div className="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
                    <div className="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-1000"></div>
                    <div className="absolute -bottom-8 left-20 w-72 h-72 bg-gradient-to-br from-indigo-400 to-blue-400 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-500"></div>
                </div>

                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
                    <div className={`text-center transition-all duration-1000 ${isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'}`}>
                        <div className="mb-6">
                            <span className="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 mb-8">
                                <SparklesIcon className="w-4 h-4 mr-2" />
                                Trusted by 50,000+ teams worldwide
                            </span>
                        </div>

                        <h1 className="text-5xl md:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                            Transform Your
                            <span className="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent"> Business</span>
                            <br />Into The Future
                        </h1>

                        <p className="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                            Discover next-generation solutions that drive exponential growth and operational excellence.
                            Join industry leaders who trust us to deliver transformative results.
                        </p>

                        <div className="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                            <button
                                onClick={() => scrollToSection('pricing')}
                                className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                Start Free Trial
                            </button>
                            <button
                                onClick={() => scrollToSection('about')}
                                className="border border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 hover:border-gray-400"
                            >
                                Watch Demo
                            </button>
                        </div>

                        {/* Stats */}
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                            {stats.map((stat, index) => (
                                <div key={index} className="text-center">
                                    <div className="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{stat.number}</div>
                                    <div className="text-gray-600 font-medium">{stat.label}</div>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="mt-20 text-center">
                        <button
                            onClick={() => scrollToSection('about')}
                            className="text-gray-400 hover:text-indigo-600 transition-colors"
                        >
                            <ChevronDownIcon className="h-8 w-8 mx-auto animate-bounce" />
                        </button>
                    </div>
                </div>
            </section>

            {/* About Section */}
            <section id="about" className="py-32 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-20">
                        <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Why Industry Leaders
                            <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Choose Us</span>
                        </h2>
                        <p className="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                            We're not just another technology company. We're your strategic partner in digital transformation,
                            combining cutting-edge innovation with proven business expertise.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
                        {features.map((feature, index) => (
                            <div
                                key={index}
                                className="group p-8 rounded-2xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-200"
                            >
                                <div className="bg-gradient-to-br from-indigo-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <feature.icon className="h-8 w-8 text-white" />
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-4 text-center">{feature.title}</h3>
                                <p className="text-gray-600 text-center leading-relaxed">
                                    {feature.description}
                                </p>
                            </div>
                        ))}
                    </div>

                    {/* CTA Section */}
                    <div className="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-12 text-center text-white">
                        <h3 className="text-3xl md:text-4xl font-bold mb-4">
                            Ready to Transform Your Business?
                        </h3>
                        <p className="text-xl mb-8 opacity-90">
                            Join thousands of companies already using our platform to drive growth and innovation.
                        </p>
                        <button
                            onClick={() => scrollToSection('pricing')}
                            className="bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-colors shadow-lg"
                        >
                            Explore Our Solutions
                        </button>
                    </div>
                </div>
            </section>

            {/* Pricing Section */}
            <section id="pricing" className="py-32 bg-gray-50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-20">
                        <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Simple, Transparent
                            <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Pricing</span>
                        </h2>
                        <p className="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">
                            Choose the perfect plan for your business needs. No hidden fees, no surprises.
                            Scale up or down anytime.
                        </p>

                        {/* Billing Toggle */}
                        <div className="flex items-center justify-center space-x-4 mb-16">
                            <span className={`text-lg font-medium transition-colors ${billingCycle === 'monthly' ? 'text-gray-900' : 'text-gray-500'}`}>
                                Monthly
                            </span>
                            <button
                                onClick={() => setBillingCycle(billingCycle === 'monthly' ? 'yearly' : 'monthly')}
                                className={`relative inline-flex h-8 w-16 items-center rounded-full transition-colors ${billingCycle === 'yearly' ? 'bg-indigo-600' : 'bg-gray-300'
                                    }`}
                            >
                                <span
                                    className={`inline-block h-6 w-6 transform rounded-full bg-white transition-transform ${billingCycle === 'yearly' ? 'translate-x-9' : 'translate-x-1'
                                        }`}
                                />
                            </button>
                            <span className={`text-lg font-medium transition-colors ${billingCycle === 'yearly' ? 'text-gray-900' : 'text-gray-500'}`}>
                                Yearly
                                <span className="ml-2 text-sm bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">
                                    Save 20%
                                </span>
                            </span>
                        </div>
                    </div>

                    <div className="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        {pricingPlans.map((plan) => (
                            <div
                                key={plan.name}
                                className={`relative bg-white rounded-3xl shadow-lg p-8 transition-all duration-300 hover:shadow-2xl ${plan.popular ? 'ring-2 ring-indigo-600 scale-105' : 'hover:scale-105'
                                    }`}
                            >
                                {plan.popular && (
                                    <div className="absolute -top-5 left-1/2 transform -translate-x-1/2">
                                        <span className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-semibold shadow-lg">
                                            Most Popular
                                        </span>
                                    </div>
                                )}

                                <div className="text-center mb-8">
                                    <h3 className="text-2xl font-bold text-gray-900 mb-2">{plan.name}</h3>
                                    <p className="text-gray-600 mb-8">{plan.description}</p>
                                    <div className="mb-6">
                                        <span className="text-5xl font-bold text-gray-900">
                                            ${billingCycle === 'monthly' ? plan.monthlyPrice : plan.yearlyPrice}
                                        </span>
                                        <span className="text-gray-600 text-lg">
                                            /{billingCycle === 'monthly' ? 'month' : 'year'}
                                        </span>
                                    </div>
                                    {billingCycle === 'yearly' && (
                                        <p className="text-sm text-green-600 font-medium">
                                            Save ${(plan.monthlyPrice * 12) - plan.yearlyPrice} per year
                                        </p>
                                    )}
                                </div>

                                <ul className="space-y-4 mb-8">
                                    {plan.features.map((feature, index) => (
                                        <li key={index} className="flex items-start">
                                            <CheckIcon className="h-5 w-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" />
                                            <span className="text-gray-700">{feature}</span>
                                        </li>
                                    ))}
                                </ul>

                                <button
                                    className={`w-full py-4 px-6 rounded-xl font-semibold transition-all duration-200 ${plan.popular
                                        ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl'
                                        : 'bg-gray-100 text-gray-900 hover:bg-gray-200'
                                        }`}
                                >
                                    {plan.popular ? 'Start Free Trial' : 'Get Started'}
                                </button>

                                {plan.popular && (
                                    <p className="text-center text-sm text-gray-500 mt-4">
                                        14-day free trial • No credit card required
                                    </p>
                                )}
                            </div>
                        ))}
                    </div>

                    <div className="text-center mt-16">
                        <p className="text-gray-600 mb-4">Need a custom solution for your enterprise?</p>
                        <button
                            onClick={() => scrollToSection('contact')}
                            className="text-indigo-600 font-semibold hover:text-indigo-700 transition-colors"
                        >
                            Contact our sales team →
                        </button>
                    </div>
                </div>
            </section>

            {/* Contact Section */}
            <section id="contact" className="py-32 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-20">
                        <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                            Let's Build Something
                            <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"> Amazing Together</span>
                        </h2>
                        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                            Ready to transform your business? Our team of experts is here to help you succeed.
                            Get in touch and let's discuss your unique needs.
                        </p>
                    </div>

                    <div className="grid lg:grid-cols-2 gap-16">
                        {/* Contact Form */}
                        <div className="bg-gray-50 rounded-3xl p-8">
                            <h3 className="text-2xl font-bold text-gray-900 mb-6">Send us a message</h3>
                            <form className="space-y-6">
                                <div className="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label htmlFor="firstName" className="block text-sm font-medium text-gray-700 mb-2">
                                            First Name
                                        </label>
                                        <input
                                            type="text"
                                            id="firstName"
                                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                            placeholder="John"
                                        />
                                    </div>
                                    <div>
                                        <label htmlFor="lastName" className="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name
                                        </label>
                                        <input
                                            type="text"
                                            id="lastName"
                                            className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                            placeholder="Doe"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="john@company.com"
                                    />
                                </div>
                                <div>
                                    <label htmlFor="company" className="block text-sm font-medium text-gray-700 mb-2">
                                        Company
                                    </label>
                                    <input
                                        type="text"
                                        id="company"
                                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Your Company"
                                    />
                                </div>
                                <div>
                                    <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                                        Message
                                    </label>
                                    <textarea
                                        id="message"
                                        rows={4}
                                        className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        placeholder="Tell us about your project and how we can help..."
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-6 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                                >
                                    Send Message
                                </button>
                            </form>
                        </div>

                        {/* Contact Information */}
                        <div className="space-y-12">
                            <div>
                                <h3 className="text-2xl font-bold text-gray-900 mb-8">Get in touch</h3>
                                <div className="space-y-6">
                                    <div className="flex items-center p-4 bg-gray-50 rounded-2xl">
                                        <div className="bg-indigo-100 p-3 rounded-xl mr-4">
                                            <PhoneIcon className="h-6 w-6 text-indigo-600" />
                                        </div>
                                        <div>
                                            <p className="font-semibold text-gray-900">Phone</p>
                                            <p className="text-gray-600">+1 (555) 123-4567</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center p-4 bg-gray-50 rounded-2xl">
                                        <div className="bg-indigo-100 p-3 rounded-xl mr-4">
                                            <EnvelopeIcon className="h-6 w-6 text-indigo-600" />
                                        </div>
                                        <div>
                                            <p className="font-semibold text-gray-900">Email</p>
                                            <p className="text-gray-600">hello@nexus.com</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center p-4 bg-gray-50 rounded-2xl">
                                        <div className="bg-indigo-100 p-3 rounded-xl mr-4">
                                            <MapPinIcon className="h-6 w-6 text-indigo-600" />
                                        </div>
                                        <div>
                                            <p className="font-semibold text-gray-900">Office</p>
                                            <p className="text-gray-600">123 Innovation Drive<br />San Francisco, CA 94102</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 className="text-xl font-bold text-gray-900 mb-6">Business Hours</h4>
                                <div className="bg-gray-50 rounded-2xl p-6">
                                    <div className="space-y-3 text-gray-700">
                                        <div className="flex justify-between">
                                            <span>Monday - Friday</span>
                                            <span className="font-medium">9:00 AM - 6:00 PM PST</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span>Saturday</span>
                                            <span className="font-medium">10:00 AM - 4:00 PM PST</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span>Sunday</span>
                                            <span className="font-medium">Closed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
                                <h4 className="text-xl font-bold mb-4">Enterprise Support</h4>
                                <p className="mb-6 opacity-90">
                                    Need dedicated support for your enterprise? Our premium support team is available 24/7.
                                </p>
                                <button className="bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                                    Learn More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-900 text-white py-16">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid md:grid-cols-4 gap-8 mb-12">
                        <div className="md:col-span-1">
                            <div className="flex items-center space-x-2 mb-6">
                                <div className="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                                    <SparklesIcon className="w-5 h-5 text-white" />
                                </div>
                                <span className="text-xl font-bold">Nexus</span>
                            </div>
                            <p className="text-gray-400 mb-6 leading-relaxed">
                                Transforming businesses through next-generation technology solutions and strategic innovation.
                            </p>
                            <div className="flex space-x-4">
                                <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                    <span className="sr-only">Twitter</span>
                                    <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                    <span className="sr-only">LinkedIn</span>
                                    <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                                <a href="#" className="text-gray-400 hover:text-white transition-colors">
                                    <span className="sr-only">GitHub</span>
                                    <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h4 className="font-semibold mb-6 text-lg">Product</h4>
                            <ul className="space-y-3 text-gray-400">
                                <li><a href="#" className="hover:text-white transition-colors">Features</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Integrations</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">API</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Security</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Pricing</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 className="font-semibold mb-6 text-lg">Company</h4>
                            <ul className="space-y-3 text-gray-400">
                                <li><a href="#" className="hover:text-white transition-colors">About</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Careers</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Blog</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Press</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Partners</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 className="font-semibold mb-6 text-lg">Support</h4>
                            <ul className="space-y-3 text-gray-400">
                                <li><a href="#" className="hover:text-white transition-colors">Help Center</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Contact Us</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Status</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Privacy Policy</a></li>
                                <li><a href="#" className="hover:text-white transition-colors">Terms of Service</a></li>
                            </ul>
                        </div>
                    </div>

                    <div className="border-t border-gray-800 pt-8">
                        <div className="flex flex-col md:flex-row justify-between items-center">
                            <p className="text-gray-400 text-sm">
                                &copy; 2024 Nexus. All rights reserved.
                            </p>
                            <div className="flex space-x-6 mt-4 md:mt-0">
                                <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Privacy</a>
                                <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Terms</a>
                                <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Cookies</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            {/* Scroll to Top Button */}
            {showScrollTop && (
                <button
                    onClick={scrollToTop}
                    className="fixed bottom-8 right-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-4 rounded-full shadow-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 z-50 hover:scale-110"
                >
                    <ArrowUpIcon className="h-6 w-6" />
                </button>
            )}
        </div>
    );
};

// export default App2;