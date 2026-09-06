"use client";

import { useState } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { X, ShoppingBag, Plus, Minus, Trash2 } from "lucide-react";
import { CartItem } from "@/types";

const formatRupiah = (price: number) => new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", minimumFractionDigits: 0 }).format(price);

export default function CartDrawer() {
  const [isOpen, setIsOpen] = useState(false);
  const [cartItems, setCartItems] = useState<CartItem[]>([]);

  const removeFromCart = (itemId: number) => setCartItems(cartItems.filter((item) => item.id !== itemId));
  
  const updateQuantity = (itemId: number, delta: number) => {
    setCartItems(cartItems.map((item) => item.id === itemId ? { ...item, quantity: Math.max(1, item.quantity + delta) } : item));
  };

  const total = cartItems.reduce((sum, item) => sum + item.harga * item.quantity, 0);

  return (
    <>
      <motion.button whileHover={{ scale: 1.05 }} whileTap={{ scale: 0.95 }} onClick={() => setIsOpen(true)} className="fixed bottom-6 right-6 z-40 bg-songket-red text-white p-4 rounded-full shadow-xl hover:bg-songket-dark transition-colors">
        <ShoppingBag className="w-6 h-6" />
        {cartItems.length > 0 && <span className="absolute -top-2 -right-2 bg-songket-gold text-foreground font-bold w-7 h-7 flex items-center justify-center rounded-full text-sm">{cartItems.length}</span>}
      </motion.button>

      <AnimatePresence>{isOpen && (
        <>
          <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }} onClick={() => setIsOpen(false)} className="fixed inset-0 bg-black/50 z-50" />
          <motion.div initial={{ x: "100%" }} animate={{ x: 0 }} exit={{ x: "100%" }} transition={{ type: "spring", damping: 25, stiffness: 300 }} className="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 overflow-hidden flex flex-col">
            <div className="p-6 border-b border-foreground/10 bg-songket-red text-white flex items-center justify-between">
              <h2 className="text-2xl font-serif font-bold">Keranjang Anda</h2>
              <button onClick={() => setIsOpen(false)}><X className="w-6 h-6 hover:text-songket-gold" /></button>
            </div>
            <div className="flex-1 overflow-y-auto p-6">
              {cartItems.length === 0 ? (
                <div className="text-center py-12">
                  <ShoppingBag className="w-16 h-16 mx-auto text-foreground/30 mb-4" />
                  <p className="text-foreground/60 text-lg">Keranjang kosong</p>
                  <button onClick={() => setIsOpen(false)} className="mt-4 text-songket-red font-medium hover:underline">Mulai Pesan</button>
                </div>
              ) : (
                <div className="space-y-4">
                  {cartItems.map((item) => (
                    <div key={item.id} className="flex gap-4 p-4 bg-background rounded-lg">
                      <img src={item.foto} alt={item.nama} className="w-20 h-20 rounded-lg object-cover" />
                      <div className="flex-1">
                        <h3 className="font-semibold">{item.nama}</h3>
                        <p className="text-songket-red font-bold mt-1">{formatRupiah(item.harga)}</p>
                        <div className="flex items-center gap-2 mt-3">
                          <button onClick={() => updateQuantity(item.id, -1)} className="p-1 hover:bg-foreground/10 rounded"><Minus className="w-4 h-4" /></button>
                          <span className="font-medium w-8 text-center">{item.quantity}</span>
                          <button onClick={() => updateQuantity(item.id, 1)} className="p-1 hover:bg-foreground/10 rounded"><Plus className="w-4 h-4" /></button>
                          <button onClick={() => removeFromCart(item.id)} className="ml-auto text-red-500 hover:text-red-700"><Trash2 className="w-4 h-4" /></button>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>
            {cartItems.length > 0 && (
              <div className="p-6 border-t border-foreground/10 bg-background">
                <div className="flex justify-between items-center mb-4">
                  <span className="text-lg font-medium">Total</span>
                  <span className="text-2xl font-bold text-songket-red">{formatRupiah(total)}</span>
                </div>
                <motion.button whileHover={{ scale: 1.02 }} whileTap={{ scale: 0.98 }} className="w-full bg-songket-red text-white py-4 rounded-lg font-semibold hover:bg-songket-dark">{/* TODO: Implement checkout */}</motion.button>
              </div>
            )}
          </motion.div>
        </>
      )}</AnimatePresence>
    </>
  );
}