{{-- File: resources/views/partials/staff/header.blade.php --}}
{{-- Copied inline from deleted admin header --}}
<header
    class="dash-header"
    style="box-shadow:inset 0px 0px 110px 5px black;">
    <div class="erp-header header-wrapper" style="background-image: url('{{ asset('assets/images/bg-pattern.png') }}');">
        <div class="me-auto dash-mob-drp">
            <ul class="list-unstyled">
                <li class="dash-h-item mob-hamburger">
                    <a href="#" class="dash-head-link" id="mobile-collapse">
                        <div class="hamburger hamburger--arrowturn">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="dropdown dash-h-item drp-company">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span
                            class="hide-mob ms-2">{{ __('Hi, ') }}{{ auth('customer')->check() ? auth('customer')->user()->name : (auth()->check() ? auth()->user()->name : 'Guest') }}!</span>
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown erp-dropdown">
                        @php $locale = app()->getLocale(); @endphp
                        <a href="{{ \Illuminate\Support\Facades\Route::has('dashboard.customer.profile') ? route('dashboard.customer.profile') : url($locale.'/customer/profile') }}" class="dropdown-item">
                            <i class="ti ti-user text-dark"></i><span>{{ __('Profile') }}</span>
                        </a>
                        <a href="{{ \Illuminate\Support\Facades\Route::has('dashboard.logout') ? route('dashboard.logout') : url($locale.'/logout') }}"
                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                            class="dropdown-item">
                            <i class="ti ti-power text-dark"></i><span>{{ __('Logout') }}</span>
                        </a>
                        <form id="frm-logout" action="{{ \Illuminate\Support\Facades\Route::has('dashboard.logout') ? route('dashboard.logout') : url($locale.'/logout') }}" method="GET" class="d-none">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-world fs-5 text-primary"></i>
                        <span
                            class="drp-text hide-mob fw-semibold">{{ ucfirst(preg_replace('/-.*/', '', $uiLocale)) }}</span>
                        <i class="ti ti-chevron-down drp-arrow hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown dropdown-menu-end erp-dropdown">
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>


