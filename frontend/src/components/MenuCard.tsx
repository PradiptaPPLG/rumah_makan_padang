"use client";

import { motion } from "framer-motion";
import { ShoppingCart, Star } from "lucide-react";
import { MenuItem } from "@/types";

interface MenuCardProps {
  item: MenuItem;
  onAddToCart: (item: MenuItem) => void;
}

export default function MenuCard({ item, onAddToCart }: MenuCardProps) {
  const formatRupiah = (price: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(price);
  };

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      whileHover={{ y: -5 }}
      className="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all overflow-hidden group"
    >
      {/* Image */}
      <div className="relative aspect-video overflow-hidden">
        <img
          src={item.foto}
          alt={item.nama}
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
        />
        {item.badge && (
          <span
            className={`absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full ${
              item.badge === "Signature"
                ? "bg-songket-red text-white"
                : item.badge === "Favorit"
                ? "bg-songket-gold text-foreground"
                : "bg-green-500 text-white"
            }`}
          >
            {item.badge}
          </span>
        )}
      </div>

      {/* Content */}
      <div className="p-5 space-y-3">
        <div className="flex items-start justify-between gap-2">
          <h3 className="font-serif font-bold text-lg text-foreground line-clamp-1">
            {item.nama}
          </h3>
          <div className="flex items-center space-x-1 flex-shrink-0">
            <Star className="w-4 h-4 text-songket-gold fill-songket-gold" />
            <span className="text-sm font-medium">{item.rating}</span>
          </div>
        </div>

        <p className="text-sm text-foreground/70 line-clamp-2 leading-relaxed">
          {item.deskripsi}
        </p>

        <div className="pt-3 border-t border-foreground/10">
          <div className="flex items-end justify-between">
            <div>
              <span className="text-xs text-foreground/60">Harga</span>
              <div className="text-xl font-bold text-songket-red">
                {formatRupiah(item.harga)}
              </div>
            </div>
            <motion.button
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              onClick={() => onAddToCart(item)}
              className="flex items-center space-x-2 bg-songket-red text-white px-4 py-2.5 rounded-lg hover:bg-songket-dark transition-colors"
            >
              <ShoppingCart className="w-4 h-4" />
              <span className="font-medium">Tambah</span>
            </motion.button>
          </div>
        </div>
      </div>
    </motion.div>
  );
}