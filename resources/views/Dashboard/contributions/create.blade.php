@extends('layouts.backend')

@section('content')
    <div class="content">
        <!-- Form Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Make a New Contribution</h3>
                <a href="{{ route('contributions.recent') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="block-content">
                <form action="{{ route('contributions.recent.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label" for="cooperative_id">Select Cooperative</label>
                        <select name="cooperative_id" id="cooperative_id" class="form-control" required>
                            <option value="">-- Select Cooperative --</option>
                            @foreach ($cooperatives as $cooperative)
                                <option value="{{ $cooperative->id }}">{{ $cooperative->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="contribution_scheme_id">Select Contribution Scheme</label>
                        <select name="contribution_scheme_id" id="contribution_scheme_id" class="form-control" required>
                            <option value="">-- Select Scheme --</option>
                            <!-- Options will be loaded via JS -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="user_contribution_id">Select User Contribution</label>
                        <select name="user_contribution_id" id="user_contribution_id" class="form-control" required>
                            <option value="">-- Select User Contribution --</option>
                            <!-- Options will be loaded via JS -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="amount">Contribution Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" required placeholder="Enter amount">
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="receipt">Upload Payment Receipt</label>
                        <input type="file" name="receipt" id="receipt" class="form-control" accept="image/*,application/pdf" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="notes">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Any additional info..."></textarea>
                    </div>

                    <div class="mb-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane me-1"></i> Submit Contribution
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('cooperative_id').addEventListener('change', function () {
            const cooperativeId = this.value;
            const schemeSelect = document.getElementById('contribution_scheme_id');
            schemeSelect.innerHTML = '<option value="">Loading schemes...</option>';

            fetch(`/api/cooperatives/${cooperativeId}/schemes`)
                .then(res => res.json())
                .then(data => {
                    schemeSelect.innerHTML = '<option value="">-- Select Scheme --</option>';
                    data.forEach(scheme => {
                        const option = document.createElement('option');
                        option.value = scheme.id;
                        option.text = scheme.name;
                        schemeSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    schemeSelect.innerHTML = '<option value="">Failed to load schemes</option>';
                });
        });

        document.getElementById('contribution_scheme_id').addEventListener('change', function () {
            const schemeId = this.value;
            const contributionSelect = document.getElementById('user_contribution_id');
            contributionSelect.innerHTML = '<option value="">Loading user contributions...</option>';

            fetch(`/api/contribution-schemes/${schemeId}/user-contributions`)
                .then(res => res.json())
                .then(data => {
                    contributionSelect.innerHTML = '<option value="">-- Select User Contribution --</option>';
                    data.forEach(uc => {
                        const option = document.createElement('option');
                        option.value = uc.id;
                        option.text = uc.description || `Contribution ID #${uc.id}`;
                        contributionSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    contributionSelect.innerHTML = '<option value="">Failed to load contributions</option>';
                });
        });
    </script>
@endpush
