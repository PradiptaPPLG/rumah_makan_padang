import { MapPin, Phone, Instagram } from "lucide-react";

const footerLinks = {
  menu: ["Nasi Rendang", "Ayam Pop", "Ikan Patin", "Telur Balado"],
  company: ["Tentang Kami", "Cabang Kami", "Karir", "Hubungi Kami"],
  legal: ["Kebijakan Privasi", "Syarat & Ketentuan"],
};

export default function Footer() {
  return (
    <footer className="bg-foreground text-background py-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid md:grid-cols-4 gap-12 mb-12">
          {/* Brand */}
          <div className="md:col-span-2">
            <h3 className="text-2xl font-serif font-bold mb-4">Raso Minang</h3>
            <p className="text-foreground/70 leading-relaxed mb-6 max-w-sm">
              Warisan rasa autentik Minangkabau sejak 1950. Setiap hidangan 
              dibuat dengan resep warisan keluarga dan rempah pilihan langsung 
              dari Sumatera Barat.
            </p>
            <div className="flex items-center space-x-6">
              <a href="#" className="hover:text-songket-gold transition-colors">
                <Instagram className="w-6 h-6" />
              </a>
              <a href="#" className="hover:text-songket-gold transition-colors flex items-center gap-2">
                <Phone className="w-5 h-5" />
                <span>+62 21 1234 5678</span>
              </a>
              <a href="#" className="hover:text-songket-gold transition-colors flex items-center gap-2">
                <MapPin className="w-5 h-5" />
                <span>Jakarta Selatan</span>
              </a>
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="font-semibold text-lg mb-4 text-songket-gold">Menu Favorit</h4>
            <ul className="space-y-2 text-foreground/70">
              {footerLinks.menu.map((link, i) => (
                <li key={i}><a href="#" className="hover:text-songket-gold transition-colors">{link}</a></li>
              ))}
            </ul>
          </div>

          {/* Company */}
          <div>
            <h4 className="font-semibold text-lg mb-4 text-songket-gold">Perusahaan</h4>
            <ul className="space-y-2 text-foreground/70">
              {footerLinks.company.map((link, i) => (
                <li key={i}><a href="#" className="hover:text-songket-gold transition-colors">{link}</a></li>
              ))}
            </ul>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t border-foreground/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-foreground/60 text-sm">
            © 2024 Raso Minang. Hak Cipta Dilindungi.
          </p>
          <div className="flex items-center gap-4">
            <span className="text-sm text-foreground/60">Jam Operasional:</span>
            <span className="text-sm font-medium">08:00 - 22:00 WIB</span>
          </div>
        </div>
      </div>
    </footer>
  );
}