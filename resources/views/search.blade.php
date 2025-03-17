@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="row ms-3 me-3">
        <div class="card">
            <div class="card-body">
                <form action="{{ url('/search') }}" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="first_name" placeholder="Search First Name here..." onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="last_name" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="Search Second Name here...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline">
                                <input type="email" class="form-control" name="email" placeholder="Search Email here..." onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="position" placeholder="Search Position here..." onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                        </div>
                    </div>
                    <button class="btn bg-gradient-dark btn-sm float-end mt-2 mb-0" id="submit-search-btn">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-start">
                            <h4>Employees</h4>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button class="btn bg-gradient-success text-white btn-sm" id="employee-export-btn" style="display: none;">Export Employees</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Datatable Simple</h5>
                    <p class="text-sm mb-0">
                        A lightweight, extendable, dependency-free javascript HTML table plugin.
                    </p>
                </div>
                <div class="table-responsive">
                    <div class="dataTable-wrapper dataTable-loading no-footer sortable fixed-height fixed-columns">
                        <div class="dataTable-top">
                            <div class="dataTable-dropdown">
                                <label>
                                    <select class="dataTable-selector" id="pagination-limit">
                                        <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('limit', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                                    </select>
                                    entries per page
                                </label>
                            </div>
                        </div>
                        <div class="dataTable-container">
                            <table class="table table-flush dataTable-table" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="checkbox-all-section">
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 asc" data-sortable="" style="width: 20.553%;"><a href="#" class="dataTable-sorter">First Name</a></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="" style="width: 24.1475%;"><a href="#" class="dataTable-sorter">Last Name</a></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="" style="width: 17.3272%;"><a href="#" class="dataTable-sorter">Email</a></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="" style="width: 8.47926%;"><a href="#" class="dataTable-sorter">Position</a></th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="" style="width: 15.576%;"><a href="#" class="dataTable-sorter">Salary</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $employee)
                                    <tr id="{{  $employee->id  }}">
                                        <th>
                                            <input type="checkbox" id="{{ $employee->id }}" name="checkbox" value="Bike">
                                        </th>
                                        <td class="text-sm font-weight-normal">{{ $employee->first_name }}</td>
                                        <td class="text-sm font-weight-normal">{{ $employee->last_name }}</td>
                                        <td class="text-sm font-weight-normal">{{ $employee->email }}</td>
                                        <td class="text-sm font-weight-normal">{{ $employee->position }}</td>
                                        <td class="text-sm font-weight-normal">{{ $employee->salary }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="dataTable-bottom">
                            <div class="dataTable-info">
                                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                            </div>

                            <nav class="dataTable-pagination">
                                <ul class="dataTable-pagination-list">
                                    {{-- Previous Page --}}
                                    @if ($data->onFirstPage())
                                    @else
                                    <li class="pager">
                                        <a href="{{ $data->previousPageUrl() }}" data-page="{{ $data->currentPage() - 1 }}">‹</a>
                                    </li>
                                    @endif

                                    @php
                                    $currentPage = $data->currentPage();
                                    $lastPage = $data->lastPage();
                                    $startPage = max(1, $currentPage - 3);
                                    $endPage = min($lastPage, $currentPage + 3);
                                    @endphp

                                    {{-- Pagination Links (Ensuring only 7 pages are displayed) --}}
                                    @for ($i = $startPage; $i <= $endPage; $i++)
                                        <li class="{{ $currentPage == $i ? 'active' : '' }}">
                                        <a href="{{ $data->url($i) }}" data-page="{{ $i }}">{{ $i }}</a>
                                        </li>
                                        @endfor

                                        {{-- Next Page --}}
                                        @if ($data->hasMorePages())
                                        <li class="pager">
                                            <a href="{{ $data->nextPageUrl() }}" data-page="{{ $data->currentPage() + 1 }}">›</a>
                                        </li>
                                        @else
                                        <li class="pager disabled"><span>›</span></li>
                                        @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ps__rail-x" style="left: 0px; bottom: -752px;">
    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
</div>
<div class="ps__rail-y" style="top: 752px; height: 321px; right: 0px;">
    <div class="ps__thumb-y" tabindex="0" style="top: 105px; height: 44px;"></div>
</div>
<script>
    const myToken = <?php echo json_encode([
                        'csrfToken' => csrf_token(),
                    ]); ?>
</script>
@endsection