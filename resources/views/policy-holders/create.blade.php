@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@push('css')
<style>
    div.iti--inline-dropdown {
        min-width: 100%!important;
    }
    .iti__selected-flag {
        height: 32px!important;
    }
    .iti--show-flags {
        width: 100%!important;
    }  
    label.error {
        color: red;
    }
    #phone_number{
        font-family: "Hind Vadodara",-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif;
        font-size: 15px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">Add New Policy Holder</div>
            <div class="card-body">
                <form id="policyHolderForm" method="POST" action="{{ route('policy-holders.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="entity" {{ old('type') == 'entity' ? 'selected' : '' }}>Entity</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label"> Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="hidden" name="dial_code" id="dial_code">
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    @forelse(Helper::$individualStates as $key => $value)
                                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @empty
                                        <option value="">No Status Available</option>
                                    @endforelse
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" readonly required>
                                @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 status-other-field @if(old('status') === 'other' || empty(old('status', null))) d-none @endif">
                        <label for="status_name" class="form-label">Status Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('status_name') is-invalid @enderror" id="status_name" name="status_name" value="{{ old('status_name') }}" @if(old('status') === 'other' || empty(old('status', null))) required @endif>
                        @error('status_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Place of Birth <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth" rows="3" required>{{ old('place_of_birth') }}</textarea>
                        @error('place_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address_line_1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <textarea name="address_line_1" id="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror" rows="3" required>{{ old('address_line_1') }}</textarea>
                                @error('address_line_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address_line_2" class="form-label">Address Line 2</label>
                                <textarea name="address_line_2" id="address_line_2" class="form-control @error('address_line_2') is-invalid @enderror" rows="3">{{ old('address_line_2') }}</textarea>
                                @error('address_line_2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $id => $name)
                                        <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required>
                                    <option value="">Select State</option>
                                </select>
                                @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                                    <option value="">Select City</option>
                                </select>
                                @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="zipcode" class="form-label">Zipcode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode" name="zipcode" value="{{ old('zipcode') }}" required>
                        @error('zipcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Policy Holder</button>
                    <a href="{{ route('policy-holders.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/intel-tel.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script src="{{ asset('assets/js/intel-tel.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%'
    });

    const input = document.querySelector('#phone_number');
    const errorMap = ["Phone number is invalid.", "Invalid country code", "Too short", "Too long"];

    const iti = window.intlTelInput(input, {
        initialCountry: "{{  Helper::$defaulDialCode  }}",
        separateDialCode:true,
        nationalMode:false,
        preferredCountries: @json(\App\Models\Country::select('iso2')->pluck('iso2')->toArray()),
        utilsScript: "{{ asset('assets/js/intel-tel-2.min.js') }}"
    });
    input.addEventListener("countrychange", function() {
        if (iti.isValidNumber()) {
            $('#dial_code').val(iti.s.dialCode);
        }
    });
    input.addEventListener('keyup', () => {
        if (iti.isValidNumber()) {
            $('#dial_code').val(iti.s.dialCode);
        }
    });

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: '-1d',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0'
    });

    const individualStatuses = @json(Helper::$individualStates);
    const entityStatuses = @json(Helper::$entityStatuses);

    function updateStatusOptions() {
        const type = $('#type').val();
        const statusSelect = $('#status');
        statusSelect.empty().append('<option value="">Select Status</option>');
            
        if (type === 'individual') {
            Object.values(individualStatuses).forEach((status, index) => {
                statusSelect.append(`<option value="${Object.keys(individualStatuses)[index]}">${status}</option>`);
            });
        } else if (type === 'entity') {
            Object.values(entityStatuses).forEach((status, index) => {
                statusSelect.append(`<option value="${Object.keys(entityStatuses)[index]}">${status}</option>`);
            });
        }
    }

    $('#type').on('change', function() {
        updateStatusOptions();
        $('#status').val('').trigger('change');
        $('.status-other-field').addClass('d-none');
    });

    $('#status').on('change', function() {
        if ($(this).val() === 'other') {
            $('.status-other-field').removeClass('d-none');
            $('#status_name').prop('required', true);
        } else {
            $('.status-other-field').addClass('d-none');
            $('#status_name').prop('required', false);
        }
    });

    $('#policyHolderForm').validate({
        rules: {
            type: 'required',
            name: 'required',
            email: {
                required: true,
                email: true
            },
            phone_number: 'required',
            gender: {
                required: function() {
                    return $('#type').val() === 'individual';
                }
            },
            dob: 'required',
            place_of_birth: 'required',
            address_line_1: 'required',
            country_id: 'required',
            state_id: 'required',
            city_id: 'required',
            zipcode: 'required',
            status: 'required',
            status_name: {
                required: function() {
                    return $('#status').val() === 'other';
                }
            }
        },
        messages: {
            type: 'Please select a type',
            name: 'Please enter full name',
            email: {
                required: 'Please enter email address',
                email: 'Please enter a valid email address'
            },
            phone_number: 'Please enter phone number',
            gender: 'Please select gender',
            dob: 'Please select date of birth',
            place_of_birth: 'Please enter place of birth',
            address_line_1: 'Please enter address line 1',
            country_id: 'Please select country',
            state_id: 'Please select state',
            city_id: 'Please select city',
            zipcode: 'Please enter zipcode',
            status: 'Please select status',
            status_name: 'Please enter status name'
        },
        errorPlacement: function(error, element) {
            if (element.attr('id') === 'phone_number') {
                error.insertAfter(element.parent());
            } else {
                error.appendTo(element.parent());
            }
        },
        submitHandler: function(form) {
            $('#dial_code').val(iti.s.dialCode);
            $('body').find('.LoaderSec').removeClass('d-none');
            form.submit();
        }
    });


        $('#country_id').select2({
        allowClear: true,
        placeholder: 'Select country',
        width: '100%',
        ajax: {
            url: "{{ route('country-list') }}",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchQuery: params.term,
                    page: params.page || 1,  
                    _token: "{{ csrf_token() }}"
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function(item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });

    $('#state_id').select2({
        allowClear: true,
        placeholder: 'Select state',
        width: '100%',
        ajax: {
            url: "{{ route('state-list') }}",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchQuery: params.term,
                    page: params.page || 1,
                    country_id: $('#country_id').val(),
                    _token: "{{ csrf_token() }}"
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function(item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });

    $('#city_id').select2({
        allowClear: true,
        placeholder: 'Select city',
        width: '100%',
        ajax: {
            url: "{{ route('city-list') }}",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchQuery: params.term,
                    page: params.page || 1,
                    state_id: $('#state_id').val(),
                    _token: "{{ csrf_token() }}"
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function(item) {
                        return {
                            id: item.id,
                            text: item.text
                        };
                    }),
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });

    updateStatusOptions();
});
</script>
@endpush
