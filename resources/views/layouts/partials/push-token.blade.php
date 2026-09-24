{{-- Hanya untuk pekerja. Token FCM dititipkan oleh aplikasi Flutter (lihat main.dart)
     lewat window.OREGONET_FCM_TOKEN dan event "oregonet-fcm-token". Di browser biasa
     token tidak ada, jadi script ini tidak melakukan apa-apa. --}}
@auth
@if (auth()->user()->role === 'pekerja')
<script>
    (function () {
        var endpoint = @json(route('worker.device-tokens.store', [], false));
        var csrf = document.querySelector('meta[name="csrf-token"]');

        function register(token) {
            if (!token || !csrf) return;

            fetch(endpoint, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf.getAttribute('content'),
                },
                body: JSON.stringify({ token: token, platform: 'android' }),
            }).catch(function () {});
        }

        register(window.OREGONET_FCM_TOKEN);

        window.addEventListener('oregonet-fcm-token', function (event) {
            register(event.detail);
        });
    })();
</script>
@endif
@endauth
