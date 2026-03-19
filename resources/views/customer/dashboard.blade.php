@extends('layouts.customer')
@section('title', 'أحداثي')

@section('content')
<div class="container">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:700;">أهلاً، {{ auth()->user()->name }} ♥</h1>
            <p style="color:#78716c; margin-top:.25rem;">إدارة دعواتك</p>
        </div>
        <a href="{{ route('customer.events.create') }}" class="btn btn-primary">
            + دعوة جديدة
        </a>
    </div>

    {{-- Events Grid --}}
    @if ($events->isEmpty())
        <div style="text-align:center; padding:5rem 1rem;">
            <div style="font-size:4rem; margin-bottom:1rem;">💌</div>
            <h2 style="font-size:1.3rem; margin-bottom:.5rem;">لا توجد دعوات بعد</h2>
            <p style="color:#78716c; margin-bottom:1.5rem;">ابدأ بإنشاء دعوتك الأولى الآن!</p>
            <a href="{{ route('customer.events.create') }}" class="btn btn-primary">إنشاء دعوة</a>
        </div>
    @else
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:1.5rem;">
            @foreach ($events as $event)
                <div class="card" style="overflow:hidden; padding:0;">
                    {{-- Template Thumbnail --}}
                    <div style="height:160px; background:linear-gradient(135deg,#0a1628,#162035,#a8863a); display:flex; align-items:center; justify-content:center;">
                        @if ($event->template?->thumbnail)
                            <img src="{{ Storage::url($event->template->thumbnail) }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <span style="font-size:3rem;">💍</span>
                        @endif
                    </div>

                    <div style="padding:1.25rem;">
                        <h3 style="font-size:1.1rem; font-weight:600;">
                            {{ $event->coupleName() }}
                        </h3>
                        <p style="color:#78716c; font-size:.875rem; margin-top:.3rem;">
                            {{ $event->event_date->format('d M Y') }}
                            · {{ $event->venue_name }}
                        </p>

                        <div style="display:flex; align-items:center; gap:.5rem; margin-top:.75rem;">
                            <span style="
                                padding:.25rem .75rem;
                                border-radius:999px;
                                font-size:.75rem;
                                background:{{ $event->is_published ? '#dcfce7' : '#fef9c3' }};
                                color:{{ $event->is_published ? '#166534' : '#854d0e' }};
                            ">
                                {{ $event->is_published ? 'منشور' : 'مسودة' }}
                            </span>

                            <span style="font-size:.75rem; color:#78716c; word-break:break-all;">
                                {{ $event->invitationUrl() }}
                            </span>
                        </div>

                        <div style="display:flex; gap:.5rem; margin-top:1rem;">
                            <a href="{{ route('customer.events.show', $event) }}"
                               class="btn btn-outline" style="flex:1; justify-content:center; font-size:.85rem; padding:.5rem;">
                                عرض
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
