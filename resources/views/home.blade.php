@extends('layouts.app')

@section('content')

<div class="col-xl-12 d-flex">
    <div class="cards-main">
        <div class="cards-container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="card-block">
                        <div class="icon">
                            <img src="{{ asset('assets/images/svg/folder.svg') }}" alt="folder" class="img-fluid">
                        </div>
                        <div class="heading">
                            <div class="title">
                                <h4> {{ \App\Models\Policy::count() }} </h4>
                            </div>
                            <div class="sub-title">
                                <h5>Cases</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card-block">
                        <div class="icon">
                            <img src="{{ asset('assets/images/svg/form.svg') }}" alt="form" class="img-fluid">
                        </div>
                        <div class="heading">
                            <div class="title">
                                <h4> {{ \App\Models\Customer::whereHas('roles', fn ($builder) => $builder->where('name', 'policy-holder'))->count() }} </h4>
                            </div>
                            <div class="sub-title">
                                <h5>Policy Holders</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card-block">
                        <div class="icon">
                            <img src="{{ asset('assets/images/svg/patnership.svg') }}" alt="patnership" class="img-fluid">
                        </div>
                        <div class="heading">
                            <div class="title">
                                <h4> {{ \App\Models\Policy::count() }} </h4>
                            </div>
                            <div class="sub-title">
                                <h5>Introducers</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="access-report">
            <div class="access-report-detail">
                <div class="title">
                    <h4>Quick Access Reports</h4>
                </div>
                <form class="search-form" role="search">
                    <input class="form-control" type="search" placeholder="Search"
                        aria-label="Search" />
                    <div class="search-icon">
                        <img src="{{ asset('assets/images/svg/search.svg') }}" alt="search" class="img-fluid">
                    </div>
                </form>
            </div>
            <div class="cards-container">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card-block">
                            <div class="icon">
                                <img src="{{ asset('assets/images/svg/arrow-patnership.svg') }}" alt="patnership" class="img-fluid">
                            </div>
                            <div class="heading">
                                <div class="sub-title">
                                    <h5>Top Introducers</h5>
                                </div>
                            </div>
                            <div class="download">
                                <a href="javascript:void(0);"><img src="{{ asset('assets/images/svg/down-arrow.svg') }}"
                                        alt="down-arrow" class="img-fluid"> Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card-block">
                            <div class="icon">
                                <img src="{{ asset('assets/images/svg/fomr-aarow.svg') }}" alt="form-arrow" class="img-fluid">
                            </div>
                            <div class="heading">
                                <div class="sub-title">
                                    <h5>Top Policyholders</h5>
                                </div>
                            </div>
                            <div class="download">
                                <a href="javascript:void(0);"><img src="{{ asset('assets/images/svg/down-arrow.svg') }}"
                                        alt="down-arrow" class="img-fluid"> Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card-block">
                            <div class="icon">
                                <img src="{{ asset('assets/images/svg/user.svg') }}" alt="folder" class="img-fluid">
                            </div>
                            <div class="heading">
                                <div class="sub-title">
                                    <h5>Top Employees</h5>
                                </div>
                            </div>
                            <div class="download">
                                <a href="javascript:void(0);"><img src="{{ asset('assets/images/svg/down-arrow.svg') }}"
                                        alt="down-arrow" class="img-fluid"> Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
