{{-- Unified Staff Panel Design System --}}
<style>
/* ===== STAFF PANEL UNIFIED DESIGN SYSTEM ===== */

/* === BASE VARIABLES === */
:root {
    --staff-primary: #0d6efd;
    --staff-primary-light: #e7f1ff;
    --staff-secondary: #6c757d;
    --staff-success: #198754;
    --staff-success-light: #d1e7dd;
    --staff-danger: #dc3545;
    --staff-danger-light: #f8d7da;
    --staff-warning: #ffc107;
    --staff-warning-light: #fff3cd;
    --staff-info: #0dcaf0;
    --staff-info-light: #cff4fc;
    --staff-light: #f8f9fa;
    --staff-dark: #212529;
    --staff-border: rgba(0, 0, 0, 0.1);
    --staff-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --staff-shadow-lg: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    --staff-radius: 0.375rem;
    --staff-radius-lg: 0.5rem;
    --staff-transition: all 0.15s ease-in-out;
}

/* === UNIFIED CARD SYSTEM === */
.staff-card {
    border: 1px solid var(--staff-border);
    border-radius: var(--staff-radius-lg);
    box-shadow: var(--staff-shadow);
    transition: var(--staff-transition);
    background: #fff;
}

.staff-card:hover {
    box-shadow: var(--staff-shadow-lg);
}

.staff-card-header {
    background: var(--staff-light);
    border-bottom: 1px solid var(--staff-border);
    border-radius: var(--staff-radius-lg) var(--staff-radius-lg) 0 0;
    padding: 1rem 1.5rem;
}

.staff-card-body {
    padding: 1.5rem;
}

.staff-card-footer {
    background: var(--staff-light);
    border-top: 1px solid var(--staff-border);
    border-radius: 0 0 var(--staff-radius-lg) var(--staff-radius-lg);
    padding: 1rem 1.5rem;
}

/* === UNIFIED TABLE SYSTEM === */
.staff-table {
    margin-bottom: 0;
}

.staff-table thead th {
    background: var(--staff-light);
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--staff-secondary);
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.staff-table tbody td {
    border: none;
    border-bottom: 1px solid var(--staff-border);
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.staff-table tbody tr:hover {
    background: var(--staff-primary-light);
}

.staff-table-responsive {
    position: relative;
    border-radius: var(--staff-radius-lg);
    overflow: hidden;
}

/* === UNIFIED DROPDOWN SYSTEM === */
.staff-dropdown {
    position: relative;
}

.staff-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    left: auto;
    z-index: 1050;
    min-width: 12rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    background: #fff;
    border: 1px solid var(--staff-border);
    border-radius: var(--staff-radius);
    box-shadow: var(--staff-shadow-lg);
    transform: none;
    will-change: auto;
}

.staff-dropdown-item {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: var(--staff-dark);
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background: none;
    border: 0;
    transition: var(--staff-transition);
}

.staff-dropdown-item:hover {
    background: var(--staff-primary-light);
    color: var(--staff-primary);
}

.staff-dropdown-item i {
    width: 1.25rem;
    margin-right: 0.5rem;
}

/* === UNIFIED BADGE SYSTEM === */
.staff-badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: var(--staff-radius);
    transition: var(--staff-transition);
}

.staff-badge-primary {
    background: var(--staff-primary-light);
    color: var(--staff-primary);
}

.staff-badge-success {
    background: var(--staff-success-light);
    color: var(--staff-success);
}

.staff-badge-danger {
    background: var(--staff-danger-light);
    color: var(--staff-danger);
}

.staff-badge-warning {
    background: var(--staff-warning-light);
    color: #664d03;
}

.staff-badge-info {
    background: var(--staff-info-light);
    color: #055160;
}

.staff-badge-secondary {
    background: #e9ecef;
    color: var(--staff-secondary);
}

/* === UNIFIED BUTTON SYSTEM === */
.staff-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.5;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    border: 1px solid transparent;
    border-radius: var(--staff-radius);
    transition: var(--staff-transition);
}

.staff-btn-primary {
    background: var(--staff-primary);
    color: #fff;
    border-color: var(--staff-primary);
}

.staff-btn-primary:hover {
    background: #0b5ed7;
    border-color: #0a58ca;
    color: #fff;
}

.staff-btn-outline-primary {
    background: transparent;
    color: var(--staff-primary);
    border-color: var(--staff-primary);
}

