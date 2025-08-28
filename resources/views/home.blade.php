@extends('layouts.master')
@section('content')
<style>
    .dashboard-stat2 {
        border-radius: 8% !important;
        height: 172px;
    }

    .div-width {
        width: 15%;
    }

    .heading {
        text-align: center;
    }

    .CustomFixedTbl th {
        background: #465cc2;
        color: #FFF;
    }

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
    }

    .CustomFixedTbl table thead th {
        position: sticky;
        top: 0;
        border: 1px solid #DDD;
    }

    .CustomFixedTbl table tbody td {
        position: sticky;
        top: 0;
        border: 1px solid #DDD;
        font-weight: bold;
    }

    .table {
        background: #FFF;
        color: #666666;
    }

    .border-top {
        border-top: 1px solid #dee2e6 !important;
    }

    .hospital-tiles {
        position: relative;
        padding: 10px;
        margin-bottom: .9rem;
        background: #ffffff;
        color: #ffffff;
        text-align: center;
        box-shadow: 0 0 25px rgba(26, 107, 225, 0.1);
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px !important;
    }

    .status-title {
        font-weight: 700;
    }

    .text-right {
        text-align: right !important;
    }

    .ml-auto,
    .mx-auto {
        margin-left: auto !important;
    }

    .hospital-tiles.primary {
        background: #465cc2;
    }

    .hospital-tiles.secondary {
        background: #8e639c;
    }

    .hospital-tiles.red {
        background: #d44843;
    }

    .hospital-tiles.green {
        background: #33af65;
    }

    .hospital-tiles.yellow {
        background: #bf870a;
    }

    .hospital-tiles.blue {
        background: #0ea1d2;
    }

    .hospital-tiles img {
        max-width: 40px;
        max-height: 40px;
        opacity: 0.7;
        margin: 1rem 0;
    }

    .hospital-tiles p {
        line-height: 100%;
        margin: 0 0 1rem 0;
    }

    .hospital-tiles h2 {
        margin: 0;
        line-height: 100%;
    }
