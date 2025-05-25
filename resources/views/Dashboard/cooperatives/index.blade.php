@php use App\Utils\Utils; @endphp
@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Full Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Cooperatives</h3>
                <!-- Trigger Modal -->
                <a href="{{ route('cooperatives.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i> Create New Cooperative
                </a>
            </div>

            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Total Members</th>
                            <th>Total Contribution Schemes</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cooperatives as $index => $cooperative)
                            <tr>
                                <td class="fw-semibold">{{ $cooperatives->firstItem() + $index }}</td>
                                <td>{{ $cooperative->name }}</td>
                                <td>{{ $cooperative->members->count() }}</td>
                                <td>{{ $cooperative->contributionSchemes->count() }}</td>
                                <td>
                                    <span
                                        class="badge {{ $cooperative->status === Utils::STATUS_ACTIVE ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($cooperative->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('contributions.schemes', ['cooperativeId' => $cooperative->id]) }}"
                                       class="btn btn-sm btn-info">
                                        contribution schemes
                                    </a>

                                    <a href="{{ route('users', ['cooperativeId' => $cooperative->id]) }}"
                                       class="btn btn-sm btn-info">
                                        Members
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No cooperatives found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
                @if($cooperatives->hasPages())
                    <div class="d-flex justify-content-center mt-4 mb-3">
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $cooperatives->currentPage() == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $cooperatives->previousPageUrl() }}"
                                   aria-label="Previous">Prev</a>
                            </li>

                            @php
                                $start = max(1, $cooperatives->currentPage() - 3);
                                $end = min($start + 6, $cooperatives->lastPage());
                            @endphp

                            @if($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $cooperatives->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <li class="page-item {{ $cooperatives->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $cooperatives->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            @if($end < $cooperatives->lastPage())
                                @if($end < $cooperatives->lastPage() - 1)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                                <li class="page-item"><a class="page-link"
                                                         href="{{ $cooperatives->url($cooperatives->lastPage()) }}">{{ $cooperatives->lastPage() }}</a>
                                </li>
                            @endif

                            <li class="page-item {{ $cooperatives->currentPage() == $cooperatives->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $cooperatives->nextPageUrl() }}"
                                   aria-label="Next">Next</a>
                            </li>
                        </ul>
                    </div>
                @endif
                <!-- End Custom Pagination -->
            </div>
        </div>
        <!-- END Full Table -->
    </div>
    <!-- END Page Content -->

    <!-- Create Cooperative Modal -->
    <div class="modal fade" id="createCooperativeModal" tabindex="-1" aria-labelledby="createCooperativeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cooperatives.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCooperativeModalLabel">Create Cooperative</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cooperativeName" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="cooperativeName"
                               placeholder="Enter cooperative name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

@endsection
