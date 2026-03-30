@extends('layouts.app')
@section('title', $category->ten . ' — E-Shop')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-12">
    <nav class="text-sm text-slate-500 mb-8">
        <a href="/" class="hover:text-indigo-600 transition-colors">Trang chủ</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-semibold">{{ $category->ten }}</span>
    </nav>

    <div class="mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight">{{ $category->ten }}</h1>
            @if($category->mo_ta)
            <p class="mt-3 text-slate-600 max-w-2xl leading-relaxed">{{ $category->mo_ta }}</p>
            @endif
        </div>
        <form method="GET" action="{{ url('/danh_muc/'.$category->id) }}" class="store-filter-card store-search-panel p-4 w-full lg:w-auto lg:max-w-xl">
            <div class="flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="store-search-input-wrap flex-1 min-w-0">
                    <span class="store-search-ico" aria-hidden="true">@include('admin.partials.icon', ['name' => 'search', 'class' => 'w-5 h-5'])</span>
                    <label class="sr-only" for="q-cat">Tìm trong danh mục</label>
                    <input id="q-cat" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm trong danh mục…" class="store-field" autocomplete="off">
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="submit" class="store-ocean-icon-btn" title="Tìm" aria-label="Tìm">@include('admin.partials.icon', ['name' => 'search', 'class' => 'w-5 h-5'])</button>
                    @if(request()->filled('q'))
                    <a href="{{ url('/danh_muc/'.$category->id) }}" class="store-ghost-icon-btn" title="Xóa tìm" aria-label="Xóa tìm">@include('admin.partials.icon', ['name' => 'x-mark', 'class' => 'w-5 h-5'])</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
        @forelse($sanPhams as $sp)
        @php
            $thumb = $sp->variants->first()?->images->first()?->hinh_anh;
            $thumbUrl = $thumb ? url_anh_public($thumb) : '';
        @endphp
        <article class="group rounded-3xl bg-white/90 backdrop-blur border border-slate-100 p-4 store-card-hover">
            <a href="/san_pham/{{ $sp->id }}" class="block">
                <div class="relative rounded-2xl overflow-hidden bg-slate-100 aspect-[4/3] mb-4 flex items-center justify-center">
                    @if($thumbUrl)
                    <img src="{{ $thumbUrl }}" alt="{{ $sp->ten }}" class="max-w-full max-h-full w-auto h-auto object-contain transition-transform duration-500 group-hover:scale-105">
                    @else
                    <span class="text-slate-400 text-sm">Chưa có ảnh</span>
                    @endif
                    @if($sp->co_bien_the_dang_sale())
                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold text-white bg-gradient-to-r from-rose-500 to-orange-500 shadow-lg">Sale</span>
                    @endif
                </div>
                <h2 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $sp->ten }}</h2>
                <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                    <span class="text-xl font-bold text-slate-900">{{ $sp->khoang_gia_hien_thi() }}</span>
                </div>
                <span class="mt-4 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300" title="Chi tiết">
                    @include('admin.partials.icon', ['name' => 'eye', 'class' => 'w-5 h-5'])
                </span>
            </a>
        </article>
        @empty
        <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white/60 py-16 text-center text-slate-500">
            @if(request()->filled('q'))
            Không tìm thấy sản phẩm phù hợp.
            @else
            Chưa có sản phẩm trong danh mục này.
            @endif
        </div>
        @endforelse
    </div>

    <div class="mt-10 flex justify-center [&_nav]:flex [&_nav]:flex-wrap [&_nav]:gap-2 [&_a]:rounded-xl [&_a]:px-4 [&_a]:py-2 [&_a]:font-semibold [&_a]:border [&_a]:border-slate-200">
        {{ $sanPhams->links() }}
    </div>
</div>
@endsection
