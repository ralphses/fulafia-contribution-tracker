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

        <!-- END Full Table -->
    </div>
    <!-- END Page Content -->
@endsection
