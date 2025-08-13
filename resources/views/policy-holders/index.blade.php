@extends('layouts.app',['title' => $title, 'subTitle' => $subTitle,'datatable' => true, 'select2' => true, 'datepicker' => true])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="filter-type" class="form-label">Type</label>
                                <select class="form-select" id="filter-type">
                                    <option value="">All Types</option>
                                    <option value="individual">Individual</option>
                                    <option value="entity">Entity</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter-status" class="form-label">Status</label>
                                <select class="form-select" id="filter-status">
                                    <option value="">All Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="separated">Separated</option>
                                    <option value="corporation">Corporation</option>
                                    <option value="llc">LLC</option>
                                    <option value="trust">Trust</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="foundation">Foundation</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter-gender" class="form-label">Gender</label>
                                <select class="form-select" id="filter-gender">
                                    <option value="">All Genders</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filter-name" class="form-label">Search</label>
                                <input type="text" class="form-control" id="filter-name" placeholder="Search by name, email, phone...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                @if(auth()->user()->can('policy-holders.create'))
                <a href="{{ route('policy-holders.create') }}" class="btn btn-primary float-end"> 
                    <i class="fa fa-plus"></i> Add New Policy Holder 
                </a>
                @endif

                <button class="btn btn-outline-secondary me-2" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="false" aria-controls="filterPanel">
                    <i class="fa fa-filter"></i> Filter
                </button>

            </div>
            <div class="card-body">
                <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Type</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        let dataTable = $('#datatables-reponsive').DataTable({
            pageLength : 10,
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route(Request::route()->getName()) }}",
                "type": "GET",
                "data" : {
                    filter_type: function() {
                        return $("#filter-type").val();
                    },
                    filter_status: function() {
                        return $("#filter-status").val();
                    },
                    filter_gender: function() {
                        return $("#filter-gender").val();
                    },
                    filter_name: function () {
                        return $('#filter-name').val();
                    }
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'full_name',
                },
                {
                    data: 'email',
                },
                {
                    data: 'phone_number',
                },
                {
                    data: 'type',
                },
                {
                    data: 'gender',
                },
                {
                    data: 'status',
                },
                {
                    data: 'address',
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                }
            ],
            order: [[1, 'asc']]
        });

        $('#filter-type, #filter-status, #filter-gender').on('change', function() {
            dataTable.ajax.reload();
        });

        $('#filter-name').on('keyup', function() {
            dataTable.ajax.reload();
        });

        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('policy-holders.destroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.success,
                                'success'
                            );
                            dataTable.ajax.reload();
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
