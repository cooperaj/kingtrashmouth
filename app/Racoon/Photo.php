<?php

declare(strict_types=1);

namespace App\Racoon;

readonly class Photo
{
    public function __construct(
        public string $id,
        public string $alt,
        public int $width,
        public int $height,
        public string $photographerName,
        public string $photographerUsername,
        public string $photographerProfileUrl,
    ) {
    }

    /**
     * @param array{
     *     id: string,
     *     alt_description: string,
     *     width: int,
     *     height: int,
     *     user: array{
     *         name: string,
     *         username: string,
     *         links: array{
     *             html: string,
     *         },
     *     },
     * } $data
     * @return self
     */
    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['alt_description'],
            $data['width'],
            $data['height'],
            $data['user']['name'],
            $data['user']['username'],
            $data['user']['links']['html'],
        );
    }
}