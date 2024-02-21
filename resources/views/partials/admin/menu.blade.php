@php
    use App\Models\Utility;
    //  $logo=asset(Storage::url('uploads/logo/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $company_logo = Utility::getValByName('company_logo_dark');
    $company_logos = Utility::getValByName('company_logo_light');
    $company_small_logo = Utility::getValByName('company_small_logo');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();
    $emailTemplate = \App\Models\EmailTemplate::first();
    $lang = Auth::user()->lang;

    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


{{-- new theam code --}}
<nav class="dash-sidebar light-sidebar ">
    <div id="nav" class="nav-container navbar-wrapper d-flex">
        <div class="nav-content d-flex">
            <!-- Logo Start -->
            <div class="logo position-relative" style ="">
                <a href="#">
                    <!-- Logo can be added directly -->
                    <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

                    <!-- Or added via css to provide different ones for different color themes -->
                    <div class="img">
                        <div class="m-header main-logo">
                            <a href="#" class="b-brand">
                                {{--     <img src="{{ asset(Storage::url('uploads/logo/'.$logo)) }}" alt="{{ env('APP_NAME') }}" class="logo logo-lg" /> --}}
                                @if ($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on')
                                    <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                                        alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
                                @else
                                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                                        alt="{{ config('app.name', 'ERPGo-SaaS') }}" class="logo logo-lg">
                                @endif
                            </a>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Logo End -->

            <!-- User Menu Start -->
            <div class="user-container d-flex">
                <a href="{{ route('profile') }}" class="d-flex user position-relative" aria-haspopup="true"
                    aria-expanded="false">

                    <img class="profile" alt="profile"
                        src="{{ !empty(\Auth::user()->avatar) ? $profile . \Auth::user()->avatar : $profile . 'avatar.png' }}" />
                    {{-- <span class="theme-avtar">
                             <img src="{{ !empty(\Auth::user()->avatar) ? $profile . \Auth::user()->avatar :  $profile.'avatar.png'}}" class="img-fluid rounded-circle">
                        </span> --}}
                    <div class="name">{{ \Auth::user()->name }}</div>
                </a>
            </div>
            <!-- User Menu End -->

            @php
                $users = \Auth::user();
                $profile = \App\Models\Utility::get_file('uploads/avatar/');
                $languages = \App\Models\Utility::languages();
                $settings = Utility::settings();
                $lang = isset($users->lang) ? $users->lang : 'en';
                if ($lang == null) {
                    $lang = 'en';
                }
                $LangName = \App\Models\Language::where('code', $lang)->first();

                $setting = \App\Models\Utility::colorset();
                $mode_setting = \App\Models\Utility::mode_layout();
                // dd($settings);
                $unseenCounter = App\Models\ChMessage::where('to_id', Auth::user()->id)
                    ->where('seen', 0)
                    ->count();
            @endphp
            <script>
                function hideDropdown() {
                    var dropdownContent = document.querySelector('.dropdown-content');
                    setTimeout(function() {
                        dropdownContent.style.display = 'none';
                    }, 1000); // Change the delay time (in milliseconds) as needed
                }
            </script>

            <style>
                /* Style for the dropdown menu */
                .dropdowni {
                    position: relative;
                    display: inline-block;
                }

                .dropdown-contente {
                    display: none;
                    position: absolute;
                    background-color: #f9f9f9;
                    min-width: 160px;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                    z-index: 1;
                    opacity: 0;
                    transition: opacity 10s ease-in-out;
                }

                .dropdowni:hover .dropdown-contente {
                    display: block;
                    opacity: 1;
                }

                /* Style for the list items */
                .dropdown-contente li {
                    padding: 12px;
                    text-decoration: none;
                    display: block;
                }

                .dropdown-contente li:hover {
                    background-color: #f1f1f1;
                }
            </style>

            <!-- Icons Menu Start -->
            <ul class="list-unstyled list-inline text-center menu-icons">
                <li class="list-inline-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                        class="dropdown-item">
                        <i data-acorn-icon="logout" data-acorn-size="18"></i>
                    </a>
                </li>

                <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


                <li class="list-inline-item">
                    <a class="dash-head-link arrow-none me-0" href="{{ url('chats') }}" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-brand-hipchat"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" id="pinButton" class="pin-button">
                        <i data-acorn-icon="lock-on" class="unpin" data-acorn-size="18"></i>
                        <i data-acorn-icon="lock-off" class="pin" data-acorn-size="18"></i>
                    </a>
                </li>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    function handleButtonClick(u) {
                        var combinedData = {
                            cust_darklayout: u,
                            _token: "{{ csrf_token() }}",
                        };

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('save.setting') }}",
                            data: combinedData,
                            success: function(response) {

                                console.log(response);
                                location.reload();
                            },
                            error: function(error) {

                                console.log(error);
                            }
                        });

                    };
                </script>

                <li class="list-inline-item" id="settingsForm1" style="margin-top: 6px;">
                    {{ Form::model($settings, ['route' => 'save.setting', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'settingsForm']) }}
                    <a href="#" id="colorButton" class="hao">
                        <i data-acorn-icon="light-on" class="light hao1 " data-hao = "light" data-acorn-size="18"
                            style="color: white"></i>
                        <i data-acorn-icon="light-off" class="dark hao1" data-hao ="dark" data-acorn-size="18"
                            style="color: white"></i>
                    </a>
                    {{ Form::close() }}

                </li>


                <li class="dropdowni" onmouseleave="hideDropdown()">
                    <a href="#"> <i data-acorn-icon="bell" data-acorn-size="18"></i></a>
                    <div
                        class="dropdown-contente dropdown-menu dropdown-menu-end wide notification-dropdown scroll-out">
                        <div class="scroll">
                            <ul class="list-unstyled border-last-none">
                                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                                    <img src="img/profile/profile-1.webp"
                                        class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                                    <div class="align-self-center">
                                        <a href="#">Joisse Kaycee just sent a new comment!</a>
                                    </div>
                                </li>
                                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                                    <img src="img/profile/profile-2.webp"
                                        class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                                    <div class="align-self-center">
                                        <a href="#">New order received! It is total $147,20.</a>
                                    </div>
                                </li>
                                <li class="mb-3 pb-3 border-bottom border-separator-light d-flex">
                                    <img src="img/profile/profile-3.webp"
                                        class="me-3 sw-4 sh-4 rounded-xl align-self-center" alt="..." />
                                    <div class="align-self-center">
                                        <a href="#">3 items just added to wish list by a user!</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

            </ul>
            <!-- Icons Menu End -->

            <!-- Menu Start -->
            <div class="menu-container navbar-content flex-grow-1" style="display: block;">
                @if (\Auth::user()->type != 'client')

                    <ul id="menu" class="menu">

                        {{-- <li>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <svg width="50px" height="50px" viewBox="-24 -24 72.00 72.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 7.063C16.5 10.258 14.57 13 12 13c-2.572 0-4.5-2.742-4.5-5.938C7.5 3.868 9.16 2 12 2s4.5 1.867 4.5 5.063zM4.102 20.142C4.487 20.6 6.145 22 12 22c5.855 0 7.512-1.4 7.898-1.857a.416.416 0 0 0 .09-.317C19.9 18.944 19.106 15 12 15s-7.9 3.944-7.989 4.826a.416.416 0 0 0 .091.317z" fill="#ffffff"></path></g></svg><span class="label">{{__('Profile')}}</span>
                        </a>
                        </li> --}}
                        <!--------------------- Start Dashboard ----------------------------------->
                        @if (Gate::check('show hrm dashboard') ||
                                Gate::check('show project dashboard') ||
                                Gate::check('show account dashboard') ||
                                Gate::check('show crm dashboard') ||
                                Gate::check('show pos dashboard') ||
                                Gate::check('show clientuser dashboard'))

                            <li class="dash-item dash-hasmenu">
                                <a href="#tent" data-bs-toggle="collapse" data-role="button"
                                    class="dash-link {{ Request::segment(1) == null ||
                                    Request::segment(1) == 'account-dashboard' ||
                                    Request::segment(1) == 'income report' ||
                                    Request::segment(1) == 'report' ||
                                    Request::segment(1) == 'reports-monthly-cashflow' ||
                                    Request::segment(1) == 'reports-quarterly-cashflow' ||
                                    Request::segment(1) == 'reports-payroll' ||
                                    Request::segment(1) == 'reports-leave' ||
                                    Request::segment(1) == 'reports-monthly-attendance' ||
                                    Request::segment(1) == 'reports-lead' ||
                                    Request::segment(1) == 'reports-deal' ||
                                    Request::segment(1) == 'pos-dashboard' ||
                                    Request::segment(1) == 'reports-warehouse' ||
                                    Request::segment(1) == 'reports-daily-purchase' ||
                                    Request::segment(1) == 'reports-monthly-purchase' ||
                                    Request::segment(1) == 'reports-daily-pos' ||
                                    Request::segment(1) == 'reports-monthly-pos' ||
                                    Request::segment(1) == 'hrm-dashboard' ||
                                    Request::segment(1) == 'reports-pos-vs-purchase' ||
                                    Request::segment(1) == 'clientuser-dashboard' ||
                                    Request::segment(1) == 'crm-dashboard' ||
                                    Request::segment(1) == 'workspace-dashboard' ||
                                    Request::segment(1) == 'project-dashboard'
                                        ? 'active'
                                        : '' }}">
                                    <span class="dash-micon">
                                        <svg width="55px" height="50px" viewBox="-64.47 -64.47 201.38 201.38"
                                            xmlns="http://www.w3.org/2000/svg" fill="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g id="Group_21" data-name="Group 21"
                                                    transform="translate(-483.393 -671.278)">
                                                    <line id="Line_13" data-name="Line 13" y2="3.5"
                                                        transform="translate(514.885 678.734)" fill="none"
                                                        stroke="#fff" stroke-miterlimit="10" stroke-width="3">
                                                    </line>
                                                    <line id="Line_14" data-name="Line 14" x1="3.086"
                                                        y2="1.652" transform="translate(532.99 691.425)"
                                                        fill="none" stroke="#fff" stroke-miterlimit="10"
                                                        stroke-width="3"></line>
                                                    <line id="Line_15" data-name="Line 15" x2="3.086"
                                                        y2="1.652" transform="translate(493.694 691.425)"
                                                        fill="none" stroke="#fff" stroke-miterlimit="10"
                                                        stroke-width="3"></line>
                                                    <g id="Group_19" data-name="Group 19" opacity="0.15">
                                                        <circle id="Ellipse_21" data-name="Ellipse 21" cx="29.992"
                                                            cy="29.992" r="29.992"
                                                            transform="translate(484.893 682.234)" fill="none"
                                                            stroke="#ffffffff" stroke-linecap="round"
                                                            stroke-miterlimit="10" stroke-width="3"></circle>
                                                    </g>
                                                    <g id="Group_20" data-name="Group 20">
                                                        <circle id="Ellipse_22" data-name="Ellipse 22" cx="29.992"
                                                            cy="29.992" r="29.992"
                                                            transform="translate(484.893 672.778)" fill="none"
                                                            stroke="#ffffffff" stroke-miterlimit="10"
                                                            stroke-width="3"></circle>
                                                    </g>
                                                    <circle id="Ellipse_23" data-name="Ellipse 23" cx="4.296"
                                                        cy="4.296" r="4.296"
                                                        transform="translate(510.589 708.474)" fill="none"
                                                        stroke="#ffffffff" stroke-linecap="round"
                                                        stroke-miterlimit="10" stroke-width="3" opacity="0.15">
                                                    </circle>
                                                    <line id="Line_16" data-name="Line 16" y1="8.616"
                                                        x2="7.603" transform="translate(517.591 690.882)"
                                                        fill="none" stroke="#fff" stroke-miterlimit="10"
                                                        stroke-width="3"></line>
                                                    <circle id="Ellipse_24" data-name="Ellipse 24" cx="4.296"
                                                        cy="4.296" r="4.296"
                                                        transform="translate(510.589 698.474)" fill="none"
                                                        stroke="#ffffffff" stroke-miterlimit="10" stroke-width="3">
                                                    </circle>
                                                </g>
                                            </g>
                                        </svg> </span>
                                    <span class="dash-mtext">{{ __('Dashboard') }}</span>
                                </a>
                                <ul id="tent" class="dash-submenu">
                                    @if (\Auth::user()->show_account() == 1 && Gate::check('show account dashboard'))
                                        <li class="dash-item dash-hasmenu ">
                                            <a class="dash-link {{ Request::segment(1) == null || Request::segment(1) == 'account-dashboard' || Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? ' active' : '' }}"
                                                href="#tree">{{ __('Accounting ') }}<span class="dash-arrow"></a>
                                            <ul id ="tree" class="dash-submenu ">
                                                @can('show account dashboard')
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::segment(1) == null || Request::segment(1) == 'account-dashboard' ? ' active' : '' }}"
                                                            href="{{ route('dashboard') }}">{{ __(' Overview') }}</a>
                                                    </li>
                                                @endcan
                                                @if (Gate::check('income report') ||
                                                        Gate::check('expense report') ||
                                                        Gate::check('income vs expense report') ||
                                                        Gate::check('tax report') ||
                                                        Gate::check('loss & profit report') ||
                                                        Gate::check('invoice report') ||
                                                        Gate::check('bill report') ||
                                                        Gate::check('stock report') ||
                                                        Gate::check('invoice report') ||
                                                        Gate::check('manage transaction') ||
                                                        Gate::check('statement report'))
                                                    <li class="dash-item dash-hasmenu ">
                                                        <a class="dash-link {{ Request::segment(1) == 'report' || Request::segment(1) == 'reports-monthly-cashflow' || Request::segment(1) == 'reports-quarterly-cashflow' ? 'active ' : '' }}"
                                                            href="#crs">{{ __('Reports') }}</a>
                                                        <ul id = "crs" class="dash-submenu">
                                                            @can('statement report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.account.statement' ? ' active' : '' }}"
                                                                        href="{{ route('report.account.statement') }}">{{ __('Account Statement') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('invoice report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.invoice.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.invoice.summary') }}">{{ __('Invoice Summary') }}</a>
                                                                </li>
                                                            @endcan
                                                            <li class="dash-item ">
                                                                <a class="dash-link {{ Request::route()->getName() == 'report.sales' ? ' active' : '' }}"
                                                                    href="{{ route('report.sales') }}">{{ __('Sales Report') }}</a>
                                                            </li>
                                                            <li class="dash-item ">
                                                                <a class="dash-link {{ Request::route()->getName() == 'report.receivables' ? ' active' : '' }}"
                                                                    href="{{ route('report.receivables') }}">{{ __('Receivables') }}</a>
                                                            </li>
                                                            @can('bill report')
                                                                <li class="dash-item">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.bill.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.bill.summary') }}">{{ __('Bill Summary') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('stock report')
                                                                <li class="dash-item ">
                                                                    <a href="{{ route('report.product.stock.report') }}"
                                                                        class="dash-link {{ Request::route()->getName() == 'report.product.stock.report' ? ' active' : '' }}">{{ __('Product Stock') }}</a>
                                                                </li>
                                                            @endcan

                                                            @can('loss & profit report')
                                                                <li class="dash-item">
                                                                    <a class="dash-link  {{ request()->is('reports-monthly-cashflow') || request()->is('reports-quarterly-cashflow') ? 'active' : '' }}"
                                                                        href="{{ route('report.monthly.cashflow') }}">{{ __('Cash Flow') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('manage transaction')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit' ? ' active' : '' }}"
                                                                        href="{{ route('transaction.index') }}">{{ __('Transaction') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('income report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.income.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.income.summary') }}">{{ __('Income Summary') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('expense report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.expense.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.expense.summary') }}">{{ __('Expense Summary') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('income vs expense report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.income.vs.expense.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.income.vs.expense.summary') }}">{{ __('Income VS Expense') }}</a>
                                                                </li>
                                                            @endcan
                                                            @can('tax report')
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'report.tax.summary' ? ' active' : '' }}"
                                                                        href="{{ route('report.tax.summary') }}">{{ __('Tax Summary') }}</a>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif

                                    @if (\Auth::user()->show_hrm() == 1)
                                        @can('show hrm dashboard')
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'hrm-dashboard' || Request::segment(1) == 'reports-payroll' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-monthly-attendance' ? ' active dash-trigger' : '' }}"
                                                    href="#game">{{ __('HRM') }}</a>
                                                <ul id="game" class="dash-submenu">
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ \Request::route()->getName() == 'hrm.dashboard' ? ' active' : '' }}"
                                                            href="{{ route('hrm.dashboard') }}">{{ __('Overview') }}</a>
                                                    </li>
                                                    @can('manage report')
                                                        <li class="dash-item dash-hasmenu " href="#hr-report"
                                                            data-toggle="collapse" role="button"
                                                            aria-expanded="{{ Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll' ? 'true' : 'false' }}">
                                                            <a class="dash-link {{ Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll' ? 'active dash-trigger' : '' }}"
                                                                href="#kant">{{ __('Reports') }}</a>
                                                            <ul id="kant" class="dash-submenu">
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ request()->is('reports-payroll') ? 'active' : '' }}"
                                                                        href="{{ route('report.payroll') }}">{{ __('Payroll') }}</a>
                                                                </li>
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ request()->is('reports-leave') ? 'active' : '' }}"
                                                                        href="{{ route('report.leave') }}">{{ __('Leave') }}</a>
                                                                </li>
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ request()->is('reports-monthly-attendance') ? 'active' : '' }}"
                                                                        href="{{ route('report.monthly.attendance') }}">{{ __('Monthly Attendance') }}</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endcan
                                    @endif


                                    @if (\Auth::user()->show_crm() == 1)
                                        @can('show crm dashboard')
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'crm-dashboard' || Request::segment(1) == 'reports-lead' || Request::segment(1) == 'reports-deal' ? ' active dash-trigger' : '' }}"
                                                    href="#trm">{{ __('CRM') }}</a>
                                                <ul id="trm" class="dash-submenu">
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ \Request::route()->getName() == 'crm.dashboard' ? ' active' : '' }}"
                                                            href="{{ route('crm.dashboard') }}">{{ __(' Overview') }}</a>
                                                    </li>
                                                    <li class="dash-item dash-hasmenu ">
                                                        <a class="dash-link {{ Request::segment(1) == 'reports-lead' || Request::segment(1) == 'reports-deal' ? 'active dash-trigger' : '' }}"
                                                            href="#repo" data-toggle="collapse" role="button"
                                                            aria-expanded="{{ Request::segment(1) == 'reports-lead' || Request::segment(1) == 'reports-deal' ? 'true' : 'false' }}">
                                                            {{ __('Reports') }}
                                                        </a>
                                                        <ul id="repo" class="dash-submenu">
                                                            <li class="dash-item ">
                                                                <a class="dash-link {{ request()->is('reports-lead') ? 'active' : '' }}"
                                                                    href="{{ route('report.lead') }}">{{ __('Lead') }}</a>
                                                            </li>
                                                            <li class="dash-item ">
                                                                <a class="dash-link {{ request()->is('reports-deal') ? 'active' : '' }}"
                                                                    href="{{ route('report.deal') }}">{{ __('Deal') }}</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endcan
                                    @endif

                                    @if (\Auth::user()->type != 'clientuser')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::route()->getName() == 'workspace.dashboard' ? ' active' : '' }}"
                                                href="{{ route('workspace.dashboard') }}">{{ __('Workspace') }}</a>
                                        </li>
                                    @endif

                                    @if (\Auth::user()->show_project() == 1)
                                        @can('show project dashboard')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ Request::route()->getName() == 'project.dashboard' ? ' active' : '' }}"
                                                    href="{{ route('project.dashboard') }}">{{ __('Project ') }}</a>
                                            </li>
                                        @endcan
                                    @endif

                                    @can('show clientuser dashboard')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::route()->getName() == 'clientuser.dashboard' ? ' active' : '' }}"
                                                href="{{ route('clientuser.dashboard') }}">{{ __('Dashboard ') }}</a>
                                        </li>
                                    @endcan

                                    {{-- @if (\Auth::user()->show_pos() == 1)
                                    @can('show pos dashboard')
                                        <li class="dash-item dash-hasmenu {{ ( Request::segment(1) == 'pos-dashboard'  || Request::segment(1) == 'reports-warehouse' || Request::segment(1) == 'reports-daily-purchase' || Request::segment(1) == 'reports-monthly-purchase' || Request::segment(1) == 'reports-daily-pos' || Request::segment(1) == 'reports-monthly-pos' ||Request::segment(1) == 'reports-pos-vs-purchase') ? ' active dash-trigger' : ''}}">
                                            <a class="dash-link" href="#yos">{{__('POS')}}</a>
                                            <ul id="yos" class="dash-submenu">
                                                <li class="dash-item {{ (\Request::route()->getName()=='pos.dashboard') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('pos.dashboard')}}">{{__(' Overview')}}</a>
                                                </li>
                                                <li class="dash-item dash-hasmenu {{ ( Request::segment(1) == 'reports-warehouse' || Request::segment(1) == 'reports-daily-purchase' || Request::segment(1) == 'reports-monthly-purchase' || Request::segment(1) == 'reports-daily-pos' || Request::segment(1) == 'reports-monthly-pos' ||Request::segment(1) == 'reports-pos-vs-purchase') ? 'active dash-trigger' : ''}}"
                                                    href="#crm-report" data-toggle="collapse" role="button"
                                                    aria-expanded="{{( Request::segment(1) == 'reports-warehouse' || Request::segment(1) == 'reports-daily-purchase' || Request::segment(1) == 'reports-monthly-purchase' || Request::segment(1) == 'reports-daily-pos' || Request::segment(1) == 'reports-monthly-pos' ||Request::segment(1) == 'reports-pos-vs-purchase') ? 'true' : 'false'}}">
                                                    <a class="dash-link" href="#report">{{__('Reports')}}</a>
                                                    <ul id="report" class="dash-submenu">
                                                        <li class="dash-item {{ request()->is('reports-warehouse') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.warehouse') }}">{{__('Warehouse Report')}}</a>
                                                        </li>
                                                        <li class="dash-item {{ request()->is('reports-daily-purchase') || request()->is('reports-monthly-purchase') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.daily.purchase') }}">{{__('Purchase Daily/Monthly Report')}}</a>
                                                        </li>
                                                        <li class="dash-item {{ request()->is('reports-daily-pos') || request()->is('reports-monthly-pos') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.daily.pos') }}">{{__('POS Daily/Monthly Report')}}</a>
                                                        </li>
                                                        <li class="dash-item {{ request()->is('reports-pos-vs-purchase') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.pos.vs.purchase') }}">{{__('Pos VS Purchase Report')}}</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    @endcan
                                @endif --}}

                                </ul>
                            </li>
                        @endif

                        <!--------------------- End Dashboard ----------------------------------->


                        <!--------------------- Start HRM ----------------------------------->

                        @if (\Auth::user()->show_hrm() == 1)
                            @if (Gate::check('manage employee') || Gate::check('manage setsalary'))
                                <li class="dash-item dash-hasmenu">
                                    <a href="#rm"
                                        class="dash-link  {{ Request::segment(1) == 'holiday-calender' ||
                                        Request::segment(1) == 'leavetype' ||
                                        Request::segment(1) == 'leave' ||
                                        Request::segment(1) == 'attendanceemployee' ||
                                        Request::segment(1) == 'document-upload' ||
                                        Request::segment(1) == 'document' ||
                                        Request::segment(1) == 'performanceType' ||
                                        Request::segment(1) == 'branch' ||
                                        Request::segment(1) == 'department' ||
                                        Request::segment(1) == 'designation' ||
                                        Request::segment(1) == 'employee' ||
                                        Request::segment(1) == 'leave_requests' ||
                                        Request::segment(1) == 'holidays' ||
                                        Request::segment(1) == 'policies' ||
                                        Request::segment(1) == 'leave_calender' ||
                                        Request::segment(1) == 'award' ||
                                        Request::segment(1) == 'transfer' ||
                                        Request::segment(1) == 'resignation' ||
                                        Request::segment(1) == 'training' ||
                                        Request::segment(1) == 'travel' ||
                                        Request::segment(1) == 'promotion' ||
                                        Request::segment(1) == 'complaint' ||
                                        Request::segment(1) == 'warning' ||
                                        Request::segment(1) == 'termination' ||
                                        Request::segment(1) == 'announcement' ||
                                        Request::segment(1) == 'job' ||
                                        Request::segment(1) == 'job-application' ||
                                        Request::segment(1) == 'candidates-job-applications' ||
                                        Request::segment(1) == 'job-onboard' ||
                                        Request::segment(1) == 'custom-question' ||
                                        Request::segment(1) == 'interview-schedule' ||
                                        Request::segment(1) == 'career' ||
                                        Request::segment(1) == 'holiday' ||
                                        Request::segment(1) == 'setsalary' ||
                                        Request::segment(1) == 'payslip' ||
                                        Request::segment(1) == 'paysliptype' ||
                                        Request::segment(1) == 'company-policy' ||
                                        Request::segment(1) == 'job-stage' ||
                                        Request::segment(1) == 'job-category' ||
                                        Request::segment(1) == 'terminationtype' ||
                                        Request::segment(1) == 'awardtype' ||
                                        Request::segment(1) == 'trainingtype' ||
                                        Request::segment(1) == 'goaltype' ||
                                        Request::segment(1) == 'paysliptype' ||
                                        Request::segment(1) == 'allowanceoption' ||
                                        Request::segment(1) == 'competencies' ||
                                        Request::segment(1) == 'loanoption' ||
                                        Request::segment(1) == 'trainer' ||
                                        Request::segment(1) == 'event' ||
                                        Request::segment(1) == 'meeting' ||
                                        Request::segment(1) == 'deductionoption' ||
                                        Request::segment(1) == 'indicator' ||
                                        Request::segment(1) == 'appraisal' ||
                                        Request::segment(1) == 'goaltracking'
                                            ? 'active dash-trigger'
                                            : '' }}">
                                        <span class="dash-micon">
                                            <svg fill="#ffffff" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="50px"
                                                height="50px" viewBox="-123.46 -123.46 384.10 384.10"
                                                xml:space="preserve" stroke="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M100.088,74.921c0.322-16.108-0.604-33.033-2.795-44.404c-2.059-2.195-4.434-4.165-7.088-5.782 c2.813,13.159,3.738,39.516,2.765,61.354C94.607,82.995,97.414,79.391,100.088,74.921z">
                                                            </path>
                                                            <path
                                                                d="M101.33,35.646c1.498,9.149,2.247,20.715,2.277,32.336c1.905-4.6,3.27-9.962,3.245-16.398 C106.834,46.979,104.904,41.078,101.33,35.646z">
                                                            </path>
                                                            <path
                                                                d="M105.379,117.07c0.183-0.28,0.359-0.56,0.536-0.876c-0.499-0.439-1.145-1.035-1.912-1.778 c-0.536,1.035-1.108,1.899-1.717,2.654H105.379L105.379,117.07z">
                                                            </path>
                                                            <path
                                                                d="M79.227,20.752c2.295,17.902,2.271,79.245-0.067,96.331h6.406c4.329-16.069,4.523-74.65,0.56-94.392 C83.97,21.788,81.668,21.111,79.227,20.752z">
                                                            </path>
                                                            <path
                                                                d="M99.667,109.685c-0.828,3.087-1.771,5.607-2.861,7.386h3.684c0.792-1.047,1.528-2.374,2.211-3.97 C101.75,112.114,100.715,110.97,99.667,109.685z">
                                                            </path>
                                                            <path
                                                                d="M97.329,106.622c-2.106-3.002-3.982-6.479-4.993-10.176c-0.73,8.945-1.826,16.387-3.324,20.637h5.176 C95.43,114.671,96.489,111.091,97.329,106.622z">
                                                            </path>
                                                            <path
                                                                d="M58.069,117.07h6.396c-2.35-17.22-2.356-79.463,0-96.763c-2.368,0.22-4.6,0.612-6.695,1.16 c-3.374,14.678-3.992,56.291-1.86,80.91c1.194-0.214,2.253-0.396,2.868-0.512c2.171,5.108,0.576,8.945-1.513,11.49 C57.515,114.769,57.783,116.011,58.069,117.07z">
                                                            </path>
                                                            <path
                                                                d="M54.315,116.097c-0.91,0.657-1.565,0.986-1.565,0.986h1.857C54.51,116.778,54.422,116.419,54.315,116.097z">
                                                            </path>
                                                            <path
                                                                d="M47.228,26.537c-4.46,17.598-4.938,55.29-1.428,77.174c0.466,0.013,0.904,0.122,1.382,0.049 c1.51-0.194,3.148-0.45,4.752-0.719c-2.725-23.784-2.083-64.643,1.939-80.294C51.405,23.745,49.146,24.966,47.228,26.537z">
                                                            </path>
                                                            <path
                                                                d="M30.315,75.609c0.021,0.651,0.04,1.315,0.07,1.967c0.618,0.64,1.647,1.163,2.707,1.571 c-0.143-3.117-0.231-6.284-0.244-9.475c-1.078,1.936-2.003,3.738-2.527,5.108C30.315,75.062,30.315,75.335,30.315,75.609z">
                                                            </path>
                                                            <path
                                                                d="M68.415,20.104c-1.1,17.142-1.105,79.528-0.006,96.967h6.828c1.084-17.354,1.084-79.247,0-96.729 C72.875,20.146,70.586,20.064,68.415,20.104z">
                                                            </path>
                                                            <path
                                                                d="M41.702,33.26c-5.812,10.948-6.253,20.557-5.812,22.347c0.451,1.791,2.351,5.14,2.351,5.14s-1.453,2.244-3.148,5.054 c-0.055,4.713,0.024,9.463,0.25,14.078c0.703,0.189,1.215,0.293,1.215,0.293s0.551,1.559-0.573,4.572 c-1.117,3.021,2.083,6.521,3.036,7.746c0.956,1.211-1.333,5.023-0.561,7.143c0.469,1.278,2.04,2.617,4.071,3.445 c-3.547-20.148-3.346-53.331,0.612-71.977C42.661,31.807,42.119,32.474,41.702,33.26z">
                                                            </path>
                                                            <path
                                                                d="M68.589,130.941c-34.383,0-62.354-27.974-62.354-62.353c0-34.383,27.971-62.353,62.354-62.353 c0.998,0,1.984,0.024,2.971,0.067l0.293-6.226C70.769,0.025,69.679,0,68.589,0C30.771,0,0,30.772,0,68.589 c0,37.813,30.771,68.588,68.589,68.588c1.09,0,2.18-0.024,3.264-0.072l-0.293-6.229C70.573,130.917,69.587,130.941,68.589,130.941 z">
                                                            </path>
                                                            <path
                                                                d="M77.667,130.284l0.896,6.168c2.241-0.322,4.445-0.761,6.619-1.297l-1.511-6.053 C81.704,129.596,79.701,129.991,77.667,130.284z">
                                                            </path>
                                                            <path
                                                                d="M85.278,2.053c-2.161-0.542-4.365-0.98-6.606-1.31l-0.913,6.166c2.033,0.301,4.037,0.691,6.004,1.184L85.278,2.053z">
                                                            </path>
                                                            <path
                                                                d="M119.433,22.555c-1.51-1.665-3.1-3.258-4.762-4.765l-4.189,4.612c1.511,1.373,2.96,2.819,4.33,4.336L119.433,22.555z">
                                                            </path>
                                                            <path
                                                                d="M97.944,6.586c-2.021-0.956-4.098-1.814-6.217-2.582L89.62,9.871c1.925,0.691,3.812,1.477,5.651,2.344L97.944,6.586z">
                                                            </path>
                                                            <path
                                                                d="M130.284,59.479l6.162-0.91c-0.329-2.238-0.768-4.439-1.297-6.604l-6.053,1.498 C129.583,55.439,129.979,57.439,130.284,59.479z">
                                                            </path>
                                                            <path
                                                                d="M127.324,47.621l5.87-2.104c-0.768-2.119-1.62-4.201-2.576-6.223l-5.638,2.67 C125.851,43.797,126.643,45.688,127.324,47.621z">
                                                            </path>
                                                            <path
                                                                d="M122.1,36.566l5.347-3.212c-1.163-1.933-2.411-3.796-3.751-5.599l-5.005,3.721C119.908,33.11,121.047,34.812,122.1,36.566 z">
                                                            </path>
                                                            <path
                                                                d="M137.092,65.271l-6.224,0.307c0.049,1.001,0.073,2,0.073,3.011c0,1.041-0.024,2.082-0.073,3.117l6.224,0.299 c0.061-1.133,0.085-2.271,0.085-3.416C137.177,67.48,137.152,66.375,137.092,65.271z">
                                                            </path>
                                                            <path
                                                                d="M89.522,127.337l2.095,5.87c2.126-0.761,4.202-1.62,6.224-2.576l-2.655-5.638 C93.347,125.876,91.453,126.655,89.522,127.337z">
                                                            </path>
                                                            <path
                                                                d="M129.078,83.8l6.047,1.51c0.542-2.162,0.986-4.372,1.309-6.606l-6.162-0.907C129.967,79.829,129.565,81.833,129.078,83.8z ">
                                                            </path>
                                                            <path
                                                                d="M124.943,95.302l5.633,2.68c0.962-2.016,1.814-4.099,2.582-6.224l-5.864-2.106 C126.605,91.581,125.814,93.469,124.943,95.302z">
                                                            </path>
                                                            <path
                                                                d="M100.666,15.107c1.754,1.054,3.452,2.195,5.085,3.41l3.72-5.005c-1.802-1.334-3.665-2.588-5.59-3.748L100.666,15.107z">
                                                            </path>
                                                            <path
                                                                d="M100.581,122.118l3.215,5.341c1.924-1.157,3.794-2.399,5.59-3.739l-3.708-5.012 C104.039,119.933,102.341,121.071,100.581,122.118z">
                                                            </path>
                                                            <path
                                                                d="M110.415,114.836l4.189,4.622c1.662-1.511,3.258-3.1,4.768-4.762l-4.615-4.189 C113.38,112.017,111.931,113.466,110.415,114.836z">
                                                            </path>
                                                            <path
                                                                d="M118.642,105.775l4.999,3.732c1.34-1.802,2.594-3.665,3.757-5.596l-5.347-3.209 C120.991,102.456,119.859,104.144,118.642,105.775z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="label">
                                            {{ __('HRM System') }}
                                        </span>

                                    </a>
                                    <ul id="rm" class="dash-submenu">
                                        <li class="dash-item  ">
                                            @if (\Auth::user()->type == 'Employee')
                                                @php
                                                    $employee = App\Models\Employee::where('user_id', \Auth::user()->id)->first();
                                                @endphp
                                                <a class="dash-link {{ Request::segment(1) == 'employee' ? 'active dash-trigger' : '' }}   "
                                                    href="{{ route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id)) }}">{{ __('Employee') }}</a>
                                            @else
                                                <a href="{{ route('employee.index') }}"
                                                    class="dash-link {{ Request::segment(1) == 'employee' ? 'active dash-trigger' : '' }} ">
                                                    {{ __('Employee Setup') }}
                                                </a>
                                            @endif
                                        </li>

                                        @if (Gate::check('manage set salary') || Gate::check('manage pay slip'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link  {{ Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip' ? 'active dash-trigger' : '' }}"
                                                    href="#payroll">{{ __('Payroll Setup') }}</a>
                                                <ul id="payroll" class="dash-submenu">
                                                    @can('manage set salary')
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ request()->is('setsalary*') ? 'active' : '' }}"
                                                                href="{{ route('setsalary.index') }}">{{ __('Set salary') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage pay slip')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('payslip*') ? 'active' : '' }}"
                                                                href="{{ route('payslip.index') }}">{{ __('Payslip') }}</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage leave') || Gate::check('manage attendance'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee' ? 'active dash-trigger' : '' }}"
                                                    href="#leave">{{ __('Leave Management Setup') }}<span
                                                        class="dash-arrow"></span></a>
                                                <ul id="leave" class="dash-submenu">
                                                    @can('manage leave')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ Request::route()->getName() == 'leave.index' ? 'active' : '' }}"
                                                                href="{{ route('leave.index') }}">{{ __('Manage Leave') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage attendance')
                                                        <li class="dash-item dash-hasmenu " href="#navbar-attendance"
                                                            data-toggle="collapse" role="button"
                                                            aria-expanded="{{ Request::segment(1) == 'attendanceemployee' ? 'true' : 'false' }}">
                                                            <a class="dash-link {{ Request::segment(1) == 'attendanceemployee' ? 'active dash-trigger' : '' }}"
                                                                href="#tender">{{ __('Attendance') }}</a>
                                                            <ul id="tender" class="dash-submenu">
                                                                <li class="dash-item ">
                                                                    <a class="dash-link {{ Request::route()->getName() == 'attendanceemployee.index' ? 'active' : '' }}"
                                                                        href="{{ route('attendanceemployee.index') }}">{{ __('Mark Attendance') }}</a>
                                                                </li>
                                                                @can('create attendance')
                                                                    <li class="dash-item ">
                                                                        <a class="dash-link {{ Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'active' : '' }}"
                                                                            href="{{ route('attendanceemployee.bulkattendance') }}">{{ __('Bulk Attendance') }}</a>
                                                                    </li>
                                                                @endcan
                                                            </ul>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage indicator') || Gate::check('manage appraisal') || Gate::check('manage goal tracking'))
                                            <li class="dash-item dash-hasmenu " href="#navbar-performance"
                                                data-toggle="collapse" role="button"
                                                aria-expanded="{{ Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking' ? 'true' : 'false' }}">
                                                <a class="dash-link {{ Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking' ? 'active dash-trigger' : '' }}"
                                                    href="#performance">{{ __('Performance Setup') }}</a>
                                                <ul id="performance"
                                                    class="dash-submenu {{ Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking' ? 'show' : 'collapse' }}">
                                                    @can('manage indicator')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('indicator*') ? 'active' : '' }}"
                                                                href="{{ route('indicator.index') }}">{{ __('Indicator') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage appraisal')
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ request()->is('appraisal*') ? 'active' : '' }}"
                                                                href="{{ route('appraisal.index') }}">{{ __('Appraisal') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage goal tracking')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('goaltracking*') ? 'active' : '' }}"
                                                                href="{{ route('goaltracking.index') }}">{{ __('Goal Tracking') }}</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage training') || Gate::check('manage trainer') || Gate::check('show training'))
                                            <li class="dash-item dash-hasmenu " href="#navbar-training"
                                                data-toggle="collapse" role="button"
                                                aria-expanded="{{ Request::segment(1) == 'trainer' || Request::segment(1) == 'training' ? 'true' : 'false' }}">
                                                <a class="dash-link {{ Request::segment(1) == 'trainer' || Request::segment(1) == 'training' ? 'active dash-trigger' : '' }}"
                                                    href="#training">{{ __('Training Setup') }}</a>
                                                <ul id="training" class="dash-submenu">
                                                    @can('manage training')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('training*') ? 'active' : '' }}"
                                                                href="{{ route('training.index') }}">{{ __('Training List') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage trainer')
                                                        <li class="dash-item">
                                                            <a class="dash-link {{ request()->is('trainer*') ? 'active' : '' }}"
                                                                href="{{ route('trainer.index') }}">{{ __('Trainer') }}</a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </li>
                                        @endif

                                        {{-- <!-- @if (Gate::check('manage job') || Gate::check('create job') || Gate::check('manage job application') || Gate::check('manage custom question') || Gate::check('show interview schedule') || Gate::check('show career'))
                                        <li
                                            class="dash-item dash-hasmenu ">
                                            <a class="dash-link {{ Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career' ? 'active dash-trigger' : '' }}" href="#setup">{{ __('Recruitment Setup') }}</a>
                                            <ul id="setup" class="dash-submenu">
                                                @can('manage job')
                                                    <li
                                                        class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'job.index' || Request::route()->getName() == 'job.create' || Request::route()->getName() == 'job.edit' || Request::route()->getName() == 'job.show' ? 'active' : '' }}"
                                                            href="{{ route('job.index') }}">{{ __('Jobs') }}</a>
                                                    </li>
                                                @endcan
                                                @can('create job')
                                                    <li
                                                        class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'job.create' ? 'active' : '' }} "
                                                            href="{{ route('job.create') }}">{{ __('Job Create') }}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li
                                                        class="dash-item">
                                                        <a class="dash-link  {{ request()->is('job-application*') ? 'active' : '' }}"
                                                            href="{{ route('job-application.index') }}">{{ __('Job Application') }}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li
                                                        class="dash-item">
                                                        <a class="dash-link {{ request()->is('candidates-job-applications') ? 'active' : '' }}"
                                                            href="{{ route('job.application.candidate') }}">{{ __('Job Candidate') }}</a>
                                                    </li>
                                                @endcan
                                                @can('manage job application')
                                                    <li
                                                        class="dash-item">
                                                        <a class="dash-link  {{ request()->is('job-onboard*') ? 'active' : '' }}"
                                                            href="{{ route('job.on.board') }}">{{ __('Job On-boarding') }}</a>
                                                    </li>
                                                @endcan
                                                @can('manage custom question')
                                                    <li
                                                        class="dash-item ">
                                                        <a class="dash-link {{ request()->is('custom-question*') ? 'active' : '' }}"
                                                            href="{{ route('custom-question.index') }}">{{ __('Custom Question') }}</a>
                                                    </li>
                                                @endcan
                                                @can('show interview schedule')
                                                    <li
                                                        class="dash-item">
                                                        <a class="dash-link {{ request()->is('interview-schedule*') ? 'active' : '' }}"
                                                            href="{{ route('interview-schedule.index') }}">{{ __('Interview Schedule') }}</a>
                                                    </li>
                                                @endcan
                                                @can('show career')
                                                    <li
                                                        class="dash-item ">
                                                        <a class="dash-link {{ request()->is('career*') ? 'active' : '' }}"
                                                            href="{{ route('career', [\Auth::user()->creatorId(), $lang]) }}">{{ __('Career') }}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif  --> --}}

                                        @if (Gate::check('manage award') ||
                                                Gate::check('manage transfer') ||
                                                Gate::check('manage resignation') ||
                                                Gate::check('manage travel') ||
                                                Gate::check('manage promotion') ||
                                                Gate::check('manage complaint') ||
                                                Gate::check('manage warning') ||
                                                Gate::check('manage termination') ||
                                                Gate::check('manage announcement') ||
                                                Gate::check('manage holiday'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'holiday-calender' || Request::segment(1) == 'holiday' || Request::segment(1) == 'policies' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' || Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'announcement' || Request::segment(1) == 'competencies' ? 'active dash-trigger' : '' }}"
                                                    href="#hr">{{ __('HR Admin Setup') }}</a>
                                                <ul id="hr" class="dash-submenu">
                                                    @can('manage award')
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ request()->is('award*') ? 'active' : '' }}"
                                                                href="{{ route('award.index') }}">{{ __('Award') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage transfer')
                                                        <li class="dash-item ">
                                                            <a class="dash-link  {{ request()->is('transfer*') ? 'active' : '' }}"
                                                                href="{{ route('transfer.index') }}">{{ __('Transfer') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage resignation')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('resignation*') ? 'active' : '' }}"
                                                                href="{{ route('resignation.index') }}">{{ __('Resignation') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage travel')
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ request()->is('travel*') ? 'active' : '' }}"
                                                                href="{{ route('travel.index') }}">{{ __('Trip') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage promotion')
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ request()->is('promotion*') ? 'active' : '' }}"
                                                                href="{{ route('promotion.index') }}">{{ __('Promotion') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage complaint')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('complaint*') ? 'active' : '' }}"
                                                                href="{{ route('complaint.index') }}">{{ __('Complaints') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage warning')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('warning*') ? 'active' : '' }}"
                                                                href="{{ route('warning.index') }}">{{ __('Warning') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage termination')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('termination*') ? 'active' : '' }}"
                                                                href="{{ route('termination.index') }}">{{ __('Termination') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage announcement')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('announcement*') ? 'active' : '' }}"
                                                                href="{{ route('announcement.index') }}">{{ __('Announcement') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage holiday')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ request()->is('holiday*') || request()->is('holiday-calender') ? 'active' : '' }}"
                                                                href="{{ route('holiday.index') }}">{{ __('Holidays') }}</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif

                                        @can('manage event')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('event*') ? 'active' : '' }}"
                                                    href="{{ route('event.index') }}">{{ __('Event Setup') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage meeting')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('meeting*') ? 'active' : '' }}"
                                                    href="{{ route('meeting.index') }}">{{ __('Meeting') }}</a>
                                            </li>
                                        @endcan
                                        {{-- @can('manage assets')
                                        <li class="dash-item {{ request()->is('account-assets*') ? 'active' : '' }}">
                                            <a class="dash-link"
                                                href="{{ route('account-assets.index') }}">{{ __('Employees Asset Setup ') }}</a>
                                        </li>
                                    @endcan --}}
                                        @can('manage document')
                                            <li class="dash-item">
                                                <a class="dash-link  {{ request()->is('document-upload*') ? 'active' : '' }}"
                                                    href="{{ route('document-upload.index') }}">{{ __('Document Setup') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage company policy')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('company-policy*') ? 'active' : '' }}"
                                                    href="{{ route('company-policy.index') }}">{{ __('Company policy') }}</a>
                                            </li>
                                        @endcan

                                        @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'branch' || \Auth::user()->type == 'HR')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ Request::segment(1) == 'leavetype' ||
                                                Request::segment(1) == 'document' ||
                                                Request::segment(1) == 'performanceType' ||
                                                Request::segment(1) == 'branch' ||
                                                Request::segment(1) == 'department' ||
                                                Request::segment(1) == 'designation' ||
                                                Request::segment(1) == 'job-stage' ||
                                                Request::segment(1) == 'performanceType' ||
                                                Request::segment(1) == 'job-category' ||
                                                Request::segment(1) == 'terminationtype' ||
                                                Request::segment(1) == 'awardtype' ||
                                                Request::segment(1) == 'trainingtype' ||
                                                Request::segment(1) == 'goaltype' ||
                                                Request::segment(1) == 'paysliptype' ||
                                                Request::segment(1) == 'allowanceoption' ||
                                                Request::segment(1) == 'loanoption' ||
                                                Request::segment(1) == 'deductionoption'
                                                    ? 'active dash-trigger'
                                                    : '' }}"
                                                    href="{{ route('branch.index') }}">{{ __('HRM System Setup') }}</a>
                                            </li>
                                        @endcan


                                    </ul>
                                </li>
                            @endif
                        @endif

                        <!--------------------- End HRM ----------------------------------->

                        <!--------------------- Start Account ----------------------------------->

                        @if (\Auth::user()->show_account() == 1)
                            @if (Gate::check('manage customer') ||
                                    Gate::check('manage vender') ||
                                    Gate::check('manage customer') ||
                                    Gate::check('manage vender') ||
                                    Gate::check('manage proposal') ||
                                    Gate::check('manage bank account') ||
                                    Gate::check('manage bank transfer') ||
                                    Gate::check('manage invoice') ||
                                    Gate::check('manage revenue') ||
                                    Gate::check('manage credit note') ||
                                    Gate::check('manage bill') ||
                                    Gate::check('manage payment') ||
                                    Gate::check('manage debit note') ||
                                    Gate::check('manage chart of account') ||
                                    Gate::check('manage journal entry') ||
                                    Gate::check('balance sheet report') ||
                                    Gate::check('ledger report') ||
                                    Gate::check('trial balance report'))
                                <li class="dash-item dash-hasmenu">
                                    <a href="#accounting"
                                        class="dash-link {{ Request::segment(1) == 'print-setting' ||
                                        Request::segment(1) == 'customer' ||
                                        Request::segment(1) == 'vender' ||
                                        Request::segment(1) == 'proposal' ||
                                        Request::segment(1) == 'bank-account' ||
                                        Request::segment(1) == 'bank-transfer' ||
                                        Request::segment(1) == 'invoice' ||
                                        Request::segment(1) == 'revenue' ||
                                        Request::segment(1) == 'credit-note' ||
                                        Request::segment(1) == 'taxes' ||
                                        Request::segment(1) == 'product-category' ||
                                        Request::segment(1) == 'product-unit' ||
                                        Request::segment(1) == 'payment-method' ||
                                        Request::segment(1) == 'custom-field' ||
                                        Request::segment(1) == 'chart-of-account-type' ||
                                        (Request::segment(1) == 'transaction' &&
                                            Request::segment(2) != 'ledger' &&
                                            Request::segment(2) != 'balance-sheet' &&
                                            Request::segment(2) != 'trial-balance') ||
                                        Request::segment(1) == 'goal' ||
                                        Request::segment(1) == 'budget' ||
                                        Request::segment(1) == 'chart-of-account' ||
                                        Request::segment(1) == 'journal-entry' ||
                                        Request::segment(2) == 'ledger' ||
                                        Request::segment(2) == 'balance-sheet' ||
                                        Request::segment(2) == 'trial-balance' ||
                                        Request::segment(2) == 'profit-loss' ||
                                        Request::segment(1) == 'bill' ||
                                        Request::segment(1) == 'expense' ||
                                        Request::segment(1) == 'payment' ||
                                        Request::segment(1) == 'debit-note'
                                            ? ' active dash-trigger'
                                            : '' }}"><span
                                            class="dash-micon">
                                            <svg height="64px" width="64px" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="-39.08 -39.08 121.58 121.58" xml:space="preserve"
                                                fill="#ffffff" stroke="#ffffff"
                                                stroke-width="0.00043417000000000005">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g>
                                                        <path style="fill:#ffffff;"
                                                            d="M12.408,10.884H0.625C0.28,10.884,0,11.164,0,11.509v27.918c0,0.345,0.28,0.625,0.625,0.625h11.783 c0.345,0,0.625-0.28,0.625-0.625V11.509C13.033,11.164,12.753,10.884,12.408,10.884z M11.783,38.802H1.25V12.134h10.533V38.802z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M37.202,11.884c-0.077-0.326-0.433-0.538-0.752-0.464l-8.721,2.081 c-0.067,0.016-0.125,0.049-0.18,0.083V3.312c0-0.345-0.28-0.625-0.625-0.625H15.14c-0.345,0-0.625,0.28-0.625,0.625v36.115 c0,0.345,0.28,0.625,0.625,0.625h11.783c0.345,0,0.625-0.28,0.625-0.625V15.438l5.915,24.811c0.039,0.161,0.138,0.299,0.281,0.388 c0.098,0.061,0.211,0.093,0.327,0.093c0.047,0,0.094-0.007,0.145-0.017l8.722-2.081c0.334-0.08,0.542-0.418,0.462-0.754 L37.202,11.884z M26.298,38.802H15.765V3.937h10.533V38.802z M34.534,39.351l-5.908-24.78l7.504-1.788l5.908,24.778L34.534,39.351z ">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M6.516,29.89c2.228,0,4.04-1.812,4.04-4.039c0-2.229-1.812-4.041-4.04-4.041 c-2.227,0-4.039,1.812-4.039,4.041C2.477,28.078,4.289,29.89,6.516,29.89z M6.516,23.06c1.539,0,2.79,1.252,2.79,2.791 c0,1.538-1.252,2.789-2.79,2.789s-2.789-1.251-2.789-2.789C3.727,24.312,4.978,23.06,6.516,23.06z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M3.102,38.259h6.83c0.345,0,0.625-0.28,0.625-0.625v-2.562c0-0.345-0.28-0.625-0.625-0.625h-6.83 c-0.345,0-0.625,0.28-0.625,0.625v2.562C2.477,37.979,2.757,38.259,3.102,38.259z M3.727,35.696h5.58v1.312h-5.58 C3.727,37.008,3.727,35.696,3.727,35.696z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M3.102,18.024h6.83c0.345,0,0.625-0.28,0.625-0.625v-2.56c0-0.345-0.28-0.625-0.625-0.625h-6.83 c-0.345,0-0.625,0.28-0.625,0.625v2.56C2.477,17.744,2.757,18.024,3.102,18.024z M3.727,15.464h5.58v1.31h-5.58 C3.727,16.774,3.727,15.464,3.727,15.464z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M21.032,27.073c2.227,0,4.04-1.812,4.04-4.039s-1.812-4.039-4.04-4.039s-4.04,1.812-4.04,4.039 S18.804,27.073,21.032,27.073z M21.032,20.245c1.538,0,2.79,1.251,2.79,2.789s-1.252,2.789-2.79,2.789 c-1.538,0-2.79-1.251-2.79-2.789S19.493,20.245,21.032,20.245z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M17.617,38.259h6.829c0.345,0,0.625-0.28,0.625-0.625v-2.562c0-0.345-0.28-0.625-0.625-0.625h-6.829 c-0.345,0-0.625,0.28-0.625,0.625v2.562C16.992,37.979,17.272,38.259,17.617,38.259z M18.242,35.696h5.579v1.312h-5.579V35.696z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M17.617,9.06h6.829c0.345,0,0.625-0.28,0.625-0.625V5.874c0-0.345-0.28-0.625-0.625-0.625h-6.829 c-0.345,0-0.625,0.28-0.625,0.625v2.561C16.992,8.779,17.272,9.06,17.617,9.06z M18.242,6.499h5.579V7.81h-5.579V6.499z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M34.673,23.299c-0.738,0.177-1.364,0.63-1.763,1.277c-0.398,0.647-0.521,1.411-0.345,2.149 c0.307,1.287,1.443,2.186,2.763,2.186c0.224,0,0.448-0.026,0.665-0.08c1.525-0.365,2.47-1.901,2.105-3.424 c-0.302-1.266-1.471-2.185-2.779-2.185C35.102,23.223,34.884,23.248,34.673,23.299z M36.883,25.698 c0.099,0.412,0.03,0.839-0.193,1.201c-0.224,0.363-0.574,0.617-0.989,0.717c-0.12,0.029-0.244,0.044-0.367,0.044 c-0.73,0-1.383-0.516-1.553-1.226c-0.099-0.413-0.03-0.842,0.194-1.205c0.224-0.362,0.574-0.616,0.987-0.714 c0.122-0.029,0.247-0.044,0.371-0.044C36.073,24.472,36.71,24.976,36.883,25.698z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M34.406,35.061c-0.087,0.14-0.114,0.312-0.076,0.474l0.595,2.492 c0.039,0.161,0.138,0.299,0.281,0.388c0.098,0.06,0.211,0.093,0.327,0.093c0.047,0,0.094-0.007,0.146-0.018l5.064-1.211 c0.335-0.08,0.542-0.417,0.462-0.752l-0.595-2.492c-0.078-0.33-0.425-0.541-0.753-0.462l-5.065,1.208 C34.63,34.819,34.492,34.919,34.406,35.061z M39.54,34.933l0.305,1.276l-3.849,0.919l-0.305-1.276L39.54,34.933z">
                                                        </path>
                                                        <path style="fill:#ffffff;"
                                                            d="M35.166,14.139l-5.065,1.208c-0.163,0.039-0.301,0.139-0.387,0.28 c-0.086,0.14-0.114,0.312-0.076,0.474l0.595,2.492c0.067,0.282,0.317,0.48,0.607,0.48c0.051,0,0.101-0.006,0.146-0.018l5.065-1.209 c0.335-0.08,0.542-0.417,0.462-0.752l-0.594-2.492C35.84,14.273,35.498,14.063,35.166,14.139z M31.303,17.694l-0.305-1.276 l3.849-0.917l0.305,1.276L31.303,17.694z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="label">{{ __('Accounting System ') }}
                                        </span>
                                    </a>
                                    <ul id="accounting" class="dash-submenu">

                                        @if (Gate::check('manage bank account') || Gate::check('manage bank transfer'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer' ? 'active dash-trigger' : '' }}"
                                                    href="#banking">{{ __('Banking') }}</a>
                                                <ul id="banking" class="dash-submenu">
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit' ? ' active' : '' }}"
                                                            href="{{ route('bank-account.index') }}">{{ __('Account') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'bank-transfer.index' || Request::route()->getName() == 'bank-transfer.create' || Request::route()->getName() == 'bank-transfer.edit' ? ' active' : '' }}"
                                                            href="{{ route('bank-transfer.index') }}">{{ __('Transfer') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage customer') ||
                                                Gate::check('manage proposal') ||
                                                Gate::check('manage invoice') ||
                                                Gate::check('manage revenue') ||
                                                Gate::check('manage credit note'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'customer' || Request::segment(1) == 'proposal' || Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note' ? 'active dash-trigger' : '' }}"
                                                    href="#sales">{{ __('Sales') }}</a>
                                                <ul id="sales" class="dash-submenu">
                                                    @if (Gate::check('manage customer'))
                                                        <li class="dash-item">
                                                            <a class="dash-link  {{ Request::segment(1) == 'customer' ? 'active' : '' }}"
                                                                href="{{ route('customer.index') }}">{{ __('Customer') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (Gate::check('manage proposal'))
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ Request::segment(1) == 'proposal' ? 'active' : '' }}"
                                                                href="{{ route('proposal.index') }}">{{ __('Estimate') }}</a>
                                                        </li>
                                                    @endif
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show' ? ' active' : '' }}"
                                                            href="{{ route('invoice.index') }}">{{ __('Invoice') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit' ? ' active' : '' }}"
                                                            href="{{ route('revenue.index') }}">{{ __('Revenue') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'credit.note' ? ' active' : '' }}"
                                                            href="{{ route('credit.note') }}">{{ __('Credit Note') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage vender') ||
                                                Gate::check('manage bill') ||
                                                Gate::check('manage payment') ||
                                                Gate::check('manage debit note'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'bill' || Request::segment(1) == 'vender' || Request::segment(1) == 'expense' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note' ? 'active dash-trigger' : '' }}"
                                                    href="#purchase">{{ __('Purchases') }}</a>
                                                <ul id="purchase" class="dash-submenu">
                                                    @if (Gate::check('manage vender'))
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ Request::segment(1) == 'vender' ? 'active' : '' }}"
                                                                href="{{ route('vender.index') }}">{{ __('Suppiler') }}</a>
                                                        </li>
                                                    @endif
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show' ? ' active' : '' }}"
                                                            href="{{ route('bill.index') }}">{{ __('Bill') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'expense.index' || Request::route()->getName() == 'expense.create' || Request::route()->getName() == 'expense.edit' || Request::route()->getName() == 'expense.show' ? ' active' : '' }}"
                                                            href="{{ route('expense.index') }}">{{ __('Expense') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit' ? ' active' : '' }}"
                                                            href="{{ route('payment.index') }}">{{ __('Payment') }}</a>
                                                    </li>
                                                    <li class="dash-item  ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'debit.note' ? ' active' : '' }}"
                                                            href="{{ route('debit.note') }}">{{ __('Debit Note') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage chart of account') ||
                                                Gate::check('manage journal entry') ||
                                                Gate::check('balance sheet report') ||
                                                Gate::check('ledger report') ||
                                                Gate::check('trial balance report'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'chart-of-account' ||
                                                Request::segment(1) == 'journal-entry' ||
                                                Request::segment(2) == 'profit-loss' ||
                                                Request::segment(2) == 'ledger' ||
                                                Request::segment(2) == 'balance-sheet' ||
                                                Request::segment(2) == 'trial-balance'
                                                    ? 'active dash-trigger'
                                                    : '' }}"
                                                    href="#double">{{ __('Accounts') }}</a>
                                                <ul id="double" class="dash-submenu">
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'chart-of-account.index' || Request::route()->getName() == 'chart-of-account.show' ? ' active' : '' }}"
                                                            href="{{ route('chart-of-account.index') }}">{{ __('Chart of Accounts') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'journal-entry.edit' ||
                                                        Request::route()->getName() == 'journal-entry.create' ||
                                                        Request::route()->getName() == 'journal-entry.index' ||
                                                        Request::route()->getName() == 'journal-entry.show'
                                                            ? ' active'
                                                            : '' }}"
                                                            href="{{ route('journal-entry.index') }}">{{ __('Journal Account') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'report.ledger' ? ' active' : '' }}"
                                                            href="{{ route('report.ledger', 0) }}">{{ __('Ledger Summary') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'report.balance.sheet' ? ' active' : '' }}"
                                                            href="{{ route('report.balance.sheet') }}">{{ __('Balance Sheet') }}</a>
                                                    </li>
                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'report.profit.loss' ? ' active' : '' }}"
                                                            href="{{ route('report.profit.loss') }}">{{ __('Profit & Loss') }}</a>
                                                    </li>

                                                    <li class="dash-item ">
                                                        <a class="dash-link {{ Request::route()->getName() == 'trial.balance' ? ' active' : '' }}"
                                                            href="{{ route('trial.balance') }}">{{ __('Trial Balance') }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'branch')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ Request::segment(1) == 'budget' ? 'active' : '' }}"
                                                    href="{{ route('budget.index') }}">{{ __('Budget Planner') }}</a>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage goal'))
                                            <li class="dash-item">
                                                <a class="dash-link {{ Request::segment(1) == 'goal' ? 'active' : '' }}"
                                                    href="{{ route('goal.index') }}">{{ __('Financial Goal') }}</a>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage constant tax') ||
                                                Gate::check('manage constant category') ||
                                                Gate::check('manage constant unit') ||
                                                Gate::check('manage constant payment method') ||
                                                Gate::check('manage constant custom field'))
                                            <li class="dash-item">
                                                <a class="dash-link  {{ Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ? 'active dash-trigger' : '' }}"
                                                    href="{{ route('taxes.index') }}">{{ __('Accounting Setup') }}</a>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage print settings'))
                                            <li class="dash-item ">
                                                <a class="dash-link {{ Request::route()->getName() == 'print.setting' ? ' active' : '' }}"
                                                    href="{{ route('print.setting') }}">{{ __('Print Settings') }}</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                        @endif

                        <!--------------------- End Account ----------------------------------->

                        <!--------------------- Start workspace ----------------------------------->

                        @if (Gate::check('view space') ||
                                Gate::check('view spacetype') ||
                                Gate::check('manage ismail') ||
                                Gate::check('manage vistor'))
                            <li class="dash-item dash-hasmenu">
                                <a href="#workspace"
                                    class="dash-link {{ Request::segment(1) == 'spacetype' || Request::segment(1) == 'space' || Request::segment(1) == 'account-assets' || Request::segment(1) == 'isvisitor' || Request::segment(1) == 'ismail' ? ' active dash-trigger' : '' }}"><span
                                        class="dash-micon">

                                        <svg fill="#ffffff" height="64px" width="64px" version="1.1"
                                            id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-54 -54 168.00 168.00"
                                            xml:space="preserve" stroke="#ffffff"
                                            stroke-width="0.0006000000000000001">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M59,38h-4v-2h-4v2h-8v-4h9c0.6,0,1-0.4,1-1V15c0-0.6-0.4-1-1-1H26c-0.6,0-1,0.4-1,1v18c0,0.6,0.4,1,1,1h9v4H21v-3 c0-0.6-0.4-1-1-1h-1v-2h1c0.6,0,1-0.4,1-1v-4c0-0.6-0.4-1-1-1H7c-0.6,0-1,0.4-1,1v3H5c-0.6,0-1,0.4-1,1v4c0,0.6,0.4,1,1,1h1v2H1 c-0.6,0-1,0.4-1,1v5v16h2V45h2v15h2V45h48v15h2V45h2v15h2V44v-5C60,38.4,59.6,38,59,38z M51,16v11H27V16H51z M27,29h24v3h-9h-6h-9 V29z M37,34h4v4h-4V34z M8,28h11v2h-1H8V28z M6,32h1h10v2H7H6V32z M8,36h10h1v2H8V36z M55,43H5H2v-3h5h13h16h6h16v3H55z">
                                                        </path>
                                                        <path
                                                            d="M6,18h14c0.6,0,1-0.4,1-1v-6c0-2.2-1.8-4-4-4h-3V0h-2v7H9c-2.2,0-4,1.8-4,4v6C5,17.6,5.4,18,6,18z M9,9h8c1.1,0,2,0.9,2,2 v5H7v-2h5v-2H7v-1C7,9.9,7.9,9,9,9z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>

                                    <span class="dash-mtext">{{ __('Workspace') }}</span>
                                </a>

                                <ul id="workspace" class="dash-submenu">

                                    @can('view spacetype')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::segment(1) == 'spacetype' ? 'active' : '' }}"
                                                href="{{ route('spacetype.index') }}">{{ __('Spacetype') }}</a>
                                        </li>
                                    @endcan
                                    @can('view space')
                                        <li class="dash-item">
                                            <a class="dash-link  {{ Request::segment(1) == 'space' ? 'active' : '' }}"
                                                href="{{ route('space.index') }}">{{ __('Space') }}</a>
                                        </li>
                                    @endcan
                                    {{-- @can('view chair')
                                    <li class="dash-item {{ (Request::segment(1) == 'chair')?'active':''}}">
                                        <a class="dash-link" href="{{ route('chair.index') }}">{{__('Chair')}}</a>
                                    </li>
                                @endcan --}}
                                    @can('manage assets')
                                        <li class="dash-item">
                                            <a class="dash-link  {{ request()->is('account-assets*') ? 'active' : '' }}"
                                                href="{{ route('account-assets.index') }}">{{ __('Asset Setup ') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage vistor')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::segment(1) == 'isvisitor' ? ' active' : '' }}"
                                                href="{{ route('isvisitor.index') }}">{{ __('Vistor') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage ismail')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::segment(1) == 'ismail' ? ' active' : '' }}"
                                                href="{{ route('ismail.index') }}">{{ __('Mail') }}</a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endif

                        <!--------------------- End Workspace ----------------------------------->

                        <!--------------------- Start CRM ----------------------------------->

                        @if (\Auth::user()->show_crm() == 1)
                            @if (Gate::check('manage lead') ||
                                    Gate::check('manage deal') ||
                                    Gate::check('manage form builder') ||
                                    Gate::check('manage contract'))
                                <li class="dash-item dash-hasmenu ">
                                        <a href="#crm"
                                            class="dash-link {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'deals' || Request::segment(1) == 'leads' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' || Request::segment(1) == 'contract' ? ' active dash-trigger' : '' }}"><span
                                            class="dash-micon"><svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg"
                                                width="50px" height="50px" viewBox="-64.47 -64.47 201.38 201.38"
                                                enable-background="new 0 0 100 100" xml:space="preserve">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <ellipse cx="41.3" cy="42.3" rx="12.2"
                                                        ry="13.5"></ellipse>
                                                    <path
                                                        d="M52.6,57.4c-3.1,2.8-7,4.5-11.3,4.5c-4.3,0-8.3-1.7-11.3-4.6c-5.5,2.5-11,5.7-11,10.7v2.1 c0,2.5,2,4.5,4.5,4.5h35.7c2.5,0,4.5-2,4.5-4.5v-2.1C63.6,63,58.2,59.9,52.6,57.4z">
                                                    </path>
                                                    <path
                                                        d="M68,47.4c-0.2-0.1-0.3-0.2-0.5-0.3c-0.4-0.2-0.9-0.2-1.3,0.1c-2.1,1.3-4.6,2.1-7.2,2.1c-0.3,0-0.7,0-1,0 c-0.5,1.3-1,2.6-1.7,3.7c0.4,0.2,0.9,0.3,1.4,0.6c5.7,2.5,9.7,5.6,12.5,9.8H75c2.2,0,4-1.8,4-4v-1.9C79,52.6,73.3,49.6,68,47.4z">
                                                    </path>
                                                    <path
                                                        d="M66.9,34.2c0-4.9-3.6-8.9-7.9-8.9c-2.2,0-4.1,1-5.6,2.5c3.5,3.6,5.7,8.7,5.7,14.4c0,0.3,0,0.5,0,0.8 C63.4,43,66.9,39.1,66.9,34.2z">
                                                    </path>
                                                </g>
                                            </svg></span><span class="label">{{ __('CRM System') }}</span>
                                        </a>
                                        <ul id="crm"
                                            class="dash-submenu {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'leads' || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' || Request::segment(1) == 'deals' || Request::segment(1) == 'pipelines' ? 'show' : '' }}">
                                            @can('manage lead')
                                                <li class="dash-item">
                                                    <a class="dash-link {{ Request::route()->getName() == 'leads.list' || Request::route()->getName() == 'leads.index' || Request::route()->getName() == 'leads.show' ? ' active' : '' }}"
                                                        href="{{ route('leads.index') }}">{{ __('Leads') }}</a>
                                                </li>
                                            @endcan
                                            @can('manage deal')
                                                <li class="dash-item">
                                                    <a class="dash-link {{ Request::route()->getName() == 'deals.list' || Request::route()->getName() == 'deals.index' || Request::route()->getName() == 'deals.show' ? ' active' : '' }}"
                                                        href="{{ route('deals.index') }}">{{ __('Deals') }}</a>
                                                </li>
                                            @endcan
                                            @can('manage form builder')
                                                <li class="dash-item">
                                                    <a class="dash-link  {{ Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' ? 'active open' : '' }}"
                                                        href="{{ route('form_builder.index') }}">{{ __('Form Builder') }}</a>
                                                </li>
                                            @endcan
                                            @can('manage contract')
                                                <li class="dash-item ">
                                                    <a class="dash-link  {{ Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show' ? 'active' : '' }}"
                                                        href="{{ route('contract.index') }}">{{ __('Contract') }}</a>
                                                </li>
                                            @endcan
                                            @if (Gate::check('manage lead stage') ||
                                                    Gate::check('manage pipeline') ||
                                                    Gate::check('manage source') ||
                                                    Gate::check('manage label') ||
                                                    Gate::check('manage stage'))
                                                <li class="dash-item ">
                                                    <a class="dash-link {{ Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' ? 'active dash-trigger' : '' }}"
                                                        href="{{ route('pipelines.index') }}   ">{{ __('CRM System Setup') }}</a>

                                                </li>
                                            @endif
                                        </ul>
                                </li>
                            @endif
                        @endif

                        <!--------------------- End CRM ----------------------------------->


                        <!--------------------- Start Project ----------------------------------->

                        @if (\Auth::user()->show_project() == 1)
                            @if (Gate::check('manage project'))
                                <li class="dash-item dash-hasmenu ">
                                    <a href="#project"
                                        class="dash-link  {{ Request::segment(1) == 'project' ||
                                        Request::segment(1) == 'bugs-report' ||
                                        Request::segment(1) == 'bugstatus' ||
                                        Request::segment(1) == 'project-task-stages' ||
                                        Request::segment(1) == 'calendar' ||
                                        Request::segment(1) == 'timesheet-list' ||
                                        Request::segment(1) == 'taskboard' ||
                                        Request::segment(1) == 'timesheet-list' ||
                                        Request::segment(1) == 'taskboard' ||
                                        Request::segment(1) == 'project' ||
                                        Request::segment(1) == 'projects' ||
                                        Request::segment(1) == 'time-tracker' ||
                                        Request::segment(1) == 'project_report'
                                            ? 'active dash-trigger'
                                            : '' }}"><span
                                            class="dash-micon"><svg width="64px" height="64px"
                                                viewBox="-512 -512 1536.00 1536.00" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                fill="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>project-configuration</title>
                                                    <g id="Page-1" stroke-width="0.00512" fill="none"
                                                        fill-rule="evenodd">
                                                        <g id="icon" fill="#ffffff"
                                                            transform="translate(42.666667, 42.666667)">
                                                            <path
                                                                d="M277.333333,234.666667 L277.333,255.999667 L298.666667,256 L298.666667,298.666667 L277.333,298.666667 L277.333333,426.666667 L256,426.666667 L256,298.666667 L234.666667,298.666667 L234.666667,256 L256,255.999667 L256,234.666667 L277.333333,234.666667 Z M341.333333,234.666667 L341.333,341.332667 L362.666667,341.333333 L362.666667,384 L341.333,383.999667 L341.333333,426.666667 L320,426.666667 L320,383.999667 L298.666667,384 L298.666667,341.333333 L320,341.332667 L320,234.666667 L341.333333,234.666667 Z M405.333333,234.666667 L405.333,277.332667 L426.666667,277.333333 L426.666667,320 L405.333,319.999667 L405.333333,426.666667 L384,426.666667 L384,319.999667 L362.666667,320 L362.666667,277.333333 L384,277.332667 L384,234.666667 L405.333333,234.666667 Z M170.666667,7.10542736e-15 L341.333333,96 L341.333,213.333 L298.666,213.333 L298.666,138.747 L192,200.331 L192,323.018 L213.333,311.018 L213.333333,320 L234.666667,320 L234.666,348 L170.666667,384 L3.55271368e-14,288 L3.55271368e-14,96 L170.666667,7.10542736e-15 Z M42.666,139.913 L42.6666667,263.04 L149.333,323.022 L149.333,201.497 L42.666,139.913 Z M170.666667,48.96 L69.246,105.991 L169.656,163.963 L271.048,105.424 L170.666667,48.96 Z"
                                                                id="Combined-Shape"> </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg></span><span class="label">{{ __('Project System') }}</span></a>
                                    <ul id="project" class="dash-submenu">
                                        @can('manage project')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : '' }} "
                                                    href="{{ route('projects.index') }}">{{ __('Projects') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage project task')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('taskboard*') ? 'active' : '' }}"
                                                    href="{{ route('taskBoard.view', 'list') }}">{{ __('Tasks') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage timesheet')
                                            <li class="dash-item">
                                                <a class="dash-link  {{ request()->is('timesheet-list*') ? 'active' : '' }}"
                                                    href="{{ route('timesheet.list') }}">{{ __('Timesheet') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage bug report')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('bugs-report*') ? 'active' : '' }}"
                                                    href="{{ route('bugs.view', 'list') }}">{{ __('Bug') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage project task')
                                            <li class="dash-item ">
                                                <a class="dash-link {{ request()->is('calendar*') ? 'active' : '' }}"
                                                    href="{{ route('task.calendar', ['all']) }}">{{ __('Task Calendar') }}</a>
                                            </li>
                                        @endcan

                                        @if (\Auth::user()->type != 'super admin')
                                            <li class="dash-item ">
                                                <a class="dash-link  {{ Request::segment(1) == 'time-tracker' ? 'active open' : '' }}"
                                                    href="{{ route('time.tracker') }}">{{ __('Tracker') }}</a>
                                            </li>
                                        @endif
                                        @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'Employee')
                                            <li class="dash-item  ">
                                                <a class="dash-link {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}"
                                                    href="{{ route('project_report.index') }}">{{ __('Project Report') }}</a>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage project task stage') || Gate::check('manage bug status'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a class="dash-link {{ Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages' ? 'active dash-trigger' : '' }}"
                                                    href="#system">{{ __('Project System Setup') }}</a>
                                                <ul id="system" class="dash-submenu">
                                                    @can('manage project task stage')
                                                        <li class="dash-item  ">
                                                            <a class="dash-link {{ Request::route()->getName() == 'project-task-stages.index' ? 'active' : '' }}"
                                                                href="{{ route('project-task-stages.index') }}">{{ __('Project Task Stages') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('manage bug status')
                                                        <li class="dash-item ">
                                                            <a class="dash-link {{ Request::route()->getName() == 'bugstatus.index' ? 'active' : '' }}"
                                                                href="{{ route('bugstatus.index') }}">{{ __('Bug Status') }}</a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif

                        <!--------------------- End Project ----------------------------------->

                        @if (Gate::check('manage project task'))
                            <li class="dash-item dash-hasmenu ">
                                <a href="{{ route('booking.calendar', ['all']) }}"
                                    class="dash-link {{ Request::segment(1) == 'bookingcalendar' ? ' active' : '' }}">
                                    <span class="dash-micon">

                                        <svg width="50px" height="50px" viewBox="-921.6 -921.6 2867.20 2867.20"
                                            class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff"
                                            stroke="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M716 190.9v-67.8h-44v67.8H352v-67.8h-44v67.8H92v710h840v-710H716z m-580 44h172v69.2h44v-69.2h320v69.2h44v-69.2h172v151.3H136V234.9z m752 622H136V402.2h752v454.7z"
                                                    fill="#ffffff"></path>
                                                <path d="M319 565.7m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                                <path d="M510 565.7m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                                <path d="M701.1 565.7m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                                <path d="M319 693.4m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                                <path d="M510 693.4m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                                <path d="M701.1 693.4m-33 0a33 33 0 1 0 66 0 33 33 0 1 0-66 0Z"
                                                    fill="#fffffffffff"></path>
                                            </g>
                                        </svg>
                                    </span><span class="label">{{ __('Booking Calender') }}</span>
                                </a>
                            </li>
                        @endif
                        @if (\Auth::user()->type == 'clientuser')
                            <li class="dash-item dash-hasmenu ">
                                <a href="{{ route('booking.calendar', ['all']) }}"
                                    class="dash-link {{ Request::segment(1) == 'bookingcalendar' ? ' active' : '' }}">
                                    <span class="dash-micon"><svg width="50px" height="50px"
                                            viewBox="-20.64 -20.64 65.28 65.28" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                    stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg></span><span class="label">{{ __('Booking Calender') }}</span>
                                </a>
                            </li>
                        @endif

                        @if (
                            \Auth::user()->type != 'super admin' &&
                                (Gate::check('manage user') ||
                                    Gate::check('manage role') ||
                                    Gate::check('manage client') ||
                                    Gate::check('view companybranch')))
                            <li class="dash-item dash-hasmenu ">

                                <a href="#user"
                                    class="dash-link {{ Request::segment(1) == 'users' ||
                                    Request::segment(1) == 'roles' ||
                                    Request::segment(1) == 'clients' ||
                                    Request::segment(1) == 'clientuser' ||
                                    Request::segment(1) == 'branches' ||
                                    Request::segment(1) == 'userlogs'
                                        ? ' active dash-trigger'
                                        : '' }}"><span
                                        class="dash-micon"><svg width="64px" height="64px" viewBox="-24 -24 72.00 72.00"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <circle cx="10" cy="6" r="4" stroke="#ffffff"
                                                    stroke-width="1.5">
                                                </circle>
                                                <path d="M19 2C19 2 21 3.2 21 6C21 8.8 19 10 19 10" stroke="#ffffff"
                                                    stroke-width="1.5" stroke-linecap="round"></path>
                                                <path d="M17 4C17 4 18 4.6 18 6C18 7.4 17 8 17 8" stroke="#ffffff"
                                                    stroke-width="1.5" stroke-linecap="round"></path>
                                                <path
                                                    d="M13 20.6151C12.0907 20.8619 11.0736 21 10 21C6.13401 21 3 19.2091 3 17C3 14.7909 6.13401 13 10 13C13.866 13 17 14.7909 17 17C17 17.3453 16.9234 17.6804 16.7795 18"
                                                    stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                                            </g>
                                        </svg></span><span class="label">{{ __('User Management') }}</span></a>
                                <ul id="user" class="dash-submenu">
                                    @can('manage user')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' || Request::route()->getName() == 'user.userlog' ? ' active' : '' }}"
                                                href="{{ route('users.index') }}">{{ __('User') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage role')
                                        <li class="dash-item  ">
                                            <a class="dash-link {{ Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit' ? ' active' : '' }}"
                                                href="{{ route('roles.index') }}">{{ __('Role') }}</a>
                                        </li>
                                    @endcan
                                    @can('view companybranch')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::route()->getName() == 'branches.index' || Request::segment(1) == 'branches' || Request::route()->getName() == 'branches.edit' ? ' active' : '' }}"
                                                href="{{ route('branches.index') }}">{{ __('Branch') }}</a>
                                        </li>
                                    @endcan
                                    {{-- @can('manage client')
                                        <li
                                            class="dash-item {{ Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit' ? ' active' : '' }}">
                                            <a class="dash-link" href="{{ route('clients.index') }}">{{ __('Client') }}</a>
                                        </li>
                                    @endcan --}}
                                    @can('manage clientuser')
                                        <li class="dash-item ">
                                            <a class="dash-link {{ Request::route()->getName() == 'clientuser.index' || Request::segment(1) == 'clientuser' || Request::route()->getName() == 'clientuser.edit' ? ' active' : '' }}"
                                                href="{{ route('clientuser.index') }}">{{ __('Clientuser') }}</a>
                                        </li>
                                    @endcan
                                    {{--                              @can('manage user') --}}
                                    {{--                                 <li class="dash-item {{ (Request::route()->getName() == 'users.index' || Request::segment(1) == 'users' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}"> --}}
                                    {{--                                     <a class="dash-link" href="{{ route('user.userlog') }}">{{__('User Logs')}}</a> --}}
                                    {{--                                 </li> --}}
                                    {{--                             @endcan --}}
                                </ul>
                            </li>
                        @endif


                        {{-- @if (Gate::check('manage product & service') || Gate::check('manage product & service'))
                            <li class="dash-item dash-hasmenu">
                                <a href="#products" class="dash-link ">
                                    <span class="dash-micon"><svg width="50px" height="50px"
                                            viewBox="-343.04 -343.04 1198.08 1198.08" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            fill="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>product-catalog</title>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <g id="icon" fill="#ffffff" transform="translate(42.666667, 41.600000)">
                                                        <path
                                                            d="M85.334,107.733 L85.335,150.399 L42.6666667,150.4 L42.6666667,342.4 L175.702784,342.4 L192,350.539 L192,250.91 L202.665434,256.831437 L213.331989,262.740708 L223.998544,256.831437 L234.666,250.909 L234.666,350.539 L250.963883,342.4 L384,342.4 L384,150.4 L341.332,150.399 L341.331,107.733 L426.666667,107.733333 L426.666667,385.066667 L261.013333,385.066667 L213.333333,408.918058 L165.632,385.066667 L3.55271368e-14,385.066667 L3.55271368e-14,107.733333 L85.334,107.733 Z M362.666667,278.4 L362.666667,310.4 L256,310.4 L256,278.4 L362.666667,278.4 Z M170.666667,278.4 L170.666667,310.4 L64,310.4 L64,278.4 L170.666667,278.4 Z M362.666667,214.4 L362.666667,246.4 L256,246.4 L256,239.065 L300.43,214.399 L362.666667,214.4 Z M126.237,214.399 L170.666,239.065 L170.666667,246.4 L64,246.4 L64,214.4 L126.237,214.399 Z M213.333333,7.10542736e-15 L320,59.2604278 L320,177.780929 L213.333333,237.041357 L106.666667,177.780929 L106.666667,59.2604278 L213.333333,7.10542736e-15 Z M170.666667,107.370667 L170.666667,188.928 L192,200.789333 L192,119.232 L170.666667,107.370667 Z M128,83.6693333 L128,165.226723 L149.333333,177.088 L149.333333,95.5306667 L128,83.6693333 Z M256.768,48.5333333 L182.037333,89.28 L202.346667,100.565333 L276.373333,59.4133333 L256.768,48.5333333 Z M213.333333,24.4053901 L139.306667,65.536 L159.957333,77.0133333 L234.688,36.2666667 L213.333333,24.4053901 Z"
                                                            id="Path-2"> </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg></span><span class="label">{{ __('Products System') }}</span>
                                </a>
                                <ul id="products" class="dash-submenu">
                                    @if (Gate::check('manage product & service'))
                                        <li class="dash-item {{ Request::segment(1) == 'productservice' ? 'active' : '' }}">
                                            <a href="{{ route('productservice.index') }}"
                                                class="label">{{ __('Product & Services') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (Gate::check('manage product & service'))
                                        <li class="dash-item {{ Request::segment(1) == 'productstock' ? 'active' : '' }}">
                                            <a href="{{ route('productstock.index') }}"
                                                class="label">{{ __('Product Stock') }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif --}}


                        {{-- @if (\Auth::user()->show_pos() == 1)
                            @if (Gate::check('manage warehouse') || Gate::check('manage purchase') || Gate::check('manage pos') || Gate::check('manage print settings'))
                                <li
                                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'warehouse' || Request::segment(1) == 'purchase' || Request::route()->getName() == 'pos.barcode' || Request::route()->getName() == 'pos.print' || Request::route()->getName() == 'pos.show' ? ' active dash-trigger' : '' }}">
                                    <a href="#pos"><span class="dash-micon"><svg fill="#ffffff" width="64px"
                                                height="64px" viewBox="-24 -24 72.00 72.00" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="m1.44 24c-.795 0-1.44-.645-1.44-1.44v-16.904c0-.795.645-1.44 1.44-1.44h1.705.001c.054 0 .106.013.151.036l-.002-.001v-4.082-.001c0-.093.075-.168.168-.168h.001 6.018.001c.093 0 .168.075.168.168v.001 4.058c.024-.006.052-.01.08-.01h1.515c.795 0 1.44.645 1.44 1.44v4.031c.042-.021.092-.033.145-.033h.001.756c.186 0 .337.151.337.337v8.772c0 .186-.151.337-.337.337h-.756-.001c-.053 0-.102-.012-.147-.034l.002.001v3.492c0 .795-.645 1.44-1.44 1.44zm7.324-3.231v1.134c0 .093.076.169.169.169h1.334c.093 0 .169-.076.169-.169v-1.134c0-.093-.076-.168-.169-.168h-1.336c-.093 0-.168.075-.169.168zm-3.156 0v1.134c0 .093.076.169.169.169h1.333c.093 0 .169-.076.169-.169v-1.134c0-.093-.076-.168-.169-.168h-1.334c-.093 0-.168.075-.169.168zm-3.156 0v1.134.001c0 .093.075.168.168.168h1.334c.093 0 .169-.076.169-.169v-1.134c0-.093-.076-.168-.169-.168h-1.334c-.093 0-.168.075-.168.168zm6.311-2.571v1.134c0 .093.076.169.169.169h1.334c.093 0 .169-.076.169-.169v-1.134-.001c0-.093-.075-.168-.168-.168h-.001-1.335-.001c-.093 0-.168.075-.168.168v.001zm-3.156 0v1.134c0 .093.076.169.169.169h1.334c.093 0 .169-.076.169-.169v-1.134-.001c0-.093-.075-.168-.168-.168h-.001-1.334-.001c-.093 0-.168.075-.168.168zm-3.156 0v1.134.001c0 .093.075.168.168.168h1.334c.093 0 .169-.076.169-.169v-1.134-.001c0-.093-.075-.168-.168-.168h-.001-1.334c-.093 0-.168.075-.168.168zm6.311-2.572v1.134.001c0 .093.075.168.168.168h.001 1.334.001c.093 0 .168-.075.168-.168v-.001-1.134c0-.093-.076-.168-.169-.168h-1.334c-.093 0-.168.075-.169.168zm-3.156 0v1.134.001c0 .093.075.168.168.168h.001 1.334.001c.093 0 .168-.075.168-.168v-.001-1.134c0-.093-.076-.168-.169-.168h-1.334c-.093 0-.168.075-.169.168zm-3.156 0v1.134.001c0 .093.075.168.168.168h1.335.001c.093 0 .168-.075.168-.168v-.001-1.134c0-.093-.076-.168-.169-.168h-1.334c-.093 0-.168.075-.168.168zm-.21-6.713v4.911.001c0 .093.075.168.168.168h.001 7.76.001c.093 0 .168-.075.168-.168v-.001-4.911c0-.093-.076-.169-.169-.169h-7.76c-.093 0-.169.076-.169.169zm-.504-2.682v1.189.001c0 .279.226.505.505.505h.001 8.398c.279 0 .505-.226.505-.505v-.001-1.189c0-.279-.226-.505-.505-.505h-.99v1.01h.488v.178h-7.392v-.178h.32.001c.084 0 .164-.021.233-.057l-.003.001v-.898c-.067-.035-.146-.056-.231-.056 0 0 0 0-.001 0h-.826c-.278 0-.504.226-.504.505z">
                                                    </path>
                                                </g>
                                            </svg></span><span class="label">{{ __('POS System') }}</span> </a>

                                    <ul id="pos">

                                        @can('manage warehouse')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'warehouse.index' || Request::route()->getName() == 'warehouse.show' ? ' active' : '' }}">
                                                <a class="dash-link"
                                                    href="{{ route('warehouse.index') }}">{{ __('Warehouse') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage purchase')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'purchase.index' || Request::route()->getName() == 'purchase.create' || Request::route()->getName() == 'purchase.edit' || Request::route()->getName() == 'purchase.show' ? ' active' : '' }}">
                                                <a class="dash-link" href="{{ route('purchase.index') }}">{{ __('Purchase') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage pos')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'pos.index' ? ' active' : '' }}">
                                                <a class="dash-link" href="{{ route('pos.index') }}">{{ __(' Add POS') }}</a>
                                            </li>
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'pos.report' || Request::route()->getName() == 'pos.show' ? ' active' : '' }}">
                                                <a class="dash-link" href="{{ route('pos.report') }}">{{ __('POS') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage warehouse')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'warehouse-transfer.index' || Request::route()->getName() == 'warehouse-transfer.show' ? ' active' : '' }}">
                                                <a class="dash-link"
                                                    href="{{ route('warehouse-transfer.index') }}">{{ __('Transfer') }}</a>
                                            </li>
                                        @endcan
                                        @can('create barcode')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'pos.barcode' || Request::route()->getName() == 'pos.print' ? ' active' : '' }}">
                                                <a class="dash-link"
                                                    href="{{ route('pos.barcode') }}">{{ __('Print Barcode') }}</a>
                                            </li>
                                        @endcan
                                        @can('manage pos')
                                            <li
                                                class="dash-item {{ Request::route()->getName() == 'pos-print-setting' ? ' active' : '' }}">
                                                <a class="dash-link"
                                                    href="{{ route('pos.print.setting') }}">{{ __('Print Settings') }}</a>
                                            </li>
                                        @endcan

                                    </ul>
                                </li>
                            @endif
                        @endif --}}


                        @if (\Auth::user()->type != 'super admin')
                            <li class="dash-item dash-hasmenu ">
                                <a href="{{ route('support.index') }}"
                                    class="dash-link {{ Request::segment(1) == 'support' ? 'active' : '' }}">
                                    <span class="dash-micon">
                                        <svg fill="#ffffff" width="50px" height="50px"
                                            viewBox="-21.12 -21.12 66.24 66.24" xmlns="http://www.w3.org/2000/svg"
                                            stroke="#ffffff" stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M12 2C6.486 2 2 6.486 2 12v4.143C2 17.167 2.897 18 4 18h1a1 1 0 0 0 1-1v-5.143a1 1 0 0 0-1-1h-.908C4.648 6.987 7.978 4 12 4s7.352 2.987 7.908 6.857H19a1 1 0 0 0-1 1V18c0 1.103-.897 2-2 2h-2v-1h-4v3h6c2.206 0 4-1.794 4-4 1.103 0 2-.833 2-1.857V12c0-5.514-4.486-10-10-10z">
                                                </path>
                                            </g>
                                        </svg>
                                    </span><span class="label">{{ __('Support System') }}</span>
                                </a>
                            </li>
                            <li class="dash-item dash-hasmenu">
                                <a href="{{ route('zoom-meeting.index') }}"
                                    class="dash-link {{ Request::segment(1) == 'zoom-meeting' || Request::segment(1) == 'zoom-meeting-calender' ? 'active' : '' }}">
                                    <span class="dash-micon">
                                        <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px"
                                            viewBox="-407.15 -407.15 1266.69 1266.69" xml:space="preserve" stroke="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <g id="Layer_8_38_">
                                                        <path
                                                            d="M441.677,43.643H10.687C4.785,43.643,0,48.427,0,54.329v297.425c0,5.898,4.785,10.676,10.687,10.676h162.069v25.631 c0,0.38,0.074,0.722,0.112,1.089h-23.257c-5.407,0-9.796,4.389-9.796,9.795c0,5.408,4.389,9.801,9.796,9.801h158.506 c5.406,0,9.795-4.389,9.795-9.801c0-5.406-4.389-9.795-9.795-9.795h-23.256c0.032-0.355,0.115-0.709,0.115-1.089V362.43H441.7 c5.898,0,10.688-4.782,10.688-10.676V54.329C452.37,48.427,447.589,43.643,441.677,43.643z M422.089,305.133 c0,5.903-4.784,10.687-10.683,10.687H40.96c-5.898,0-10.684-4.783-10.684-10.687V79.615c0-5.898,4.786-10.684,10.684-10.684 h370.446c5.898,0,10.683,4.785,10.683,10.684V305.133z M303.942,290.648H154.025c0-29.872,17.472-55.661,42.753-67.706 c-15.987-10.501-26.546-28.571-26.546-49.13c0-32.449,26.306-58.755,58.755-58.755c32.448,0,58.753,26.307,58.753,58.755 c0,20.553-10.562,38.629-26.545,49.13C286.475,234.987,303.942,260.781,303.942,290.648z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </span><span class="label">{{ __('Zoom Meeting') }}</span>
                                </a>
                            </li>
                            <li class="dash-item dash-hasmenu">
                                <a href="{{ url('chats') }}"
                                    class="dash-link {{ Request::segment(1) == 'chats' ? 'active' : '' }}">
                                    <span class="dash-micon">
                                        <svg width="50px" height="50px" viewBox="-21.6 -21.6 67.20 67.20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12 3.5C7.28986 3.5 3.5 7.1899 3.5 11.7071C3.5 14.0838 4.54603 16.2271 6.2249 17.7289C6.31701 17.8113 6.37534 17.9249 6.38864 18.0478L6.70243 20.9462C6.73215 21.2207 6.53369 21.4674 6.25915 21.4971C5.98462 21.5268 5.73796 21.3284 5.70824 21.0538L5.41479 18.3433C3.62078 16.6708 2.5 14.317 2.5 11.7071C2.5 6.60668 6.76902 2.5 12 2.5C15.0863 2.5 17.7762 3.83689 19.5165 6.06743C19.6775 6.27381 19.6521 6.56945 19.4582 6.74532L14.0482 11.6531C13.8719 11.8131 13.6073 11.8266 13.4156 11.6853L10.3489 9.42482L8.00341 13.3115L10.1084 11.6944C10.2829 11.5603 10.5246 11.5561 10.7037 11.6841L14.0166 14.0515L19.7983 7.67052C19.9076 7.5499 20.0688 7.49003 20.2303 7.51005C20.3919 7.53007 20.5335 7.62747 20.6101 7.77113C21.2947 9.056 21.5 10.2136 21.5 11.7071C21.5 16.8075 17.231 20.9141 12 20.9141C10.9256 20.9141 9.89175 20.7411 8.92713 20.4217C8.66499 20.3349 8.52284 20.052 8.60964 19.7899C8.69644 19.5278 8.97931 19.3856 9.24146 19.4724C10.1057 19.7585 11.0334 19.9141 12 19.9141C16.7101 19.9141 20.5 16.2242 20.5 11.7071C20.5 10.607 20.3821 9.75722 20.0355 8.898L14.4587 15.0529C14.2883 15.241 14.004 15.2715 13.7975 15.124L10.4238 12.7131L6.50993 15.7197C6.31928 15.8662 6.05139 15.8562 5.87214 15.696C5.69289 15.5358 5.65303 15.2707 5.77725 15.0649L9.77609 8.43863C9.84874 8.31823 9.96873 8.234 10.1067 8.20657C10.2446 8.17915 10.3877 8.21106 10.5008 8.29449L13.6795 10.6375L18.4328 6.32538C16.8861 4.55847 14.6156 3.5 12 3.5Z"
                                                    fill="#ffffff"></path>
                                            </g>
                                        </svg>
                                    </span><span class="label">{{ __('Messenger') }}</span>
                                </a>
                            </li>
                        @endif

                        @if (\Auth::user()->type == 'company')
                            <li class="dash-item dash-hasmenu ">
                                <a href="{{ route('notification-templates.index') }}"
                                    class="dash-link {{ Request::segment(1) == 'notification-templates' ? 'active' : '' }}">
                                    <span class="dash-micon">
                                        <svg fill="#ffffff" width="50px" height="50px" viewBox="-21.6 -21.6 67.20 67.20"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"
                                            stroke-width="0.00024000000000000003">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M16 2H8C7.46957 2 6.96086 2.21071 6.58579 2.58579C6.21071 2.96086 6 3.46957 6 4H15V9H20V20H6C6 20.5304 6.21071 21.0391 6.58579 21.4142C6.96086 21.7893 7.46957 22 8 22H20C20.5304 22 21.0391 21.7893 21.4142 21.4142C21.7893 21.0391 22 20.5304 22 20V8L16 2Z">
                                                </path>
                                                <path
                                                    d="M11.3245 14.4883L12.6906 15.822V16.4942H2V15.822L3.3553 14.4883V11.1597C3.28833 10.2186 3.55162 9.28363 4.09982 8.51576C4.64802 7.74789 5.44681 7.1952 6.35864 6.95288V6.4975C6.35864 6.23295 6.46373 5.97923 6.6508 5.79216C6.83787 5.60509 7.09159 5.5 7.35614 5.5C7.62069 5.5 7.87441 5.60509 8.06148 5.79216C8.24855 5.97923 8.35364 6.23295 8.35364 6.4975V6.95288C9.25835 7.20335 10.0485 7.75916 10.59 8.52597C11.1315 9.29278 11.391 10.2233 11.3245 11.1597V14.4883Z">
                                                </path>
                                                <path
                                                    d="M8.26662 18.1094C8.01652 18.3595 7.67731 18.5 7.32361 18.5C6.96992 18.5 6.63071 18.3595 6.3806 18.1094C6.1305 17.8593 5.99 17.5201 5.99 17.1664H8.65722C8.65722 17.5201 8.51672 17.8593 8.26662 18.1094Z">
                                                </path>
                                            </g>
                                        </svg> </span><span class="label">{{ __('Notification Template') }}</span>
                                </a>
                            </li>
                        @endif



                        @if (\Auth::user()->type != 'super admin')
                            @if (Gate::check('manage company plan') || Gate::check('manage order') || Gate::check('manage company settings'))
                                <li class="dash-item dash-hasmenu ">
                                    <a href="#settings"
                                        class="dash-link {{ Request::segment(1) == 'settings' ||
                                        Request::segment(1) == 'plans' ||
                                        Request::segment(1) == 'stripe' ||
                                        Request::segment(1) == 'order'
                                            ? ' active dash-trigger'
                                            : '' }}">
                                        <span class="dash-micon">
                                            <svg fill="#ffffff" height="50px" width="50px" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="-397.52 -397.52 1192.56 1192.56" xml:space="preserve"
                                                stroke="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                                </g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g>
                                                        <g id="Layer_5_36_">
                                                            <g>
                                                                <path
                                                                    d="M126.32,156.454c-37.993,0-68.901,30.911-68.901,68.905c0,37.991,30.909,68.9,68.901,68.9s68.9-30.909,68.9-68.9 C195.22,187.365,164.311,156.454,126.32,156.454z M126.32,279.641c-29.932,0-54.283-24.351-54.283-54.281 c0-29.934,24.352-54.286,54.283-54.286s54.282,24.353,54.282,54.286C180.602,255.29,156.251,279.641,126.32,279.641z">
                                                                </path>
                                                                <path
                                                                    d="M241.133,193.697l-9.568-2.638c-1.085-0.299-2.955-2.038-3.333-3.102l-2.717-6.683l-0.152-0.346 c-0.483-1.028-0.382-3.607,0.179-4.597l4.819-8.491c3.36-5.921,2.264-14.015-2.549-18.824l-23.776-23.779 c-2.852-2.848-6.952-4.482-11.248-4.482c-2.723,0-5.341,0.669-7.57,1.935l-8.038,4.561c-0.324,0.184-1.251,0.458-2.478,0.458 c-1.061,0-1.766-0.207-1.991-0.316l-8.275-3.484l-0.348-0.136c-1.068-0.385-2.818-2.276-3.121-3.375l-2.719-9.851 c-1.81-6.563-8.307-11.511-15.113-11.511h-33.629c-6.807,0-13.303,4.949-15.11,11.508l-2.723,9.855 c-0.303,1.101-2.06,3.003-3.132,3.393l-8.905,3.768l-0.378,0.173c-0.223,0.11-0.926,0.318-1.988,0.318 c-1.202,0.001-2.109-0.267-2.429-0.448l-7.565-4.295c-2.231-1.266-4.851-1.936-7.575-1.936c-4.3,0-8.4,1.636-11.247,4.484 l-23.782,23.778c-4.812,4.813-5.906,12.904-2.546,18.822l4.736,8.343c0.565,0.998,0.677,3.584,0.198,4.613 c-1.323,2.844-4.967,8.298-6.713,9.848l-8.841,2.438C4.946,195.509,0,202.006,0,208.812v33.626c0,6.803,4.946,13.3,11.506,15.112 l9.568,2.641c1.088,0.3,2.96,2.038,3.338,3.101l2.945,7.17l0.149,0.338c0.484,1.024,0.39,3.586-0.169,4.568l-4.362,7.68 c-3.356,5.916-2.261,14.006,2.55,18.822l23.78,23.777c2.85,2.85,6.95,4.484,11.248,4.484l0,0c2.723,0,5.342-0.669,7.576-1.936 l7.361-4.177c0.327-0.186,1.26-0.461,2.492-0.461c1.062,0,1.769,0.206,1.995,0.315l8.39,3.522l0.357,0.139 c1.065,0.382,2.81,2.264,3.112,3.358l2.56,9.276c1.808,6.561,8.305,11.511,15.111,11.511h33.629 c6.806,0,13.303-4.948,15.113-11.511l2.558-9.279c0.3-1.087,2.038-2.957,3.099-3.335l7.735-3.188l0.355-0.158 c0.225-0.107,0.931-0.311,1.99-0.311c1.259,0,2.214,0.282,2.548,0.472l7.823,4.443c2.232,1.267,4.851,1.936,7.576,1.936 c4.3,0,8.4-1.636,11.248-4.485l23.778-23.777c4.814-4.812,5.91-12.904,2.549-18.825l-4.441-7.82 c-0.556-0.979-0.647-3.525-0.163-4.541l3.188-7.659l0.134-0.347c0.379-1.064,2.253-2.805,3.343-3.105l9.57-2.64 c6.559-1.812,11.505-8.309,11.505-15.112v-33.623C252.641,202.006,247.695,195.508,241.133,193.697z M237.247,243.459 l-9.568,2.64c-5.615,1.549-11.11,6.61-13.151,12.086l-2.914,7.023c-2.439,5.314-2.139,12.778,0.738,17.851l4.422,7.782 c0.124,0.31,0.021,1.075-0.152,1.31L192.875,315.9c-0.096,0.073-0.467,0.233-0.944,0.233c-0.22,0-0.366-0.046-0.357-0.03 l-7.824-4.443c-2.702-1.534-6.17-2.379-9.766-2.379c-2.072,0-5.137,0.288-8.082,1.641l-7.098,2.934 c-5.479,2.037-10.544,7.533-12.093,13.151l-2.544,9.234c-0.13,0.305-0.73,0.766-1.066,0.82l-33.553,0.002 c-0.331-0.045-0.946-0.513-1.064-0.78l-2.56-9.276c-1.546-5.609-6.598-11.106-12.064-13.157l-7.725-3.232 c-2.97-1.383-6.063-1.678-8.155-1.678c-3.572,0-7.02,0.841-9.707,2.366l-7.32,4.155c-0.036,0.015-0.178,0.053-0.402,0.053 c-0.478,0-0.85-0.161-0.913-0.204l-23.747-23.741c-0.204-0.268-0.309-1.036-0.206-1.304l4.36-7.676 c2.873-5.058,3.185-12.52,0.766-17.839l-2.701-6.555c-2.037-5.48-7.535-10.548-13.153-12.097l-9.521-2.625 c-0.309-0.132-0.778-0.748-0.822-1.035l-0.002-33.581c0.045-0.333,0.514-0.949,0.777-1.067l9.563-2.637 c8.015-2.207,15.287-17.422,15.357-17.572c2.473-5.313,2.164-12.878-0.737-17.994l-4.718-8.307 c-0.124-0.312-0.021-1.076,0.15-1.309l23.749-23.748c0.096-0.073,0.467-0.232,0.943-0.232c0.222,0,0.363,0.041,0.359,0.03 l7.562,4.292c2.674,1.52,6.101,2.357,9.649,2.357c2.116,0,5.241-0.303,8.236-1.722l8.238-3.494 c5.445-2.071,10.479-7.573,12.021-13.166l2.709-9.813c0.131-0.308,0.746-0.776,1.032-0.819l33.584-0.002 c0.333,0.045,0.948,0.514,1.066,0.781l2.719,9.85c1.545,5.604,6.591,11.105,12.048,13.164l7.61,3.193 c2.975,1.39,6.073,1.686,8.17,1.686c3.568,0,7.012-0.84,9.694-2.363l7.995-4.538c0.036-0.015,0.176-0.051,0.396-0.051 c0.48,0,0.853,0.161,0.914,0.202l23.744,23.744c0.203,0.267,0.306,1.032,0.201,1.304l-4.819,8.493 c-2.868,5.056-3.189,12.511-0.79,17.823l2.489,6.102c2.034,5.487,7.535,10.562,13.154,12.11l9.523,2.623 c0.309,0.132,0.777,0.748,0.82,1.036l0.002,33.581C237.98,242.726,237.511,243.342,237.247,243.459z">
                                                                </path>
                                                                <path
                                                                    d="M393.377,112.81l-6.573-1.953c-2.321-0.688-4.846-3.132-5.611-5.428l-1.713-4.439c-0.983-2.211-0.778-5.725,0.459-7.805 l3.443-5.806c1.236-2.08,0.875-5.212-0.8-6.958L366.48,63.675c-1.679-1.746-4.794-2.232-6.922-1.076l-5.609,3.038 c-2.13,1.154-5.636,1.198-7.793,0.097l-5.418-2.399c-2.262-0.866-4.599-3.496-5.199-5.843l-1.745-6.844 c-0.598-2.345-3.066-4.304-5.487-4.352l-23.232-0.457c-2.42-0.048-4.965,1.814-5.654,4.133l-2.013,6.77 c-0.691,2.321-3.129,4.861-5.42,5.645l-5.954,2.389c-2.19,1.027-5.692,0.856-7.772-0.38l-5.166-3.07 c-2.083-1.237-5.215-0.876-6.96,0.805l-16.751,16.1c-1.742,1.676-2.226,4.793-1.073,6.921l3.159,5.831 c1.153,2.13,1.23,5.645,0.169,7.813c-1.061,2.167-5.21,8.66-7.557,9.256l-6.643,1.693c-2.345,0.599-4.305,3.07-4.353,5.49 l-0.456,23.228c-0.047,2.422,1.814,4.965,4.134,5.655l6.573,1.954c2.322,0.688,4.849,3.132,5.616,5.43l1.852,4.759 c0.992,2.211,0.795,5.721-0.444,7.802l-3.113,5.241c-1.238,2.084-0.875,5.215,0.803,6.961l16.104,16.746 c1.678,1.747,4.793,2.232,6.924,1.078l5.14-2.785c2.128-1.155,5.638-1.197,7.796-0.101l5.501,2.428 c2.261,0.864,4.605,3.488,5.2,5.837l1.642,6.442c0.598,2.348,3.067,4.307,5.488,4.354l23.231,0.455 c2.422,0.049,4.964-1.811,5.654-4.133l1.894-6.373c0.687-2.323,3.131-4.851,5.43-5.617l5.146-2.013 c2.207-0.997,5.719-0.802,7.798,0.436l5.342,3.172c2.082,1.238,5.215,0.876,6.958-0.804l16.751-16.1 c1.744-1.68,2.229-4.794,1.074-6.921l-2.962-5.467c-1.152-2.129-1.21-5.644-0.123-7.808l2.192-5.01 c0.86-2.266,3.482-4.609,5.829-5.206l6.645-1.693c2.343-0.599,4.305-3.066,4.352-5.488l0.457-23.229 C397.557,116.047,395.695,113.5,393.377,112.81z M314.236,170.826c-23.495-0.462-42.171-19.886-41.709-43.381 c0.462-23.5,19.886-42.176,43.381-41.715c23.497,0.463,42.172,19.889,41.71,43.387 C357.156,152.614,337.733,171.288,314.236,170.826z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </span><span class="label">{{ __('Settings') }}</span>
                                    </a>
                                    <ul id="settings" class="dash-submenu">
                                        @if (Gate::check('manage company settings'))
                                            <li class="dash-item dash-hasmenu ">
                                                <a href="{{ route('settings') }}"
                                                    class="label {{ Request::segment(1) == 'settings' ? ' active' : '' }}">{{ __('System Settings') }}</a>
                                            </li>
                                        @endif
                                        @if (Gate::check('manage company plan'))
                                            <li class="dash-item">
                                                <a href="{{ route('plans.index') }}"
                                                    class="label {{ Request::route()->getName() == 'plans.index' || Request::route()->getName() == 'stripe' ? ' active' : '' }}">{{ __('Setup Subscription Plan') }}</a>
                                            </li>
                                        @endif

                                        @if (Gate::check('manage order') && Auth::user()->type == 'company')
                                            <li class="dash-item ">
                                                <a href="{{ route('order.index') }}"
                                                    class="label {{ Request::segment(1) == 'order' ? 'active' : '' }}">{{ __('Order') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif





                        @if (\Auth::user()->type == 'client')
                            <ul class="dash-navbar">
                                @if (Gate::check('manage client dashboard'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                                        <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-home"></i></span><span
                                                class="label">{{ __('Dashboard') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage deal'))
                                    <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'deals' ? ' active' : '' }}">
                                        <a href="{{ route('deals.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                                                class="label">{{ __('Deals') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage contract'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'contract.index' || Request::route()->getName() == 'contract.show' ? 'active' : '' }}">
                                        <a href="{{ route('contract.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-rocket"></i></span><span
                                                class="label">{{ __('Contract') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage project'))
                                    <li
                                        class="dash-item dash-hasmenu  {{ Request::segment(1) == 'projects' ? ' active' : '' }}">
                                        <a href="{{ route('projects.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-share"></i></span><span
                                                class="label">{{ __('Project') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage project'))
                                    <li
                                        class="dash-item  {{ Request::route()->getName() == 'project_report.index' || Request::route()->getName() == 'project_report.show' ? 'active' : '' }}">
                                        <a class="dash-link" href="{{ route('project_report.index') }}">
                                            <span class="dash-micon"><i class="ti ti-chart-line"></i></span><span
                                                class="label">{{ __('Project Report') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Gate::check('manage project task'))
                                    <li
                                        class="dash-item dash-hasmenu  {{ Request::segment(1) == 'taskboard' ? ' active' : '' }}">
                                        <a href="{{ route('taskBoard.view', 'list') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-list-check"></i></span><span
                                                class="label">{{ __('Tasks') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Gate::check('manage bug report'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'bugs-report' ? ' active' : '' }}">
                                        <a href="{{ route('bugs.view', 'list') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-bug"></i></span><span
                                                class="label">{{ __('Bugs') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Gate::check('manage timesheet'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'timesheet-list' ? ' active' : '' }}">
                                        <a href="{{ route('timesheet.list') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-clock"></i></span><span
                                                class="label">{{ __('Timesheet') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Gate::check('manage project task'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'calendar' ? ' active' : '' }}">
                                        <a href="{{ route('task.calendar', ['all']) }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-calendar"></i></span><span
                                                class="label">{{ __('Task Calender') }}</span>
                                        </a>
                                    </li>
                                @endif


                                <li class="dash-item dash-hasmenu">
                                    <a href="{{ route('support.index') }}"
                                        class="dash-link {{ Request::segment(1) == 'support' ? 'active' : '' }}">
                                        <span class="dash-micon"><i class="ti ti-headphones"></i></span><span
                                            class="label">{{ __('Support') }}</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        @if (\Auth::user()->type == 'super admin')
                            <ul class="dash-navbar">
                                @if (Gate::check('manage super admin dashboard'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
                                        <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-home"></i></span><span
                                                class="label">{{ __('Dashboard') }}</span>
                                        </a>
                                    </li>
                                @endif


                                @can('manage user')
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : '' }}">
                                        <a href="{{ route('users.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-users"></i></span><span
                                                class="label">{{ __('User') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @if (Gate::check('manage plan'))
                                    <li class="dash-item dash-hasmenu  {{ Request::segment(1) == 'plans' ? 'active' : '' }}">
                                        <a href="{{ route('plans.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-trophy"></i></span><span
                                                class="label">{{ __('Plan') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (\Auth::user()->type == 'super admin')
                                    <li class="dash-item dash-hasmenu {{ request()->is('plan_request*') ? 'active' : '' }}">
                                        <a href="{{ route('plan_request.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-arrow-up-right-circle"></i></span><span
                                                class="label">{{ __('Plan Request') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage coupon'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::segment(1) == 'coupons' ? 'active' : '' }}">
                                        <a href="{{ route('coupons.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-gift"></i></span><span
                                                class="label">{{ __('Coupon') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Gate::check('manage order'))
                                    <li
                                        class="dash-item dash-hasmenu  {{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                                        <a href="{{ route('order.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-shopping-cart-plus"></i></span><span
                                                class="label">{{ __('Order') }}</span>
                                        </a>
                                    </li>
                                @endif
                                <li
                                    class="dash-item dash-hasmenu {{ Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
                                    <a href="{{ route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang]) }}"
                                        class="dash-link">
                                        <span class="dash-micon"><i class="ti ti-template"></i></span>
                                        <span class="label">{{ __('Email Template') }}</span>
                                    </a>
                                </li>

                                @if (\Auth::user()->type == 'super admin')
                                    @include('landingpage::menu.landingpage')
                                @endif

                                @if (Gate::check('manage system settings'))
                                    <li
                                        class="dash-item dash-hasmenu {{ Request::route()->getName() == 'systems.index' ? ' active' : '' }}">
                                        <a href="{{ route('systems.index') }}" class="dash-link">
                                            <span class="dash-micon"><i class="ti ti-settings"></i></span><span
                                                class="label">{{ __('Settings') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        @endif


                    </ul>
                @endif

            </div>

            <!-- Menu End -->

            <!-- Mobile Buttons Start -->
            <div class="mobile-buttons-container">
                <!-- Menu Button Start -->
                <a href="#" id="mobileMenuButton" class="menu-button">
                    <i data-acorn-icon="menu"></i>
                </a>
                <!-- Menu Button End -->
            </div>
            <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
    </div>
    {{-- </ul>
    </div>
    </div> --}}
    </div>
</nav>
{{-- new theam code --}}

<script>
    // // Wait for the DOM to be fully loaded
    // document.addEventListener("DOMContentLoaded", function() {
    //     // Get all elements with the class 'dash-link'
    //     var dashLinks = document.querySelectorAll('.dash-link');

    //     // Loop through each dash link
    //     dashLinks.forEach(function(link) {
    //         // Add click event listener
    //         link.addEventListener('click', function(event) {
    //             // Prevent the default action of the link
    //             event.preventDefault();

    //             // Toggle the active class for the clicked link
    //             link.classList.toggle('active');

    //             // Check if the link has a submenu
    //             if (link.nextElementSibling && link.nextElementSibling.classList.contains(
    //                     'dash-submenu')) {
    //                 // Toggle the 'show' class for the submenu
    //                 link.nextElementSibling.classList.toggle('show');
    //             } else {
    //                 // If the link doesn't have a submenu, check if its parent has one
    //                 var parentSubmenu = link.closest('.dash-submenu');
    //                 if (parentSubmenu) {
    //                     // Toggle the 'show' class for the parent submenu
    //                     parentSubmenu.classList.toggle('show');
    //                 }
    //             }
    //         });

    //         // Add click event listener to the SVG icon
    //         var svgIcon = link.querySelector('.dash-micon');
    //         if (svgIcon) {
    //             svgIcon.addEventListener('click', function(event) {
    //                 // Prevent the default action of the SVG icon
    //                 event.preventDefault();

    //                 // Find the parent menu item
    //                 var parentMenuItem = link.closest('.dash-item');

    //                 // Toggle the 'show' class for the parent menu item
    //                 if (parentMenuItem) {
    //                     parentMenuItem.classList.toggle('show');
    //                 }
    //             });
    //         }
    //     });
    // });

var menuContainer = document.querySelector(".menu-container");

// Add click event listener to the menu container
menuContainer.addEventListener("click", function(event) {
  // Check if the clicked element is an li
//   console.log("event:", event);
  if (event.target.tagName === "A" && event.target.classList.contains("dash-link")) {
  console.log("dash:", event.target.classList.contains("dash-link"));
    // Find the parent list item
    var listItem = event.target.closest("li");
    console.log("Sub LI:", listItem);
    
    // Check if the parent list item exists and contains a sub unordered list
    if (listItem && listItem.querySelector("ul")) {
      // Find the immediate child unordered list
      var subUL = listItem.querySelector("ul");
       // Remove "show" class if it exists, otherwise add it

        // Delay the execution of toggling the "show" class by 1 second
            setTimeout(function() {                
                
        if (subUL.classList.contains("show") && subUL.classList.contains("open")) {
            subUL.classList.remove("open");
            subUL.classList.remove("show");
            event.target.setAttribute("aria-expanded", "false");
        } else {
            subUL.classList.add("show");
            subUL.classList.add("open");
            event.target.setAttribute("aria-expanded", "true");
        }
        }, 500); // 1000 milliseconds = 1 second
      // Do whatever you want with the sub unordered list
    } 
  }
});

  
</script>
