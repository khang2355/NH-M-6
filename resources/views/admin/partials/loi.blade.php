@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm shadow-sm space-y-1">
        @foreach ($errors->all() as $loi)
            <p>{{ $loi }}</p>
        @endforeach
    </div>
@endif
