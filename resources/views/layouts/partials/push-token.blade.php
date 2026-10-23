<script>
    (function () {
        var endpoint = @json(route('device-tokens.store', [], false));
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

        var destroyEndpoint = @json(route('device-tokens.destroy', [], false));

        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form.matches || !form.matches('form[action$="/logout"]')) return;

            var token = window.OREGONET_FCM_TOKEN;
            if (!token || !csrf || form.dataset.fcmDone) return;

            e.preventDefault();
            form.dataset.fcmDone = '1';

            var proceed = function () { form.submit(); };
            fetch(destroyEndpoint, {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf.getAttribute('content'),
                },
                body: JSON.stringify({ token: token }),
            }).then(proceed, proceed);
        }, true);
    })();
</script>