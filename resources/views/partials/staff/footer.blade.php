{{-- File: resources/views/partials/staff/footer.blade.php --}}
{{-- Inline from deleted admin footer --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables core JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons extension JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<!-- HTML5 export buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- Print button -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Required for Excel/CSV/Copy -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

@stack('scripts')
@yield('scripts')

<!-- [ Main Content ] end -->
<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <p class="mb-0 text-muted"> &copy;
                {{ date('Y') }}
                {{ config('app.name', 'Holol-tec') }}
            </p>
        </div>
    </div>
</footer>

<!-- Warning Section Ends -->
<!-- Required Js -->

{{-- <script>
    var site_currency_symbol_position = '{{ $setting['site_currency_symbol_position'] }}';
    var site_currency_symbol = '{{ $setting['site_currency_symbol'] }}';
</script> --}}

@stack('datatable-js')

@if ($message = Session::get('success'))
    <script>
        show_toastr('success', '{!! __($message) !!}');
    </script>
@endif
@if ($message = Session::get('error'))
    <script>
        show_toastr('error', '{!! __($message) !!}');
    </script>
@endif

@if ($message = Session::get('alert'))
    <script>
        window.onload = function() {
            alert('تنبيه:\n' + `{!! implode("\n", $message) !!}`);
        }
    </script>
@endif

{{-- @if ($setting['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif --}}
@stack('script-page')

<script>
    $(document).ready(function() {
        $('.table_tools').DataTable({
            dom: '<"d-flex justify-content-between top-table-bar"lBf>tip',
            select: true,
            buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel"></i> Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-copy"></i> Copy',
                    className: 'btn btn-warning btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    customize: function(win) {
                                $.ajax({
                                    url: '{{ \Illuminate\Support\Facades\Route::has('dashboard.company.info') ? route('dashboard.company.info') : url(app()->getLocale().'/customer/company-info') }}',
                            method: 'GET',
                            success: function(data) {
                                const lang = $('html').attr('lang') || 'en';
                                const dir = $('html').attr('dir') || 'ltr';
                                const isRTL = dir === 'rtl';

                                const now = new Date();
                                const formattedDate = now.toLocaleDateString(lang, {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                $(win.document.head).append(`
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        font-size: 12px;
                                        color: #333;
                                        margin: 20px;
                                        position: relative;
                                    }
                                    .print-header {
                                        display: flex;
                                        align-items: flex-end;
                                        justify-content: space-between;
                                        margin-bottom: 20px;
                                        flex-direction: ${isRTL ? 'row-reverse' : 'row'};
                                    }
                                    .print-header .company-info {
                                        padding: 0 10px;
                                        text-align: ${isRTL ? 'left' : 'right'};
                                        font-size: 11px;
                                    }
                                    .print-date {
                                        text-align: center;
                                        margin: 10px 0;
                                        font-weight: bold;
                                        font-size: 11px;
                                    }
                                    .watermark {
                                        position: fixed;
                                        top: 50%;
                                        left: 50%;
                                        transform: translate(-50%, -50%);
                                        width: 80%;
                                        opacity: 0.08;
                                        z-index: -1;
                                    }
                                    table {
                                        width: 100%;
                                        border-collapse: collapse;
                                        margin-top: 20px;
                                    }
                                    table th, table td {
                                        border: 1px solid #ccc;
                                        padding: 6px 8px;
                                        text-align: center;
                                    }
                                    table thead {
                                        background: #f1f1f1;
                                        font-weight: bold;
                                    }
                                    hr {
                                        margin: 15px 0;
                                        border: 0;
                                        border-top: 1px solid #333;
                                    }
                                </style>
                            `);

                                $(win.document.body).prepend(`
                                <img src="${data.background}" class="watermark" alt="Watermark">
                                <div class="print-header">
                                    <div class="logo">
                                        <img src="${data.logo}" alt="Company Logo" style="width:150px;">
                                    </div>
                                    <div class="company-info">
                                        ${data.settings}
                                    </div>
                                </div>
                                <div class="print-date">
                                    Printed on: ${formattedDate}
                                </div>
                                <hr>
                            `);

                                const table = $(win.document.body).find('table');
                                table.addClass('table table-bordered');
                                if (isRTL) {
                                    $(win.document.body).css('direction', 'rtl');
                                    table.attr('dir', 'rtl');
                                }
                            },
                            error: function() {
                                alert('Failed to fetch company info for print.');
                            }
                        });
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search customers...",
                lengthMenu: "Show _MENU_ entries"
            },
            paging: true,
            ordering: true,
            responsive: true
        });
    });
</script>


