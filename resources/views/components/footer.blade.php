@php
    $footer = \App\Models\FooterSetting::where('is_active', true)->first();
@endphp

<footer class="mt-16 text-white" style="background-color: #009689;">

    {{-- =========================
        FOOTER UTAMA
    ========================== --}}
    <div style="border-bottom: 1px solid #00877C;">

        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5 lg:items-start">

                {{-- =========================
                    LOGO
                ========================== --}}
                <div class="lg:col-span-1">

                    <a
                        href="{{ route('home') }}"
                        wire:navigate
                        class="inline-flex items-center"
                    >

                        @if ($footer?->logo)
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($footer->logo) }}"
                                alt="Logo"
                                class="w-44 object-contain"
                            >
                        @else
                            <img
                                src="{{ asset('image/ptsp.png') }}"
                                alt="Logo PTSP"
                                class="w-44 object-contain"
                            >
                        @endif

                    </a>

                </div>


                {{-- =========================
                    ALAMAT
                ========================== --}}
                <div>

                    <div class="mb-4 flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full text-white"
                            style="background-color: #00786F;"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M11.54 22.351l.07.04.04.02a.75.75 0 00.7 0l.04-.02.07-.04c.36-.21 5.79-3.54 7.79-8.25A7.5 7.5 0 004.75 11c0 4.71 5.43 8.04 6.79 8.25zM12 13.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            Alamat
                        </h3>

                    </div>

                    @if ($footer?->alamat)
                        <p class="whitespace-pre-line text-sm leading-6 text-white/90">
                            {{ $footer->alamat }}
                        </p>
                    @else
                        <p class="text-sm leading-6 text-white/70">
                            Alamat belum diatur.
                        </p>
                    @endif

                </div>


                {{-- =========================
                    EMAIL
                ========================== --}}
                <div>

                    <div class="mb-4 flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full text-white"
                            style="background-color: #00786F;"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5"
                            >
                                <path d="M1.5 8.67v8.58A2.25 2.25 0 003.75 19.5h16.5a2.25 2.25 0 002.25-2.25V8.67l-9.69 5.79a1.5 1.5 0 01-1.54 0L1.5 8.67z" />
                                <path d="M22.5 6.42V6a2.25 2.25 0 00-2.25-2.25H3.75A2.25 2.25 0 001.5 6v.42l10.46 6.25a.75.75 0 00.77 0L22.5 6.42z" />
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            E-mail
                        </h3>

                    </div>

                    @if ($footer?->email)
                        <a
                            href="mailto:{{ $footer->email }}"
                            class="break-all text-sm text-white/90 transition hover:text-[#66D1C8]"
                        >
                            {{ $footer->email }}
                        </a>
                    @else
                        <p class="text-sm text-white/70">
                            E-mail belum diatur.
                        </p>
                    @endif

                </div>


                {{-- =========================
                    TELEPON
                ========================== --}}
                <div>

                    <div class="mb-4 flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full text-white"
                            style="background-color: #00786F;"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M1.5 4.5A3 3 0 014.5 1.5h2.18a2.25 2.25 0 012.18 1.69l.76 3.05a2.25 2.25 0 01-.57 2.13L7.67 9.75a12.04 12.04 0 006.58 6.58l1.38-1.38a2.25 2.25 0 012.13-.57l3.05.76a2.25 2.25 0 011.69 2.18v2.18a3 3 0 01-3 3h-1.5C9.72 22.5 1.5 14.28 1.5 4.5z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            Telepon
                        </h3>

                    </div>

                    <div class="space-y-1 text-sm text-white/90">

                        @if ($footer?->telepon_1)
                            <p>{{ $footer->telepon_1 }}</p>
                        @endif

                        @if ($footer?->telepon_2)
                            <p>{{ $footer->telepon_2 }}</p>
                        @endif

                        @if (!$footer?->telepon_1 && !$footer?->telepon_2)
                            <p class="text-white/70">
                                Nomor telepon belum diatur.
                            </p>
                        @endif

                    </div>

                </div>


                {{-- =========================
                    SOSIAL MEDIA
                ========================== --}}
                <div>

                    <div class="mb-4 flex items-center gap-3">

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full text-white"
                            style="background-color: #00786F;"
                        >
                            <span class="text-lg font-bold">
                                #
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            Ikuti Kami
                        </h3>

                    </div>


                    {{-- SOCIAL MEDIA --}}
                    <div class="flex items-center gap-4">

                        @if ($footer?->instagram)
                            <a
                                href="{{ $footer->instagram }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="transition hover:scale-110 hover:text-[#66D1C8]"
                                aria-label="Instagram"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5a4.25 4.25 0 004.25 4.25h8.5a4.25 4.25 0 004.25-4.25v-8.5a4.25 4.25 0 00-4.25-4.25h-8.5z" />
                                    <path d="M12 7a5 5 0 100 10 5 5 0 000-10zm0 1.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7z" />
                                    <circle cx="17.5" cy="6.5" r="1.25" />
                                </svg>
                            </a>
                        @endif


                        @if ($footer?->facebook)
                            <a
                                href="{{ $footer->facebook }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="transition hover:scale-110 hover:text-[#66D1C8]"
                                aria-label="Facebook"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path d="M13.5 22v-8h2.75l.5-3h-3.25V9.05c0-.87.29-1.55 1.6-1.55h1.7V4.82c-.29-.04-1.28-.12-2.43-.12-2.4 0-4.05 1.46-4.05 4.15V11H7.6v3h2.72v8h3.18z" />
                                </svg>
                            </a>
                        @endif


                        @if ($footer?->youtube)
                            <a
                                href="{{ $footer->youtube }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="transition hover:scale-110 hover:text-[#66D1C8]"
                                aria-label="YouTube"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path d="M23.5 6.2a3 3 0 00-2.1-2.12C19.55 3.5 12 3.5 12 3.5s-7.55 0-9.4.58A3 3 0 00.5 6.2 31.7 31.7 0 000 12a31.7 31.7 0 00.5 5.8 3 3 0 002.1 2.12c1.85.58 9.4.58 9.4.58s7.55 0 9.4-.58a3 3 0 002.1-2.12A31.7 31.7 0 0024 12a31.7 31.7 0 00-.5-5.8zM9.75 15.75v-7.5L16.25 12l-6.5 3.75z" />
                                </svg>
                            </a>
                        @endif


                        @if ($footer?->whatsapp)
                            <a
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footer->whatsapp) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="transition hover:scale-110 hover:text-[#66D1C8]"
                                aria-label="WhatsApp"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path d="M12 2a10 10 0 00-8.66 15l-1.1 4.02 4.13-1.08A10 10 0 1012 2zm0 1.5a8.5 8.5 0 016.01 14.51A8.5 8.5 0 0112 20.5a8.4 8.4 0 01-4.27-1.15l-.3-.18-2.45.64.65-2.36-.2-.31A8.5 8.5 0 1112 3.5zm-3.1 3.8c-.2 0-.52.08-.8.38-.27.3-1.05 1.03-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.08 3.33 5.14 4.54 2.54 1 2.54.67 3 .63.46-.04 1.48-.6 1.69-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.15-.48-.27-.25-.12-1.48-.73-1.71-.81-.23-.08-.4-.12-.57.12-.17.25-.65.81-.8.98-.15.17-.29.19-.54.06-.25-.12-1.03-.38-1.96-1.21-.72-.64-1.21-1.42-1.35-1.67-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.44.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.57-1.36-.78-1.86-.21-.49-.42-.42-.57-.42z" />
                                </svg>
                            </a>
                        @endif

                    </div>


                    @if ($footer?->deskripsi_sosial)

                        <p class="mt-4 text-sm leading-6 text-white/80">
                            {{ $footer->deskripsi_sosial }}
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        COPYRIGHT
    ========================== --}}
    <div style="background-color: #00786F;">

        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-6 py-5 text-sm text-white/90 sm:flex-row lg:px-8"
        >

            <p>
                &copy; {{ date('Y') }}
                {{ $footer?->copyright ?? 'PTSP' }}.
                Hak cipta dilindungi.
            </p>

            @if ($footer?->dikelola_oleh)

                <p>
                    {{ $footer->dikelola_oleh }}
                </p>

            @endif

        </div>

    </div>

</footer>
