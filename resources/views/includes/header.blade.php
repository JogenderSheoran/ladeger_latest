<style>
  .top-menu{
    font-weight: bold;
  }  
</style>
<div class="page-wrapper-row">
    <div class="page-wrapper-top">
        
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container">

                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="{{route('home')}}">
                            <h2 style="color:white;"><b>{{config('app.name')}}</b></h2>
                            {{-- <img src="../assets/layouts/layout3/img/logo-default.jpg" alt="logo" class="logo-default"> --}}
                        </a>
                    </div>
                    <!-- END LOGO -->

                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">   
                            
                            <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                                <div class="btn-group Toppadding">
                                    <span class="btn sbold green">
                                    @if(Auth::user()->is_admin=='id_cutter')
                                    Punter Admin
                                    @else
                                         {{ucfirst(Auth::user()->is_admin)}}
                                    @endif
                                        </span>
                                </div>
                            </li>
                           
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                 <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="../assets/layouts/layout3/img/avatar9.jpg">
                                    <span class="username username-hide-mobile" style="color:white;">
                                    <b>{{Auth::user()->name}}</b> 
                                </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            <i class="icon-key"></i> Log Out 
                                        </a>
                                    </li>
                                        {{-- Logout form --}}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            
            <!-- BEGIN INSTRUCTION TICKER BAR -->
            <div class="instruction-ticker-bar" style="background: linear-gradient(45deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 0; overflow: hidden; white-space: nowrap; position: relative;">
                <div class="container">
                    <div class="ticker-content" style="display: inline-block; animation: scroll-left 30s linear infinite;">
                        <i class="fa fa-bullhorn" style="margin-right: 10px;"></i>
                        <strong>INSTRUCTION:</strong> 
                        <span id="instruction-text">
                            @php
                                $activeInstruction = \App\Models\Instruction::getActiveInstruction();
                                $instructionText = $activeInstruction ? $activeInstruction->instruction_text : 'Welcome to the Ledger Management System! Please follow the guidelines for accurate transaction recording.';
                            @endphp
                            {{ $instructionText }}
                        </span>
                    </div>
                </div>
            </div>
            
            <style>
                @keyframes scroll-left {
                    0% { transform: translateX(100%); }
                    100% { transform: translateX(-100%); }
                }
                
                .instruction-ticker-bar:hover .ticker-content {
                    animation-play-state: paused;
                }
                
                @media (max-width: 768px) {
                    .ticker-content {
                        font-size: 12px;
                        animation-duration: 25s;
                    }
                }
            </style>
            <!-- END INSTRUCTION TICKER BAR -->
                
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container">
                  
                    <!-- BEGIN MEGA MENU -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">

                            {{-- Dashboard --}}
                           
                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown @if(isset($title)) @if($title == 'Dashboard') active  @endif @endif">
                                <a href="{{route('home')}}"> Dashboard
                                    <span class="arrow"></span>
                                </a>
                                
                            </li>

                            <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(isset($title)) @if($title == 'Ledgers') active  @endif @endif ">
                            <a href="{{route('ledgers')}}" class="nav-link   "> Ledgers </a>
                            </li>

                            <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(isset($title)) @if($title == 'Transaction') active  @endif @endif ">
                            <a href="{{route('journal_voucher')}}" class="nav-link   "> Transaction </a>
                            </li>

                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('daily_report')}}"> Daily Report
                                    <span class="arrow"></span>
                                </a>
                            </li>

                           {{-- <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('filter_report')}}"> Filter Report
                                    <span class="arrow"></span>
                                </a>
                            </li>--}}
                           {{-- <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('archieve_transaction')}}"> Archieve
                                    <span class="arrow"></span>
                                </a>
                            </li>--}}
                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('notes')}}"> Notes
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            @if(Auth::user()->is_admin=='Admin')
                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('admin')}}"> Admin
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown @if(isset($title)) @if($title == 'Instruction Settings') active  @endif @endif">
                                <a href="{{route('instructionSettings')}}">Instruction Settings
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            @endif
                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
                                <a href="{{route('medicineTransaction')}}"> Medicine Transaction
                                    <span class="arrow"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!-- END HEADER -->
    </div>
</div>

<script>window.pageData={}; window.pageData.baseUrl = "{{ url('/') }}";</script>