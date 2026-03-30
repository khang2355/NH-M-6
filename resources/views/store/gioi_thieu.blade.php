@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
<div class="container mx-auto px-4 lg:px-8 py-8 lg:py-14 max-w-6xl">
    
    {{-- Tiêu đề trang --}}
    <div class="text-center mb-12 lg:mb-16">
        <h1 class="text-3xl lg:text-5xl font-bold tracking-tight mb-4">
            <span class="bg-gradient-to-r from-indigo-600 to-fuchsia-600 bg-clip-text text-transparent">Về E-Shop</span>
        </h1>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto">Chúng tôi tự hào mang đến cho khách hàng những sản phẩm chất lượng cao với dịch vụ tận tâm nhất.</p>
    </div>

                <p class="lead">Chào mừng bạn đến với cửa hàng của chúng tôi!</p>
    {{-- Nội dung giới thiệu & Hình ảnh --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center mb-16 lg:mb-24">
        <div class="space-y-6 text-slate-600 leading-relaxed text-lg">
            <p>Cửa hàng được thành lập vào năm 2024 với niềm đam mê mang lại những trải nghiệm mua sắm trực tuyến tuyệt vời nhất. Sứ mệnh của chúng tôi là cung cấp những mặt hàng tốt nhất, đi kèm với dịch vụ hỗ trợ khách hàng nhanh chóng và chuyên nghiệp.</p>
            <p>Chúng tôi tin rằng mỗi khách hàng đều xứng đáng nhận được sự quan tâm chu đáo và tiếp cận với những sản phẩm chất lượng nhất với mức giá phải chăng.</p>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-100 to-fuchsia-100 rounded-[2rem] transform rotate-3 scale-105 -z-10 transition-transform hover:rotate-6"></div>
            {{-- Ảnh minh họa lấy từ Unsplash cho sinh động, bạn có thể thay bằng ảnh thật của cửa hàng --}}
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=800" alt="Không gian cửa hàng" class="rounded-[2rem] shadow-xl w-full object-cover aspect-[4/3] border-4 border-white">
        </div>
    </div>

                <p>Chúng tôi tự hào mang đến cho khách hàng những sản phẩm chất lượng cao với giá cả phải chăng. Sứ mệnh của chúng tôi là cung cấp những mặt hàng tốt nhất, đi kèm với dịch vụ khách hàng tuyệt vời.</p>

                <p>Cửa hàng được thành lập vào năm 2024 với niềm đam mê mang lại những trải nghiệm mua sắm trực tuyến tốt nhất. Chúng tôi tin rằng mỗi khách hàng đều xứng đáng nhận được sự quan tâm và những sản phẩm tốt nhất.</p>
    
                <h3 class="mt-5">Giá trị cốt lõi</h3>
                <ul>
                    <li><strong>Chất lượng:</strong> Chúng tôi không bao giờ thỏa hiệp về chất lượng.</li>
                    <li><strong>Khách hàng là trên hết:</strong> Sự hài lòng của bạn là ưu tiên hàng đầu của chúng tôi.</li>
                    <li><strong>Minh bạch:</strong> Chúng tôi luôn trung thực và minh bạch trong mọi hoạt động.</li>
                </ul>

                <hr class="my-5">

                
    {{-- Giá trị cốt lõi --}}
    <div class="mb-16 lg:mb-24">
        <br>
        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 text-center mb-10">Giá trị cốt lõi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            {{-- Khối 1 --}}
            <div class="rounded-[2rem] bg-white/80 backdrop-blur border border-slate-100 p-8 shadow-lg shadow-indigo-100/20 hover:shadow-indigo-200/40 hover:-translate-y-1 transition-all duration-300">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </span>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Chất lượng</h3>
                <p class="text-slate-600">Chúng tôi không bao giờ thỏa hiệp về chất lượng. Mỗi sản phẩm tới tay bạn đều được kiểm tra kỹ lưỡng nhất.</p>
            </div>
            {{-- Khối 2 --}}
            <div class="rounded-[2rem] bg-white/80 backdrop-blur border border-slate-100 p-8 shadow-lg shadow-fuchsia-100/20 hover:shadow-fuchsia-200/40 hover:-translate-y-1 transition-all duration-300">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-fuchsia-100 text-fuchsia-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </span>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Khách hàng là trên hết</h3>
                <p class="text-slate-600">Sự hài lòng của bạn là ưu tiên hàng đầu. Chúng tôi luôn sẵn sàng lắng nghe và đồng hành cùng bạn.</p>
            </div>
            {{-- Khối 3 --}}
            <div class="rounded-[2rem] bg-white/80 backdrop-blur border border-slate-100 p-8 shadow-lg shadow-sky-100/20 hover:shadow-sky-200/40 hover:-translate-y-1 transition-all duration-300">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-100 text-sky-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </span>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Minh bạch</h3>
                <p class="text-slate-600">Chúng tôi cam kết luôn trung thực và minh bạch trong mọi hoạt động kinh doanh và dịch vụ.</p>
            </div>
        </div>
    </div>

    {{-- Bản đồ --}}
    <div>
        <br>
        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 text-center mb-10">Vị trí của chúng tôi</h2>
        <div class="rounded-[2rem] bg-white p-2 md:p-3 shadow-2xl shadow-indigo-100/50 border border-slate-100">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.863981044336!2d105.74459841542343!3d21.03813279283501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b991d80fd5%3A0x53ce12c7d6dc6636!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1678886972701!5m2!1svi!2s"
                    class="w-full aspect-[4/3] md:aspect-[21/9] rounded-[1.5rem]" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.map-responsive {
    overflow: hidden;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    position: relative;
    height: 0;
}
.map-responsive iframe {
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    position: absolute;
}
</style>
@endpush