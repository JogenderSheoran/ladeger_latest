@extends('layouts.login_master') 
@section('content')
<div class="container-min-full-height d-flex justify-content-center align-items-center">
    <div class="login-center">
        <div class="navbar-header text-center mt-2 mb-4">
            <a href="index.html">
                <h1 class="fw-600">SMH</h1>
                <span class="black">Welcome back,<br/></span>
                <span class="black">Please sign in to your account below.</span>
                {{-- <img alt="" src="{{ URL::asset('/theme/assets/img/logo-dark.png')}}" class="login-logo"> --}}
            </a>
        </div>
        <!-- /.navbar-header -->
        @if(session('logout'))
        <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
               {{ session('logout') }}
        </div>
        @endif
        <form class="login-form"  action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="example-email">Username</label>
                <input class="form-control form-control-line"  type="text" autocomplete="off" placeholder="Username" name="name" required /> 
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                <label for="example-password">Password</label>
                <input type="password" placeholder="Password" id="password" name="password" required class="form-control form-control-line">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>



            <div class="form-group ">
                <img style="width:14px;cursor: pointer;" class="reset" src="{{URL::asset('image/logo/refresh.png')}}" /> &nbsp;

                <p class="btn btn-primary margin4" id="question"></p><input id="ans" type="text">

            </div>

            <div id="message">Please verify you are a human.</div>
            <div id="success">Validation complete :)</div>
            <div id="fail">Validation failed :(</div>		

            <div class="form-group">
                <button class="btn btn-block btn-lg btn-primary text-uppercase fs-12 fw-600" type="submit" value="submit">Login</button>
            </div>
            
            <!-- /.form-group -->
        </form>
        <!-- /.form-material -->
        
        
    </div>
    <!-- /.login-center -->
</div>
@endsection            