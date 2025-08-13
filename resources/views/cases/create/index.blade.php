@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle, 'select2' => true])

@section('content')
    <div class="row" style="margin-top: 80px;">
        <div class="col-md-3">

            <ul class="policy-dropdown-menu policy-dropdown-submenu" style="display: block;">
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">Introducers Information</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu">
                        <li><a class="policy-dropdown-item each-options active" data-section="section-a-1" >Profile</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-a-2">Key Parties & Roles</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="policyholders">Policyholders
                        Information</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu" style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-b-1">Profile</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-b-2">Controlling Person</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="insured">Insured Life
                        Information</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu" style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-c-1">Insured Life</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="beneficiary">Beneficiary
                        Information</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu" style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-d-1">Beneficiary</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="kyc">KYC Requirements &amp;
                        Checklists</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu"  style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-e-1">Policy Holder Required Documents</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-e-2">Controlling Person Required Documents</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-e-3">Insured Life/ves Required Documents</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-e-4">Beneficiary/ies Required Documents</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="policy">Policy Information</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu"  style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-1">Economic Profile</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-2">Premium</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-3">Fee Summary (Internal)</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-4">Fee Summary (External)</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-5">Investment Profile (Inception)</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-6">Investment Profile (On-Going)</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-f-7">Investment Profile (Investment Notes)</a></li>
                    </ul>
                </li>
                <li class="dropdown child-dropdown">
                    <a href="#" class="policy-dropdown-item policy-dropdown-toggle" data-bs-toggle="dropdown" data-section="communications">Communications &amp;
                        Lifecycle</a>
                    <ul class="policy-dropdown-menu policy-dropdown-submenu"  style="display: none;">
                        <li><a class="policy-dropdown-item each-options" data-section="section-g-1">Communications</a></li>
                        <li><a class="policy-dropdown-item each-options" data-section="section-g-2">Case File Notes</a></li>
                    </ul>
                </li>
            </ul>

        </div>

        <div class="col-9 new-case">

            <div class="sub-title" style="margin-bottom: 40px;">
                <h2>
                    {{  request()->segment(2) == 'create' ? 'Add New Case' : 'Edit Case'  }} / CASE ID {{ Helper::generateCaseNumber() }}
                    <div id="saving-container" style="float:right;">                        
                    </div>
                </h2>
            </div>

            <div class="new-case-main" style="padding-left: 0px!important;">
            <div class="case-section" id="section-a-1">
                @php
                    $introducer = isset($policy->introducers[0]) ? $policy->introducers[0] : [
                        'type' => null,
                        'name' => null,
                        'email' => null,
                        'dial_code' => null,
                        'contact_number' => null
                    ];
                @endphp
                @include('cases.create.section-a-1', ['introducer' => $introducer])
            </div>
            <div class="case-section d-none" id="section-a-2">
                @php
                    $keyRolesA = $policy->keyroles()->where('type', 'policy-holder')->count() > 0 ? $policy->keyroles()->where('type', 'policy-holder')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];

                    $keyRolesB = $policy->keyroles()->where('type', 'insured-life')->count() > 0 ? $policy->keyroles()->where('type', 'insured-life')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];
                    
                    $keyRolesC = $policy->keyroles()->where('type', 'beneficiary')->count() > 0 ? $policy->keyroles()->where('type', 'beneficiary')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];

                    $keyRolesD = $policy->keyroles()->where('type', 'investment-advisor')->count() > 0 ? $policy->keyroles()->where('type', 'investment-advisor')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];

                    $keyRolesE = $policy->keyroles()->where('type', 'idf-name')->count() > 0 ? $policy->keyroles()->where('type', 'idf-name')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];

                    $keyRolesF = $policy->keyroles()->where('type', 'idf-manager')->count() > 0 ? $policy->keyroles()->where('type', 'idf-manager')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];

                    $keyRolesG = $policy->keyroles()->where('type', 'custodian-bank')->count() ? $policy->keyroles()->where('type', 'custodian-bank')->first()->toArray() : [
                        'type' => null,
                        'name' => null,
                        'entity_type' => null,
                        'notes' => null
                    ];
                @endphp
                @include('cases.create.section-a-2', [
                    'keyRolesA' => $keyRolesA,
                    'keyRolesB' => $keyRolesB,
                    'keyRolesC' => $keyRolesC,
                    'keyRolesD' => $keyRolesD,
                    'keyRolesE' => $keyRolesE,
                    'keyRolesF' => $keyRolesF,
                    'keyRolesG' => $keyRolesG
                ])
            </div>
            <div class="case-section d-none" id="section-b-1">
                @php
                    $polhol = \App\Models\PolicyHolder::with('holder')->where('policy_id', $policy->id)->first();

                    if ($polhol) {
                        $polhol = $polhol->toArray();
                    } else {
                        $polhol = [];
                    }
                @endphp

                @include('cases.create.section-b-1', ['polhol', 'polhol'])
            </div>
            <div class="case-section d-none" id="section-b-2">
                @php
                    $polhol = \App\Models\PolicyController::where('policy_id', $policy->id)->first();

                    if ($polhol) {
                        $polhol = $polhol->toArray();
                    } else {
                        $polhol = [];
                    }
                @endphp

                @include('cases.create.section-b-2', ['polhol', 'polhol'])
            </div>
            <div class="case-section d-none" id="section-c-1">
                @include('cases.create.section-c-1')
            </div>
            <div class="case-section d-none" id="section-d-1">
                @include('cases.create.section-d-1')
            </div>
            <div class="case-section d-none" id="section-e-1">
                @php
                    $dArr = \App\Models\PolicyDocument::where('policy_id', $policy->id)
                    ->where('document_type', 'policy-holder')
                    ->get(['document_id', 'uploaded', 'document'])
                    ->keyBy('document_id')
                    ->map(function ($item) {
                        return [
                            'uploaded' => $item->uploaded,
                            'document' => $item->document,
                        ];
                    })
                    ->toArray();
                @endphp

                @include('cases.create.section-e-1', ['dArr' => $dArr])
            </div>
            <div class="case-section d-none" id="section-e-2">
                @php
                    $dArr = \App\Models\PolicyDocument::where('policy_id', $policy->id)
                    ->where('document_type', 'controlling-person')
                    ->get(['document_id', 'uploaded', 'document'])
                    ->keyBy('document_id')
                    ->map(function ($item) {
                        return [
                            'uploaded' => $item->uploaded,
                            'document' => $item->document,
                        ];
                    })
                    ->toArray();
                @endphp

                @include('cases.create.section-e-2', ['dArr' => $dArr])
            </div>
            <div class="case-section d-none" id="section-e-3">
                @php
                    $dArr = \App\Models\PolicyDocument::where('policy_id', $policy->id)
                    ->where('document_type', 'insured-life')
                    ->get(['document_id', 'uploaded', 'document'])
                    ->keyBy('document_id')
                    ->map(function ($item) {
                        return [
                            'uploaded' => $item->uploaded,
                            'document' => $item->document,
                        ];
                    })
                    ->toArray();
                @endphp

                @include('cases.create.section-e-3', ['dArr' => $dArr])
            </div>
            <div class="case-section d-none" id="section-e-4">
                @php
                    $dArr = \App\Models\PolicyDocument::where('policy_id', $policy->id)
                    ->where('document_type', 'beneficiary')
                    ->get(['document_id', 'uploaded', 'document'])
                    ->keyBy('document_id')
                    ->map(function ($item) {
                        return [
                            'uploaded' => $item->uploaded,
                            'document' => $item->document,
                        ];
                    })
                    ->toArray();
                @endphp

                @include('cases.create.section-e-4', ['dArr' => $dArr])
            </div>
            <div class="case-section d-none" id="section-f-1">
                @php
                    $f1Data = \App\Models\PolicyEconomicProfile::where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-1', ['f1Data' => $f1Data])
            </div>
            <div class="case-section d-none" id="section-f-2">
                @php
                    $f2Data = \App\Models\PolicyPremium::where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-2', ['f2Data' => $f2Data])
            </div>
            <div class="case-section d-none" id="section-f-3">
                @php
                    $f3Data = \App\Models\PolicyFeeSummaryInternal::with('items')->where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-3', ['f3Data' => $f3Data])
            </div>
            <div class="case-section d-none" id="section-f-4">
                @php
                    $f4Data = \App\Models\PolicyFeeSummaryExternal::with('items')->where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-4', ['f4Data' => $f4Data])
            </div>
            <div class="case-section d-none" id="section-f-5">
                @php
                    $f5Data = \App\Models\PolicyInception::where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-5', ['f5Data' => $f5Data])
            </div>
            <div class="case-section d-none" id="section-f-6">
                @php
                    $f6Data = \App\Models\PolicyOnGoing::where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-6', ['f6Data' => $f6Data])
            </div>
            <div class="case-section d-none" id="section-f-7">
                @php
                    $f7Data = \App\Models\PolicyInvestmentNote::where('policy_id', $policy->id)->first();
                @endphp
                @include('cases.create.section-f-7', ['f7Data' => $f7Data])
            </div>
            <div class="case-section d-none" id="section-g-1">
                @php
                    $g1Data = \App\Models\PolicyCommunication::where('policy_id', $policy->id)->get();
                @endphp
                @include('cases.create.section-g-1', ['g1Data' => $g1Data])
            </div>
            <div class="case-section d-none" id="section-g-2">
                @php
                    $g2Data = \App\Models\PolicyCaseFileNote::where('policy_id', $policy->id)->get();
                @endphp
                @include('cases.create.section-g-2', ['g2Data' => $g2Data])
            </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/intel-tel.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">

@include('cases.create.style')

@endpush

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script src="{{ asset('assets/js/intel-tel.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

@include('cases.create.initial-script', [
    'policy'  => $policy ?? null,
])

@include('cases.create.script', [
    'introducer' => $introducer ?? [],
])
@endpush
