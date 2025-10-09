{{-- Modern Sidebar --}}
<nav class="p-3" id="sidebarMenu">
    <div class="text-center mb-4">
        <a href="{{ auth()->user()?->role === 'super admin' ? route('dashboard.index') : '#' }}" class="text-decoration-none">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="bg-primary rounded-3 p-2 me-2">
                    <i class="fas fa-cube text-white fs-4"></i>
                </div>
                <div class="text-start">
                    <h5 class="mb-0 text-dark fw-bold">FERP</h5>
                    <small class="text-muted">Admin Panel</small>
                </div>
            </div>
        </a>
    </div>

    @if (Auth::guard('staff')->check())
        <ul class="list-unstyled">
            <li class="mb-2">
                <a href="/admin" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-start px-3 py-2 rounded-3 sidebar-main-item">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    <span class="fw-medium">{{ __('Dashboard') }}</span>
                </a>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuCustomers" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users me-3"></i>
                        <span class="fw-medium">{{ __('Customers') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuCustomers">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.customers.index') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-list submenu-icon me-2"></i>{{ __('List') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.customers.create') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-plus submenu-icon me-2"></i>{{ __('Add New') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuSubscriptions" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-credit-card me-3"></i>
                        <span class="fw-medium">{{ __('Subscription') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuSubscriptions">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.subscriptions.index') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-list submenu-icon me-2"></i>{{ __('List') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuInvoices" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-invoice me-3"></i>
                        <span class="fw-medium">{{ __('Invoices') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuInvoices">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.invoices.index') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-list submenu-icon me-2"></i>{{ __('All Invoices') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.invoices.create') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-plus submenu-icon me-2"></i>{{ __('Create Invoice') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuPlans" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-box me-3"></i>
                        <span class="fw-medium">{{ __('Plans') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuPlans">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.plans.index') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-list submenu-icon me-2"></i>{{ __('All Plans') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.plans.create') }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-plus submenu-icon me-2"></i>{{ __('Create Plan') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuOrders" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shopping-bag me-3"></i>
                        <span class="fw-medium">{{ __('Orders') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuOrders">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.orders.index', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-list submenu-icon me-2"></i>{{ __('All Orders') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.orders.pending', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-clock submenu-icon me-2"></i>{{ __('Pending Orders') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.orders.paid', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-check-circle submenu-icon me-2"></i>{{ __('Paid Orders') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="mb-2">
                <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 sidebar-main-item" data-bs-target="#submenuReports" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chart-bar me-3"></i>
                        <span class="fw-medium">{{ __('Reports') }}</span>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse sidebar-submenu" id="submenuReports">
                    <ul class="list-unstyled fw-normal small ps-4 pt-2">
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.index', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-tachometer-alt submenu-icon me-2"></i>{{ __('Overview') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.customers', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-users submenu-icon me-2"></i>{{ __('Customer Reports') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.revenue', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-dollar-sign submenu-icon me-2"></i>{{ __('Revenue Reports') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.plans', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-box submenu-icon me-2"></i>{{ __('Plan Reports') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.invoices', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-file-invoice submenu-icon me-2"></i>{{ __('Invoice Reports') }}
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('staff.reports.analytics', ['locale' => $uiLocale]) }}" class="text-decoration-none text-muted d-block py-2 px-3 rounded-2 sidebar-submenu-item">
                                <i class="fas fa-chart-line submenu-icon me-2"></i>{{ __('Analytics') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    @elseif (Auth::guard('customer')->check())
        <ul class="list-unstyled">
            <li class="mb-1">
                <a href="{{ Route::has('company.profile') ? route('company.profile') : url($uiLocale . '/customer/profile') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-between">
                    <span><i class="fa-regular fa-circle-user me-2"></i>{{ __('Profile') }}</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ Route::has('company.plan') ? route('company.plan') : url($uiLocale . '/customer/plan') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-toolbox me-2"></i>{{ __('Own Plan') }}</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ Route::has('company.invoice') ? route('company.invoice') : url($uiLocale . '/customer/invoice') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-file-invoice me-2"></i>{{ __('Invoice') }}</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ Route::has('company.invoice.history') ? route('company.invoice.history') : url($uiLocale . '/customer/invoices') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-file-waveform me-2"></i>{{ __('Invoice History') }}</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ Route::has('company.request-plan') ? route('company.request-plan') : url($uiLocale . '/customer/request-plan') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-between">
                    <span><i class="fa-solid fa-code-pull-request me-2"></i>{{ __('Plan Request') }}</span>
                </a>
            </li>
        </ul>
    @endif
</nav>


