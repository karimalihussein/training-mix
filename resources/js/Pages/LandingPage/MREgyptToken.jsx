import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import {
    CheckIcon,
    StarIcon,
    ArrowUpIcon,
    WalletIcon,
    DocumentTextIcon,
    QuestionMarkCircleIcon,
    ShieldCheckIcon,
    FireIcon,
    ClockIcon,
} from '@heroicons/react/24/outline';

export default function MREgyptToken() {
    const [activeSection, setActiveSection] = useState('home');
    const [showScrollTop, setShowScrollTop] = useState(false);
    const [walletConnected, setWalletConnected] = useState(false);
    const [countdown, setCountdown] = useState({
        days: 7,
        hours: 0,
        minutes: 0,
        seconds: 0
    });
    const [flashTransactions, setFlashTransactions] = useState([]);
    const [showFlash, setShowFlash] = useState(false);

    // Presale end date (7 days from now)
    const presaleEndDate = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);

    // Countdown timer
    useEffect(() => {
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = presaleEndDate.getTime() - now;

            if (distance > 0) {
                setCountdown({
                    days: Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                    minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds: Math.floor((distance % (1000 * 60)) / 1000)
                });
            }
        }, 1000);

        return () => clearInterval(timer);
    }, []);

    // Simulate flash transactions
    useEffect(() => {
        const transactionInterval = setInterval(() => {
            const mockTransactions = [
                { address: '0x5AEc...FcA3', amount: '23.2K', eth: '0.0245', time: '1 sec ago' },
                { address: '0x8B2d...Ef7B', amount: '15.7K', eth: '0.0189', time: '3 sec ago' },
                { address: '0x3F9a...C2D1', amount: '45.1K', eth: '0.0523', time: '5 sec ago' },
                { address: '0x7E4b...A8F6', amount: '12.3K', eth: '0.0147', time: '8 sec ago' },
                { address: '0x1C8e...B5D9', amount: '67.8K', eth: '0.0789', time: '12 sec ago' },
            ];

            const randomTransaction = mockTransactions[Math.floor(Math.random() * mockTransactions.length)];

            setFlashTransactions(prev => {
                const newTransactions = [randomTransaction, ...prev.slice(0, 4)];
                return newTransactions;
            });

            setShowFlash(true);
            setTimeout(() => setShowFlash(false), 3000);
        }, 4000);

        return () => clearInterval(transactionInterval);
    }, []);

    // Smooth scroll to section
    const scrollToSection = (sectionId) => {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            setActiveSection(sectionId);
        }
    };

    // Handle scroll events
    useEffect(() => {
        const handleScroll = () => {
            setShowScrollTop(window.scrollY > 500);

            const sections = ['home', 'staking', 'about', 'how-to-buy', 'tokenomics', 'faqs', 'whitepaper'];
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

    // Connect wallet function
    const connectWallet = () => {
        setWalletConnected(true);
        setTimeout(() => {
            scrollToSection('how-to-buy');
        }, 500);
    };

    // Buy token function
    const buyToken = () => {
        if (!walletConnected) {
            connectWallet();
            return;
        }
        alert('Connecting to MetaMask for purchase...');
    };

    const navigation = [
        { name: 'Home', id: 'home' },
        { name: 'Staking', id: 'staking' },
        { name: 'About', id: 'about' },
        { name: 'How to Buy', id: 'how-to-buy' },
        { name: 'Tokenomics', id: 'tokenomics' },
        { name: 'FAQ', id: 'faqs' },
        { name: 'Whitepaper', id: 'whitepaper' },
    ];

    const tokenomics = [
        { name: 'Presale', percentage: 40, color: 'bg-blue-500' },
        { name: 'Liquidity', percentage: 25, color: 'bg-green-500' },
        { name: 'Team', percentage: 15, color: 'bg-purple-500' },
        { name: 'Marketing', percentage: 10, color: 'bg-yellow-500' },
        { name: 'Development', percentage: 10, color: 'bg-red-500' },
    ];

    const faqs = [
        {
            question: 'What is $MR Egypt Token?',
            answer: '$MR Egypt Token is a revolutionary cryptocurrency designed to support Egypt\'s digital economy and provide innovative financial solutions for the region.'
        },
        {
            question: 'How can I participate in the presale?',
            answer: 'Connect your MetaMask wallet, ensure you have ETH or USDT, and click the "Buy Now" button to participate in the presale.'
        },
        {
            question: 'What are the staking rewards?',
            answer: 'Stake your $MR Egypt tokens to earn up to 25% APY. The longer you stake, the higher your rewards.'
        },
        {
            question: 'When will trading begin?',
            answer: 'Trading will begin immediately after the presale ends. The exact date is shown in the countdown timer above.'
        },
        {
            question: 'Is the smart contract audited?',
            answer: 'Yes, our smart contract has been thoroughly audited by leading security firms to ensure maximum safety for our investors.'
        },
    ];

    return (
        <>
            <Head>
                <title>MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN | Presale Live</title>
                <meta name="description" content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now and be part of Egypt's digital revolution. High staking rewards up to 25% APY." />
                <meta name="keywords" content="MR Egypt Token, cryptocurrency, presale, staking, Egypt, blockchain, tokenomics" />
                <meta property="og:title" content="MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN" />
                <meta property="og:description" content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now and be part of Egypt's digital revolution." />
                <meta property="og:type" content="website" />
                <meta property="og:image" content="/mr-egypt-token-og.jpg" />
                <meta name="twitter:card" content="summary_large_image" />
                <meta name="twitter:title" content="MR Egypt Token - LAST CHANCE TO BUY $MR Egypt TOKEN" />
                <meta name="twitter:description" content="Don't miss the LAST CHANCE to buy $MR Egypt Token! Join the presale now." />
            </Head>

            {/* Flash Transaction Notifications */}
            {showFlash && flashTransactions.length > 0 && (
                <div className="fixed top-20 right-4 z-50 space-y-2">
                    {flashTransactions.slice(0, 3).map((tx, index) => (
                        <div
                            key={index}
                            className="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg animate-slide-in-right"
                            style={{ animationDelay: `${index * 0.1}s` }}
                        >
                            <div className="flex items-center justify-between">
                                <span className="font-mono text-sm">{tx.address} • View Transaction</span>
                            </div>
                            <div className="text-xs mt-1">
                                Bought {tx.amount} $MR Egypt for {tx.eth} ETH • {tx.time}
                            </div>
                        </div>
                    ))}
                </div>
            )}

            {/* Navigation */}
            <nav className="fixed top-0 w-full bg-gray-900/95 backdrop-blur-md z-40 border-b border-gray-700">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <h1 className="text-2xl font-bold text-blue-400">$MR Egypt</h1>
                            </div>
                        </div>
                        <div className="hidden md:block">
                            <div className="ml-10 flex items-baseline space-x-4">
                                {navigation.map((item) => (
                                    <button
                                        key={item.id}
                                        onClick={() => scrollToSection(item.id)}
                                        className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${activeSection === item.id
                                            ? 'text-blue-400 bg-blue-900/50'
                                            : 'text-gray-300 hover:text-blue-400 hover:bg-blue-900/30'
                                            }`}
                                    >
                                        {item.name}
                                    </button>
                                ))}
                            </div>
                        </div>
                        <div className="flex items-center space-x-4">
                            <button
                                onClick={connectWallet}
                                className={`px-4 py-2 rounded-lg font-semibold transition-colors ${walletConnected
                                    ? 'bg-green-600 text-white'
                                    : 'bg-blue-600 text-white hover:bg-blue-700'
                                    }`}
                            >
                                <WalletIcon className="h-4 w-4 inline mr-2" />
                                {walletConnected ? 'Connected' : 'Connect Wallet'}
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section id="home" className="pt-16 bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 min-h-screen flex items-center">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div className="text-center">
                        {/* Logo */}
                        <div className="mb-8">
                            <div className="w-24 h-24 mx-auto bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mb-4">
                                <span className="text-2xl font-bold text-white">MR</span>
                            </div>
                            <h1 className="text-6xl md:text-8xl font-bold text-white mb-4">
                                $MR Egypt
                            </h1>
                        </div>

                        {/* Main Headline */}
                        <h2 className="text-3xl md:text-5xl font-bold text-red-400 mb-8 animate-pulse">
                            LAST CHANCE TO BUY $MR Egypt TOKEN
                        </h2>

                        {/* Countdown Timer */}
                        <div className="mb-12">
                            <div className="text-white text-lg mb-4">Presale Ends In:</div>
                            <div className="flex justify-center space-x-4 md:space-x-8">
                                {Object.entries(countdown).map(([unit, value]) => (
                                    <div key={unit} className="text-center">
                                        <div className="bg-gray-800 rounded-lg p-4 min-w-[80px]">
                                            <div className="text-3xl md:text-4xl font-bold text-blue-400">
                                                {value.toString().padStart(2, '0')}
                                            </div>
                                            <div className="text-sm text-gray-400 capitalize">
                                                {unit}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* CTA Buttons */}
                        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                            <button
                                onClick={buyToken}
                                className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-xl hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 shadow-lg"
                            >
                                <FireIcon className="h-6 w-6 inline mr-2" />
                                Buy Now
                            </button>
                            <button
                                onClick={() => scrollToSection('whitepaper')}
                                className="border-2 border-blue-400 text-blue-400 px-12 py-4 rounded-lg font-bold text-xl hover:bg-blue-400 hover:text-gray-900 transition-all"
                            >
                                <DocumentTextIcon className="h-6 w-6 inline mr-2" />
                                Whitepaper
                            </button>
                        </div>

                        {/* Live Transactions */}
                        <div className="bg-gray-800/50 rounded-lg p-6 max-w-2xl mx-auto">
                            <h3 className="text-white text-lg font-semibold mb-4 flex items-center">
                                <FireIcon className="h-5 w-5 mr-2 text-red-400" />
                                Live Transactions
                            </h3>
                            <div className="space-y-2">
                                {flashTransactions.slice(0, 3).map((tx, index) => (
                                    <div key={index} className="flex justify-between items-center text-sm">
                                        <span className="text-gray-300 font-mono">{tx.address}</span>
                                        <span className="text-green-400">{tx.amount} $MR Egypt</span>
                                        <span className="text-blue-400">{tx.eth} ETH</span>
                                        <span className="text-gray-400">{tx.time}</span>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Staking Section */}
            <section id="staking" className="py-24 bg-gray-800">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
                            Earn Up to <span className="text-green-400">25% APY</span>
                        </h2>
                        <p className="text-xl text-gray-300 max-w-3xl mx-auto">
                            Stake your $MR Egypt tokens and earn passive income. The longer you stake, the higher your rewards.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-3 gap-8">
                        <div className="bg-gray-700 rounded-lg p-8 text-center">
                            <div className="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <ClockIcon className="h-8 w-8 text-white" />
                            </div>
                            <h3 className="text-2xl font-bold text-white mb-2">30 Days</h3>
                            <p className="text-3xl font-bold text-green-400 mb-4">15% APY</p>
                            <p className="text-gray-300">Perfect for short-term staking</p>
                        </div>

                        <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-center transform scale-105">
                            <div className="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                                <StarIcon className="h-8 w-8 text-blue-600" />
                            </div>
                            <h3 className="text-2xl font-bold text-white mb-2">90 Days</h3>
                            <p className="text-3xl font-bold text-yellow-300 mb-4">25% APY</p>
                            <p className="text-white">Most popular staking option</p>
                        </div>

                        <div className="bg-gray-700 rounded-lg p-8 text-center">
                            <div className="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <ShieldCheckIcon className="h-8 w-8 text-white" />
                            </div>
                            <h3 className="text-2xl font-bold text-white mb-2">180 Days</h3>
                            <p className="text-3xl font-bold text-green-400 mb-4">20% APY</p>
                            <p className="text-gray-300">Long-term commitment rewards</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* About Section */}
            <section id="about" className="py-24 bg-gray-900">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                                About <span className="text-blue-400">$MR Egypt</span>
                            </h2>
                            <p className="text-xl text-gray-300 mb-6">
                                $MR Egypt Token is a revolutionary cryptocurrency designed to support Egypt's digital economy
                                and provide innovative financial solutions for the region.
                            </p>
                            <div className="space-y-4">
                                <div className="flex items-center">
                                    <CheckIcon className="h-6 w-6 text-green-400 mr-3" />
                                    <span className="text-gray-300">Audited smart contract for maximum security</span>
                                </div>
                                <div className="flex items-center">
                                    <CheckIcon className="h-6 w-6 text-green-400 mr-3" />
                                    <span className="text-gray-300">High staking rewards up to 25% APY</span>
                                </div>
                                <div className="flex items-center">
                                    <CheckIcon className="h-6 w-6 text-green-400 mr-3" />
                                    <span className="text-gray-300">Transparent tokenomics and team</span>
                                </div>
                                <div className="flex items-center">
                                    <CheckIcon className="h-6 w-6 text-green-400 mr-3" />
                                    <span className="text-gray-300">Community-driven development</span>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8">
                            <h3 className="text-2xl font-bold text-white mb-4">Our Mission</h3>
                            <p className="text-white mb-6">
                                To revolutionize Egypt's financial landscape by providing accessible, secure,
                                and profitable cryptocurrency solutions that empower individuals and businesses.
                            </p>
                            <div className="grid grid-cols-2 gap-4">
                                <div className="text-center">
                                    <div className="text-3xl font-bold text-white">1M+</div>
                                    <div className="text-gray-200">Target Users</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-3xl font-bold text-white">$50M</div>
                                    <div className="text-gray-200">Market Cap Goal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* How to Buy Section */}
            <section id="how-to-buy" className="py-24 bg-gray-800">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
                            How to Buy <span className="text-blue-400">$MR Egypt</span>
                        </h2>
                        <p className="text-xl text-gray-300 max-w-3xl mx-auto">
                            Follow these simple steps to join the $MR Egypt presale and secure your tokens.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-4 gap-8">
                        <div className="text-center">
                            <div className="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white">
                                1
                            </div>
                            <h3 className="text-xl font-bold text-white mb-2">Connect Wallet</h3>
                            <p className="text-gray-300">Install MetaMask and connect your wallet to our platform</p>
                        </div>

                        <div className="text-center">
                            <div className="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white">
                                2
                            </div>
                            <h3 className="text-xl font-bold text-white mb-2">Add ETH/USDT</h3>
                            <p className="text-gray-300">Ensure you have enough ETH or USDT in your wallet</p>
                        </div>

                        <div className="text-center">
                            <div className="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white">
                                3
                            </div>
                            <h3 className="text-xl font-bold text-white mb-2">Enter Amount</h3>
                            <p className="text-gray-300">Choose how many $MR Egypt tokens you want to purchase</p>
                        </div>

                        <div className="text-center">
                            <div className="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold text-white">
                                4
                            </div>
                            <h3 className="text-xl font-bold text-white mb-2">Confirm Purchase</h3>
                            <p className="text-gray-300">Review and confirm your transaction in MetaMask</p>
                        </div>
                    </div>

                    <div className="text-center mt-12">
                        <button
                            onClick={buyToken}
                            className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-xl hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105"
                        >
                            <WalletIcon className="h-6 w-6 inline mr-2" />
                            {walletConnected ? 'Buy $MR Egypt Now' : 'Connect Wallet & Buy'}
                        </button>
                    </div>
                </div>
            </section>

            {/* Tokenomics Section */}
            <section id="tokenomics" className="py-24 bg-gray-900">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
                            <span className="text-blue-400">$MR Egypt</span> Tokenomics
                        </h2>
                        <p className="text-xl text-gray-300 max-w-3xl mx-auto">
                            Transparent token distribution designed for long-term growth and community rewards.
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <div className="space-y-6">
                                {tokenomics.map((item, index) => (
                                    <div key={index} className="flex items-center justify-between">
                                        <div className="flex items-center">
                                            <div className={`w-4 h-4 ${item.color} rounded-full mr-4`}></div>
                                            <span className="text-white font-semibold">{item.name}</span>
                                        </div>
                                        <span className="text-blue-400 font-bold text-xl">{item.percentage}%</span>
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div className="bg-gray-800 rounded-lg p-8">
                            <h3 className="text-2xl font-bold text-white mb-6">Token Details</h3>
                            <div className="space-y-4">
                                <div className="flex justify-between">
                                    <span className="text-gray-300">Total Supply:</span>
                                    <span className="text-white font-bold">1,000,000,000 $MR Egypt</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-300">Presale Price:</span>
                                    <span className="text-white font-bold">1 ETH = 40,000 $MR Egypt</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-300">Listing Price:</span>
                                    <span className="text-white font-bold">1 ETH = 35,000 $MR Egypt</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-300">Min Buy:</span>
                                    <span className="text-white font-bold">0.01 ETH</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-300">Max Buy:</span>
                                    <span className="text-white font-bold">5 ETH</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* FAQ Section */}
            <section id="faqs" className="py-24 bg-gray-800">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold text-white mb-4">
                            Frequently Asked Questions
                        </h2>
                        <p className="text-xl text-gray-300">
                            Everything you need to know about $MR Egypt Token
                        </p>
                    </div>

                    <div className="space-y-6">
                        {faqs.map((faq, index) => (
                            <div key={index} className="bg-gray-700 rounded-lg p-6">
                                <h3 className="text-xl font-bold text-white mb-3 flex items-center">
                                    <QuestionMarkCircleIcon className="h-6 w-6 mr-3 text-blue-400" />
                                    {faq.question}
                                </h3>
                                <p className="text-gray-300">{faq.answer}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Whitepaper Section */}
            <section id="whitepaper" className="py-24 bg-gray-900">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
                        Download <span className="text-blue-400">Whitepaper</span>
                    </h2>
                    <p className="text-xl text-gray-300 mb-8">
                        Learn more about our technology, roadmap, and vision for the future of $MR Egypt Token.
                    </p>
                    <button className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-xl hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105">
                        <DocumentTextIcon className="h-6 w-6 inline mr-2" />
                        Download Whitepaper (PDF)
                    </button>
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-900 border-t border-gray-700">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="grid md:grid-cols-4 gap-8">
                        <div>
                            <h3 className="text-2xl font-bold text-blue-400 mb-4">$MR Egypt</h3>
                            <p className="text-gray-300">
                                Revolutionizing Egypt's digital economy with innovative blockchain solutions.
                            </p>
                        </div>
                        <div>
                            <h4 className="text-white font-semibold mb-4">Quick Links</h4>
                            <ul className="space-y-2">
                                {navigation.map((item) => (
                                    <li key={item.id}>
                                        <button
                                            onClick={() => scrollToSection(item.id)}
                                            className="text-gray-300 hover:text-blue-400 transition-colors"
                                        >
                                            {item.name}
                                        </button>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-white font-semibold mb-4">Legal</h4>
                            <ul className="space-y-2">
                                <li><a href="#terms" className="text-gray-300 hover:text-blue-400 transition-colors">Terms of Service</a></li>
                                <li><a href="#privacy" className="text-gray-300 hover:text-blue-400 transition-colors">Privacy Policy</a></li>
                                <li><a href="#cookies" className="text-gray-300 hover:text-blue-400 transition-colors">Cookies Policy</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-white font-semibold mb-4">Connect</h4>
                            <div className="space-y-2">
                                <p className="text-gray-300">Email: info@mregypt.com</p>
                                <p className="text-gray-300">Telegram: @MREgyptToken</p>
                                <p className="text-gray-300">Twitter: @MREgyptToken</p>
                            </div>
                        </div>
                    </div>
                    <div className="border-t border-gray-700 mt-8 pt-8 text-center">
                        <p className="text-gray-300">
                            © 2024 $MR Egypt Token. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>

            {/* Scroll to Top Button */}
            {showScrollTop && (
                <button
                    onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                    className="fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors z-50"
                >
                    <ArrowUpIcon className="h-6 w-6" />
                </button>
            )}
        </>
    );
} 