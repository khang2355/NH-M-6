@extends('layouts.app')
@section('title', 'Trang chủ — E-Shop')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-12">
    @if($banners->isNotEmpty())
    <div class="mb-10 lg:mb-14 rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-200/40 ring-1 ring-white/60" x-data="{ active: 0 }" x-init="setInterval(() => { active = (active + 1) % {{ $banners->count() }} }, 5000)">
        <div class="relative aspect-[21/9] min-h-[280px] max-h-[500px] bg-slate-900 flex items-center justify-center">
            @foreach($banners as $i => $bn)
            @php $bnUrl = url_anh_public($bn->hinh_anh); @endphp
            <div x-show="active === {{ $i }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="absolute inset-0 flex items-center justify-center p-4"
                 style="display: none;">
                @if($bnUrl)
                <img src="{{ $bnUrl }}" alt="" class="max-w-full max-h-full w-auto h-auto object-contain">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent pointer-events-none"></div>
            </div>
            @endforeach
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                @foreach($banners as $i => $bn)
                <button type="button" @click="active = {{ $i }}" :class="active === {{ $i }} ? 'w-8 bg-white' : 'w-2 bg-white/40'" class="h-2 rounded-full transition-all duration-300 hover:bg-white/80" aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($categories->isNotEmpty())
    <div class="mb-10 lg:mb-16">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">CÁC DANH MỤC</h2>
                <p class="mt-2 text-slate-500 text-sm">Khám phá những danh mục sản phẩm yêu thích.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach($categories as $cat)
            @php
                $catImg = $cat->hinh_anh ? url_anh_public($cat->hinh_anh) : '';
            @endphp
            <a href="{{ url('/?danh_muc='.$cat->id) }}" class="group rounded-2xl overflow-hidden bg-white/90 backdrop-blur border border-slate-100 shadow-md hover:shadow-lg transition-shadow duration-300 p-2 sm:p-3">
                <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                    @if($catImg)
                    <img src="{{ $catImg }}" alt="{{ $cat->ten }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500" style="aspect-ratio: 4/3;">
                    @else
                    <span class="text-slate-400 text-xs font-medium">Chưa có ảnh</span>
                    @endif
                </div>
                <div class="p-2">
                    <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-1">{{ $cat->ten }}</h3>
                    <div class="flex items-center justify-between gap-1">
                        <span class="text-xs font-medium text-indigo-600 flex-shrink-0">Khám phá</span>
                        <div class="inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 transition-colors duration-300 group-hover:bg-indigo-600">
                            <svg class="h-3 w-3 text-indigo-600 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <form method="GET" action="/" class="store-filter-card store-search-panel mb-8 p-4 sm:p-5">
        <div class="store-search-bar">
            <div class="store-search-input-wrap">
                <span class="store-search-ico" aria-hidden="true">@include('admin.partials.icon', ['name' => 'search', 'class' => 'w-5 h-5'])</span>
                <label class="sr-only" for="q-home">Tìm sản phẩm</label>
                <input id="q-home" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm theo tên sản phẩm…" class="store-field" autocomplete="off">
            </div>
            <div>
                <label class="sr-only" for="dm-home">Danh mục</label>
                <select id="dm-home" name="danh_muc" class="store-field" title="Danh mục">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected((string) request('danh_muc') === (string) $cat->id)>{{ $cat->ten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap gap-2 items-center">
                <button type="submit" class="store-ocean-icon-btn" title="Lọc" aria-label="Lọc kết quả">
                    @include('admin.partials.icon', ['name' => 'filter', 'class' => 'w-5 h-5'])
                </button>
                @if(request()->hasAny(['q', 'danh_muc']))
                <a href="/" class="store-ghost-icon-btn" title="Xóa bộ lọc" aria-label="Xóa bộ lọc">
                    @include('admin.partials.icon', ['name' => 'x-mark', 'class' => 'w-5 h-5'])
                </a>
                @endif
            </div>
        </div>
    </form>

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">Sản phẩm nổi bật</h1>
            <p class="mt-2 text-slate-500 text-sm">Xem chi tiết và thêm vào giỏ.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
        @forelse($products as $sp)
        @php
            $thumb = $sp->variants->first()?->images->first()?->hinh_anh;
            $thumbUrl = $thumb ? url_anh_public($thumb) : '';
        @endphp
        <article class="group rounded-3xl bg-white/90 backdrop-blur border border-slate-100 p-6 store-card-hover">
            <a href="/san_pham/{{ $sp->id }}" class="block">
                <div class="relative rounded-2xl overflow-hidden bg-slate-100 aspect-[4/3] mb-6 flex items-center justify-center">
                    @if($thumbUrl)
                    <img src="{{ $thumbUrl }}" alt="{{ $sp->ten }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500" style="aspect-ratio: 4/3;">
                    @else
                    <span class="text-slate-400 text-sm">Chưa có ảnh</span>
                    @endif
                    @if($sp->co_bien_the_dang_sale())
                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold text-white bg-gradient-to-r from-rose-500 to-orange-500 shadow-lg">Sale</span>
                    @endif
                </div>
                <h2 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $sp->ten }}</h2>
                <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                    <span class="text-2xl font-bold text-slate-900">{{ $sp->khoang_gia_hien_thi() }}</span>
                </div>
                <span class="mt-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300" title="Chi tiết">
                    @include('admin.partials.icon', ['name' => 'eye', 'class' => 'w-6 h-6'])
                </span>
            </a>
        </article>
        @empty
        <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white/60 py-16 text-center text-slate-500">
            Không có sản phẩm phù hợp. Thử đổi từ khóa hoặc danh mục.
        </div>
        @endforelse
    </div>

    <div class="mt-10 flex justify-center [&_nav]:flex [&_nav]:flex-wrap [&_nav]:gap-2 [&_a]:rounded-xl [&_a]:px-4 [&_a]:py-2 [&_a]:font-semibold [&_a]:border [&_a]:border-slate-200 [&_a]:transition [&_a:hover]:border-indigo-300 [&_a:hover]:text-indigo-700 [&_span]:rounded-xl [&_span]:px-4 [&_span]:py-2 [&_span]:font-semibold">
        {{ $products->links() }}
    </div>
</div>
@endsection
