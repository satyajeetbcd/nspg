<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if (!request()->ajax())
    <script src="{{ asset('assets/dashboard/js/customForm.js') }}"></script>
@endif

<!-- Bootstrap (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Minimal vendor -->
<script src="{{ asset('assets/dashboard/js/jquery.form.js') }}"></script>

<!-- Axios (required by custom JS) -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Select2 removed: no longer used -->

<!-- DataTables Core -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- JSZip (Excel Export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- PDFMake (PDF Export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/dashboard/js/custome/main.js') }}"></script>

@stack('scripts')
@yield('scripts')
@stack('datatable-js')
@stack('script-page')
