export interface MenuItem {
  id: number;
  nama: string;
  kategori: string;
  deskripsi: string;
  foto: string;
  badge?: 'Signature' | 'Favorit' | 'Baru';
  rating: number;
  harga: number;
}

export interface Branch {
  id: number;
  nama: string;
  kota: string;
  alamat: string;
  jam_buka: string;
  kontak_whatsapp: string;
}

export interface CartItem extends MenuItem {
  quantity: number;
}