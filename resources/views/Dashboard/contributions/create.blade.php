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
                        <select name="cooperative_id" id="cooperative_id" class="form-control @error('cooperative_id') is-invalid @enderror" required>
                            <option value="">-- Select Cooperative --</option>
                            @foreach ($cooperatives as $cooperative)
                                <option value="{{ $cooperative->id }}" {{ old('cooperative_id') == $cooperative->id ? 'selected' : '' }}>
                                    {{ $cooperative->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cooperative_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="contribution_scheme_id">Select Contribution Scheme</label>
                        <select name="contribution_scheme_id" id="contribution_scheme_id" class="form-control @error('contribution_scheme_id') is-invalid @enderror" required>
                            <option value="">-- Select Scheme --</option>
                        </select>
                        @error('contribution_scheme_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="user_contribution_id">Select User Contribution</label>
                        <select name="user_contribution_id" id="user_contribution_id" class="form-control @error('user_contribution_id') is-invalid @enderror" required>
                            <option value="">-- Select User Contribution --</option>
                        </select>
                        @error('user_contribution_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="amount">Contribution Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" required
                               placeholder="Enter amount" value="{{ old('amount') }}">
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="receipt">Upload Payment Receipt</label>
                        <input type="file" name="receipt" id="receipt" class="form-control @error('receipt') is-invalid @enderror"
                               accept="image/*,application/pdf" required>
                        @error('receipt')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="notes">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Any additional info...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cooperativeSelect = document.getElementById('cooperative_id');
            const schemeSelect = document.getElementById('contribution_scheme_id');
            const contributionSelect = document.getElementById('user_contribution_id');

            if (cooperativeSelect) {
                cooperativeSelect.addEventListener('change', function () {
                    const cooperativeId = this.value;
                    schemeSelect.innerHTML = '<option value="">Loading schemes...</option>';

                    fetch(`/dashboard/cooperatives/${cooperativeId}/schemes`)
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
            }

            if (schemeSelect) {
                schemeSelect.addEventListener('change', function () {
                    const schemeId = this.value;
                    contributionSelect.innerHTML = '<option value="">Loading user contributions...</option>';

                    fetch(`/dashboard/contribution-schemes/${schemeId}/user-contributions`)
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
            }
        });
    </script>

