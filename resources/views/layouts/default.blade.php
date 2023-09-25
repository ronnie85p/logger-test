<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? env('APP_NAME') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="/assets/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <header class="p-header py-2 mb-4">
            <div class="container">
                <span class="logo">
                    <a href="/" style="color: inherit; text-decoration: inherit">{{ env('APP_NAME') }}</a>
                </span>
            </div>
        </header>

        <section class="p-content">
            <div class="container">
                @yield('content')
            </div>
        </section>

        <footer class="p-footer py-2">
            <div class="container">
                <div class="text-center">{{ env('APP_NAME') }}&COPY;{{ date('Y') }}</div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="/assets/js/ajaxform.js"></script>



        <script>
            // Get all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (form.dataset.ajax != 1) return true;
                
                // Init form for ajax requests
                new AjaxForm(form, {
                    onBeforeRequest(e, config) {
                        console.log("beforerequest", e, config);

                        switch (config.method.toUpperCase()) {
                            case 'DELETE':

                                if (!confirm(form.getAttribute('title'))) {
                                    return false;
                                }

                                break;
                        }

                        return true;
                    },
                    onAfterRequest(e) {
                        // console.log("afterrequest", e);
                    },
                    onSuccessRequest(response) {
                        if (response) {
                            if (confirm('Reload page?')) {
                                window.location.reload();
                            }
                        }
                        console.log("successrequest", response);
                    },
                    onErrorRequest(error) {
                        console.log("errorrequest", error);
                    },
                });
            });
        </script>
    </body>
</html>