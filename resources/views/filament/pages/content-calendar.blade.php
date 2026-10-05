<x-filament-panels::page>

    @vite('resources/js/app.js')

    <div class="w-full">

        {{-- HEADER --}}
        <div class="w-full rounded-xl px-6 py-5" style="background: linear-gradient(90deg,#10b981,#a7f3d0);">

            <div class="flex items-center justify-between">


                {{-- KIRI --}}
                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 text-white">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-6 w-6">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 7.5h16.5M5.25 5.25h13.5a1.5 1.5 0 011.5 1.5v13.5a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5z" />

                        </svg>

                    </div>


                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            Kalender Konten Medsos
                        </h1>

                        <p class="mt-1 text-sm text-white">
                            Matriks perencanaan tayang konten media sosial Humas PTSP
                        </p>
                    </div>


                </div>


                {{-- KANAN --}}
                <div>

                    <a href="{{ route('filament.admin.resources.konten-medsos.create') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 text-sm font-medium text-white shadow-sm hover:bg-emerald-600">

                        <span class="text-lg">
                            +
                        </span>

                        Buat Konten

                    </a>

                </div>


            </div>

        </div>

        {{-- ================= STATISTIK ================= --}}

        <div class="flex justify-center w-full mb-6">

            <div class="flex items-center gap-1 rounded-2xl border border-gray-200 bg-white px-2 py-1 shadow-sm">


                {{-- SEMUA --}}
                <div class="flex items-center gap-2 rounded-xl bg-blue-50 px-4 py-2">

                    <span class="text-sm font-semibold text-blue-600">
                        Semua
                    </span>

                    <span class="rounded-md bg-blue-100 px-2 py-0.5 text-xs font-bold text-blue-600">
                        {{ $stats['total'] ?? 0 }}
                    </span>

                </div>



                {{-- SIAP TAYANG --}}
                <div class="flex items-center gap-2 px-4 py-2">

                    <span class="text-sm text-gray-600">
                        🕒 Siap Tayang
                    </span>

                    <span class="rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-600">
                        {{ $stats['siapTayang'] ?? 0 }}
                    </span>

                </div>



                {{-- REVIEW --}}
                <div class="flex items-center gap-2 px-4 py-2">

                    <span class="text-sm text-gray-600">
                        ⚠️ Butuh Review
                    </span>

                    <span class="rounded-md bg-orange-50 px-2 py-0.5 text-xs font-bold text-orange-600">
                        {{ $stats['review'] ?? 0 }}
                    </span>

                </div>



                {{-- PUBLISHED --}}
                <div class="flex items-center gap-2 px-4 py-2">

                    <span class="text-sm text-gray-600">
                        ✔ Sudah Tayang
                    </span>

                    <span class="rounded-md bg-green-50 px-2 py-0.5 text-xs font-bold text-green-600">
                        {{ $stats['published'] ?? 0 }}
                    </span>

                </div>


            </div>

        </div>
        {{-- ================= FILTER & STATUS ================= --}}

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">


            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">


                {{-- STATUS --}}

                <div class="flex flex-wrap items-center gap-3">


                    <span class="text-sm font-semibold text-gray-700">
                        Status
                    </span>


                    <span class="rounded-full bg-gray-100 px-4 py-2 text-xs font-medium text-gray-600">
                        Draft
                    </span>


                    <span class="rounded-full bg-orange-50 px-4 py-2 text-xs font-medium text-orange-600">
                        Review
                    </span>


                    <span class="rounded-full bg-blue-50 px-4 py-2 text-xs font-medium text-blue-600">
                        Siap Tayang
                    </span>


                    <span class="rounded-full bg-green-50 px-4 py-2 text-xs font-medium text-green-600">
                        Published
                    </span>


                </div>



                {{-- FILTER --}}

                <div class="flex flex-wrap gap-3">


                    <select id="filterStatus"
                        class="rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">


                        <option value="all">
                            Semua Status
                        </option>


                        <option value="Draft">
                            Draft
                        </option>


                        <option value="Review">
                            Review
                        </option>


                        <option value="Siap Tayang">
                            Siap Tayang
                        </option>


                        <option value="Published">
                            Published
                        </option>


                    </select>




                    <select id="filterPlatform"
                        class="rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">


                        <option value="all">
                            Semua Platform
                        </option>


                        <option value="Instagram">
                            Instagram
                        </option>


                        <option value="TikTok">
                            TikTok
                        </option>


                        <option value="Facebook">
                            Facebook
                        </option>


                        <option value="Youtube">
                            Youtube
                        </option>


                    </select>


                </div>


            </div>


        </div>

        {{-- ================= CALENDAR ================= --}}



        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">


            <div id="calendar" class="content-calendar min-h-[720px]">

            </div>


        </div>


        {{-- ================= LIST KONTEN ================= --}}

        <div class="mt-6 w-full rounded-2xl border border-gray-100 bg-white shadow-sm">


            {{-- HEADER --}}
            <div class="flex items-center justify-between border-b border-gray-100 px-8 py-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-5 w-5">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 0H5.625A2.625 2.625 0 003 4.875v14.25A2.625 2.625 0 005.625 21.75h12.75A2.625 2.625 0 0021 19.125V7.5L8.25 2.25z" />

                        </svg>

                    </div>


                    <div>

                        <h2 class="text-lg font-bold text-gray-900">
                            Daftar Konten
                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Kelola seluruh konten media sosial.
                        </p>

                    </div>

                </div>

                <span class="text-sm text-gray-400">
                    {{ count($konten) }} Konten
                </span>

            </div>

            {{-- CARD --}}
            <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">


                @foreach($konten as $item)

                    <div
                        class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl">
                        <div class="flex justify-between">

                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                {{ $item->platform }}
                            </span>


                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600">
                                {{ $item->format }}
                            </span>

                        </div>



                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                            {{ $item->judul }}
                        </h3>



                        <div class="mt-5 flex items-center justify-between">


                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                                     @if($item->status == 'Published')
                                                        bg-green-50 text-green-700

                                                    @elseif($item->status == 'Review')
                                                        bg-orange-50 text-orange-700

                                                    @elseif($item->status == 'Siap Tayang')
                                                        bg-blue-50 text-blue-700

                                                    @else
                                                        bg-gray-100 text-gray-700
                                                    @endif
                                                   ">

                                {{ $item->status }}

                            </span>



                            <span class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </span>


                        </div>



                        <div class="mt-5 flex gap-3 border-t pt-4">


                            <a href="/admin/konten-medsos/{{ $item->id }}/edit"
                                class="rounded-lg bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-600">
                                Edit
                            </a>


                            <a href="/admin/konten-medsos/{{ $item->id }}"
                                class="rounded-lg bg-gray-50 px-4 py-2 text-xs font-semibold text-gray-700">
                                Detail
                            </a>


                            <button onclick="deleteContent({{ $item->id }})"
                                style="
                                                                                                                                                                                                    background:#dc2626;
                                                                                                                                                                                                    color:white;
                                                                                                                                                                                                    padding:8px 16px;
                                                                                                                                                                                                    border-radius:8px;
                                                                                                                                                                                                    font-size:12px;
                                                                                                                                                                                                    font-weight:600;
                                                                                                                                                                                                ">
                                Hapus
                            </button>


                        </div>


                    </div>


                @endforeach


            </div>


        </div>

        <div id="deleteModal" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.55);
    z-index:999999;
    align-items:center;
    justify-content:center;
