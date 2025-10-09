/**
 * ========================================================================
 * Plans Management Script
 * ========================================================================
 * Purpose:
 *  - Handles interactive features in Plan management such as:
 *      1. Toggling plan status via AJAX + toast notifications
 *      2. Managing Features dynamically inside a modal
 *      3. Managing Prices dynamically with countries/currencies
 *      4. Enhancing multi-select dropdowns with Choices.js
 *
 * Dependencies:
 *  - jQuery
 *  - Axios (for AJAX)
 *  - Toastr.js (for notifications)
 *  - Bootstrap (for modal events)
 *  - Choices.js (for select enhancements)
 *
 * Author: [Your Name]
 * Created: [Date]
 * Version: 1.0
 * ========================================================================
 */
"use strict"; // Local strict mode inside this closure
$(function () {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Attach change event to all status toggles
    document.querySelectorAll('.toggle-status').forEach(function (switchInput) {
        switchInput.addEventListener('change', function () {
            let url = this.dataset.url;    // API endpoint
            let planId = this.dataset.id;  // Plan ID
            let status = this.checked ? 0 : 1; // is_disable logic: checked = visible (0), unchecked = disabled (1)

            // === AJAX CALL ===
            axios.post(url, { is_disable: status }, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
                .then(response => {
                    // Always show toast for both success/failure
                    if (response.data.success) {
                        toastr.success(response.data.message, 'Success', { timeOut: 3000, closeButton: true });

                        // 🔄 Update status label if exists
                        let statusLabel = document.querySelector(`#statusLabel${planId}`);
                        if (statusLabel) {
                            statusLabel.innerText = status === 0 ? 'Active' : 'Inactive';
                        }
                    } else {
                        toastr.warning(response.data.message || 'Failed to update!', 'Warning', { timeOut: 3000, closeButton: true });
                        this.checked = !this.checked; // Revert toggle
                    }
                })
                .catch(error => {
                    toastr.error(error.response?.data?.message || "Something went wrong!", 'Error', { timeOut: 3000, closeButton: true });
                    this.checked = !this.checked; // Revert toggle
                });
        });
    });

});



/**
 * ========================================================================
 * FEATURES + PRICES + MULTI SELECT HANDLERS
 * Triggered when #commonModal is shown (Bootstrap modal)
 * ========================================================================
 */
$(document).on("shown.bs.modal", "#commonModal", function () {

    // ================================================================
    // 2. FEATURES SECTION
    // ================================================================
    let $featuresList = $("#features-list");

    /**
     * Create a new Feature "chip" UI element
     * @param {string} value - Feature name
     * @param {string} type - Feature type (text, number, boolean, dropdown)
     */
    function createFeatureChip(value = '', type = '') {
        const featureChip = $(`
            <div class="col-md-4 col-sm-6 feature-chip-wrapper mb-3">
                <div class="feature-chip d-flex flex-column p-3 rounded-3 shadow-sm bg-gradient-to-right"
                     style="background: linear-gradient(135deg,#4e73df,#1cc88a); color:white;">

                    <div class="d-flex align-items-center mb-2">
                        <!-- Feature Name Input -->
                        <input type="text" name="features[]" value="${value}"
                               class="form-control form-control-sm me-2 rounded-pill bg-white text-dark flex-grow-1"
                               placeholder="Feature Name" style="min-width: 100px;">

                        <!-- Remove Button -->
                        <button type="button" class="btn btn-sm btn-light remove-feature" title="Remove Feature">
                            <i class="fa-solid fa-xmark" style="color: #c02a2a;"></i>
                        </button>
                    </div>

                    <!-- Feature Type Dropdown -->
                    <select name="feature_types[]" class="form-select form-select-sm rounded-pill text-dark">
                        <option value="" ${type === '' ? 'selected' : ''}>Select Type</option>
                        <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
                        <option value="number" ${type === 'number' ? 'selected' : ''}>Number</option>
                        <option value="boolean" ${type === 'boolean' ? 'selected' : ''}>Boolean</option>
                        <option value="dropdown" ${type === 'dropdown' ? 'selected' : ''}>Dropdown</option>
                    </select>
                </div>
            </div>
        `);

        // Remove handler
        featureChip.find(".remove-feature").on("click", function () {
            featureChip.remove();
        });

        // Hover effect
        featureChip.find(".feature-chip").hover(
            function () { $(this).css("box-shadow", "0 8px 20px rgba(0,0,0,0.25)"); },
            function () { $(this).css("box-shadow", "0 4px 12px rgba(0,0,0,0.1)"); }
        );

        $featuresList.append(featureChip);
    }

    // Add feature
    $("#add-feature").off("click").on("click", function () {
        createFeatureChip();
    });

    // Remove feature (delegated)
    $(document).on("click", ".remove-feature", function () {
        $(this).closest(".feature-chip-wrapper").remove();
    });

    // Drag & drop ordering
    function addDragEvents(chip) {
        chip.addEventListener("dragstart", e => {
            chip.classList.add("dragging");
            e.dataTransfer.effectAllowed = "move";
        });
        chip.addEventListener("dragend", () => chip.classList.remove("dragging"));
    }

    $featuresList.on("dragover", function (e) {
        e.preventDefault();
        let dragging = $featuresList.find(".dragging")[0];
        if (!dragging) return;

        // Find position for inserting dragged item
        let afterElement = [...$featuresList.find(".feature-chip:not(.dragging)")].reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = e.originalEvent.clientY - box.top - box.height / 2;
                return offset < 0 && offset > closest.offset ? { offset, element: child } : closest;
            },
            { offset: Number.NEGATIVE_INFINITY }
        ).element;

        if (afterElement) {
            $(afterElement).closest(".feature-chip-wrapper").before($(dragging).closest(".feature-chip-wrapper"));
        } else {
            $featuresList.append($(dragging).closest(".feature-chip-wrapper"));
        }
    });



    // ================================================================
    // 3. PRICES SECTION
    // ================================================================
    $(document).ready(function () {
        let $pricesList = $("#prices-list");
        let newPriceIndex = 0;
        let deleteIndex = 0;

        let countries = JSON.parse($pricesList.attr("data-countries")) || [];

        /**
         * Create a new Price item row
         * @param {string|number} country - Country ID
         * @param {string|number} currency - Currency ID
         * @param {string|number} amount - Price value
         * @param {string|null} id - Existing DB record ID
         */
        function createPriceItem(country = "", currency = "", amount = "", id = null) {
            let key = id ?? "new_" + newPriceIndex;

            // Build country options
            let countryOptions = countries.map(c => {
                let countryName = c.country_languages[0]?.name ?? c.code;
                return `<option value="${c.id}" ${c.id == country ? "selected" : ""}>${countryName}</option>`;
            }).join("");

            // Build currency options
            let currencyOptions = [];
            if (country) {
                let selectedCountry = countries.find(c => c.id == country);
                if (selectedCountry) {
                    currencyOptions = selectedCountry.currencies.map(cur => {
                        let currencyName = cur.currency_languages[0]?.name ?? cur.currency_id;
                        return `<option value="${cur.currency_id}" ${cur.currency_id == currency ? "selected" : ""}>${currencyName}</option>`;
                    });
                }
            } else {
                countries.forEach(c => {
                    c.currencies.forEach(cur => {
                        let currencyName = cur.currency_languages[0]?.name ?? cur.currency_id;
                        currencyOptions.push(`<option value="${cur.currency_id}" ${cur.currency_id == currency ? "selected" : ""}>${currencyName}</option>`);
                    });
                });
            }

            // Build price item wrapper
            let $wrapper = $(`
                <div class="col-md-12 price-item-wrapper" data-id="${id ?? ''}">
                    <div class="row g-2 align-items-end border rounded p-3 shadow-sm bg-light">
                        <!-- Country -->
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <select name="prices[${key}][country]" class="form-select select2 country-select" required>
                                <option value="">Select Country</option>
                                ${countryOptions}
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- Currency -->
                        <div class="col-md-3">
                            <label class="form-label">Currency</label>
                            <select name="prices[${key}][currency]" class="form-select select2 currency-select" required>
                                <option value="">Select Currency</option>
                                ${currencyOptions.join("")}
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- Price -->
                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="prices[${key}][amount]" class="form-control" value="${amount}" required>
                        </div>
                        <!-- Remove -->
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger remove-price">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Update currency when country changes
            $wrapper.find(".country-select").on("change", function () {
                let selectedCountryId = $(this).val();
                let selectedCountry = countries.find(c => c.id == selectedCountryId);
                let $currencySelect = $wrapper.find(".currency-select");

                $currencySelect.empty().append('<option value="">Select Currency</option>');
                if (selectedCountry) {
                    selectedCountry.currencies.forEach(cur => {
                        let currencyName = cur.currency_languages[0]?.name ?? cur.currency_id;
                        $currencySelect.append(`<option value="${cur.currency_id}">${currencyName}</option>`);
                    });
                }
            });

            $pricesList.append($wrapper);
            newPriceIndex++;
        }

        // Remove price row
        $pricesList.on("click", ".remove-price", function () {
            let $wrapper = $(this).closest(".price-item-wrapper");
            let priceId = $wrapper.data("id");

            if (priceId) {
                // Mark for deletion in hidden input
                if ($wrapper.find('input[name^="deleted_prices"]').length === 0) {
                    $wrapper.append(`<input type="hidden" name="deleted_prices[del_${deleteIndex}]" value="${priceId}">`);
                    deleteIndex++;
                }
                $wrapper.hide();
            } else {
                $wrapper.remove();
            }
        });

        // Add new price row
        $("#add-price").off("click").on("click", function () {
            createPriceItem();
        });
    });



    // ================================================================
    // 4. MULTI SELECT (Basic Features)
    // ================================================================
    $(document).ready(function () {
        function select2() {
            if ($('.select2').length > 0) {
                $('.select2').each(function () {
                    var $select = $(this);

                    // Plugin-free validation and behavior
                    if ($select.val()) {
                        $select.addClass('is-valid').removeClass('is-invalid');
                    } else {
                        $select.addClass('is-invalid').removeClass('is-valid');
                    }

                    $select.on('change', function () {
                        if ($select.val()) {
                            $select.removeClass('is-invalid').addClass('is-valid');
                        } else {
                            $select.removeClass('is-valid').addClass('is-invalid');
                        }
                    });
                });
            }
        }
        select2()
    });






});

/** =========================
* DATATABLE INIT
* ========================= */

$(document).ready(function () {
    $('.datatable').each(function () {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable({
                dom: '<"d-flex justify-content-between top-table-bar"lBf>tip',
                select: true,
                buttons: [
                    {
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
                        customize: function (win) {
                            $.ajax({
                                url: "{{ route('dashboard.company.info') }}",
                                method: 'GET',
                                success: function (data) {
                                    const lang = $('html').attr('lang') || 'en';
                                    const dir = $('html').attr('dir') || 'ltr';
                                    const isRTL = dir === 'rtl';
                                    const searchName = $(this).data('search-name') || null;

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
                                            body { font-family: Arial, sans-serif; font-size:12px; color:#333; margin:20px; }
                                            .print-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:20px; flex-direction:${isRTL ? 'row-reverse' : 'row'}; }
                                            .print-header .company-info { padding:0 10px; text-align:${isRTL ? 'left' : 'right'}; font-size:11px; }
                                            .print-date { text-align:center; margin:10px 0; font-weight:bold; font-size:11px; }
                                            .watermark { position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); width:80%; opacity:0.08; z-index:-1; }
                                            table { width:100%; border-collapse:collapse; margin-top:20px; }
                                            table th, table td { border:1px solid #ccc; padding:6px 8px; text-align:center; }
                                            table thead { background:#f1f1f1; font-weight:bold; }
                                            hr { margin:15px 0; border:0; border-top:1px solid #333; }
                                        </style>
                                    `);

                                    $(win.document.body).prepend(`
                                        <img src="${data.background}" class="watermark" alt="Watermark">
                                        <div class="print-header">
                                            <div class="logo">
                                                <img src="${data.logo}" alt="Company Logo" style="width:150px;">
                                            </div>
                                            <div class="company-info">${data.settings}</div>
                                        </div>
                                        <div class="print-date">Printed on: ${formattedDate}</div>
                                        <hr>
                                    `);

                                    const table = $(win.document.body).find('table');
                                    table.addClass('table table-bordered');
                                    if (isRTL) {
                                        $(win.document.body).css('direction', 'rtl');
                                        table.attr('dir', 'rtl');
                                    }
                                },
                                error: function () {
                                    alert('Failed to fetch company info for print.');
                                }
                            });
                        }
                    }
                ],
                searchModule: 'bootstrap-5',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder:  $(this).data('search-name') || "Search Records...",
                    lengthMenu: "Show _MENU_ entries"
                },
                paging: true,
                ordering: true,
                responsive: true
            });

        }
    });


    $(document).ready(function () {
        $('#filterDuration').on('change', function () {
            var selected = $(this).val().toLowerCase();

            $('#plans tbody tr').each(function () {
                var rowDuration = $(this).find('td[data-duration]').data('duration');

                if (selected === "" || rowDuration === selected) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
});


/** =========================
 * DELETE CONFIRM MODAL
 * ========================= */
$(function () {
    let deleteUrl = '';
    let deleteId = '';
    const modalEl = $('#deleteModal');
    const planNameEl = $('#planName');
    const confirmDeleteBtn = $('#confirmDelete');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Open modal
    $('.itemDelete').on('click', function () {
        deleteUrl = $(this).data('url');
        deleteId = $(this).data('item_id');
        planNameEl.text($(this).data('name') || 'this plan');
        modalEl.modal('show');
    });

    // Confirm delete
    confirmDeleteBtn.on('click', async function () {
        try {
            const response = await axios.delete(deleteUrl, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });

            if (response.status === 200 || response.data.message) {
                $(`button[data-item_id="${deleteId}"]`).closest('.col-lg-4, tr').fadeOut(300, function () {
                    $(this).remove();
                });

                showToast(response.data.message || 'Deleted successfully!', 'success');
                modalEl.modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                refreshTable();
            } else {
                showToast(response.data.message || 'Failed to delete record.', 'danger');
            }
        } catch (error) {
            console.error(error);
            showToast('Something went wrong while deleting.', 'danger');
        }
    });

    // Toast helper
    function showToast(message, type = 'success') {
        const toast = $('<div class="custom-toast"></div>')
            .text(message)
            .css({
                position: 'fixed',
                bottom: '20px',
                right: '20px',
                background: type === 'success' ? '#28a745' : '#dc3545',
                color: '#fff',
                padding: '10px 20px',
                borderRadius: '6px',
                boxShadow: '0 2px 6px rgba(0,0,0,0.3)',
                zIndex: 9999
            })
            .appendTo('body');

        setTimeout(() => toast.fadeOut(400, () => toast.remove()), 2500);
    }

    // Refresh table
    function refreshTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().ajax.reload(null, true);
        } else {
            location.reload();
        }
    }
});