.staff-btn-outline-primary:hover {
    background: var(--staff-primary);
    color: #fff;
}

.staff-btn-outline-secondary {
    background: transparent;
    color: var(--staff-secondary);
    border-color: var(--staff-secondary);
}

.staff-btn-outline-secondary:hover {
    background: var(--staff-secondary);
    color: #fff;
}

.staff-btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

/* === UNIFIED AVATAR SYSTEM === */
.staff-avatar {
    display: inline-block;
    border-radius: 50%;
    overflow: hidden;
}

.staff-avatar-sm {
    width: 40px;
    height: 40px;
}

.staff-avatar-md {
    width: 60px;
    height: 60px;
}

.staff-avatar-lg {
    width: 80px;
    height: 80px;
}

.staff-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* === UNIFIED BREADCRUMB SYSTEM === */
.staff-breadcrumb {
    background: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
}

.staff-breadcrumb-item {
    display: inline-block;
}

.staff-breadcrumb-item + .staff-breadcrumb-item::before {
    content: "›";
    color: var(--staff-secondary);
    margin: 0 0.5rem;
}

.staff-breadcrumb-item a {
    color: var(--staff-primary);
    text-decoration: none;
    transition: var(--staff-transition);
}

.staff-breadcrumb-item a:hover {
    color: #0b5ed7;
}

.staff-breadcrumb-item.active {
    color: var(--staff-secondary);
}

/* === UNIFIED PAGE HEADER SYSTEM === */
.staff-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--staff-border);
}

.staff-page-title {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--staff-dark);
}

.staff-page-subtitle {
    margin: 0.25rem 0 0 0;
    color: var(--staff-secondary);
    font-size: 0.875rem;
}

.staff-page-actions {
    display: flex;
    gap: 0.5rem;
}

/* === UNIFIED STATS CARD SYSTEM === */
.staff-stats-card {
    background: #fff;
    border: 1px solid var(--staff-border);
    border-radius: var(--staff-radius-lg);
    padding: 1.5rem;
    text-align: center;
    transition: var(--staff-transition);
}

.staff-stats-card:hover {
    box-shadow: var(--staff-shadow-lg);
    transform: translateY(-2px);
}

.staff-stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.staff-stats-label {
    color: var(--staff-secondary);
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* === UNIFIED EMPTY STATE SYSTEM === */
.staff-empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
}

.staff-empty-state-icon {
    font-size: 4rem;
    color: var(--staff-secondary);
    margin-bottom: 1rem;
}

.staff-empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--staff-secondary);
    margin-bottom: 0.5rem;
}

.staff-empty-state-description {
    color: var(--staff-secondary);
    margin-bottom: 1.5rem;
}

/* === UNIFIED FORM SYSTEM === */
.staff-form-group {
    margin-bottom: 1rem;
}

.staff-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--staff-dark);
}

.staff-form-control {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    color: var(--staff-dark);
    background: #fff;
    border: 1px solid var(--staff-border);
    border-radius: var(--staff-radius);
    transition: var(--staff-transition);
}

.staff-form-control:focus {
    border-color: var(--staff-primary);
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* === UNIFIED ALERT SYSTEM === */
.staff-alert {
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: var(--staff-radius);
}

.staff-alert-success {
    background: var(--staff-success-light);
    border-color: var(--staff-success);
    color: var(--staff-success);
}

.staff-alert-danger {
    background: var(--staff-danger-light);
    border-color: var(--staff-danger);
    color: var(--staff-danger);
}

.staff-alert-warning {
    background: var(--staff-warning-light);
    border-color: var(--staff-warning);
    color: #664d03;
}

.staff-alert-info {
    background: var(--staff-info-light);
    border-color: var(--staff-info);
    color: #055160;
}

/* === RESPONSIVE UTILITIES === */
@media (max-width: 768px) {
    .staff-page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .staff-page-actions {
        width: 100%;
        justify-content: flex-start;
    }
    
    .staff-table-responsive {
        font-size: 0.875rem;
    }
    
    .staff-stats-card {
        margin-bottom: 1rem;
    }
}

/* === ANIMATION UTILITIES === */
.staff-fade-in {
    animation: staffFadeIn 0.3s ease-in-out;
}

@keyframes staffFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.staff-slide-in {
    animation: staffSlideIn 0.3s ease-in-out;
}

@keyframes staffSlideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>

