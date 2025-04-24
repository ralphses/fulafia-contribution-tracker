@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Full Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Recent Contributions</h3>
                <a href="{{ route('contributions.recent.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i> Make New Contribution
                </a>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Receipt</th>
                            <th>Status</th>
                            <th>Scheme</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contributions as $index => $contribution)
                            <tr>
                                <td class="fw-semibold">{{ $contributions->firstItem() + $index }}</td>
                                <td>{{ number_format($contribution->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($contribution->payment_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($contribution->receipt_path)
                                        <a href="{{ asset('storage/' . $contribution->receipt_path) }}" target="_blank">View Receipt</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $contribution->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($contribution->status) }}
                                    </span>
                                </td>
                                <td>{{ $contribution->contributionScheme->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{-- Add action buttons here if needed --}}
                                    <button class="btn btn-sm btn-secondary">Accept</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No contributions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($contributions->hasPages())
                    <div class="d-flex justify-content-center mt-4 mb-3">
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $contributions->currentPage() == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $contributions->previousPageUrl() }}" aria-label="Previous">Prev</a>
                            </li>

                            @php
                                $start = max(1, $contributions->currentPage() - 3);
                                $end = min($start + 6, $contributions->lastPage());
                            @endphp

                            @if($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $contributions->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                <li class="page-item {{ $contributions->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $contributions->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            @if($end < $contributions->lastPage())
                                @if($end < $contributions->lastPage() - 1)
                                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $contributions->url($contributions->lastPage()) }}">{{ $contributions->lastPage() }}</a></li>
                            @endif

                            <li class="page-item {{ $contributions->currentPage() == $contributions->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $contributions->nextPageUrl() }}" aria-label="Next">Next</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <!-- END Full Table -->
    </div>
    <!-- END Page Content -->
@endsection
