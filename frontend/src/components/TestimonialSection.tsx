"use client";

import { motion } from "framer-motion";
import { Star } from "lucide-react";

const testimonials = [
  { name: "Ahmad Rizky", initial: "AR", rating: 5, comment: "Rendangnya juara! Rasa autentik banget, nggak kalah sama yang di Bukittinggi.", location: "Jakarta" },
  { name: "Siti Nurhaliza", initial: "SN", rating: 5, comment: "Sudah langganan dari tahun 2019. Kualitas konsisten, harga terjangkau.", location: "Bandung" },
  { name: "Budi Santoso", initial: "BS", rating: 4, comment: "Ayam popnya lembut dan gurih. Pelayanan cepat dan ramah.", location: "Surabaya" },
];

export default function TestimonialSection() {
  return (
    <section id="ulasan" className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="text-center mb-12"
        >
          <h2 className="text-3xl md:text-4xl font-serif font-bold text-foreground mb-4">
            Kata Mereka Tentang Kami
          </h2>
          <p className="text-foreground/70 max-w-2xl mx-auto leading-relaxed">
            Lebih dari 10,000 pelanggan puas dengan rasa otentik Raso Minang
          </p>
        </motion.div>

        <div className="grid md:grid-cols-3 gap-8">
          {testimonials.map((t, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: index * 0.2, duration: 0.5 }}
              className="bg-background p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow"
            >
              <div className="flex items-center gap-1 mb-4">
                {[...Array(t.rating)].map((_, i) => (
                  <Star key={i} className="w-5 h-5 text-songket-gold fill-songket-gold" />
                ))}
              </div>
              <p className="text-foreground/80 leading-relaxed mb-6 italic">"{t.comment}"</p>
              <div className="flex items-center justify-between">
                <div>
                  <div className="font-semibold">{t.name}</div>
                  <div className="text-sm text-foreground/60">{t.location}</div>
                </div>
                <div className="w-12 h-12 bg-songket-red/10 rounded-full flex items-center justify-center">
                  <span className="font-bold text-songket-red">{t.initial}</span>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}