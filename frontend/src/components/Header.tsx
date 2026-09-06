"use client";

import { useState, useEffect } from "react";
import { motion } from "framer-motion";
import { ShoppingBag, Search, Menu, X, MapPin } from "lucide-react";

export default function Header() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [cartCount, setCartCount] = useState(0);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  return (
    <header
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled
          ? "bg-background/95 backdrop-blur-md shadow-lg"
          : "bg-transparent"
      }`}
    >
      <nav className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16 lg:h-20">
          {/* Logo */}
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.5 }}
            className="flex items-center space-x-2"
          >
            <span className="text-2xl lg:text-3xl font-serif font-bold text-songket-red">
              Raso Minang
            </span>
          </motion.div>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center space-x-8">
            <a
              href="#menu"
              className="text-foreground hover:text-songket-red font-medium transition-colors relative group"
            >
              Menu
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-songket-red transition-all group-hover:w-full" />
            </a>
            <a
              href="#cerita"
              className="text-foreground hover:text-songket-red font-medium transition-colors relative group"
            >
              Cerita Kami
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-songket-red transition-all group-hover:w-full" />
            </a>
            <a
              href="#ulasan"
              className="text-foreground hover:text-songket-red font-medium transition-colors relative group"
            >
              Ulasan
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-songket-red transition-all group-hover:w-full" />
            </a>
            <button className="p-2 hover:bg-songket-gold/20 rounded-full transition-colors">
              <Search className="w-5 h-5" />
            </button>
            <motion.button
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              className="relative p-2 hover:bg-songket-gold/20 rounded-full transition-colors"
            >
              <ShoppingBag className="w-5 h-5" />
              {cartCount > 0 && (
                <span className="absolute -top-1 -right-1 bg-songket-red text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                  {cartCount}
                </span>
              )}
            </motion.button>
            <motion.button
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              className="bg-songket-red text-white px-5 py-2.5 rounded-lg font-medium hover:bg-songket-dark transition-colors"
            >
              Pesan Sekarang
            </motion.button>
          </div>

          {/* Mobile menu button */}
          <button
            onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            className="md:hidden p-2"
            aria-label="Toggle menu"
          >
            {isMobileMenuOpen ? (
              <X className="w-6 h-6" />
            ) : (
              <Menu className="w-6 h-6" />
            )}
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <motion.div
            initial={{ opacity: 0, y: -20 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20 }}
            className="md:hidden pb-4 space-y-4"
          >
            <a
              href="#menu"
              className="block text-foreground hover:text-songket-red font-medium py-2"
            >
              Menu
            </a>
            <a
              href="#cerita"
              className="block text-foreground hover:text-songket-red font-medium py-2"
            >
              Cerita Kami
            </a>
            <a
              href="#ulasan"
              className="block text-foreground hover:text-songket-red font-medium py-2"
            >
              Ulasan
            </a>
            <div className="flex items-center space-x-4 pt-4 border-t border-foreground/10">
              <button className="p-2 hover:bg-songket-gold/20 rounded-full">
                <Search className="w-5 h-5" />
              </button>
              <button className="relative p-2 hover:bg-songket-gold/20 rounded-full">
                <ShoppingBag className="w-5 h-5" />
                {cartCount > 0 && (
                  <span className="absolute -top-1 -right-1 bg-songket-red text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
                    {cartCount}
                  </span>
                )}
              </button>
            </div>
          </motion.div>
        )}
      </nav>
    </header>
  );
}
