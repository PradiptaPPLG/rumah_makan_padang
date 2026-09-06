# Raso Minang - Frontend

Frontend untuk aplikasi website Rumah Makan Padang "Raso Minang" dengan Next.js 14, TypeScript, dan Tailwind CSS.

## Tech Stack

- **Framework**: Next.js 14 (App Router)
- **Language**: TypeScript
- **Styling**: Tailwind CSS + Custom Config
- **Animation**: Framer Motion
- **Icons**: Lucide React

## Installation & Setup

```bash
cd frontend

# Install dependencies
npm install

# Create .env.local file
cp .env.local.example .env.local
# Edit .env.local and add: NEXT_PUBLIC_API_URL=http://localhost:8000/api

# Run development server
npm run dev

# Open http://localhost:3000
```

## Project Structure

```
frontend/
├── src/
│   ├── app/                    # Next.js App Router pages
│   │   ├── globals.css         # Global styles with custom colors
│   │   ├── layout.tsx          # Root layout
│   │   └── page.tsx            # Home page
│   ├── components/             # Reusable UI components
│   │   ├── Header.tsx
│   │   ├── Hero.tsx
│   │   ├── BranchSelector.tsx
│   │   ├── MenuCard.tsx
│   │   ├── MenuSection.tsx
│   │   ├── CartDrawer.tsx
│   │   ├── TestimonialSection.tsx
│   │   ├── CeritaKami.tsx
│   │   └── Footer.tsx
│   ├── lib/                    # Utility functions
│   │   └── api.ts              # Axios client configuration
│   └── types/                  # TypeScript type definitions
│       └── index.ts
├── public/                     # Static assets
├── tailwind.config.ts          # Tailwind configuration
├── tsconfig.json               # TypeScript config
└── package.json
```

## Design System

### Color Palette (Minangkabau Inspired)
- **Primary Red**: `#7A1F2B` (Songket merah - accent)
- **Secondary Gold**: `#C9A227` (Songket emas - highlights)
- **Background**: `#F5EFE2` (Warm off-white)
- **Foreground**: `#241B16` (Dark brown text)

### Typography
- **Headlines**: Playfair Display (serif)
- **Body**: Inter (sans-serif)

## API Integration

The frontend communicates with Laravel backend via REST API at `NEXT_PUBLIC_API_URL`.

Endpoints used:
- `GET /api/branches` - List branches
- `GET /api/menu-items?branch_id=X` - Get menu items per branch
- `POST /api/orders` - Create order

## Features

- ✅ Responsive design (mobile-first)
- ✅ WCAG AA accessible (focus states, contrast)
- ✅ Reduced motion support
- ✅ Branch selector with dynamic pricing
- ✅ Category filtering & search
- ✅ Shopping cart drawer
- ✅ Framer Motion animations (single entrance animation only)
- ✅ Gonjong-inspired divider elements

## License

Proprietary - Raso Minang 2024
