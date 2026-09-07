import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('restaurantApp', () => ({
        selectedBranch: 'Jakarta Selatan',
        selectedCategory: 'all',
        searchQuery: '',
        isCartOpen: false,
        isMobileMenuOpen: false,
        isScrolled: false,
        cart: [],
        notificationMessage: '',
        showNotification: false,

        init() {
            // Load saved cart from localStorage if available
            try {
                const savedCart = localStorage.getItem('raso_minang_cart');
                if (savedCart) {
                    this.cart = JSON.parse(savedCart);
                }
            } catch (e) {
                console.warn('Could not read cart from localStorage', e);
            }

            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 20;
            });
        },

        saveCart() {
            try {
                localStorage.setItem('raso_minang_cart', JSON.stringify(this.cart));
            } catch (e) {
                console.warn('Could not save cart to localStorage', e);
            }
        },

        addToCart(item) {
            const existing = this.cart.find(c => c.id === item.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                this.cart.push({
                    id: item.id,
                    nama: item.nama,
                    harga: Number(item.harga),
                    foto: item.foto,
                    quantity: 1
                });
            }
            this.saveCart();
            this.notify(`${item.nama} ditambahkan ke pesanan!`);
        },

        updateQuantity(itemId, delta) {
            const index = this.cart.findIndex(c => c.id === itemId);
            if (index !== -1) {
                this.cart[index].quantity += delta;
                if (this.cart[index].quantity <= 0) {
                    this.cart.splice(index, 1);
                }
                this.saveCart();
            }
        },

        removeFromCart(itemId) {
            this.cart = this.cart.filter(c => c.id !== itemId);
            this.saveCart();
            this.notify('Menu dihapus dari pesanan');
        },

        clearCart() {
            this.cart = [];
            this.saveCart();
        },

        get cartCount() {
            return this.cart.reduce((sum, item) => sum + item.quantity, 0);
        },

        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.harga * item.quantity), 0);
        },

        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        },

        notify(msg) {
            this.notificationMessage = msg;
            this.showNotification = true;
            setTimeout(() => {
                this.showNotification = false;
            }, 2500);
        },

        checkoutWhatsApp() {
            if (this.cart.length === 0) return;
            
            let message = `*HALO RASO MINANG (${this.selectedBranch.toUpperCase()})*\n`;
            message += `Saya ingin memesan hidangan berikut:\n\n`;
            
            this.cart.forEach((item, i) => {
                message += `${i + 1}. *${item.nama}* x${item.quantity} = ${this.formatRupiah(item.harga * item.quantity)}\n`;
            });
            
            message += `\n*Total Tagihan:* ${this.formatRupiah(this.cartTotal)}\n`;
            message += `*Cabang Pemesanan:* ${this.selectedBranch}\n`;
            message += `Mohon konfirmasi pesanan dan ketersediaan menu. Terima kasih!`;
            
            const encoded = encodeURIComponent(message);
            window.open(`https://wa.me/6281234567890?text=${encoded}`, '_blank');
        }
    }));
});

Alpine.start();
