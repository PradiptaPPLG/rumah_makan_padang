"use client";

import { motion } from "framer-motion";
import { Star, Users, Clock } from "lucide-react";

export default function Hero() {
  const stats = [
    { icon: Star, value: "4.8", label: "Rating Pelanggan" },
    { icon: Users, value: "50+", label: "Lauk Tiap Hari" },
    { icon: Clock, value: "73", label: "Tahun Berpengalaman" },
  ];

  return (
    <section className="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
      <div className="absolute inset-0 bg-gradient-to-br from-background via-songket-red/5 to-songket-gold/10" />
      <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-songket-gold/10 rounded-full blur-3xl" />
      <div className="absolute bottom-1/4 right-1/4 w-80 h-80 bg-songket-red/10 rounded-full blur-3xl" />

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <motion.div initial={{ opacity: 0, y: 30 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.8 }}>
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.2 }}>
              <span className="text-songket-red font-medium tracking-wide uppercase text-sm">Warisan Keluarga Sejak 1950</span>
            </motion.div>
            <motion.h1 initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.4 }} className="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-serif font-bold text-foreground leading-tight mt-4">
              Rasa Autentik{" "}
              <span className="text-songket-red italic">Minangkabau</span>{" "}
              dalam Setiap Gigitan
            </motion.h1>
            <motion.p initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.6 }} className="text-lg text-foreground/80 max-w-lg mx-auto lg:mx-0 leading-relaxed mt-6">
              Nikmati kelezatan masakan Padang asli dengan resep warisan leluhur yang telah dijaga selama lebih dari 7 dekade. Dari Sumatera Barat langsung ke meja Anda.
            </motion.p>
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 0.8 }} className="flex items-center justify-center lg:justify-start space-x-8 pt-4">
              {stats.map((stat, index) => (
                <div key={index} className="text-center lg:text-left">
                  <stat.icon className="w-5 h-5 mx-auto lg:mx-0 text-songket-gold mb-1" />
                  <div className="font-bold text-xl">{stat.value}</div>
                  <div className="text-sm text-foreground/70">{stat.label}</div>
                </div>
              ))}
            </motion.div>
            <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 1 }} className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-6">
              <motion.a href="#menu" whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }} className="bg-songket-red text-white px-8 py-4 rounded-lg font-semibold hover:bg-songket-dark transition-colors shadow-lg hover:shadow-xl text-center">
                Lihat Menu
              </motion.a>
              <motion.a href="#cabang" whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }} className="border-2 border-songket-red text-songket-red px-8 py-4 rounded-lg font-semibold hover:bg-songket-red hover:text-white transition-colors text-center">
                Makan di Tempat
              </motion.a>
            </motion.div>
          </motion.div>
          <motion.div initial={{ opacity: 0, x: 50 }} animate={{ opacity: 1, x: 0 }} transition={{ duration: 0.8, delay: 0.4 }} className="relative hidden lg:block">
            <div className="relative aspect-square max-w-md mx-auto">
              <div className="absolute inset-0 bg-gradient-to-tr from-songket-gold/20 to-songket-red/20 rounded-full blur-3xl" />
              <img src="https://images.unsplash.com/photo-1565557628821-2b6a3f3c2d6e?w=800&q=80" alt="Nasi Padang Autentik" className="relative z-10 rounded-2xl shadow-2xl object-cover w-full h-full" />
              <motion.div initial={{ opacity: 0, scale: 0.8 }} animate={{ opacity: 1, scale: 1 }} transition={{ delay: 1.2 }} className="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl z-20">
                <div className="flex items-center space-x-3">
                  <div className="w-12 h-12 bg-songket-gold/10 rounded-full flex items-center justify-center">
                    <Star className="w-6 h-6 text-songket-gold fill-songket-gold" />
                  </div>
                  <div>
                    <div className="font-bold text-lg">4.8</div>
                    <div className="text-sm text-foreground/70">Rating Total</div>
                  </div>
                </div>
              </motion.div>
            </div>
          </motion.div>
        </div>
      </div>
    </section>
  );
}