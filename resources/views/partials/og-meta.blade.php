@php
    $ogTitle       = $event->coupleName() . ' – ' . $event->event_date->translatedFormat('d F Y');
    $ogDescription = $event->venue_name . ($event->event_time ? ' · ' . $event->event_time : '');
    $ogUrl         = $event->id ? $event->invitationUrl() : url()->current();

    // Use generated static card if available, otherwise template thumbnail
    $cardPath  = "invitations/{$event->id}/invitation.jpg";
    $ogImage   = \Illuminate\Support\Facades\Storage::exists($cardPath)
        ? \Illuminate\Support\Facades\Storage::url($cardPath)
        : null;

    // Thumbnail fallback (public/thumbnails/{slug}.jpg)
    if (! $ogImage) {
        $thumb = public_path("thumbnails/{$event->template->slug}.jpg");
        if (file_exists($thumb)) {
            $ogImage = asset("thumbnails/{$event->template->slug}.jpg");
        }
    }
@endphp
{{-- Open Graph & Twitter Card --}}
<meta property="og:type"        content="website">
<meta property="og:url"         content="{{ $ogUrl }}">
<meta property="og:title"       content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
@if($ogImage)
<meta property="og:image"       content="{{ $ogImage }}">
<meta property="og:image:width"  content="800">
<meta property="og:image:height" content="1131">
@endif
<meta property="og:site_name"   content="فرحنا – Farahna">
<meta property="og:locale"      content="{{ app()->isLocale('ar') ? 'ar_AR' : 'en_US' }}">
<meta name="twitter:card"       content="summary_large_image">
<meta name="twitter:title"      content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDescription }}">
@if($ogImage)
<meta name="twitter:image"      content="{{ $ogImage }}">
@endif
