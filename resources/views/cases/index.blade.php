@extends('layouts.app',['title' => $title, 'subTitle' => $subTitle,'datatable' => true, 'select2' => true, 'datepicker' => true])

@section('content')

    <div class="case-management-main">
        <div class="sub-title">
            <h2>Case Management</h2>
        </div>
        <div class="case-management-block">
            <div class="form-content">
                <input type="text" class="form-control" placeholder="Case ID" id="filter-case">
            </div>
            <div class="form-content">
                <input type="text" class="form-control common-date-picker" placeholder="Date Opened - Renewal" id="filter-opened">
            </div>
            <div class="form-content">
                <input type="text" class="form-control" placeholder="Primary Holder" id="filter-holder">
            </div>
            <div class="form-content">
                <input type="text" class="form-control" placeholder="Introducer" id="filter-introducer">
            </div>
            <div class="form-content">
                <select class="form-control" id="filter-status">
                    <option selected value=""> All </option>
                    <option value="0"> Draft </option>
                    <option value="1"> Pending </option>
                    <option value="2"> Follow Up </option>
                    <option value="3"> Active </option>
                    <option value="4"> InActive </option>
                </select>
            </div>
            <div class="form-button">
                <button type="button" class="btn red-btn the-btn">Search</button>
            </div>
        </div>
        <div class="case-mananement-table table-responsive">
            <table class="table" id="datatables-reponsive">
                <thead>
                    <tr>
                        <th scope="col">Case ID</th>
                        <th scope="col">Date Opened</th>
                        <th scope="col">Last Renewal</th>
                        <th scope="col">Primary Holder</th>
                        <th scope="col">Introducer</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

@endsection


@push('js')
<script>
    $(document).ready(function () {
        let dataTable = $('#datatables-reponsive').DataTable({
            pageLength : 50,
            searching: false,
            ordering: false,
            "lengthChange": false,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route(Request::route()->getName()) }}",
                "type": "GET",
                "data" : {
                    filter_case:function() {
                        return $("#filter-case").val();
                    },
                    filter_opened: function () {
                        return $('#filter-opened').val();
                    },
                    filter_holder: function () {
                        return $('#filter-holder').val();
                    },
                    filter_introducer: function () {
                        return $('#filter-introducer').val();
                    },
                    filter_status: function () {
                        return $('#filter-status').val();
                    }
                }
            },
            columns: [
                {
                    data: 'policy_number',
                },
                {
                    data: 'opening_date',
                },
                {
                    data: 'opening_date',
                },
                {
                    data: 'theholder',
                },
                {
                    data: 'introducer',
                },
                {
                    data: 'status',
                },
                {
                    data: 'action',
                }
            ],
        });

        $('.the-btn').on('click', function () {
            dataTable.ajax.reload();
        });

        $('.common-date-picker').datepicker({
            timepicker:false,
            format:'d/m/Y',
            className: 'common-datepicker-popup'
        });        

    });
</script>
@endpush