<x-layouts.main :title="$title">
    <!-- Breadcrumb -->
    <div class="mb-4 px-2">
        <h2 class="page-title">{{ $heading }}</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">Informasi</li>
            <li class="breadcrumb-item">{{ $heading }}</li>
            <li class="breadcrumb-item active fw-bold text-dark " aria-current="page">Data {{ $heading }}</li>
        </ol>
    </div>

    <div class="card shadow-sm px-3" style="min-height: 70vh">
        <div class="p-3 bg-white d-flex align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-0" style="font-size: 18px">Data {{ $heading }}</h4>
            </div>
        
        <!-- Create Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Create New Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm" action="{{ route('pages.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="createTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="createTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="createShortDescription" class="form-label">Short Description</label>
                                <textarea class="form-control" id="createShortDescription" name="short_description" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" form="createForm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ubah Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editTitle">
                        </div>
                        <div class="mb-3">
                            <label for="editShortDescription" class="form-label">Short Description</label>
                            <textarea class="form-control" id="editShortDescription" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveEditBtn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
            <x-button.create-button href="#" />
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <x-input.filter-informasi :months="$months" :years="$years" />

            <!-- DataTable -->
            <div class="table-responsive">
                <table class="table table-hover" id="PageBuilderTable" style="width: 100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Title</th>
                            <th width="25%">Short Description</th>
                            <th width="20%">Last Update</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div
                    class="table-footer d-flex align-items-center justify-content-between flex-column flex-sm-row mt-3">
                    <div class="flex-row d-flex align-items-center mb-2 mb-sm-0">
                        <select id="customPageLength" class="form-select form-select-sm w-auto ms-2 me-2">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="-1" selected>Semua</option>
                        </select>

                        <p class="mb-0 text-black table-info me-2">
                            Menampilkan <span class="table-show">1</span> sampai <span class="table-end">3</span> dari
                            <span class="table-total">3</span> entri
                        </p>
                    </div>

                    <div class="btn-group" role="group" aria-label="Navigation buttons">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="prevBtn">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="nextBtn">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <x-ui.delete-confirm />

        <!-- Toast -->
        <x-ui.boostrap-toast id="notificationToast" message="Berita berhasil dihapus" />

        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Berita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Memuat data...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <x-ui.boostrap-toast id="toastSuccess" :message="session('success')" />
        @endif

        @push('style')
            <link rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.css">
            <link rel="stylesheet" href="{{ asset('assets/css/informasi.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/button-gradient.css') }}">
        @endpush

        @push('plugin')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.js"></script>
        @endpush

        @push('script')
            @if (session('success'))
                <script>
                    $(document).ready(function() {
                        $('#toastSuccess').toast('show');
                    });
                </script>
            @endif

            <script src="{{ asset('js/pageBuilder.js') }}"></script>
        @endpush
</x-layouts.main>
