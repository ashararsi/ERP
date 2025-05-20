@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Generate Recovery Sheet</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.recovery_sheet.generate') }}" method="POST" target="_blank">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="sales_person_id" class="form-label">Sales Person:</label>
                        <select id="sales_person_id" name="sales_person_id" class="form-select select2" multiple required>
                            @foreach($salesPersons as $person)
                                <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="city_id" class="form-label">City:</label>
                        <select id="city_id" name="cities[]" class="form-select select2" multiple required>
                            <option value="all">All</option>
                            {{-- Dynamically filled --}}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="area_id" class="form-label">Area:</label>
                        <select id="area_id" name="areas[]" class="form-select select2" multiple required>
                            <option value="all">All</option>
                            {{-- Dynamically filled --}}
                        </select>
                    </div>
                </div>
            
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
            
                <button type="submit" class="btn btn-success">Generate Recovery Sheet</button>
            </form>            
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();

        $('#sales_person_id').on('change', function () {
            const selectedSPOs = $(this).val();

            if (selectedSPOs.length) {
                $.ajax({
                    url: '{{ route("admin.recovery.getLocations") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sales_person_ids: selectedSPOs
                    },
                    success: function (data) {
                        // Cities
                        let cityOptions = `<option value="all">All</option>`;
                        data.cities.forEach(city => {
                            cityOptions += `<option value="${city.id}">${city.name}</option>`;
                        });
                        $('#city_id').html(cityOptions);

                        // Areas
                        let areaOptions = `<option value="all">All</option>`;
                        data.areas.forEach(area => {
                            areaOptions += `<option value="${area.id}">${area.name}</option>`;
                        });
                        $('#area_id').html(areaOptions);

                        // Auto-select all fetched city and area IDs
                        const selectedCityIds = data.cities.map(city => city.id.toString());
                        const selectedAreaIds = data.areas.map(area => area.id.toString());

                        $('#city_id').val(selectedCityIds).trigger('change');
                        $('#area_id').val(selectedAreaIds).trigger('change');
                    }
                });
            } else {
                $('#city_id, #area_id').html('<option value="all">All</option>').val([]).trigger('change');
            }
        });

        $('#sales_person_id').trigger('change'); 
    });
</script>


@endsection
