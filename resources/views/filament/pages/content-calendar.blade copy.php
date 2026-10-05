@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-filament-panels::page>

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold">
                Kalender Konten Medsos
            </h1>

            <p class="text-gray-500">
                Kelola jadwal publikasi konten media sosial
            </p>
        </div>


        {{-- Calendar Card --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-6">

                <div>
                    <h2 class="text-xl font-bold">
                        Oktober 2026
                    </h2>

                    <p class="text-sm text-gray-500">
                        Rencana konten dan jadwal publikasi
                    </p>
                </div>


                <div class="flex gap-2">

                    <button class="px-4 py-2 bg-primary-600 text-white rounded-lg">
                        + Buat Konten
                    </button>

                </div>

            </div>


            {{-- Kalender sementara --}}
            <div class="grid grid-cols-7 gap-2 text-center">


                @foreach([
                'Sen',
                'Sel',
                'Rab',
                'Kam',
                'Jum',
                'Sab',
                'Min'
                ] as $day)

                <div class="font-semibold text-gray-600">
                    {{ $day }}
                </div>

                @endforeach



                @for($i = 1; $i <= 31; $i++) <div class="min-h-24 border rounded-lg p-2 text-left">

                    <div class="font-semibold">
                        {{ $i }}
                    </div>


                    @if($i == 1)

                    <div class="mt-2 text-xs bg-blue-100 text-blue-700 rounded p-1">
                        Hari Kesaktian Pancasila
                    </div>

                    @endif


            </div>

            @endfor


        </div>


    </div>


    </div>

    @push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            initContentCalendar([]);

        });

    </script>

    @endpush

</x-filament-panels::page>