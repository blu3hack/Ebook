import React, { useState, useEffect } from "react";
import { Head, Link } from "@inertiajs/react";

export default function LandingPage() {
    const [scrolled, setScrolled] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 50);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white overflow-hidden">
            {/* Animated Background */}
            <div className="fixed inset-0 overflow-hidden pointer-events-none">
                <div className="absolute -top-1/2 -left-1/2 w-full h-full bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div
                    className="absolute -bottom-1/2 -right-1/2 w-full h-full bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
                    style={{ animationDelay: "2s" }}
                ></div>
            </div>

            {/* Navigation */}
            <nav
                className={`fixed w-full z-50 transition-all duration-300 ${
                    scrolled ? "bg-slate-900/80 backdrop-blur-lg shadow-lg" : ""
                }`}
            >
                <div className="max-w-7xl mx-auto px-6 py-4">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg"></div>
                            <span className="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                                Nexus
                            </span>
                        </div>

                        <div className="flex items-center space-x-4">
                            <Link
                                href="/login"
                                className="px-6 py-2 rounded-lg hover:bg-white/10 transition-all backdrop-blur-sm"
                            >
                                Login
                            </Link>
                            <Link
                                href="/register"
                                className="px-6 py-2 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg hover:shadow-lg hover:shadow-purple-500/50 transition-all transform hover:scale-105"
                            >
                                Register
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="relative pt-40 pb-20 px-6">
                <div className="max-w-7xl mx-auto">
                    <div className="text-center space-y-8">
                        <h1 className="text-5xl md:text-7xl font-bold leading-tight">
                            Welcome to the
                            <span className="block bg-gradient-to-r from-purple-400 via-pink-400 to-blue-400 bg-clip-text text-transparent">
                                Future of Innovation
                            </span>
                        </h1>
                        <p className="text-xl text-gray-300 max-w-2xl mx-auto">
                            Transform your ideas into reality with our
                            cutting-edge platform. Fast, secure, and incredibly
                            powerful.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <Link
                                href="/register"
                                className="group px-8 py-4 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg text-lg font-semibold hover:shadow-2xl hover:shadow-purple-500/50 transition-all transform hover:scale-105 flex items-center gap-2"
                            >
                                Mulai
                            </Link>
                            <button className="px-8 py-4 bg-white/10 backdrop-blur-lg rounded-lg text-lg font-semibold border border-white/20 hover:bg-white/20 transition-all">
                                Learn More
                            </button>
                        </div>
                    </div>

                    {/* Glass Card Hero */}
                    <div className="mt-20 relative">
                        <div className="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                            <div className="grid md:grid-cols-3 gap-8">
                                <div className="text-center space-y-3">
                                    <div className="bg-purple-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto backdrop-blur-lg">
                                        <span className="text-3xl">⚡</span>
                                    </div>
                                    <h3 className="text-xl font-semibold">
                                        Lightning Fast
                                    </h3>
                                    <p className="text-gray-300">
                                        Optimized for speed and performance
                                    </p>
                                </div>
                                <div className="text-center space-y-3">
                                    <div className="bg-blue-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto backdrop-blur-lg">
                                        <span className="text-3xl">🛡️</span>
                                    </div>
                                    <h3 className="text-xl font-semibold">
                                        Secure & Safe
                                    </h3>
                                    <p className="text-gray-300">
                                        Enterprise-grade security built-in
                                    </p>
                                </div>
                                <div className="text-center space-y-3">
                                    <div className="bg-pink-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto backdrop-blur-lg">
                                        <span className="text-3xl">✨</span>
                                    </div>
                                    <h3 className="text-xl font-semibold">
                                        Beautiful UI
                                    </h3>
                                    <p className="text-gray-300">
                                        Stunning design that users love
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section className="py-20 px-6">
                <div className="max-w-7xl mx-auto">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-5xl font-bold mb-4">
                            Powerful Features
                        </h2>
                        <p className="text-gray-300 text-lg">
                            Everything you need to succeed
                        </p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {[
                            {
                                icon: "🚀",
                                title: "Fast Performance",
                                desc: "Lightning-fast load times and smooth interactions",
                            },
                            {
                                icon: "🎨",
                                title: "Modern Design",
                                desc: "Beautiful and intuitive user interface",
                            },
                            {
                                icon: "🔒",
                                title: "Secure Data",
                                desc: "Your data is protected with top-tier encryption",
                            },
                            {
                                icon: "📱",
                                title: "Responsive",
                                desc: "Works perfectly on all devices and screen sizes",
                            },
                            {
                                icon: "⚙️",
                                title: "Easy Setup",
                                desc: "Get started in minutes with simple configuration",
                            },
                            {
                                icon: "💎",
                                title: "Premium Quality",
                                desc: "Built with the latest technologies and best practices",
                            },
                        ].map((item, index) => (
                            <div
                                key={index}
                                className="bg-white/5 backdrop-blur-lg rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-purple-500/50 transition-all duration-300 group"
                            >
                                <div className="text-4xl mb-4 group-hover:scale-110 transition-transform inline-block">
                                    {item.icon}
                                </div>
                                <h3 className="text-xl font-semibold mb-2">
                                    {item.title}
                                </h3>
                                <p className="text-gray-400">{item.desc}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Stats Section */}
            <section className="py-20 px-6">
                <div className="max-w-7xl mx-auto">
                    <div className="bg-white/5 backdrop-blur-lg rounded-3xl p-12 border border-white/10">
                        <div className="grid md:grid-cols-3 gap-8 text-center">
                            <div>
                                <div className="text-5xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-2">
                                    10K+
                                </div>
                                <p className="text-gray-300">Active Users</p>
                            </div>
                            <div>
                                <div className="text-5xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-2">
                                    99.9%
                                </div>
                                <p className="text-gray-300">Uptime</p>
                            </div>
                            <div>
                                <div className="text-5xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent mb-2">
                                    24/7
                                </div>
                                <p className="text-gray-300">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="py-20 px-6">
                <div className="max-w-4xl mx-auto">
                    <div className="bg-gradient-to-r from-purple-500/20 to-blue-500/20 backdrop-blur-lg rounded-3xl p-12 border border-white/20 text-center space-y-6">
                        <h2 className="text-4xl md:text-5xl font-bold">
                            Ready to Get Started?
                        </h2>
                        <p className="text-xl text-gray-300">
                            Join thousands of users who trust our platform
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <button className="px-8 py-4 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg text-lg font-semibold hover:shadow-2xl hover:shadow-purple-500/50 transition-all transform hover:scale-105">
                                Register Now
                            </button>
                            <button className="px-8 py-4 bg-white/10 backdrop-blur-lg rounded-lg text-lg font-semibold border border-white/20 hover:bg-white/20 transition-all">
                                Contact Sales
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="py-12 px-6 border-t border-white/10">
                <div className="max-w-7xl mx-auto text-center text-gray-400">
                    <p>&copy; 2025 Nexus. All rights reserved.</p>
                </div>
            </footer>
        </div>
    );
}
