<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 animate__animated animate__zoomIn">

            <!-- Header -->
            <div class="modal-header bg-gradient-danger  rounded-top-4 p-4">
                <h5 class="modal-title text-white fw-bold" id="deleteModalLabel">
                    <i class="fa-solid fa-trash me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center py-5 px-4">
                <div class="icon-wrapper mb-3">
                    <i
                        class="fa-solid fa-triangle-exclamation fs-1 text-danger bg-light rounded-circle p-3 shadow-sm"></i>

                </div>
                <p class="fs-5 text-muted mb-1">
                    Are you sure you want to delete
                    <span class="fw-bold text-danger" id="planName"></span>?
                </p>
                <small class="text-secondary">This action cannot be undone.</small>
            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-center border-0 pb-4 gap-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" id="confirmDelete" class="btn btn-danger rounded-pill px-4 shadow-sm">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>


{{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> --}}
@push('scripts')
    <script>
     
    </script>
@endpush
