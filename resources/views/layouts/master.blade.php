<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }} - Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #3 for statistics, charts, recent events and reports" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @include('includes.css')

        @yield('css')

        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid"  data-bind="nextFieldOnEnter:true">
        <div class="page-wrapper">

            <!-- BEGIN Header File  -->
                @include('includes.header')
            <!-- END Header File  -->

            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">
                        <!-- BEGIN CONTENT -->
                            @yield('content')
                        <!-- END CONTENT -->
                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>

             <!-- Footer  -->
            @include('includes.footer')           

        </div>

        <!-- Begin Script -->
        @include('includes.js')
         <!-- End Script -->   
        @yield('js')
 
    </body>

</html>