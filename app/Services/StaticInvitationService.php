<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class StaticInvitationService
{
    public function generate(Event $event): string
    {
        $event->loadMissing('template');

        $templateSlug = $event->template->slug;
        $viewName     = "templates.static.{$templateSlug}.template";
        $isPremium    = ! $event->template->plan->isFree();

        $html = View::make($viewName, [
            'event'        => $event,
            'watermark'    => ! $isPremium,
            'forScreenshot'=> true,
        ])->render();

        $outputDir  = "invitations/{$event->id}";
        $outputPath = "{$outputDir}/invitation.jpg";

        Storage::makeDirectory($outputDir);

        $absolutePath = Storage::path($outputPath);

        Browsershot::html($html)
            ->windowSize(800, 1131)
            ->setScreenshotType('jpeg', 90)
            ->save($absolutePath);

        return $outputPath;
    }
}
