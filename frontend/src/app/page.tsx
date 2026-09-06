"use client";

import { motion } from "framer-motion";
import Hero from "@/components/Hero";
import BranchSelector from "@/components/BranchSelector";
import MenuSection from "@/components/MenuSection";
import CeritaKami from "@/components/CeritaKami";
import TestimonialSection from "@/components/TestimonialSection";

export default function Home() {
  return (
    <div className="min-h-screen">
      <Hero />
      <BranchSelector />
      <MenuSection />
      <TestimonialSection />
      <div className="gonjong-divider py-12" />
      <CeritaKami />
    </div>
  );
}
