"use client";

import { motion } from "framer-motion";
import { ChefHat, Flame, Users } from "lucide-react";

export default function CeritaKami() {
  const features = [
    { icon: ChefHat, title: "Resep Warisan", desc: "Dijaga dari generasi ke generasi sejak 1950" },
    { icon: Flame, title: "Memasak Manual", desc: "Dimasak dengan api tradisional setiap hari" },
    { icon: Users, title: "Tim Profesional", desc: "Masak-masak berpengalaman 20+ tahun" },
  ];

  return (
    <section id="cerita" className="py-20 bg-background">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="grid lg:grid-cols-2 gap-12 items-center"
        >
          <div>
            <span className="text-songket-red font-medium tracking-wide uppercase text-sm">
              Tentang Raso Minang
            </span>
            <h2 className="text-3xl md:text-4xl font-serif font-bold text-foreground mt-3 mb-6">
              Warisan Rasa Otentik{" "}
              <span className="text-songket-red italic">Minangkabau</span>
            </h2>
            <p className="text-foreground/70 leading-relaxed mb-4">
              Berawal dari sebuah kedai kecil di Bukittinggi pada tahun 1950, 
              Raso Minang telah menjadi saksi perjalanan cita rasa masakan Padang 
              yang autentik dan otentik.
            </p>
            <p className="text-foreground/70 leading-relaxed mb-6">
              Setiap hidangan kami dibuat dengan resep warisan keluarga yang telah 
              dijaga selama lebih dari 7 dekade. Rempah-rempah pilihan langsung 
              dari Sumatera Barat, dimasak dengan teknik tradisional menggunakan 
              arang kayu.
            </p>
            <div className="grid grid-cols-3 gap-6">
              {features.map((f, i) => (
                <div key={i} className="text-center p-4">
                  <f.icon className="w-8 h-8 text-songket-gold mx-auto mb-2" />
                  <h4 className="font-semibold text-sm mb-1">{f.title}</h4>
                  <p className="text-xs text-foreground/60">{f.desc}</p>
                </div>
              ))}
            </div>
          </div>
          <motion.div
            initial={{ opacity: 0, x: 30 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
            className="relative"
          >
            <img
              src="https://images.unsplash.com/photo-1604152135912-04a12fc6b9c1?w=600&q=80"
              alt="Warisan Raso Minang"
              className="rounded-xl shadow-xl w-full"
            />
            <div className="absolute -bottom-6 -left-6 bg-white p-6 rounded-xl shadow-lg max-w-xs">
              <div className="text-3xl font-bold text-songket-red mb-1">73+</div>
              <div className="text-sm text-foreground/70">Tahun Menjaga Kualitas & Rasa</div>
            </div>
          </motion.div>
        </motion.div>
      </div>
    </section>
  );
}