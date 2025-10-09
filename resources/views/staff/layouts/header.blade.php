<header class="modern-header">
    <div class="container-fluid px-4">
        <div class="header-content d-flex justify-content-between align-items-center py-3">
            
            {{-- LEFT SIDE: Mobile Menu + Breadcrumb --}}
            <div class="d-flex align-items-center gap-4">
                {{-- Mobile hamburger menu --}}
                <button class="mobile-menu-btn d-lg-none" id="sidebarToggle" type="button">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                {{-- Page Title & Breadcrumb --}}
                <div class="page-info">
                    <h1 class="page-title mb-0">
                        @hasSection('page-title')
                            @yield('page-title')
                        @else
                            {{ __('Dashboard') }}
                        @endif
                    </h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('staff.dashboard', ['locale' => app()->getLocale()]) }}" class="breadcrumb-link">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- RIGHT SIDE: Search + Notifications + Profile --}}
            <div class="d-flex align-items-center gap-3">
                
                {{-- Search Bar --}}
                <div class="search-container d-none d-md-block">
                    <div class="search-input-group">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search anything..." id="globalSearch">
                        <div class="search-results" id="searchResults"></div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="quick-actions d-none d-lg-flex align-items-center gap-2">
                    <a href="{{ route('staff.customers.create', ['locale' => app()->getLocale()]) }}" 
                       class="quick-action-btn" 
                       data-bs-toggle="tooltip" 
                       title="Add Customer">
                        <i class="fas fa-user-plus"></i>
                    </a>
                    <a href="{{ route('staff.invoices.create', ['locale' => app()->getLocale()]) }}" 
                       class="quick-action-btn" 
                       data-bs-toggle="tooltip" 
                       title="New Invoice">
                        <i class="fas fa-file-invoice"></i>
                    </a>
                    <a href="{{ route('staff.plans.create', ['locale' => app()->getLocale()]) }}" 
                       class="quick-action-btn" 
                       data-bs-toggle="tooltip" 
                       title="Create Plan">
                        <i class="fas fa-box"></i>
                    </a>
                    <a href="{{ route('staff.subscriptions.create', ['locale' => app()->getLocale()]) }}" 
                       class="quick-action-btn" 
                       data-bs-toggle="tooltip" 
                       title="New Subscription">
                        <i class="fas fa-credit-card"></i>
                    </a>
                    <a href="{{ route('staff.reports.index', ['locale' => app()->getLocale()]) }}" 
                       class="quick-action-btn" 
                       data-bs-toggle="tooltip" 
                       title="Reports">
                        <i class="fas fa-chart-bar"></i>
                    </a>
                </div>

                {{-- Notifications --}}
                <div class="notification-container">
                    <button class="notification-btn position-relative" data-bs-toggle="offcanvas" 
                            href="#offcanvasNotifications" role="button" aria-controls="offcanvasNotifications">
                        <i class="fas fa-bell"></i>
                        @if(($unreadCount ?? 0) > 0)
                            <span class="notification-badge">{{ $unreadCount ?? 0 }}</span>
                        @endif
                    </button>
                        </div>

                {{-- Language Selector --}}
                <div class="language-selector">
                    <div class="dropdown">
                        <button class="language-btn dropdown-toggle" data-bs-toggle="dropdown" type="button">
                            <i class="fas fa-globe"></i>
                            <span class="language-code">{{ strtoupper(substr(app()->getLocale(), 0, 2)) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('public.change.language', ['lang' => 'en', 'return_to' => request()->path()]) }}">
                                    <span class="flag-icon">🇺🇸</span>
                                    <span>English</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('public.change.language', ['lang' => 'ar', 'return_to' => request()->path()]) }}">
                                    <span class="flag-icon">🇸🇦</span>
                                    <span>العربية</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- User Profile --}}
                <div class="user-profile">
                    <div class="dropdown">
                        <button class="profile-btn dropdown-toggle" data-bs-toggle="dropdown" type="button" aria-expanded="false" id="profileDropdownToggle">
                            <div class="profile-avatar">
                                @if(auth()->guard('staff')->user()->avatar)
                                    <img src="{{ auth()->guard('staff')->user()->avatar }}" alt="Profile" class="avatar-img">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="profile-info">
                                <span class="profile-name">{{ auth()->guard('staff')->user()->name ?? 'Admin User' }}</span>
                                <span class="profile-role">{{ ucfirst(auth()->guard('staff')->user()->type ?? 'Admin') }}</span>
                            </div>
                            <i class="fas fa-chevron-down profile-arrow"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                            <li class="dropdown-header">
                                <div class="profile-header-info">
                                    <div class="profile-header-avatar">
                                        @if(auth()->guard('staff')->user()->avatar)
                                            <img src="{{ auth()->guard('staff')->user()->avatar }}" alt="Profile" class="avatar-img">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="profile-header-name">{{ auth()->guard('staff')->user()->name ?? 'Admin User' }}</div>
                                        <div class="profile-header-email">{{ auth()->guard('staff')->user()->email ?? 'admin@example.com' }}</div>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('staff.plans.index') }}">
                                    <i class="fas fa-user me-2"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-question-circle me-2"></i>
                                    <span>Help & Support</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-btn" href="{{ route('logout', ['locale' => app()->getLocale()]) }}"
                                   onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="frm-logout" action="{{ route('logout', ['locale' => app()->getLocale()]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
                </div>

                {{-- Notifications Offcanvas --}}
    <div class="offcanvas offcanvas-end modern-notifications" tabindex="-1" id="offcanvasNotifications"
                    aria-labelledby="offcanvasNotificationsLabel">
                    <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNotificationsLabel">
                <i class="fas fa-bell me-2"></i>Notifications
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
        <div class="offcanvas-body">
            <div class="notifications-header mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="notification-count">
                        <i class="fas fa-bell me-1"></i>
                        {{ $unreadCount ?? 0 }} unread notifications
                    </span>
                    <button class="btn btn-sm btn-outline-primary">Mark all as read</button>
                            </div>
                        </div>

            <div id="notification-list" class="notification-list">
                            @isset($notifications)
                    @forelse($notifications->sortByDesc('created_at') ?? [] as $noti)
                                    @php
                                        $decodedData = json_decode($noti->data);
                                        $formattedMessage = formatNotification($noti->type, $decodedData->action ?? '');
                                    @endphp
                        <div class="notification-item" id="notification-{{ $noti->id }}">
                            <div class="notification-icon">
                                <i class="fas fa-info-circle"></i>
                                        </div>
                            <div class="notification-content">
                                <div class="notification-title">{{ ucfirst(__($decodedData->action ?? '')) }}</div>
                                <div class="notification-message">{{ __($formattedMessage) }}</div>
                                <div class="notification-time">{{ $noti->created_at->diffForHumans() }}</div>
                                    </div>
                            <button class="notification-close" onclick="markAsSeen({{ $noti->id }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @empty
                        <div class="no-notifications">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications yet</p>
                    </div>
                    @endforelse
                @else
                    <div class="no-notifications">
                        <i class="fas fa-bell-slash"></i>
                        <p>No notifications yet</p>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    {{-- Modern Header JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (mobileMenuBtn && sidebar) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    sidebar.classList.toggle('show');
                });
            }

            // Global search functionality
            const searchInput = document.getElementById('globalSearch');
            const searchResults = document.getElementById('searchResults');
            
            if (searchInput) {
                let searchTimeout;
                
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    
                    if (query.length < 2) {
                        searchResults.style.display = 'none';
                        return;
                    }
                    
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });

                // Hide search results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.style.display = 'none';
                    }
                });
            }

            // Quick action buttons are now proper links, no need for click handlers

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize dropdowns
            const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Custom profile dropdown handler
            const profileDropdown = document.getElementById('profileDropdownToggle');
            if (profileDropdown) {
                console.log('Profile dropdown found:', profileDropdown);
                
                profileDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Profile dropdown clicked');
                    
                    const dropdownMenu = this.nextElementSibling;
                    console.log('Dropdown menu element:', dropdownMenu);
                    console.log('Dropdown menu classes:', dropdownMenu ? dropdownMenu.className : 'Not found');
                    
                    if (dropdownMenu) {
                        const isOpen = dropdownMenu.classList.contains('show');
                        console.log('Is currently open:', isOpen);
                        
                        // Close all other dropdowns
                        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                            if (menu !== dropdownMenu) {
                                menu.classList.remove('show');
                                const toggle = menu.previousElementSibling;
                                if (toggle) {
                                    toggle.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });
                        
                        // Toggle current dropdown
                        if (isOpen) {
                            dropdownMenu.classList.remove('show');
                            this.setAttribute('aria-expanded', 'false');
                            console.log('Dropdown closed');
                        } else {
                            dropdownMenu.classList.add('show');
                            this.setAttribute('aria-expanded', 'true');
                            console.log('Dropdown opened');
                        }
                        
                        console.log('Dropdown toggled, show class:', dropdownMenu.classList.contains('show'));
                        console.log('Dropdown display style:', window.getComputedStyle(dropdownMenu).display);
                    } else {
                        console.error('Dropdown menu not found!');
                    }
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.user-profile')) {
                    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                    openDropdowns.forEach(dropdown => {
                        dropdown.classList.remove('show');
                        const toggle = dropdown.previousElementSibling;
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });
        });

        // Search function
        function performSearch(query) {
            const searchResults = document.getElementById('searchResults');
            
            // Simulate search results (replace with actual API call)
            const mockResults = [
                { title: 'Customer: John Doe', type: 'customer', url: '/staff/customers/1' },
                { title: 'Invoice: #INV-001', type: 'invoice', url: '/staff/invoices/1' },
                { title: 'Plan: Basic Plan', type: 'plan', url: '/staff/plans/1' }
            ];
            
            const filteredResults = mockResults.filter(item => 
                item.title.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredResults.length > 0) {
                searchResults.innerHTML = filteredResults.map(result => `
                    <div class="search-result-item" onclick="window.location.href='${result.url}'">
                        <i class="fas fa-${getIconForType(result.type)} me-2"></i>
                        <span>${result.title}</span>
                    </div>
                `).join('');
                searchResults.style.display = 'block';
            } else {
                searchResults.innerHTML = '<div class="search-no-results">No results found</div>';
                searchResults.style.display = 'block';
            }
        }

        function getIconForType(type) {
            const icons = {
                customer: 'user',
                invoice: 'file-invoice',
                plan: 'box',
                subscription: 'credit-card'
            };
            return icons[type] || 'search';
        }

        // Notification functions
        function markAsSeen(notificationId) {
            fetch(`/api/notification/seen/${notificationId}`, {
                    method: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        document.getElementById('notification-' + notificationId)?.remove();
                        updateNotificationCount();
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        function updateNotificationCount() {
            const notificationBadge = document.querySelector('.notification-badge');
            const notificationCount = document.querySelector('.notification-count');
            const remainingNotifications = document.querySelectorAll('.notification-item').length;
            
            if (notificationBadge) {
                if (remainingNotifications > 0) {
                    notificationBadge.textContent = remainingNotifications;
                    notificationBadge.style.display = 'flex';
                } else {
                    notificationBadge.style.display = 'none';
                }
            }
            
            if (notificationCount) {
                notificationCount.innerHTML = `<i class="fas fa-bell me-1"></i>${remainingNotifications} unread notifications`;
            }
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            const toast = createToast(message, type);
            toastContainer.appendChild(toast);
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }

        function createToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            return toast;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // زر الهامبرجر (في الهيدر): يبقى <a id="sidebarToggle">...</a>
            const toggle = document.getElementById('sidebarToggle');
            // نبحث عن sidebar بعدة أسماء محتملة
            const sidebar = document.getElementById('sidebar') || document.getElementById('erpSidebar') || document
                .querySelector('.dash-sidebar');
            // overlay: إن لم يكن موجود ننشئه
            let overlay = document.getElementById('sidebarOverlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'sidebarOverlay';
                overlay.className = 'sidebar-overlay';
                document.body.appendChild(overlay);
            }

            if (!toggle || !sidebar) {
                // العناصر المطلوبة غير موجودة — ننهي بهدوء (لا نرمي أخطاء)
                return;
            }

            // العنصر .hamburger داخل الزر (لإضافة is-active animation)
            const hamburger = toggle.querySelector('.hamburger') || toggle;

            const openSidebar = () => {
                sidebar.classList.add('show'); // توقع: لديك CSS مثل #sidebar.show { transform: translateX(0); }
                overlay.classList.add('active');
                hamburger.classList.add('is-active'); // يعطي animation للهامبرجر (Hamburgers.css)
                document.documentElement.classList.add('no-scroll'); // لمنع scroll لو حبيت
                document.body.style.overflow = 'hidden';
            };

            const closeSidebar = () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('active');
                hamburger.classList.remove('is-active');
                document.documentElement.classList.remove('no-scroll');
                document.body.style.overflow = '';
            };

            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            // Escape to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' || e.key === 'Esc') closeSidebar();
            });

            // Optional: close sidebar when a sidebar link is clicked (mobile UX)
            sidebar.querySelectorAll('a').forEach(a => {
                a.addEventListener('click', function() {
                    // only auto-close on small screens
                    if (window.innerWidth <= 768) closeSidebar();
                });
            });
        });
    </script>
    
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();

            // Toggle the "is-active" class on the hamburger button
            this.querySelector('.hamburger').classList.toggle('is-active');

            // Toggle sidebar visibility
            let sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('d-none'); // or your custom show/hide class
            }
        });
    </script>

</header>
