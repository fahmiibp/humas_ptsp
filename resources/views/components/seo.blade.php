@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'url' => null,
    'type' => 'website', // 'website' atau 'article'
    'publishedTime' => null,
    'modifiedTime' => null,
    'section' => null,
    'noindex' => false,
])

@php
    $siteName = config('app.name');
    $fullTitle = $title ? $title . ' | ' . $siteName : $siteName;
    $canonical = $url ?? url()->current();
    $image = $image ?? asset('image/ptsp.png');
    $description = $description ?: 'Berita dan siaran pers terbaru dari ' . $siteName . '.';

    $schema = null;
    if ($type === 'article') {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
            'headline' => \Illuminate\Support\Str::limit($title, 110, ''),
            'description' => $description,
            'image' => [$image],
            'datePublished' => $publishedTime,
            'dateModified' => $modifiedTime ?? $publishedTime,
            'articleSection' => $section,
            'inLanguage' => 'id-ID',
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'logo' => ['@type' => 'ImageObject', 'url' => asset('image/ptsp.png')],
            ],
        ];
    }
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large' }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="id_ID">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title ?? $siteName }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $title ?? $siteName }}">

@if ($type === 'article')
    @if ($publishedTime)
        <meta property="article:published_time" content="{{ $publishedTime }}">
    @endif
    @if ($modifiedTime)
        <meta property="article:modified_time" content="{{ $modifiedTime }}">
    @endif
    @if ($section)
        <meta property="article:section" content="{{ $section }}">
    @endif
@endif

{{-- Twitter / X --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? $siteName }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

@if ($schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endif
