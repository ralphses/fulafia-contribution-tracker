@php use App\Utils\Utils; @endphp
@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">
                    @if($members)
                        Members Contributions
                    @else
                        My Contributions
                    @endif
                </h3>
                <form method="GET"
                      action="{{ request()->is('') ? route('userContributions.user') : route('userContributions.users') }}"
                      class="d-flex align-items-center">
                    <label for="scheme_id" class="me-2 mb-0 fw-semibold">Filter by Scheme:</label>
                    <select name="scheme_id" id="scheme_id" class="form-select form-select-sm me-2"
                            onchange="this.form.submit()">
                        <option value="">All Schemes</option>
                        @foreach($contributionSchemes as $scheme)
                            <option value="{{ $scheme->id }}" {{ $selectedScheme == $scheme->id ? 'selected' : '' }}>
                                {{ $scheme->name }}
                            </option>
                        @endforeach
                    </select>
                    @if(request()->has('scheme_id'))
                        <a href="{{ route('userContributions.users') }}" class="btn btn-sm btn-secondary">Reset</a>
                    @endif
                </form>
            </div>

            <div class="block-content">
                @forelse($userContributions as $userContribution)
                    <div class="block block-rounded border mb-4">
                        <div class="block-header bg-body-light">
                            <h4 class="mb-0">
                                {{ $userContribution->title }}
                                <span
                                    class="text-muted">({{ $userContribution->contributionScheme->name ?? 'N/A' }})</span>
                            </h4>
                        </div>
                        <div class="block-content">
                            <p><strong>Total Amount:</strong> ₦{{ number_format($userContribution->total_amount, 2) }}
                            </p>
                            <p><strong>Withdrawal Status:</strong> {{ ucfirst($userContribution->withdrawal_status) }}
                            </p>

                            @if($userContribution->contributions->count())
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount (₦)</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Receipt</th>
                                            <th>Admin Note</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($userContribution->contributions as $contribution)
                                            <tr>
                                                <td>{{ $contribution->contributed_at }}</td>
                                                <td>{{ number_format($contribution->amount, 2) }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($contribution->status === Utils::STATUS_ACTIVE) bg-success
                                                        @elseif($contribution->status === Utils::STATUS_REJECTED) bg-warning
                                                        @else bg-danger @endif">
                                                        {{ ucfirst($contribution->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $contribution->note ?? 'N/A' }}</td>
                                                <td>
                                                    @if($contribution->receipt_url)
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#receiptModal{{ $contribution->id }}">
                                                            View
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="receiptModal{{ $contribution->id }}"
                                                             tabindex="-1"
                                                             aria-labelledby="receiptModalLabel{{ $contribution->id }}"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="receiptModalLabel{{ $contribution->id }}">
                                                                            Receipt Preview</h5>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ $contribution->receipt_url }}"
                                                                             alt="Receipt Image" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No Receipt</span>
                                                    @endif
                                                </td>

                                                <td>{{ $contribution->admin_note ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No individual contributions yet.</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">
                        @if($members)
                            No members contribution found
                        @else
                            You have not made any contributions yet.
                        @endif
                    </p>
                @endforelse

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $userContributions->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
