<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_if($event->user_id !== auth()->id(), 403);

        $request->validate([
            'photos'   => ['required', 'array', 'max:20'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'photos.required'   => 'يرجى اختيار صورة واحدة على الأقل.',
            'photos.*.image'    => 'الملف يجب أن يكون صورة.',
            'photos.*.mimes'    => 'الصور المقبولة: JPG, PNG, WEBP.',
            'photos.*.max'      => 'حجم الصورة لا يتجاوز 5 ميجابايت.',
        ]);

        $currentCount = $event->gallery()->count();
        $maxPhotos    = 20;

        foreach ($request->file('photos') as $index => $file) {
            if ($currentCount >= $maxPhotos) break;

            $path = $file->store("galleries/{$event->id}", 'public');

            $event->gallery()->create([
                'image_path' => $path,
                'sort_order' => $currentCount + $index,
            ]);

            $currentCount++;
        }

        return back()->with('gallery_success', 'تم رفع الصور بنجاح ✓');
    }

    public function destroy(Event $event, EventGallery $gallery): RedirectResponse
    {
        abort_if($event->user_id !== auth()->id(), 403);
        abort_if($gallery->event_id !== $event->id, 403);

        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return back()->with('gallery_success', 'تم حذف الصورة ✓');
    }
}