</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->

    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">

            <!-- BEGIN PAGE BREADCRUMBS -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{route('home')}}">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->

            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">



                <div class="row">
                    <div class="row gutters">
                        {{-- <div class="col-xl-8 col-lglg-8 col-md-8 col-sm-8 col-12">

                            <div class="row" id="DashboardShiftBody">

                                @php   $colors = ['primary','blue','red','green','yellow','secondary']; @endphp
                              
                                <div style="cursor: pointer;" onclick="redirect(1,'')"
                                    class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="hospital-tiles red">
                                        <h5 class="status-title">Ledger</h5>
                                        <div class="border-top my-1"></div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5 class="status-title">Test</h5>
                                            </div>
                                        </div>
                                        <div class="border-top my-1"></div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h5 class="status-title">Test</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}





                    </div>
                    <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body" style="padding: 0.55rem 0.55rem;">

                                <div class="table-responsive CustomFixedTbl">
                                    <table id="" class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">SR</th>
                                                <th>LEDGER </th>
                                                <th class="text-center" style="width:130px;">Net Balance</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if($admin_amount!= '' && $admin_amount->total_amount > 0)
                                            <tr>
                                                <td>#</td>
                                                <td>Admin</td>
                                                <td class="text-center" style="padding:1px 5px;">
                                                    <div style="margin-top:5px; font-size:12px;">
                                                        @if($admin_amount->total_amount > 0)
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold green">{{substr_replace($admin_amount->total_amount,'.',-2,0)}}</a>
                                                        @else
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold red">{{substr_replace($admin_amount->total_amount,'.',-2,0)}}</a>
                                                        @endif
                                                    </div>
                                                    <div style="font-size:10px; opacity:.7;"></div>
                                                </td>
                                            </tr>
                                            @endif

                                            @php $i=0; @endphp


                                            @foreach($ledger as $key=>$l)
                                            @if($l->net_balance > 0)
                                            <tr>
                                                @php $i=$i+1; @endphp
                                                <td>{{$i}}</td>
                                                <td><a href="{{route('ledger_report',['id'=>$l->id])}}" style="color:#666666">{{ucfirst($l->name)}}</a></td>
                                                <td class="text-center" style="padding:1px 5px;">
                                                    <div style="margin-top:5px; font-size:12px;">
                                                        @if($l->net_balance > 0)
                                                         
                                                       
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold green">{{substr_replace($l->net_balance,'.',-2,0)}}</a>
                                                        @else
                                                       
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold red">{{substr_replace($l->net_balance,'.',-2,0)}}</a>
                                                        @endif
                                                    </div>
                                                    <div style="font-size:10px; opacity:.7;"></div>
                                                </td>
                                                
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body" style="padding: 0.55rem 0.55rem;">

                                <div class="table-responsive CustomFixedTbl">
                                    <table id="" class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">SR</th>
                                                <th>LEDGER </th>
                                                <th class="text-center" style="width:130px;">Net Balance</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if($admin_amount!= '' && $admin_amount->total_amount < 0)
                                            <tr>
                                                <td>#</td>
                                                <td>Admin</td>
                                                <td class="text-center" style="padding:1px 5px;">
                                                    <div style="margin-top:5px; font-size:12px;">
                                                        @if($admin_amount->total_amount > 0)
                                                        
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold green">{{substr_replace($admin_amount->total_amount,'.',-2,0)}}</a>
                                                        @else
                                                        
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold red">{{substr_replace($admin_amount->total_amount,'.',-2,0)}}</a>
                                                        @endif
                                                    </div>
                                                    <div style="font-size:10px; opacity:.7;"></div>
                                                </td>
                                            </tr>
                                            @endif
                                            @php $j=0; @endphp
                                            @foreach($ledger as $key=>$l)
                                            <tr>
                                            @if($l->net_balance < 0)
                                                @php $j=$j+1; @endphp
                                                <td>{{$j}}</td>
                                                
                                                    <td><a href="{{route('ledger_report',['id'=>$l->id])}}" style="color:#666666">{{ucfirst($l->name)}}</a></td>
                                                </a>
                                                <td class="text-center" style="padding:1px 5px;">
                                                    <div style="margin-top:5px; font-size:12px;">
                                                        @if($l->net_balance > 0)
                                                        
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold green">{{substr_replace($l->net_balance,'.',-2,0)}}</a>
                                                        @else
                                                        
                                                        <a href="javascript:;" id="search"
                                                            class="btn sbold red">{{substr_replace($l->net_balance,'.',-2,0)}}</a>
                                                        @endif
                                                    </div>
                                                    <div style="font-size:10px; opacity:.7;"></div>
                                                </td>
                                            @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{--<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="card">
                            <div class="card-body" style="padding: 0.55rem 0.55rem;">

                            <div class="table-responsive CustomFixedTbl">
                                    <table id="" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width:130px;">Ledger</th>                                             
                                                <th class="text-center">Amount</th>
                                                <th class="text-center" style="width:130px;">Type</th>
                                                <th class="text-center" style="width:130px;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lene as $key=>$d)
                                            <tr>
                                                <td class="text-center">{{ucfirst($d->ledger_name)}}</td>
                                                <td class="text-center">{{ucfirst($d->amount)}}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="label label-sm label-success label-mini btn sbold red">
                                                        Dene </span>
                                                </td>
                                                <td class="text-center">{{date('d-m-Y', strtotime($d->date));}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>--}}
                    {{--<div class="col-xl-4 col-lglg-4 col-md-4 col-sm-4 col-12">
                        <div class="card">
                            <div class="card-body" style="padding: 0.55rem 0.55rem;">

                                <div class="table-responsive CustomFixedTbl">
                                    <table id="" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width:130px;">Ledger</th>                                             
                                                <th class="text-center">Amount</th>
                                                <th class="text-center" style="width:130px;">Type</th>
                                                <th class="text-center" style="width:130px;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dene as $key=>$d)
                                            <tr>
                                                <td class="text-center">{{ucfirst($d->ledger_name)}}</td>
                                                <td class="text-center">{{ucfirst($d->amount)}}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="label label-sm label-success label-mini btn sbold green">
                                                        Lene </span>
                                                </td>
                                                <td class="text-center">{{date('d-m-Y', strtotime($d->date));}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>--}}
                </div>

            
            </div>
            {{--<div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Report Chart</span>
                            </div>
                            <div id="barchart_material" style="width: 100%; height: 350px;"></div>
                        </div>

                    </div>
                </div>
            </div>--}}
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<div id="redeclare_model" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Are you sure to redeclare number?</h4>
            </div>
            <form id="redeclare_number" class="form-horizontal form-row-seperated">
                <div class="modal-body form">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="hidden" id="date" name="date">
                                <input type="hidden" id="shift_id" name="shift_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">No</button>
                    <button type="submit" class="btn green"><i class="fa fa-check"></i>Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" id="id" />
@endsection

@section('js')
<script>
    $('#redeclare_number').submit(function (e) {
        e.preventDefault();
        var form = $('#redeclare_number')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/redeclare_number`,
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.status == true) {
                    toastr.success(data.message, 'Success');
                    $('#row' + $('#id').val()).hide();
                    $('#redeclare_model').modal('toggle');
                } else {
                    toastr.error(data.message, 'Error');
                }
            }
        });
    });

    //Redeclare number
    function redeclare(date, shift_id, id) {
        $("#shift_id").val(shift_id);
        $("#date").val(date);
        $("#id").val(id);
    }

    function redirect(type, id) {
        if (type == 1) {
            window.location.href = "{{route('transaction_list')}}";
        } else {
            window.location.href = "{{url('add-transaction')}}" + "/" + id;
        }
    }
</script>
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

{{--<script type="text/javascript">
 
 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(drawChart);

 function drawChart() {
   var data = google.visualization.arrayToDataTable([
       ['Day', 'Profit', 'Loss'],

       @php
         foreach($amount_total as $amount) {
          
            echo "['".$amount['day']."',".$amount['profit'].", ".$amount['loss']."],";
         }
       @endphp
   ]);

   var options = {
     chart: {
       title: 'Bar Graph | Profit & Loss ',
       subtitle: 'Profit, Loss',
     },
     vAxis: { 
        viewWindow: {
            min:0
        }
    },
     bars: 'vertical',
   };
   var chart = new google.charts.Bar(document.getElementById('barchart_material'));
   chart.draw(data, google.charts.Bar.convertOptions(options));
 }
</script>--}}