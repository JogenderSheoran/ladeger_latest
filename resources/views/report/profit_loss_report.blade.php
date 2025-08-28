@extends('layouts.master') 
@section('content')
<style>
    table, th, td {
        text-align: center;
    }
</style>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
                <div class="container">

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 5px;"> 
                                <div class="btn-group">
                                    <input type="date" id="date_from" name="date_from" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <input type="date" id="date_to" name="date_to" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <a href="javascript:;" id="search" class="btn sbold green"> Search </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Profit & Loss Report</span>
                                    </div>
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                    <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Shift</th>
                                                    <th style="text-align: center;">Total Sale	</th>
                                                    <th style="text-align: center;">Dara Sale	</th>
                                                    <th style="text-align: center;">Akhar Sale	</th>
                                                    <th style="text-align: center;">Comm</th>
                                                    <th style="text-align: center;">Dara Open	</th>
                                                    <th style="text-align: center;">Akhar Open	</th>
                                                    <th style="text-align: center;">TPC</th>
                                                    <th style="text-align: center;">Hissa</th>
                                                    <th style="text-align: center;">Closing</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report_data">

                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                                <tr>
                                                    <th id="serial">0</th>
                                                    <th>Shift</th>
                                                    <th id="total_sale">0</th>
                                                    <th id="d_sale">0</th>
                                                    <th id="a_sale">0</th>
                                                    <th id="comm">0</th>
                                                    <th id="o_dara">0</th>
                                                    <th id="o_akhar">0</th>
                                                    <th id="tpc">0</th>
                                                    <th id="hissa">0</th>
                                                    <th id="credit">0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
    </div>
    <!-- END CONTENT -->


@endsection
@section('js')
<script>

    $("#search").click(function(){

        var table = $('#mytable').DataTable();
        table.destroy();
        var html='';
        $("#report_data").empty();

        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/profit_loss_data`,
            enctype: 'multipart/form-data',
            data: {date_from:$('#date_from').val(),date_to:$('#date_to').val()},                                     
            success: function(res)
            {
                // console.log(res);
                if(res.status == 'success'){

                    var last_serial=0;
                    var total=0;
                    var d_sale=0;
                    var a_sale=0;
                    var comm=0;
                    var o_dara=0;
                    var o_akhar=0;
                    var tpc=0;
                    var hissa=0;
                    var credit=0;
                    var debit=0;
                    $.each(res.data, function (key, shift) {
                        var serial=parseFloat(key)+1;
                        last_serial=serial;
                        var commission=shift['commission'];
                        if (commission>0) {
                            commission="-"+commission;
                        }
                        html +='<tr><td>'+serial+'</td><td>'+shift['name']+'</td><td>'+shift['total']+'</td><td>'+shift['dara_total']+'</td><td>'+shift['akhar_total']+'</td><td>'+commission+'</td><td>'+shift['o_dara']+'</td><td>'+shift['o_akhar']+'</td><td>'+shift['tpc']+'</td><td>'+shift['hissa']+'</td><td>'+shift['profit']+'</td></tr>';

                        total=parseFloat(total)+parseFloat(shift['total']);
                        d_sale=parseFloat(d_sale)+parseFloat(shift['dara_total']);
                        a_sale=parseFloat(a_sale)+parseFloat(shift['akhar_total']);
                        comm=parseFloat(comm)+parseFloat(shift['commission']);
                        o_dara=parseFloat(o_dara)+parseFloat(shift['o_dara']);
                        o_akhar=parseFloat(o_akhar)+parseFloat(shift['o_akhar']);
                        tpc=parseFloat(tpc)+parseFloat(shift['tpc']);
                        hissa=parseFloat(hissa)+parseFloat(shift['hissa']);
                        credit=parseFloat(credit)+parseFloat(shift['profit']);
                    });
                    $("#report_data").append(html);

                    $("#serial").text(last_serial);
                    $("#total_sale").text(total);
                    $("#d_sale").text(d_sale);
                    $("#a_sale").text(a_sale);
                    $("#comm").text(comm);
                    $("#o_dara").text(o_dara);
                    $("#o_akhar").text(o_akhar);
                    $("#tpc").text(tpc);
                    $("#hissa").text(hissa);
                    $("#credit").text(credit);
                    $('.footer').show();

                    $('#mytable').DataTable({
                        "ordering": false,
                        "searching": false,
                        "paging": true,
                        "info": false,
                        scrollY: 280,
                        "scroller":true,
                    });
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    });

</script>    
@endsection
