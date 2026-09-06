"use client";

import { useState, useEffect } from "react";
import { motion } from "framer-motion";
import { MapPin } from "lucide-react";

const branches = [
  { id: 1, nama: "Raso Minang - Jakarta Selatan", kota: "Jakarta Selatan" },
  { id: 2, nama: "Raso Minang - Bandung", kota: "Bandung" },
  { id: 3, nama: "Raso Minang - Surabaya", kota: "Surabaya" },
  { id: 4, nama: "Raso Minang - Medan", kota: "Medan" },
  { id: 5, nama: "Raso Minang - Palembang", kota: "Palembang" },
  { id: 6, nama: "Raso Minang - Bukittinggi", kota: "Bukittinggi" },
];

export default function BranchSelector() {
  const [selectedBranch, setSelectedBranch] = useState<string>("");

  return (
    <section id="cabang" className="py-12 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="text-center mb-8"
        >
          <h2 className="text-3xl font-serif font-bold text-foreground mb-2">
            Pilih Cabang Terdekat
          </h2>
          <p className="text-foreground/70 max-w-2xl mx-auto">
            Raso Minang hadir di berbagai kota untuk convenience Anda. Harga dapat berbeda tergantung lokasi cabang.
          </p>
        </motion.div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
          {branches.map((branch, index) => (
            <motion.button
              key={branch.id}
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: index * 0.1, duration: 0.3 }}
              onClick={() => setSelectedBranch(branch.kota)}
              className={`p-4 rounded-xl border-2 transition-all ${
                selectedBranch === branch.kota
                  ? "border-songket-red bg-songket-red/5 text-songket-red"
                  : "border-foreground/10 hover:border-songket-gold/50 hover:bg-songket-gold/5"
              }`}
            >
              <MapPin className="w-5 h-5 mx-auto mb-2" />
              <span className="text-sm font-medium">{branch.kota}</span>
            </motion.button>
          ))}
        </div>

        {selectedBranch && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: "auto" }}
            transition={{ duration: 0.3 }}
            className="mt-8 p-6 bg-songket-gold/5 rounded-xl"
          >
            <h3 className="font-semibold text-lg mb-2">
              Anda memilih: {selectedBranch}
            </h3>
            <p className="text-foreground/70 text-sm">
              Menu dan harga akan disesuaikan untuk cabang {selectedBranch}. 
              Silakan scroll ke bawah untuk melihat pilihan menu.
            </p>
          </motion.div>
        )}
      </div>
    </section>
  );
}