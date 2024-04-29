<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>King Trashmouth</title>

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
                        src="{{ $photo->url }}"
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
