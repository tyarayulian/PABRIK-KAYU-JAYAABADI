# Design Brief: Jaya Cash Landing Page Redesign

## Objective
Redesign the existing landing page (`resources/views/landing.blade.php`) into a modern, high-conversion SaaS landing page for an ERP system specializing in wood factories. The design should feel professional, trustworthy, and cutting-edge.

## Aesthetic Direction: Industrial-Modernist
- **Clean & Sharp**: High contrast, plenty of whitespace, and rounded corners (24px-32px) matching the app's dashboard.
- **Professional Palette**: Use the app's core colors: Navy (#0f172a), Primary Blue (#1e2a78), and Light Background (#f8fafc to #eef0ff).
- **Industrial Context**: Subtle imagery or icons related to the wood industry, paired with clean "FinTech" UI elements.
- **Micro-interactions**: Subtle hover effects, smooth scroll reveals, and a polished loading experience (NProgress).

## Content Structure
1. **Sticky Header**: Logo, Nav Links (Features, How it Works), and a prominent "Login" button.
2. **Hero Section**: 
   - Left: Punchy headline "Kuasai Keuangan Pabrik Anda" + Value Prop + Primary CTA.
   - Right: A high-fidelity "App Preview" mockup showing the dashboard interface.
3. **Features (3-Column Grid)**: 
   - Real-time Dashboard.
   - Automatic Reporting.
   - Industrial-scale Tracking.
4. **How It Works (Horizontal Steps)**: Visual 1-2-3-4 flow.
5. **CTA Footer**: "Transformasi Digital Dimulai Sekarang" with a big button.
6. **Footer**: Modern layout with categories.

## Typography
- **Plus Jakarta Sans**: Use this as the primary font for everything to match the app.

## Color System
- Primary: #1e2a78
- Secondary: #0f172a
- BG: #f8fafc
- Surface: #ffffff
- Accent: #3b82f6 (vibrant blue for highlights)

## Technical Constraints
- Update `resources/views/landing.blade.php` directly.
- Maintain existing Laravel/Blade logic (assets, routes).
- Use Tailwind CSS or pure CSS as per existing patterns.
- Ensure responsiveness (mobile-first).
- No external image services; describe image needs for the implementation agent to generate/handle.

## Image Needs
- High-fidelity dashboard preview mockup.
- Hero background elements (subtle wood textures or geometric shapes).
- Feature icons (lucide/feather/font-awesome).
