{{-- Customer Sidebar Navigation --}}
<div class="nav-section-title">{{ __('Dashboard') }}</div>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
           href="{{ route('customer.dashboard', ) }}">
            <i class="fas fa-tachometer-alt"></i>
            {{ __('Dashboard') }}
        </a>
    </li>
</ul>

<div class="nav-section-title">{{ __('Account') }}</div>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}"
           href="{{ route('customer.profile.index', ) }}">
            <i class="fas fa-user"></i>
            {{ __('Profile') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.subscription.*') ? 'active' : '' }}"
           href="{{ route('customer.subscription.index', ) }}">
            <i class="fas fa-credit-card"></i>
            {{ __('Subscription') }}
        </a>
    </li>
</ul>

<div class="nav-section-title">{{ __('Billing') }}</div>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}"
           href="{{ route('customer.orders.index', ) }}">
            <i class="fas fa-shopping-cart"></i>
            {{ __('Orders') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('customer.invoices.*') || request()->routeIs('customer.invoice') ? 'active' : '' }}"
           href="{{ route('customer.invoices.index', ) }}">
            <i class="fas fa-file-invoice"></i>
            {{ __('Invoices') }}
        </a>
    </li>
</ul>

<div class="nav-section-title">{{ __('Support') }}</div>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="alert('{{ __('Support feature coming soon!') }}')">
            <i class="fas fa-life-ring"></i>
            {{ __('Help & Support') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="alert('{{ __('Documentation feature coming soon!') }}')">
            <i class="fas fa-book"></i>
            {{ __('Documentation') }}
        </a>
    </li>
</ul>
