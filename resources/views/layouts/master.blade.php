<!DOCTYPE html>
<html lang="{{ $uiLocale }}" dir="{{ $textDir }}">

<head>
    @php
        $websiteSettings = App\Helpers\WebsiteSettingsHelper::getWebsiteSettings();
    @endphp
    <title>{{ $websiteSettings['title'] }} - @yield('page-title')</title>

    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="">
    <meta name="description" content="">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/version-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    @stack('style')
    <style>
        :root {
            --color-customColor: #0061ae;
        }
    </style>

</head>

<body>
    <div class="d-flex">
        <nav id="sidebar" class="bg-white shadow-sm">
            @include('partials.staff.menu')
        </nav>
        <main class="flex-grow-1">
            @if (!isset($header) || $header != false)
                @include('partials.staff.header')
            @endif
            <div class="container-fluid py-3">
                <div class="row mb-3 align-items-center">
                    <div class="col-auto">
                        <h4 class="mb-0">@yield('page-title')</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                    <div class="col text-end">
                        @yield('action-btn')
                    </div>
                </div>
                @yield('content')
            </div>
        </main>
    </div>
    <div class="modal fade" id="notification-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <h6 class="mt-2">
                        <i data-feather="monitor" class="me-2"></i>Desktop settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                        <label class="form-check-label fw-semibold ps-1" for="pcsetting1">Allow desktop
                            notification</label>
                    </div>
                    <p class="text-muted ms-5">
                        you get lettest content at a time when data will updated
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting2" />
                        <label class="form-check-label fw-semibold ps-1" for="pcsetting2">Store Cookie</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="save" class="me-2"></i>Application settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting3" />
                        <label class="form-check-label fw-semibold ps-1" for="pcsetting3">Backup Storage</label>
                    </div>
                    <p class="text-muted mb-4 ms-5">
                        Automaticaly take backup as par schedule
                    </p>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting4" />
                        <label class="form-check-label fw-semibold ps-1" for="pcsetting4">Allow guest to print
                            file</label>
                    </div>
                    <h6 class="mb-0 mt-5">
                        <i data-feather="cpu" class="me-2"></i>System settings
                    </h6>
                    <hr />
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                        <label class="form-check-label fw-semibold ps-1" for="pcsetting5">View other user chat</label>
                    </div>
                    <p class="text-muted ms-5">Allow to show public user message</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-light-primary btn-sm">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="commonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="commonModalOver" tabindex="-1" aria-labelledby="commonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    ✅ Success message!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

    </div>

    <script>
        function playNotificationSound(url) {
            const sound = new Audio(url);
            sound.volume = 0.7;
            sound.play().catch(err => console.error("Error playing sound:", err));
        }
        function showNotification(message, soundUrl) {
            const toastElement = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastMessage');
            toastBody.textContent = message;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            playNotificationSound(soundUrl);
        }
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('preloader').style.display = 'none';
            @if (session('success'))
                showNotification("✅ {{ session('success') }}",
                    'https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3');
            @elseif (session('error'))
                showNotification("❌ {{ session('error') }}", 'https://www.soundjay.com/button/sounds/beep-09.mp3');
            @endif
        });
    </script>
    @include('partials.staff.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- @include('vendor.Chatify.layouts.footerLinks') --}}

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    @stack('scripts-page')
</body>

</html>
