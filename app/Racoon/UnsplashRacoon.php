<?php

declare(strict_types=1);

namespace App\Racoon;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageManagerInterface;
use Unsplash\HttpClient;
use Unsplash\Photo as UnsplashPhoto;

class UnsplashRacoon implements RacoonInterface
{
    public function __construct(string $applicationId, private ImageManagerInterface $imageManager)
    {
        HttpClient::init([
            'applicationId' => $applicationId,
            'utmSource'     => 'King Trash Mouth'
        ]);
    }

    public function getRandom(): Photo 
    {
        return Cache::remember('todays_photo', Carbon::now()->secondsUntilEndOfDay(), function() {
            $photo = UnsplashPhoto::random([
                'query' => 'racoon'
            ]);

            $image = $this->imageManager->read(file_get_contents($photo->download()));
    
            Storage::disk('public')->put($photo->id . '.webp', (string) $image->scaleDown(width: 1536)->toWebp(80));
            Storage::disk('public')->put($photo->id . '_OG.webp', (string) $image->coverDown(width: 1200, height: 630, position: 'center')->toWebp(80));

            $photo = $photo->toArray();

            return Photo::from($photo);
        });
    }
}