<?php

declare(strict_types=1);

namespace App\Racoon;

readonly class Photo
{
    public function __construct(
        public string $url,
        public string $alt,
        public int $width,
        public int $height,
        public string $photographerName,
        public string $photographerUsername,
        public string $photographerProfileUrl,
    )
    {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['cached_url'],
            $data['alt_description'],
            $data['width'],
            $data['height'],
            $data['user']['name'],
            $data['user']['username'],
            $data['user']['links']['html'],
        );
    }
}