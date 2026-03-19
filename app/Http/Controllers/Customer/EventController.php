<?php

namespace App\Http\Controllers\Customer;

use App\Enums\EventCategory;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EventController extends Controller
{
    public function create(): View
    {
        return view('customer.events.create');
    }

    public function show(Event $event): View
    {
        $this->authorizeEvent($event);

        $event->load(['template', 'gallery', 'wishes', 'rsvpResponses']);

        return view('customer.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $this->authorizeEvent($event);

        return view('customer.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorizeEvent($event);

        $cat = $event->category instanceof EventCategory
            ? $event->category
            : EventCategory::from($event->category ?? 'wedding');

        [$primaryLabel, $secondaryLabel] = $cat->nameLabels();

        $request->validate([
            'groom_name'     => ['required', 'string', 'max:255'],
            'bride_name'     => [$cat->isCoupleEvent() ? 'required' : 'nullable', 'string', 'max:255'],
            'event_date'     => ['required', 'date'],
            'event_time'     => ['nullable', 'string', 'max:10'],
            'venue_name'     => ['required', 'string', 'max:255'],
            'venue_address'  => ['nullable', 'string', 'max:255'],
            'venue_map_link' => ['nullable', 'string', 'max:500'],
            'music_url'      => ['nullable', 'url', 'max:500'],
            'subdomain'      => ['nullable', 'alpha_dash', 'max:100', 'unique:events,subdomain,' . $event->id],
            'password_hint'  => ['nullable', 'string', 'max:255'],
            'new_password'   => ['nullable', 'string', 'min:4', 'max:100'],
            'is_published'   => ['boolean'],
        ], [
            'groom_name.required'  => "يرجى إدخال {$primaryLabel}.",
            'bride_name.required'  => "يرجى إدخال {$secondaryLabel}.",
            'event_date.required'  => 'يرجى تحديد تاريخ المناسبة.',
            'venue_name.required'  => 'يرجى إدخال اسم المكان.',
            'subdomain.unique'     => 'هذا الـ subdomain محجوز، جرّب اسماً آخر.',
            'subdomain.alpha_dash' => 'الـ subdomain يقبل فقط حروف وأرقام وشرطات.',
            'venue_map_link.url'   => 'رابط الخريطة غير صحيح.',
        ]);

        $data = [
            'groom_name'     => $request->groom_name,
            'bride_name'     => $request->bride_name,
            'event_date'     => $request->event_date,
            'event_time'     => $request->event_time ?: null,
            'venue_name'     => $request->venue_name,
            'venue_address'  => $request->venue_address ?: null,
            'venue_map_link' => $request->venue_map_link ?: null,
            'custom_data'    => array_filter(array_merge(
                $event->custom_data ?? [],
                ['music_url' => $request->music_url ?: null]
            )),
            'subdomain'      => $request->subdomain ?: null,
            'password_hint'  => $request->password_hint ?: null,
            'is_published'   => $request->boolean('is_published'),
        ];

        if ($request->filled('new_password')) {
            $data['password'] = bcrypt($request->new_password);
        }

        $event->update($data);

        return redirect()->route('customer.events.show', ['event' => $event->id])
            ->with('success', 'تم تحديث بيانات الحفل بنجاح ✓');
    }

    public function approveWish(Event $event, Wish $wish): RedirectResponse
    {
        $this->authorizeEvent($event);
        abort_if($wish->event_id !== $event->id, 403);

        $wish->update(['is_approved' => !$wish->is_approved]);

        return back();
    }

    public function deleteWish(Event $event, Wish $wish): RedirectResponse
    {
        $this->authorizeEvent($event);
        abort_if($wish->event_id !== $event->id, 403);

        $wish->delete();

        return back();
    }

    private function authorizeEvent(Event $event): void
    {
        abort_if($event->user_id !== auth()->id(), 403);
    }
}
