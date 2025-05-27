@php use App\Utils\Utils; @endphp
@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Contribution Schemes Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Contribution Schemes</h3>
                @if(!in_array(auth()->user()->role, [Utils::ROLE_STAFF, Utils::ROLE_STUDENT]))
                    <a href="{{ route('contribution-schemes.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i> Create New Scheme
                    </a>
                @endif
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Penalty Fee (₦)</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Corperative</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contributionSchemes as $index => $scheme)
                            <tr>
                                <td class="fw-semibold">{{ $contributionSchemes->firstItem() + $index }}</td>
                                <td>{{ $scheme->name }}</td>
                                <td>{{ ucfirst($scheme->type) }}</td>
                                <td>{{ number_format($scheme->penalty_fee, 2) }}</td>
                                <td>{{ $scheme->payment_time }}</td>
                                <td>
                                    <span class="badge {{ $scheme->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($scheme->status) }}
                                    </span>
                                </td>
                                <td>{{ $scheme->corperative->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if(!in_array(auth()->user()->role, [Utils::ROLE_STAFF, Utils::ROLE_STUDENT]))

                                    <a href="{{ route('userContributions.users', ['scheme_id' => $scheme->id]) }}"
                                       class="btn btn-sm btn-info">View Contributors</a>
                                    @endif

                                    <form action="{{ route('userContributions.create') }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        <input name="scheme" value="{{ $scheme->id }}" hidden>
                                        <button type="submit" class="btn btn-sm btn-info">Join</button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No contribution schemes found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($contributionSchemes->hasPages())
                    <div class="d-flex justify-content-center mt-4 mb-3">
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $contributionSchemes->currentPage() == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $contributionSchemes->previousPageUrl() }}"
                                   aria-label="Previous">Prev</a>
                            </li>

                            @php
                                $start = max(1, $contributionSchemes->currentPage() - 3);
                                $end = min($start + 6, $contributionSchemes->lastPage());
                            @endphp

                            @if($start > 1)
                                <li class="page-item"><a class="page-link"
                                                         href="{{ $contributionSchemes->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <li class="page-item {{ $contributionSchemes->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $contributionSchemes->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            @if($end < $contributionSchemes->lastPage())
                                @if($end < $contributionSchemes->lastPage() - 1)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                                <li class="page-item"><a class="page-link"
                                                         href="{{ $contributionSchemes->url($contributionSchemes->lastPage()) }}">{{ $contributionSchemes->lastPage() }}</a>
                                </li>
                            @endif

                            <li class="page-item {{ $contributionSchemes->currentPage() == $contributionSchemes->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $contributionSchemes->nextPageUrl() }}" aria-label="Next">Next</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- END Contribution Schemes Table -->
    </div>
    <!-- END Page Content -->
@endsection
