@props([
    'id' => 'modalDelete',
    'label' => 'modalDeleteLabel',
    'title' => 'Konfirmasi Hapus Data',
    'message' => 'Apakah anda yakin ingin menghapus data ini?',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $label }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="pb-0 border-0 modal-header">
                <h1 class="text-center modal-title fw-700 text-dark w-100 fs-5" id="{{ $label }}">
                    {{ $title }}</h1>
            </div>
            <div class="modal-body">
                <p class="mb-4 text-center text-black">{{ $message }}</p>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="px-4 py-2 btn btn-danger fw-700 me-3"
                        data-bs-dismiss="modal">Batal</button>
                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button type="button" class="px-4 py-2 btn btn-outline-secondary fw-700" id="buttonDelete">Ya,
                            Hapus!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
