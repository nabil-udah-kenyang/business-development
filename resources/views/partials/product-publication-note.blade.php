<div class="product-draft-note mt-8 rounded-2xl bg-violet-50 p-4 text-sm leading-6 text-violet-800">
    <div class="flex items-start gap-3">
        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-violet-100 text-violet-700">
            <i data-lucide="info" class="h-4 w-4"></i>
        </span>
        <div>
            <strong class="product-draft-note-title">Informasi publikasi</strong>
            <p class="product-draft-note-description">
                Silakan hubungi
                @if ($whatsappLink)
                    <a href="{{ $whatsappLink }}" target="_blank" rel="noreferrer" class="font-bold underline">WhatsApp admin</a>
                @else
                    <span class="font-bold">WhatsApp admin</span>
                @endif
                untuk menampilkan atau mengaktifkan produk di halaman publik.
            </p>
        </div>
    </div>
</div>
