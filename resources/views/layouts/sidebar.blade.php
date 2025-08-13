@php
    $user = auth()->user();

    $userManagementPermissions = [
        'users.index', 'roles.index'
    ];

    $customerManagementPermissions = [
        'policy-holders.index'
    ];

    $caseManagementPermissions = [
        'cases.index', 'cases.create'
    ];

    $canViewUserManagement = collect($userManagementPermissions)->contains(fn($perm) => $user->can($perm));
    $canViewCustomerManagement = collect($customerManagementPermissions)->contains(fn($perm) => $user->can($perm));
    $canViewCaseManagement = collect($caseManagementPermissions)->contains(fn($perm) => $user->can($perm));

    $segment = request()->segment(1);

    $userManagementSegments = ['users', 'roles'];
    $customerManagementSegment = ['policy-holders'];
    $caseManagementSegment = ['cases'];

    $activeUserManagement = in_array($segment, $userManagementSegments);
    $activeCustomerManagement = in_array($segment, $customerManagementSegment);
    $activeCaseManagement = in_array($segment, $caseManagementSegment);

    $caseId = implode('***', [auth()->id(), null, 'sha-2']);
    $oldCasePending = false;

@endphp

<aside class="sidebar-main-menu collapse show" id="navbar-content">
    <nav class="navbar navbar-expand">
        <div class="sidebar-logo">
            <a class="navbar-brand" href="index.html">
                <img src="{{ Helper::logo() }}" alt="logo" class="img-fluid">
            </a>

            <span>Case Management Portal</span>
        </div>
        <div class="collapse navbar-collapse" id="navbar-content">
            <div class="sidebar-menu-heading">
                <img src="{{ asset('assets/images/svg/dashboard.svg') }}" alt="dashboard" class="img-fluid">
                <span>Dashboard</span>
            </div>
            <ul class="navbar-nav">


                @if ($canViewCaseManagement)
                <li class="nav-item dropdown child-dropdown">
                    <a class="nav-link dropdown-toggle @if ($activeCaseManagement) show @endif" href="#" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside">Case Management</a>
                    <ul class="dropdown-menu @if ($activeCaseManagement) show @endif">
                        <li><a class="dropdown-item" href="{{ route('cases.index') }}">List Cases</a></li>
                        <li><a class="dropdown-item" href="{{ route('cases.create', encrypt($caseId)) }}"> Add New </a></li>
                    </ul>
                </li>
                @endif


                @if ($canViewUserManagement)
                <li class="nav-item dropdown child-dropdown">
                    <a class="nav-link dropdown-toggle @if ($activeUserManagement) show @endif" href="#" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside">Users Management</a>
                    <ul class="dropdown-menu @if ($activeUserManagement) show @endif">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                        <li><a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a></li>
                    </ul>
                </li>
                @endif


                @if ($canViewCustomerManagement)
                <li class="nav-item dropdown child-dropdown">
                    <a class="nav-link dropdown-toggle @if ($activeCustomerManagement) show @endif" href="#" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside">Customers Management</a>
                    <ul class="dropdown-menu @if ($activeCustomerManagement) show @endif">
                        <li><a class="dropdown-item" href="{{ route('policy-holders.index') }}">Policy Holders</a></li>
                    </ul>
                </li>
                @endif


            </ul>
            <div class="h-login-logout">
                <ul>
                    <li>
                        <form action="{{ route('logout') }}" method="POST"> @csrf
                            <button type="submit" style="border: none;background:transparent;">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" stroke="#837E7E"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.71533 19.4612L0.766574 19.4612L0.766574 0.871826L3.71533 0.871826"
                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linejoin="round" />
                                    <path d="M13.5438 16.0369L19.4413 10.1665L13.5438 4.29622" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linejoin="round" />
                                    <path d="M19.4414 10.1665L4.20612 10.1665" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linejoin="round" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</aside>
