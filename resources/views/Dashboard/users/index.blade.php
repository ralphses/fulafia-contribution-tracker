@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default d-flex justify-content-between align-items-center">
                <h3 class="block-title">Cooperative Members</h3>
            </div>

            <div class="block-content">
                @if($members->count())
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->phone_number }}</td>
                                    <td>
                                            <span class="badge {{ $member->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('userContributions.user', ['user' => $member->id]) }}" class="btn btn-sm btn-primary">
                                            View Contributions
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Custom Pagination --}}
                    @if($members->hasPages())
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $members->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $members->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                </li>

                                @php
                                    $start = max(1, $members->currentPage() - 3);
                                    $end = min($start + 6, $members->lastPage());
                                @endphp

                                @if($start > 1)
                                    <li class="page-item"><a class="page-link" href="{{ $members->url(1) }}">1</a></li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                    @endif
                                @endif

                                @for($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $members->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $members->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $members->lastPage())
                                    @if($end < $members->lastPage() - 1)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                    @endif
                                    <li class="page-item"><a class="page-link" href="{{ $members->url($members->lastPage()) }}">{{ $members->lastPage() }}</a></li>
                                @endif

                                <li class="page-item {{ $members->currentPage() == $members->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $members->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            </ul>
                        </div>
                    @endif

                @else
                    <p class="text-center text-muted">No members found in your cooperative.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
