"use client";

import { useState } from "react";
import { motion } from "framer-motion";
import MenuCard from "./MenuCard";
import { MenuItem } from "@/types";

const categories = [
  { id: "all", name: "Semua" },
  { id: "nasi-padang", name: "Nasi Padang" },
  { id: "daging", name: "Daging" },
  { id: "ayam", name: "Ayam" },
  { id: "ikan", name: "Ikan" },
  { id: "sayur", name: "Sayur & Sambal" },
  { id: "minuman", name: "Minuman" },
];

const menuItems: MenuItem[] = [
  { id: 1, nama: "Nasi Rendang Sapi", kategori: "daging", deskripsi: "Nasi dengan rendang sapi asli Minang yang dimasak dengan rempah pilihan selama 8 jam.", foto: "https://images.unsplash.com/photo-1565557628821-2b6a3f3c2d6e?w=400&q=80", badge: "Signature", rating: 4.9, harga: 35000 },
  { id: 2, nama: "Nasi Ayam Pop", kategori: "ayam", deskripsi: "Ayam pop khas Padang yang lembut dan dibumbui santan serta rempah tradisional.", foto: "https://images.unsplash.com/photo-1598103452416-9554604aa204?w=400&q=80", badge: "Favorit", rating: 4.8, harga: 28000 },
  { id: 3, nama: "Nasi Ikan Patin Gulai", kategori: "ikan", deskripsi: "Ikan patin sungai dengan gulai kental khas Sumatera Barat.", foto: "https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=400&q=80", rating: 4.7, harga: 32000 },
  { id: 4, nama: "Nasi Daging Sunda", kategori: "daging", deskripsi: "Daging sapi muda dengan bumbu gulai yang gurih dan kaya rempah.", foto: "https://images.unsplash.com/photo-1547496512-09bbec1e70ce?w=400&q=80", rating: 4.6, harga: 30000 },
  { id: 5, nama: "Nasi Telur Balado", kategori: "ayam", deskripsi: "Telur ayam kampung dengan balado merah pedas manis khas Minang.", foto: "https://images.unsplash.com/photo-1516684732072-2c9c5ad3e2fc?w=400&q=80", badge: "Baru", rating: 4.7, harga: 25000 },
  { id: 6, nama: "Gancho Sayuran", kategori: "sayur", deskripsi: "Campuran sayuran segar dengan kuah gulai yang menyegarkan.", foto: "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&q=80", rating: 4.5, harga: 22000 },
  { id: 7, nama: "Es Teh Manis", kategori: "minuman", deskripsi: "Teh manis dingin yang menyegarkan untuk menemani makan Anda.", foto: "https://images.unsplash.com/photo-1556679343-c7306c1976bd?w=400&q=80", rating: 4.6, harga: 8000 },
  { id: 8, nama: "Air Keluar Muda", kategori: "minuman", deskripsi: "Air kelapa muda segar langsung dari buah.", foto: "https://images.unsplash.com/photo-1525686463730-8ed935685606?w=400&q=80", rating: 4.8, harga: 12000 },
];

export default function MenuSection() {
  const [selectedCategory, setSelectedCategory] = useState("all");
  const [searchQuery, setSearchQuery] = useState("");

  const filteredItems = menuItems.filter((item) => {
    const matchesCategory = selectedCategory === "all" || item.kategori === selectedCategory;
    const matchesSearch = item.nama.toLowerCase().includes(searchQuery.toLowerCase());
    return matchesCategory && matchesSearch;
  });

  const handleAddToCart = (item: MenuItem) => {
    alert(`${item.nama} added to cart!`);
  };

  return (
    <section id="menu" className="py-20 bg-background">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.5 }} className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-serif font-bold text-foreground mb-4">Menu Kami</h2>
          <p className="text-foreground/70 max-w-2xl mx-auto leading-relaxed">Pilih dari berbagai hidangan autentik Padang yang dibuat setiap hari dengan bahan-bahan terbaik.</p>
        </motion.div>

        <div className="flex flex-wrap items-center justify-center gap-3 mb-12">
          {categories.map((category) => (
            <motion.button key={category.id} whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }} onClick={() => setSelectedCategory(category.id)} className={`px-5 py-2.5 rounded-full text-sm font-medium transition-all ${selectedCategory === category.id ? "bg-songket-red text-white shadow-lg" : "bg-white text-foreground hover:bg-songket-gold/20 border border-foreground/10"}`}>
              {category.name}
            </motion.button>
          ))}
        </div>

        <div className="max-w-md mx-auto mb-12">
          <input type="text" placeholder="Cari menu..." value={searchQuery} onChange={(e) => setSearchQuery(e.target.value)} className="w-full px-5 py-3 rounded-lg border border-foreground/20 focus:border-songket-red focus:ring-2 focus:ring-songket-red/20 outline-none transition-all" />
        </div>

        {filteredItems.length > 0 ? (
          <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ duration: 0.5 }} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {filteredItems.map((item) => (
              <MenuCard key={item.id} item={item} onAddToCart={handleAddToCart} />
            ))}
          </motion.div>
        ) : (
          <div className="text-center py-16"><p className="text-foreground/60 text-lg">Tidak ada menu yang cocok dengan pencarian Anda.</p></div>
        )}
      </div>
    </section>
  );
}