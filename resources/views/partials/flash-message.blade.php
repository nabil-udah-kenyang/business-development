@if ($flashMessage)
    <div data-flash-message role="alert" class="mb-6 flex items-start gap-3 rounded-2xl border p-4 text-sm font-semibold {{ $isFlashError ? 'border-red-200 bg-red-50 text-red-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700' }}">
        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-xl {{ $isFlashError ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}"><i data-lucide="{{ $isFlashError ? 'circle-alert' : 'check' }}" class="h-4 w-4"></i></span>
        <span class="flex-1 pt-1">{{ $flashMessage }}</span>
        <button type="button" data-dismiss-flash aria-label="Tutup pesan" class="grid h-8 w-8 shrink-0 place-items-center rounded-xl text-current/70 hover:bg-black/5 hover:text-current"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
@endif
