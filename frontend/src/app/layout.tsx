import type { Metadata } from "next";
import { Playfair_Display, Inter } from "next/font/google";
import "./globals.css";
import Header from "@/components/Header";
import Footer from "@/components/Footer";
import CartDrawer from "@/components/CartDrawer";

const playfair = Playfair_Display({
  subsets: ["latin"],
  weight: ["400", "600", "700"],
  variable: "--font-playfair-display",
});

const inter = Inter({
  subsets: ["latin"],
  weight: ["400", "500", "600"],
  variable: "--font-inter",
});

export const metadata: Metadata = {
  title: "Raso Minang - Rumah Makan Padang Autentik",
  description: "Nikmati rasa otentik masakan Padang dengan warisan keluarga sejak 1950. Banyak cabang di seluruh Indonesia.",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="id">
      <body className={`${playfair.variable} ${inter.variable}`}>
        <Header />
        <main>{children}</main>
        <CartDrawer />
        <Footer />
      </body>
    </html>
  );
}
