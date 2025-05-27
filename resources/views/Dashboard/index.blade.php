@php use App\Utils\Utils;use Carbon\Carbon; @endphp

@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <!-- Total Users Block -->
            @if(!$isRegularUser)
                <div class="col-md-6 col-xl-6">
                    <div class="block block-rounded h-100 mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Total Students
                            </h3>
                        </div>
                        <div class="block-content font-size-sm text-muted">
                            <p>
                                <strong>{{ $statistics['totalStudents'] }}</strong>
                            </p>
                        </div>
                    </div>
                </div>

            <!-- Active Users Block -->
            <div class="col-md-6 col-xl-6">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Total Staff
                        </h3>
                    </div>
                    <div class="block-content font-size-sm text-muted">
                        <p>
                            <strong>{{ $statistics['totalStaff'] }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="row items-push">
            <!-- Total Users Block -->
            <div class="col-md-6 col-xl-4">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Total Amount
                        </h3>
                    </div>
                    <div class="block-content font-size-sm text-muted">
                        <p>
                            <strong>{{ $statistics['totalAmount'] }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Active Users Block -->
            <div class="col-md-6 col-xl-4">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Amount Received
                        </h3>
                    </div>
                    <div class="block-content font-size-sm text-muted">
                        <p>
                            <strong>{{ $statistics['amountReceived'] }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            @if(!$isRegularUser)

                <div class="col-md-6 col-xl-4">
                    <div class="block block-rounded h-100 mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Amount Disbursed
                            </h3>
                        </div>
                        <div class="block-content font-size-sm text-muted">
                            <p>
                                <strong>{{ $statistics['amountDisbursed'] }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

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
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contributions as $index => $contribution)
                            <tr>
                                <td class="fw-semibold">{{ $contributions->firstItem() + $index }}</td>
                                <td>{{ number_format($contribution->amount, 2) }}</td>
                                <td>{{ Carbon::parse($contribution->payment_date)->format('d/m/Y') }}</td>
                                <td>
                                    @if($contribution->receipt_path)
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="modal"
                                                data-bs-target="#receiptModal{{ $contribution->id }}">
                                            View Receipt
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="receiptModal{{ $contribution->id }}" tabindex="-1"
                                             aria-labelledby="receiptModalLabel{{ $contribution->id }}"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="receiptModalLabel{{ $contribution->id }}">Payment
                                                            Receipt</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $contribution->receipt_path) }}"
                                                             class="img-fluid" alt="Receipt Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                <span
                                    class="badge {{ $contribution->status == Utils::STATUS_ACTIVE ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($contribution->status) }}
                                </span>
                                </td>
                                <td class="text-center">
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
            </div>
        </div>
        <!-- END Full Table -->
    </div>
    <!-- END Page Content -->
@endsection
