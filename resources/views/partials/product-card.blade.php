<article class="product-card {{ $promoted ? 'promoted-product-card' : '' }} soft-card group min-w-0 overflow-hidden p-2.5">
    <a href="{{ $preloved ? route('preloved.show', $product->slug) : route('products.show', $product->slug) }}" class="block">
        <div class="relative overflow-hidden">
            <img class="product-image" src="{{ $product->image ? asset($product->image) : asset('image/divisi_bd.jpeg') }}" alt="{{ $product->name }}">
            <span class="product-badge absolute left-3 top-3 chip {{ $promoted ? 'recommendation-badge' : ($preloved ? 'bg-amber-100 text-amber-700' : 'chip-purple') }}">{{ $promoted ? 'REKOMENDASI' : ($preloved ? 'PRELOVED' : ($product->type === 'service' ? 'Jasa' : 'Produk')) }}</span>
        </div>
        <div class="product-meta px-1.5 pb-1 pt-3">
            <h3 class="line-clamp-1 text-[.94rem] font-bold">{{ $product->name }}</h3>
            <p class="product-price mt-1 text-base font-bold text-violet-700">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="product-seller mt-2 text-xs font-semibold text-slate-500">{{ $product->owner?->name ?? 'Pemilik belum diatur' }}</p>
            <div class="product-details mt-2 flex items-center gap-1.5 text-[.7rem] text-slate-400"><span>{{ $product->category ?? 'Lainnya' }}</span><span>·</span><span>{{ $product->location ?? 'Medan' }}</span></div>
            @if ($preloved)<span class="mt-2 inline-flex rounded-full bg-slate-100 px-2 py-1 text-[.65rem] font-bold text-slate-500">Kondisi {{ $product->condition ?? 'Belum diatur' }}</span>@endif
        </div>
    </a>
</article>
