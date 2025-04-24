@php use App\Utils\Utils;use Carbon\Carbon; @endphp
@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Full Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Contribution Schemes</h3>
                <!-- Trigger Modal -->
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createCooperativeModal">
                    <i class="fa fa-plus me-1"></i> Create New Contribution Scheme
                </button>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Penalty Fee</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Cooperative</th>
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
                                <td>{{ Carbon::parse($scheme->payment_date)->toFormattedDateString() }}</td>
                                <td>
                                    <span
                                        class="badge {{ $scheme->status === Utils::STATUS_ACTIVE ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($scheme->status) }}
                                    </span>
                                </td>
                                <td>{{ $scheme->corperative?->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('contribution-schemes.show', $scheme->id) }}"
                                       class="btn btn-sm btn-info">
                                        User contributions
                                    </a>
                                    <a href="{{ route('contribution-schemes.edit', $scheme->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <form action="{{ route('contribution-schemes.destroy', $scheme->id) }}"
                                          method="POST"
                                          class="d-inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this scheme?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No contribution schemes found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
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

                            <li class="page-item {{ $contributionSchemes->currentPage() == $contributionSchemes->lastPage() ? 'disabled' :
