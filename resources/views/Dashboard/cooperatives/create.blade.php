@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create New Corperative</h3>
            </div>

            <div class="block-content">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input.</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('cooperatives.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="name">Corperative Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('cooperatives') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