">


            <div style="
        width:420px;
        background:white;
        border-radius:20px;
        padding:32px;
        box-shadow:0 20px 50px rgba(0,0,0,.25);
    ">


                <div class="text-center">


                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-3xl">
                        🗑️
                    </div>


                    <h2 class="mt-5 text-xl font-bold text-gray-900">
                        Delete Konten Media Sosial
                    </h2>


                    <p class="mt-3 text-gray-500">
                        Are you sure you would like to do this?
                    </p>


                    <div class="mt-6 grid grid-cols-2 gap-4">


                        <button type="button" onclick="closeDeleteModal()"
                            class="rounded-xl border border-gray-200 px-5 py-3 font-semibold text-gray-700 hover:bg-gray-50">

                            Cancel

                        </button>


                        <button style="display:block !important; width:100%; background:red; color:white; padding:15px;"
                            onclick="confirmDelete()">

                            Hapus

                        </button>

                    </div>


                </div>


            </div>


        </div>
        @push('scripts')

            <script>

                document.addEventListener('DOMContentLoaded', function () {

                    if (window.initContentCalendar) {

                        window.initContentCalendar(
                            @json($events ?? [])
                        );

                    }

                });



                let deleteId = null;


                function deleteContent(id) {

                    deleteId = id;

                    const modal = document.getElementById('deleteModal');

                    modal.style.display = 'flex';

                }



                function closeDeleteModal() {

                    const modal = document.getElementById('deleteModal');

                    modal.style.display = 'none';

                }



                function confirmDelete() {


                    fetch('/admin/konten-medsos/' + deleteId + '/calendar-delete', {

                        method: 'DELETE',

                        headers: {

                            'X-CSRF-TOKEN':
                                document.querySelector('meta[name="csrf-token"]').content,

                            'Accept': 'application/json'

                        }

                    })


                        .then(response => response.json())


                        .then(data => {

                            console.log(data);


                            if (data.success) {

                                location.reload();

                            }


                        })

                        .catch(error => {

                            console.error(error);
                        });
                }


            </script>



        @endpush

</x-filament-panels::page>