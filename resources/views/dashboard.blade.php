@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <!-- Total Users Block -->
            <div class="col-md-6 col-xl-6">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Total Students
                        </h3>
                    </div>
                    <div class="block-content font-size-sm text-muted">
                        <p>
                            <strong>{{ 2 }}</strong>
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
                           <strong>{{ 2 }}</strong>
                        </p>
                    </div>
                </div>
            </div>
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
                            <strong>{{ 2 }}</strong>
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
                            <strong>{{ 2 }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            Amount Disbursed
                        </h3>
                    </div>
                    <div class="block-content font-size-sm text-muted">
                        <p>
                            <strong>{{ 2 }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Table -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Recent Payments</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th style="width: 30%;">Email</th>
                            <th style="width: 15%;">Access</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="fw-semibold">Albert Ray</td>
                            <td>customer1@example.com</td>
                            <td>
                                <span class="badge bg-danger">Disabled</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Full Table -->
    </div>
    <!-- END Page Content -->
@endsection
