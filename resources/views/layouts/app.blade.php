<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Shop — Cửa hàng trực tuyến')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Tailwind npm không có file .min.css; dùng Play CDN khi chưa chạy npm run build / npm run dev --}}
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .store-mesh {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 40% 20%, rgba(99, 102, 241, 0.12) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(236, 72, 153, 0.1) 0px, transparent 45%),
                radial-gradient(at 0% 50%, rgba(34, 211, 238, 0.1) 0px, transparent 50%);
        }
        @keyframes storeFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes storeFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .store-card-hover {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
        }
        .store-card-hover:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 25px 50px -12px rgba(99, 102, 241, 0.18);
        }
        .store-btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            color: #ffffff !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, filter 0.2s;
        }
        .store-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -6px rgba(99, 102, 241, 0.45);
            filter: brightness(1.05);
        }
        /* Nút / ô lọc luôn đọc được (trắng trên trắng khi Tailwind không load) — tone trắng + xanh biển */
        .store-ocean-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 1.5rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            background: #0284c7 !important;
            color: #ffffff !important;
            border: none !important;
            cursor: pointer;
            box-shadow: 0 4px 14px -3px rgba(2, 132, 199, 0.45);
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .store-ocean-btn:hover:not(:disabled) {
            background: #0369a1 !important;
            transform: translateY(-1px);
        }
        .store-ocean-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .store-ocean-compact {
            min-height: 36px !important;
            padding: 0.5rem 0.875rem !important;
            font-size: 0.75rem !important;
        }
        .store-field {
            min-height: 48px;
            width: 100%;
            min-width: 0;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            color: #0f172a;
        }
        .store-field:focus {
            outline: 2px solid #38bdf8;
            outline-offset: 0;
            border-color: #0ea5e9;
        }
        .store-filter-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px -8px rgba(14, 165, 233, 0.15);
        }
        /* Form tìm kiếm / lọc — rõ ràng khi Tailwind CDN không khớp bản build */
        .store-search-panel {
            border: 1px solid #bae6fd;
            box-shadow: 0 10px 40px -12px rgba(14, 165, 233, 0.28);
        }
        /* Khối tổng tiền: nền đậm cố định + chữ sáng (không phụ thuộc gradient utility) */
        .store-summary-bar {
            background: linear-gradient(135deg, #0369a1 0%, #0c4a6e 100%) !important;
            color: #ffffff !important;
        }
        .store-summary-bar .store-summary-label {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        .store-summary-bar .store-summary-amount {
            color: #ffffff !important;
        }
        /* Nút sáng trên nền đậm — không kế thừa text-white của cha */
        .store-cta-light {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 2rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            background: #ffffff !important;
            color: #0c4a6e !important;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        .store-cta-light:hover {
            background: #f0f9ff !important;
            color: #075985 !important;
            transform: translateY(-1px);
        }
        /* Hàng giỏ hàng: grid cố định — tránh cột ảnh / nội dung vỡ khi flex utility lỗi */
        .store-cart-row {
            display: grid;
            gap: 1rem;
            align-items: center;
        }
        @media (min-width: 640px) {
            .store-cart-row {
                grid-template-columns: 7.5rem minmax(0, 1fr) auto;
            }
        }
        .store-cart-thumb {
            width: 100%;
            max-width: 10rem;
            aspect-ratio: 1;
            margin: 0 auto;
        }
        @media (min-width: 640px) {
            .store-cart-thumb {
                width: 7.5rem;
                max-width: none;
                height: 7.5rem;
                margin: 0;
            }
        }
        .store-cart-aside {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        @media (min-width: 640px) {
            .store-cart-aside {
                flex-direction: column;
                flex-wrap: nowrap;
                align-items: flex-end;
                justify-content: center;
                text-align: right;
                min-width: 10.5rem;
            }
        }
        .store-qty-group {
            display: inline-flex;
            align-items: center;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 0.125rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
        }
        .store-qty-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border: none;
            border-radius: 0.75rem;
            background: transparent;
            color: #475569;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
        }
        .store-qty-btn:hover:not(:disabled) {
            background: #e0f2fe;
            color: #0369a1;
            transform: scale(1.06);
        }
        .store-qty-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
        .store-icon-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            border: none;
            background: #fff1f2;
            color: #e11d48;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
        }
        .store-icon-danger:hover {
            background: #ffe4e6;
            transform: scale(1.06);
            box-shadow: 0 6px 16px -6px rgba(225, 29, 72, 0.45);
        }
        /* Thanh tìm kiếm cửa hàng — một hàng rõ ràng trên desktop */
        .store-search-bar {
            display: grid;
            gap: 1rem;
            align-items: end;
        }
        @media (min-width: 1024px) {
            .store-search-bar {
                grid-template-columns: minmax(0, 1fr) 13.5rem auto;
            }
        }
        .store-search-input-wrap {
            position: relative;
        }
        .store-search-input-wrap .store-search-ico {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .store-search-input-wrap .store-field {
            padding-left: 2.75rem;
        }
        .store-ocean-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 3rem;
            min-height: 3rem;
            padding: 0 1rem;
            border-radius: 1rem;
            border: none;
            background: #0284c7 !important;
            color: #fff !important;
            cursor: pointer;
            box-shadow: 0 4px 14px -3px rgba(2, 132, 199, 0.45);
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }
        .store-ocean-icon-btn:hover {
            background: #0369a1 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px -6px rgba(2, 132, 199, 0.5);
        }
        .store-ghost-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 3rem;
            min-height: 3rem;
            padding: 0 1rem;
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            background: #fff !important;
            color: #475569 !important;
            text-decoration: none;
            font-weight: 700;
            transition: border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        .store-ghost-icon-btn:hover {
            border-color: #7dd3fc;
            color: #0369a1 !important;
            transform: translateY(-1px);
        }
        .store-shine {
            position: relative;
            overflow: hidden;
        }
        .store-shine::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.35) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .store-shine:hover::after {
            transform: translateX(100%);
        }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="store-mesh min-h-screen text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('partials.navbar')
        <main class="flex-1">
            @if(session('success'))
                <div class="container mx-auto px-4 pt-4">
                    <div class="rounded-2xl border border-emerald-200/80 bg-emerald-50/90 px-4 py-3 text-emerald-800 text-sm font-medium shadow-lg shadow-emerald-100/50 text-center" style="animation: storeFadeIn 0.5s ease;">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="container mx-auto px-4 pt-4">
                    <div class="rounded-2xl border border-rose-200/80 bg-rose-50/90 px-4 py-3 text-rose-800 text-sm font-medium text-center" style="animation: storeFadeIn 0.5s ease;">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
    @stack('scripts')
</body>
</html>
