<style>
  .top-menu {
    font-weight: bold;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-left: auto;
  }

  .top-menu ul.nav {
    display: flex;
    flex-wrap: wrap;
    margin: 0;
    padding: 0;
  }

  .top-menu ul.nav li {
    white-space: nowrap;
    margin-left: 10px;
  }

  .page-header .page-header-top {
    min-height: 105px;
    height: auto !important;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
  }

  .page-header .page-header-top .page-logo .logo-default {
    margin: 0 !important;
    max-width: 100%;
    height: auto;
  }

  .instruction-ticker-bar {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 0;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    margin-top:5px;
  }

  .ticker-content {
    display: inline-block;
    animation: scroll-left 30s linear infinite;
  }

  @keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
  }

  .page-header-menu {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
  }

  .hor-menu {
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
  }

  .hor-menu ul.nav {
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
  }

  .hor-menu ul.nav li {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
  }

  .hor-menu ul.nav li a {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 4px;
    position: relative;
  }

  .hor-menu ul.nav li a:hover {
    text-decoration: none;
  }



  .menu-dropdown.classic-menu-dropdown,
  .menu-dropdown.mega-menu-dropdown {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
  }

  .menu-dropdown.classic-menu-dropdown a,
  .menu-dropdown.mega-menu-dropdown a {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  /* Responsive adjustments */
  @media (max-width: 991px) {
    .page-header .page-header-menu .hor-menu .navbar-nav {
      background:#4861C2 !important;
      color:white !important;
    }
    .page-header .page-header-menu .hor-menu .navbar-nav > li > a {
      background: 0 0 !important;
      color: white !important;
    }
    .page-header .page-header-menu .hor-menu .navbar-nav > li {
      border: none !important;
    }
    .instruction-ticker-bar {
      font-size: 12px;
      padding: 5px 0;
    }
  }

  @media (max-width: 576px) {
    .top-menu ul.nav {
      flex-direction: column;
      width: 100%;
    }
    .top-menu ul.nav li {
      margin: 5px 0;
    }
    .instruction-ticker-bar {
      font-size: 11px;
      padding: 4px 0;
    }
  }
</style>

<div class="page-wrapper-row">
  <div class="page-wrapper-top">
    <!-- BEGIN HEADER -->
    <div class="page-header">
      <!-- BEGIN HEADER TOP -->
      <div class="page-header-top">
        <div class="container d-flex align-items-center justify-content-between">
          <!-- BEGIN LOGO -->
          <div class="page-logo">
            <a href="{{route('home')}}">
              <img src="{{URL::asset('image/logo/ledger-1.png')}}" alt="logo" class="logo-default" style="max-height:100px;">
            </a>
          </div>
          <!-- END LOGO -->

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
                      <i class="icon-user"></i> My Profile 
                    </a>
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
      <div class="instruction-ticker-bar">
        <div class="container">
          <div class="ticker-content">
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
      <!-- END INSTRUCTION TICKER BAR -->

      <!-- BEGIN HEADER MENU -->
      <div class="page-header-menu">
        <div class="container">
          <div class="hor-menu">
            <ul class="nav navbar-nav">
              <li class="menu-dropdown classic-menu-dropdown @if(isset($title)) @if($title == 'Dashboard') active  @endif @endif">
                <a href="{{route('home')}}"> Dashboard <span class="arrow"></span></a>
              </li>
              <li class="menu-dropdown mega-menu-dropdown @if(isset($title)) @if($title == 'Ledgers') active  @endif @endif">
                <a href="{{route('ledgers')}}" class="nav-link"> Ledgers </a>
              </li>
              <li class="menu-dropdown mega-menu-dropdown @if(isset($title)) @if($title == 'Transaction') active  @endif @endif">
                <a href="{{route('journal_voucher')}}" class="nav-link"> Transaction </a>
              </li>
              <li class="menu-dropdown classic-menu-dropdown">
                <a href="{{route('daily_report')}}"> Daily Report <span class="arrow"></span></a>
              </li>
              <li class="menu-dropdown classic-menu-dropdown">
                <a href="{{route('notes')}}"> Notes <span class="arrow"></span></a>
              </li>
              @if(Auth::user()->is_admin=='Admin')
                <li class="menu-dropdown classic-menu-dropdown">
                  <a href="{{route('admin')}}"> Admin <span class="arrow"></span></a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown @if(isset($title)) @if($title == 'Instruction Settings') active  @endif @endif">
                  <a href="{{route('instructionSettings')}}">Instruction Settings <span class="arrow"></span></a>
                </li>
              @endif
              <li class="menu-dropdown classic-menu-dropdown">
                <a href="{{route('medicineTransaction')}}"> Medicine Transaction <span class="arrow"></span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- END HEADER MENU -->
    </div>
    <!-- END HEADER -->
  </div>
</div>

<script>
  window.pageData = {};
  window.pageData.baseUrl = "{{ url('/') }}";
</script>
