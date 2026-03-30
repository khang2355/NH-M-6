<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — E-Shop')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --admin-sidebar: #0f172a;
            --admin-accent: #6366f1;
        }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .admin-app-body {
            background: linear-gradient(165deg, #eef2ff 0%, #f1f5f9 35%, #f8fafc 70%);
            min-height: 100vh;
        }
        @keyframes adminFadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes adminShimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .admin-fade-up { animation: adminFadeUp 0.6s ease-out forwards; }
        .admin-stagger { opacity: 0; animation: adminFadeUp 0.55s ease-out forwards; }
        .admin-glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
        }
        .admin-sidebar-gradient {
            background: linear-gradient(165deg, #0f172a 0%, #1e1b4b 45%, #312e81 100%);
        }
        .admin-nav-link {
            position: relative;
            transition: transform 0.25s ease, background 0.25s ease, color 0.2s ease;
        }
        .admin-nav-link:hover {
            transform: translateX(4px);
        }
        .admin-nav-link::before {
            content: '';
            position: absolute;
            left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 0; border-radius: 999px;
            background: linear-gradient(180deg, #a5b4fc, #6366f1);
            transition: height 0.25s ease;
        }
        .admin-nav-link:hover::before, .admin-nav-link.active::before { height: 70%; }
        .admin-nav-link.active {
            background: rgba(99, 102, 241, 0.2);
            color: #e0e7ff;
        }
        /* Nút luôn đọc được khi Tailwind CDN / build không áp dụng class */
        .admin-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            background: #0284c7 !important;
            color: #ffffff !important;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.08);
            transition: transform 0.2s ease, background 0.2s ease, opacity 0.2s ease;
        }
        .admin-btn-primary:hover:not(:disabled) {
            background: #0369a1 !important;
            transform: scale(1.02);
        }
        .admin-btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        /* Ô tìm kiếm admin: luôn đọc được, không phụ thuộc hoàn toàn vào utility Tailwind */
        .admin-search-panel {
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        .admin-search-panel input[type="search"],
        .admin-search-panel input[type="text"],
        .admin-search-panel select {
            min-height: 44px;
            width: 100%;
            border-radius: 0.75rem !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        .admin-search-panel input:focus,
        .admin-search-panel select:focus {
            outline: 2px solid #38bdf8 !important;
            outline-offset: 0;
            border-color: #0ea5e9 !important;
        }
        .admin-btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            background: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }
        .admin-btn-ghost:hover {
            background: #f0f9ff !important;
            border-color: #7dd3fc !important;
        }
        .admin-sr-only {
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
        .admin-icon-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            min-width: 2.75rem;
            padding: 0 !important;
            border-radius: 0.875rem;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease, filter 0.2s ease;
            text-decoration: none;
            border: none;
        }
        .admin-icon-btn:hover:not(:disabled) {
            transform: translateY(-3px) scale(1.04);
            box-shadow: 0 12px 28px -10px rgba(15, 23, 42, 0.35);
        }
        .admin-icon-btn:active:not(:disabled) {
            transform: translateY(0) scale(0.98);
        }
        .admin-icon-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .admin-icon-btn--indigo {
            background: linear-gradient(145deg, #4f46e5, #6366f1) !important;
            color: #ffffff !important;
        }
        .admin-icon-btn--sky {
            background: linear-gradient(145deg, #0284c7, #0369a1) !important;
            color: #ffffff !important;
        }
        .admin-icon-btn--rose {
            background: #ffffff !important;
            color: #e11d48 !important;
            border: 1px solid #fecdd3 !important;
        }
        .admin-icon-btn--rose:hover:not(:disabled) {
            background: #fff1f2 !important;
        }
        .admin-icon-btn--slate {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .admin-icon-btn--slate:hover:not(:disabled) {
            background: #e2e8f0 !important;
            color: #0f172a !important;
        }
        /* Nút có icon + chữ ngắn (vd: Thêm) */
        a.admin-btn-compact,
        button.admin-btn-compact {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: auto !important;
            min-width: auto !important;
            height: auto !important;
            min-height: 2.75rem;
            padding: 0.5rem 1.15rem !important;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(145deg, #0284c7, #0369a1) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px -4px rgba(2, 132, 199, 0.55);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
        }
        a.admin-btn-compact:hover,
        button.admin-btn-compact:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px -6px rgba(2, 132, 199, 0.5);
        }
        .admin-icon-btn-block {
            width: 100% !important;
            min-width: 0 !important;
        }
        .admin-search-row {
            display: grid;
            gap: 0.75rem;
            align-items: end;
        }
        @media (min-width: 768px) {
            .admin-search-row {
                grid-template-columns: minmax(0, 2fr) minmax(10rem, 1fr) auto;
            }
        }
        .admin-search-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
        .admin-input-wrap {
            position: relative;
        }
        .admin-input-wrap .admin-input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #94a3b8;
        }
        .admin-input-wrap input {
            padding-left: 2.75rem !important;
        }
        .admin-product-card {
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 4px 24px -12px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            transition: box-shadow 0.35s ease, border-color 0.25s ease, transform 0.3s ease;
        }
        .admin-product-card:hover {
            box-shadow: 0 20px 40px -16px rgba(99, 102, 241, 0.18);
            border-color: #c7d2fe;
            transform: translateY(-2px);
        }
        .admin-product-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }
        .admin-table-card {
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            background: #fff;
            box-shadow: 0 4px 20px -10px rgba(15, 23, 42, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .admin-table-card:hover {
            box-shadow: 0 16px 36px -14px rgba(99, 102, 241, 0.15);
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen admin-app-body text-slate-800 antialiased">
    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')
        <div class="flex-1 flex flex-col min-w-0">
            @include('admin.partials.topbar')
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-medium shadow-sm">{{ session('success') }}</div>
                @endif
                @include('admin.partials.loi')
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
