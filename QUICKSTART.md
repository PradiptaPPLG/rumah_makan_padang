# 🚀 Quick Start Guide - Raso Mandeh

Langkah cepat untuk menjalankan project secara lokal.

## 📋 Prerequisites Checklist

- [ ] PHP 8.2+ installed
- [ ] MySQL 8.0+ running
- [ ] Node.js 18+ installed
- [ ] Composer installed
- [ ] Git installed

## 🎯 Quick Setup (5 Minutes)

### 1️⃣ Database Setup

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE raso_minang;
exit
```

### 2️⃣ Backend Setup

```bash
cd backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve --port=8000
```

✅ Backend running at: http://localhost:8000

### 3️⃣ Frontend Setup

```bash
cd frontend

# Install dependencies
npm install

# Configure environment
echo 'NEXT_PUBLIC_API_URL=http://localhost:8000/api' >> .env.local

# Start dev server
npm run dev
```

✅ Frontend running at: http://localhost:3000

## 🎨 Access Points

- **Main Website**: http://localhost:3000
- **API Documentation**: http://localhost:8000/api/v1/branches
- **Admin Panel** (optional): `/admin` after installing Filament

## 🔍 Test API Endpoints

```bash
# Get all branches
curl http://localhost:8000/api/v1/branches

# Get menu items
curl http://localhost:8000/api/v1/menu-items

# Get branches with full menu & prices
curl http://localhost:8000/api/v1/branches-with-menu
```

## 🛠️ Troubleshooting

### Issue: Migration errors
```bash
# Check database connection in .env
php artisan config:clear
php artisan migrate:fresh
```

### Issue: API not responding
```bash
# Verify backend is running on port 8000
lsof -i :8000
```

### Issue: Frontend can't connect
```bash
# Check .env.local has correct URL
cat frontend/.env.local
```

## 📝 Next Steps

1. ✅ Add sample data to database
2. 🎨 Customize colors in tailwind.config.ts
3. 👤 Set up admin panel with Filament
4. 🚀 Deploy to production

---

Need help? Check README.md for detailed documentation.
