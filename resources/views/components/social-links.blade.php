@props(['label' => true])

@php
    use App\Models\SocialLink;

    // Daftar ikon yang diizinkan
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
        ->filter(fn($social) => isset($icons[strtolower($social->icon ?? '')]));
@endphp

<div {{ $attributes->merge([
    'class' => 'flex flex-wrap items-center gap-3',
]) }}>
    @if ($label)
        <span class="text-sm font-semibold text-gray-700">
            Ikuti Kami:
        </span>
    @endif

    @foreach ($socials as $social)
        @php
            $icon = strtolower($social->icon);
            $iconUrl = 'https://cdn.simpleicons.org/' . $icons[$icon];
        @endphp

        <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social->name }}"
            title="{{ $social->name }}"
            class="inline-flex items-center justify-center
                   text-gray-500 transition duration-200
                   hover:scale-110 hover:text-gray-900">
            <img src="{{ $iconUrl }}" alt="" width="20" height="20" loading="lazy" class="h-5 w-5">
        </a>
    @endforeach
</div>
