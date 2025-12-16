@props(['months' => [], 'years' => []])

<div class="row mb-4">
    {{-- Kolom Filter --}}
    <div class="col-xl-9 mb-2">
        <div class="row g-0">
            <div class="col-auto d-flex align-items-center rounded-start border justify-content-center"
                style="padding: 0.6rem 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M9.48398 15.7501C9.20898 15.7501 8.93398 15.6834 8.68398 15.5417C8.17565 15.2584 7.86732 14.7417 7.86732 14.1584V11.5917C7.86732 11.4334 7.74232 11.1251 7.61732 10.9667L5.80898 9.06675C5.46732 8.72508 5.20898 8.12508 5.20898 7.66675V6.55841C5.20898 5.63341 5.90898 4.91675 6.80065 4.91675H13.1923C14.0673 4.91675 14.784 5.63341 14.784 6.50841V7.57508C14.784 8.15841 14.4507 8.80008 14.1173 9.13341L12.009 11.0001C11.8757 11.1167 11.734 11.4084 11.734 11.6501V13.7334C11.734 14.2584 11.4173 14.8417 10.9923 15.0917L10.334 15.5167C10.0757 15.6751 9.78398 15.7501 9.48398 15.7501ZM6.80065 6.16675C6.60065 6.16675 6.45898 6.33341 6.45898 6.55841V7.66675C6.45898 7.77508 6.57565 8.05841 6.70898 8.19175L8.55898 10.1417C8.84232 10.5001 9.11732 11.0751 9.11732 11.5917V14.1584C9.11732 14.3251 9.22565 14.4167 9.29232 14.4501C9.38398 14.5001 9.53398 14.5334 9.66732 14.4501L10.334 14.0167C10.4007 13.9667 10.484 13.8001 10.484 13.7167V11.6334C10.484 11.0417 10.7757 10.3834 11.1923 10.0417L13.259 8.20841C13.3673 8.10008 13.534 7.76675 13.534 7.55841V6.50841C13.534 6.32508 13.3757 6.16675 13.1923 6.16675H6.80065Z" fill="#292D32" />
                    <path d="M12.4993 18.9584H7.49935C2.97435 18.9584 1.04102 17.0251 1.04102 12.5001V7.50008C1.04102 2.97508 2.97435 1.04175 7.49935 1.04175H12.4993C17.0243 1.04175 18.9577 2.97508 18.9577 7.50008V12.5001C18.9577 17.0251 17.0243 18.9584 12.4993 18.9584ZM7.49935 2.29175C3.65768 2.29175 2.29102 3.65841 2.29102 7.50008V12.5001C2.29102 16.3417 3.65768 17.7084 7.49935 17.7084H12.4993C16.341 17.7084 17.7077 16.3417 17.7077 12.5001V7.50008C17.7077 3.65841 16.341 2.29175 12.4993 2.29175H7.49935Z" fill="#292D32" />
                </svg>
            </div>

            {{-- Bulan & Tahun  --}}
            <div class="col-12 col-md-3">
                <div class="dropdown">
                    <button class="btn border rounded-0 dropdown-toggle w-100 text-start" type="button"
                        id="dateFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="padding: 0.6rem 1rem;">
                        <span id="dateFilterText">Bulan & Tahun</span>
                    </button>
                    <div class="dropdown-menu p-3" aria-labelledby="dateFilterDropdown" style="width: 320px;"
                        onclick="event.stopPropagation();">
                        <div class="d-flex justify-content-between">
                            {{-- Kolom Pilihan Bulan --}}
                            <div class="month-selector pe-2" style="width: 50%; max-height: 200px; overflow-y: auto;">
                                <div class="list-group list-group-flush">
                                    @foreach ($months as $key => $month)
                                    <a href="#" class="list-group-item list-group-item-action month-item"
                                        data-value="{{ $key + 1 }}">
                                        {{ $month }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Kolom Pilihan Tahun --}}
                            <div class="year-selector ps-2 border-start"
                                style="width: 50%; max-height: 200px; overflow-y: auto;">
                                <div class="list-group list-group-flush">
                                    @foreach ($years as $year)
                                    <a href="#" class="list-group-item list-group-item-action year-item"
                                        data-value="{{ $year }}">
                                        {{ $year }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Status --}}
            <!-- <div class="col-12 col-md-3">
                <div class="dropdown">
                    <button class="btn border rounded-0 dropdown-toggle w-100 text-start" type="button"
                        id="statusFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="padding: 0.6rem 1rem;">
                        <span id="statusFilterText">Status</span>
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="statusFilterDropdown">
                        <li><a class="dropdown-item status-item" href="#" data-value="">Semua Status</a></li>
                        <li><a class="dropdown-item status-item" href="#" data-value="published">Terunggah</a>
                        </li>
                        <li><a class="dropdown-item status-item" href="#" data-value="draft">Draf</a></li>
                    </ul>
                </div>
            </div> -->

            {{-- Reset --}}
            <div class="col-12 col-md-3">
                <button class="btn border text-danger rounded-end rounded-0 w-100" id="resetFilter"
                    style="padding: 0.6rem 1rem;">
                    <i class="fas fa-redo"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="col-xl-3">
        <form id="searchForm" onsubmit="return false;">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari Sesuatu..."
                    style="padding: 0.6rem 1rem;">
                <button class="btn border" type="submit" style="padding: 0.6rem 1rem;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/informasi.css') }}">
@endpush