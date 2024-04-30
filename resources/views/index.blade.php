<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Little King Trashmouth</title>

        <meta property="og:title" content="Little King Trashmouth" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://kingtrashmouth.org" />
        <meta property="og:description" content="His name's Little King Trashmouth, he's gay... yeah, he's got a boyfriend - they just got maaaaried." />
        <meta property="og:image" content="{{ asset('storage/' . $photo->id . '_OG.webp') }}" />

        @vite('resources/css/app.scss')
    </head>
    <body>
        <main class="is-flex is-flex-direction-column is-align-items-center">
            <div class="image is-flex is-flex-direction-column is-align-items-center">
                <div class="header">
                   {{ svg('header')->inline(true) }}
                </div>
                <figure>
                    <img
                        src="{{ asset('storage/' . $photo->id . '.webp') }}"
                        alt="{{ $photo->alt }}"
                    />
                    <figcaption class="is-family-primary">
                        <a href="{{ $photo->photographerProfileUrl }}">
                            &copy; {{ $photo->photographerName }}
                        </a>
                    </figcaption>
                </figure>
            </div>
        </main>
        
        {{-- @vite('resources/js/app.js') --}}
    </body>
</html>
