@php
use App\Models\FooterSetting;
use App\Models\SocialLink;

$footer = FooterSetting::where('is_active', true)->first();

$icons = [
'instagram' => 'instagram',
'tiktok' => 'tiktok',
'facebook' => 'facebook',
'youtube' => 'youtube',
'x' => 'x',
'whatsapp' => 'whatsapp',
'telegram' => 'telegram',
'linkedin' => 'linkedin',
'threads' => 'threads',
'pinterest' => 'pinterest',
'reddit' => 'reddit',
'discord' => 'discord',
'github' => 'github',
'medium' => 'medium',
'spotify' => 'spotify',
'twitch' => 'twitch',
'snapchat' => 'snapchat',
];

$socials = SocialLink::query()
->where('is_active', true)
->orderBy('sort_order')
->get()
->filter(fn ($social) => isset($icons[strtolower($social->icon ?? '')]));
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
                        class="inline-flex items-center">

                        @if ($footer?->logo)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($footer->logo) }}"
                            alt="Logo"
                            class="w-44 object-contain">
                        @else
                        <img
                            src="{{ asset('image/ptsp.png') }}"
                            alt="Logo PTSP"
                            class="w-44 object-contain">
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
                            style="background-color: #00786F;">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5">
                                <path
                                    fill-rule="evenodd"
                                    d="M11.54 22.351l.07.04.04.02a.75.75 0 00.7 0l.04-.02.07-.04c.36-.21 5.79-3.54 7.79-8.25A7.5 7.5 0 004.75 11c0 4.71 5.43 8.04 6.79 8.25zM12 13.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"
                                    clip-rule="evenodd" />
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
                            style="background-color: #00786F;">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5">
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
                        class="break-all text-sm text-white/90 transition hover:text-[#66D1C8]">
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
                            style="background-color: #00786F;">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-5 w-5">
                                <path
                                    fill-rule="evenodd"
                                    d="M1.5 4.5A3 3 0 014.5 1.5h2.18a2.25 2.25 0 012.18 1.69l.76 3.05a2.25 2.25 0 01-.57 2.13L7.67 9.75a12.04 12.04 0 006.58 6.58l1.38-1.38a2.25 2.25 0 012.13-.57l3.05.76a2.25 2.25 0 011.69 2.18v2.18a3 3 0 01-3 3h-1.5C9.72 22.5 1.5 14.28 1.5 4.5z"
                                    clip-rule="evenodd" />
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
                            style="background-color: #00786F;">
                            <span class="text-lg font-bold">
                                #
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            Ikuti Kami
                        </h3>

                    </div>

                    {{-- SOCIAL MEDIA --}}
                    <div class="flex flex-wrap items-center gap-4">

                        @forelse ($socials as $social)

                        @php
                        $icon = strtolower($social->icon);
                        $iconUrl = 'https://cdn.simpleicons.org/' . $icons[$icon];
                        @endphp

                        <a
                            href="{{ $social->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ $social->name }}"
                            title="{{ $social->name }}"
                            class="inline-flex items-center justify-center transition duration-200 hover:scale-110">

                            <img
                                src="{{ $iconUrl }}"
                                alt=""
                                width="24"
                                height="24"
                                loading="lazy"
                                class="h-6 w-6 brightness-0 invert transition duration-200 hover:opacity-70">

                        </a>

                        @empty

                        <p class="text-sm text-white/70">
                            Media sosial belum diatur.
                        </p>

                        @endforelse

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
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-6 py-5 text-sm text-white/90 sm:flex-row lg:px-8">

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