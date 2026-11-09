@inject('repo', 'App\Repositories\ArticleRepository')

@php
    $categories = $repo->categories();
@endphp

<footer class="mt-16 text-white" style="background-color: #009689;">

    {{-- =========================
        FOOTER UTAMA
    ========================== --}}
    <div style="border-bottom: 1px solid #00877C;">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5 lg:items-start">

                {{-- LOGO --}}
                <div class="lg:col-span-1">
                    <a
                        href="{{ route('home') }}"
                        wire:navigate
                        class="inline-flex items-center"
                    >
                        <img
                            src="{{ asset('image/ptsp.png') }}"
                            alt="Logo PTSP"
                            class="w-44 object-contain"
                        >
                    </a>
                </div>


                {{-- ALAMAT --}}
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

                    <p class="text-sm leading-6 text-white/90">
                        Jl. Mgr Sugiyopranoto No.1, Pendrikan Kidul,<br>
                        Kec. Semarang Tengah, Kota Semarang,<br>
                        Jawa Tengah 50131
                    </p>
                </div>


                {{-- EMAIL --}}
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

                    <a
                        href="mailto:dpmptsp@jatengprov.go.id"
                        class="text-sm text-white/90 transition hover:text-[#66D1C8]"
                    >
                        dpmptsp@jatengprov.go.id
                    </a>
                </div>


                {{-- TELEPON --}}
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
                        <p>(024) 3547091 - 3547438</p>
                        <p>(024) 3541487 - 3563069</p>
                    </div>
                </div>


                {{-- SOSIAL MEDIA --}}
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

                    <x-social-links
                        :label="false"
                        :dark="true"
                        class="gap-4"
                    />

                    <p class="mt-4 text-sm leading-6 text-white/80">
                        Dapatkan informasi terbaru melalui media sosial kami.
                    </p>
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
                &copy; {{ date('Y') }} PTSP.
                Hak cipta dilindungi.
            </p>

            <p>
                Dikelola oleh PTSP
            </p>

        </div>

    </div>

</footer>