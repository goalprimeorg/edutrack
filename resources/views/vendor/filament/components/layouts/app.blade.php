{{-- resources/views/vendor/filament/components/layouts/app.blade.php --}}
<x-filament::layouts.app>
    {{-- Inject custom PWA assets --}}
    @push('head')
        <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
        <meta name="theme-color" content="#0d6efd">
        <link rel="icon" href="{{ asset('icons/icon-192x192.png') }}">
    @endpush

    @push('scripts')
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(() => console.log('Service Worker registered.'))
                    .catch(error => console.error('Service Worker registration failed:', error));
            }
        </script>
    @endpush
</x-filament::layouts.app>
