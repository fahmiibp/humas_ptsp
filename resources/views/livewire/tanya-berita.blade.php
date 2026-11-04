<section class="mb-10 rounded-2xl border border-teal-100 mb-6 bg-white p-5">
    <h2 class="mb-1 text-lg font-bold text-gray-900">Tanya Berita</h2>
    <p class="mb-4 text-xs text-gray-500">Jawaban hanya diambil dari berita yang sudah tayang di situs ini.</p>

    <form wire:submit="tanya" class="flex gap-2">
        <input type="text" wire:model="pertanyaan" maxlength="300"
            placeholder="Contoh: Apa saja perizinan usaha terbaru?"
            class="min-w-0 flex-1 rounded-full border border-gray-300 px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
        <button type="submit" wire:loading.attr="disabled" wire:target="tanya"
            class="rounded-full bg-teal-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-teal-700 disabled:opacity-60">
            <span wire:loading.remove wire:target="tanya">Tanya</span>
            <span wire:loading wire:target="tanya">Mencari...</span>
        </button>
    </form>

    @if ($error)
        <p class="mt-4 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if ($jawaban)
        <div class="mt-4 rounded-xl bg-teal-50 p-4">
            <p class="text-sm leading-relaxed text-gray-800">{{ $jawaban }}</p>

            @if ($sumber)
                <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-teal-700">Sumber</p>
                <ul class="mt-1 space-y-1 text-sm">
                    @foreach ($sumber as $s)
                        <li>
                            <a href="{{ $s['url'] }}" wire:navigate
                                class="text-teal-700 underline underline-offset-2 hover:text-teal-900">
                                {{ $s['judul'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <p class="mt-3 text-xs text-gray-400">Dijawab otomatis oleh AI, bisa keliru. Rujuk berita sumber.</p>
        </div>
    @endif
</section>
