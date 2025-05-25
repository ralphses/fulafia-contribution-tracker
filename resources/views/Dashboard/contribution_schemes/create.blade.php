@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Create New Contribution Scheme</h3>
            </div>
            <div class="block-content">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contribution-schemes.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">Scheme Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="type">Type</label>
                        <select
                            class="form-control"
                            id="type"
                            name="type"
                            required
                        >
                            <option value="">-- Select Type --</option>
                            @foreach($types as $type)
                                <option
                                    value="{{ $type }}"
                                    {{ old('type') == $type ? 'selected' : '' }}
                                >
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Time inputs -->
                    <div class="mb-3" id="payment-time-daily-wrapper" style="display:none;">
                        <label class="form-label" for="payment_time_daily">Time of Day (Daily)</label>
                        <input
                            type="time"
                            class="form-control"
                            id="payment_time_daily"
                            name="payment_time"
                            value="{{ old('payment_time') }}"
                        >
                    </div>

                    <div class="mb-3" id="payment-time-select-wrapper" style="display:none;">
                        <label class="form-label" for="payment_time_select">Payment Time</label>
                        <select class="form-control" id="payment_time_select" name="payment_time">
                            <!-- Options populated dynamically -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="penalty_fee">Penalty Fee (₦)</label>
                        <input
                            type="number"
                            class="form-control"
                            id="penalty_fee"
                            name="penalty_fee"
                            step="0.01"
                            value="{{ old('penalty_fee') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="total_amount">Total Amount to Pay (₦)</label>
                        <input
                            type="number"
                            class="form-control"
                            id="total_amount"
                            name="total_amount"
                            step="0.01"
                            value="{{ old('total_amount') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="total_times">Total Number of Times to Pay</label>
                        <input
                            type="number"
                            class="form-control"
                            id="total_times"
                            name="total_times"
                            min="1"
                            value="{{ old('total_times') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="corperative_id">Cooperative</label>
                        <select
                            class="form-control"
                            id="corperative_id"
                            name="corperative_id"
                            required
                        >
                            <option value="">-- Select Cooperative --</option>
                            @foreach($corperatives as $corperative)
                                <option
                                    value="{{ $corperative->id }}"
                                    {{ old('corperative_id') == $corperative->id ? 'selected' : '' }}
                                >
                                    {{ $corperative->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check-circle me-1"></i> Create Scheme
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeField = document.getElementById('type');
        const dailyWrapper = document.getElementById('payment-time-daily-wrapper');
        const selectWrapper = document.getElementById('payment-time-select-wrapper');
        const selectField = document.getElementById('payment_time_select');

        const options = {
            weekly: [
                'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
            ],
            monthly: Array.from({length: 31}, (_, i) => (i + 1).toString()), // 1 to 31
            quarterly: [
                'January', 'February', 'March',     // Q1
                'April', 'May', 'June',             // Q2
                'July', 'August', 'September',     // Q3
                'October', 'November', 'December'  // Q4
            ],
            yearly: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ]
        };

        function populateSelectOptions(arr) {
            selectField.innerHTML = '';
            arr.forEach(option => {
                const el = document.createElement('option');
                el.value = option;
                el.textContent = option;
                selectField.appendChild(el);
            });
        }

        function handleTypeChange() {
            const selected = typeField.value.toLowerCase();

            dailyWrapper.style.display = 'none';
            selectWrapper.style.display = 'none';

            if (selected === 'daily') {
                dailyWrapper.style.display = 'block';
            } else if (options[selected]) {
                populateSelectOptions(options[selected]);
                selectWrapper.style.display = 'block';
            }
        }

        handleTypeChange();

        typeField.addEventListener('change', handleTypeChange);
    });
</script>
