<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <section class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="max-w-3xl">

                <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                    FAQ
                </p>

                <h1 class="mt-2 text-3xl md:text-4xl font-bold text-gray-900">
                    Pertanyaan yang Sering Diajukan
                </h1>

                <p class="mt-4 text-gray-600 text-base md:text-lg">
                    Temukan jawaban atas pertanyaan yang sering diajukan
                    mengenai layanan dan informasi PTSP.
                </p>

            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="max-w-4xl mx-auto px-6 py-12">

        @if ($faqs->isNotEmpty())

            <div class="space-y-4">

                @foreach ($faqs as $faq)

                    <details
                        class="group bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
                    >

                        <summary
                            class="flex items-center justify-between gap-4
                                   cursor-pointer list-none
                                   px-6 py-5
                                   font-semibold text-gray-900
                                   hover:bg-gray-50 transition"
                        >

                            <span>
                                {{ $faq->pertanyaan }}
                            </span>

                            <svg
                                class="w-5 h-5 shrink-0 text-gray-500
                                       transition-transform duration-200
                                       group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="px-6 pb-5 pt-1 text-gray-600 leading-relaxed">
                            {{ $faq->jawaban }}
                        </div>

                    </details>

                @endforeach

            </div>

        @else

            <div class="bg-white rounded-xl border border-gray-200 p-10 text-center">

                <h2 class="text-lg font-semibold text-gray-900">
                    Belum Ada FAQ
                </h2>

                <p class="mt-2 text-gray-500">
                    Informasi pertanyaan yang sering diajukan belum tersedia.
                </p>

            </div>

        @endif

    </section>

</div>