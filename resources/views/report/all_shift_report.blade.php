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
                                <div class="btn-group">
                                    <select class="form-control" id="party_type">
                                        <option value="" selected disable>All Party</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>                                
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">All Shift Report</span>
                                    </div>
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-striped table-bordered table-hover order-column" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                    <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Party</th>
                                                    <th style="text-align: center;">Mobile</th>
                                                    <th style="text-align: center;">Limit</th>
                                                    <th style="text-align: center;">Opening</th>
                                                    <th style="text-align: center;">Total Sale</th>
                                                    <th style="text-align: center;">Dara Sale</th>
                                                    <th style="text-align: center;">Akhar Sale</th>
                                                    <th style="text-align: center;">Comm</th>
                                                    <th style="text-align: center;">Dara Open</th>
                                                    <th style="text-align: center;">Akhar Open</th>
                                                    <th style="text-align: center;">TPC</th>
                                                    <th style="text-align: center;">Hissa</th>
                                                    <th style="text-align: center;">T-Profit</th>
                                                    <th style="text-align: center;">Payment</th>
                                                    <th style="text-align: center;">Closing</th>
                                                    <th style="text-align: center;">Party</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report_data">

                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                                <tr>
                                                    <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Party</th>
                                                    <th style="text-align: center;">Mobile</th>
                                                    <th style="text-align: center;" id="limit">0</th>
                                                    <th style="text-align: center;" id="opening">0</th>
                                                    <th style="text-align: center;" id="total_sale">0</th>
                                                    <th style="text-align: center;" id="d_sale">0</th>
                                                    <th style="text-align: center;" id="a_sale">0</th>
                                                    <th style="text-align: center;" id="comm">0</th>
                                                    <th style="text-align: center;" id="o_dara">0</th>
                                                    <th style="text-align: center;" id="o_akhar">0</th>
                                                    <th style="text-align: center;" id="tpc">0</th>
                                                    <th style="text-align: center;" id="hissa">0</th>
                                                    <th style="text-align: center;" id="t_profit">0</th>
                                                    <th style="text-align: center;" id="payment">0</th>
                                                    <th style="text-align: center;" id="closing">0</th>
                                                    <th style="text-align: center;">Party</th>
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

    <div class="modal fade" id="ShiftModal" style="background: #fff;" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
        <div class="modal-header bg-blue bg-font-blue">
        <h5 class="modal-title">ALL SHIFT REPORT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" style="padding:3px !important;">
        <div class="table-responsive">
        <table style="width:99.9%;" class="table table-bordered">
        <tbody>
        <tr>
        <td style="width:30%"><b>FROM: <span id="as_FromDate"></span> | TO: <span id="as_ToDate"></span></b></td>
        <td align="center">
            <h3><b><span id="as_OrganizationName"></span></b><h3>
            <h5><b><span id="ShiftPartyName"></span></b><h5>
            <h5><b><span id="ShiftPartyUserId"></span></b><h5>
        </td>
        <td style="width:30%" class="text-right"><b>REPORTING TIME: <span id="as_ReportingTime">FROM</span></b></td>
        </tr>
        </tbody>
        </table>
        <div class="table-responsive table2excel CustomFixedTbl">
        <table style="width:99.9%;" class="table table-bordered">
            <thead class="bg-blue bg-font-blue">
                <tr style="border-top:1px solid #DDD;">
                <th>SR.</th>
                <th style="width:200px;">Shift</th>
                <th class="text-center">RATE</th>
                <th class="text-center">S-HISSA</th>
                <th class="text-right">T-SALE</th>
                <th class="text-right">D-SALE</th>
                <th class="text-right">A-SALE</th>
                <th class="text-right">COMM</th>
                <th class="text-right">O-DARA</th>
                <th class="text-right">O-AKHAR</th>
                <th class="text-right">TPC</th>
                <th class="text-right">HISSA</th>
                <th class="text-right">DEBIT</th>
                <th class="text-right">CREDIT</th>
                </tr>
            </thead>
            <tbody id="ShiftListBodyPanel"></tbody>
            <tfoot id="footer" class="bg-blue bg-font-blue" style="display: none">
                <tr style="border-top:1px solid #DDD;">
                    <th id="serial_m">SR.</th>
                    <th style="width:200px;" id="shift_m">Shift</th>
                    <th class="text-center">RATE</th>
                    <th class="text-center">0</th>
                    <th class="text-right" id="total_sale_m">T-SALE</th>
                    <th class="text-right" id="d_sale_m">D-SALE</th>
                    <th class="text-right" id="a_sale_m">A-SALE</th>
                    <th class="text-right" id="comm_m">COMM</th>
                    <th class="text-right" id="o_dara_m">O-DARA</th>
                    <th class="text-right" id="o_akhar_m">O-AKHAR</th>
                    <th class="text-right" id="tpc_m">TPC</th>
                    <th class="text-right" id="hissa_m">HISSA</th>
                    <th class="text-right" id="debit_m">DEBIT</th>
                    <th class="text-right" id="credit_m">CREDIT</th>
                    </tr>
            </tfoot>
        </table>
        </div>
        <br>
        <table style="width:99.9%;" class="table table-bordered">
            <tbody>
                <tr>
                    <td style="width:15%" class="text-center"> <h5><b> OPENING: <span id="as_Opening"></span> </b></h5></td>
                    <td style="width:12%" class="text-center"><b> P&L: <span id="as_TodayProfit"></span></b></td>
                    <td style="width:12%" class="text-center"><b> TPC: <span id="as_TPC"></span></b></td>
                    <td style="width:12%" class="text-center"><b> PAYMENT: <span id="as_Payment"></span></b></td>
                    <td style="width:15%" class="text-center"><h5><b> CLOSING: <span id="as_Closing"></span> </b></h5></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div style="Width:100%;" class="text-center"><b> Download Android App <br> https://play.google.com/store/apps/details?id=com.stark.mandi </b></div>
        <br>
        </div>
        </div>
        </div>
        </div>
    </div>


@endsection
@section('js')
<script>

    function open_details(id){
        $("#ShiftListBodyPanel").empty();
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/profit_loss_data`,
            enctype: 'multipart/form-data',
            data: {date_from:$('#date_from').val(),date_to:$('#date_to').val(),'ledger_id':id},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    var html='';
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
                        var commission=shift['commission'];
                        if (commission>0) {
                            commission="-"+commission;
                        }
                        html +='<tr><td>'+serial+'</td><td>'+shift['name']+'</td><td>'+res.ledger['dara']+'/'+res.ledger['dara_commission']+'</td><td>0</td><td>'+shift['total']+'</td><td>'+shift['dara_total']+'</td><td>'+shift['akhar_total']+'</td><td>'+commission+'</td><td>'+shift['o_dara']+'</td><td>'+shift['o_akhar']+'</td><td>'+shift['tpc']+'</td><td>'+shift['hissa']+'</td><td>'+shift['debit']+'</td><td>'+shift['credit']+'</td></tr>';

                        total=parseFloat(total)+parseFloat(shift['total']);
                        d_sale=parseFloat(d_sale)+parseFloat(shift['dara_total']);
                        a_sale=parseFloat(a_sale)+parseFloat(shift['akhar_total']);
                        comm=parseFloat(comm)+parseFloat(shift['commission']);
                        o_dara=parseFloat(o_dara)+parseFloat(shift['o_dara']);
                        o_akhar=parseFloat(o_akhar)+parseFloat(shift['o_akhar']);
                        tpc=parseFloat(tpc)+parseFloat(shift['tpc']);
                        hissa=parseFloat(hissa)+parseFloat(shift['hissa']);
                        credit=parseFloat(credit)+parseFloat(shift['credit']);
                    });
                    $("#ShiftListBodyPanel").append(html);
                    $('#as_OrganizationName').html("SMH"); 
                    $('#ShiftPartyName').html($('#'+id).text()); 
			        $('#ShiftPartyUserId').html("USER-ID: "+id);
                    $("#serial_m").text(res.data.length);
                    $("#total_sale_m").text(total);
                    $("#d_sale_m").text(d_sale);
                    $("#a_sale_m").text(a_sale);
                    $("#comm_m").text(comm);
                    $("#o_dara_m").text(o_dara);
                    $("#o_akhar_m").text(o_akhar);
                    $("#tpc_m").text(tpc);
                    $("#hissa_m").text(hissa);
                    $("#credit_m").text(credit);
                    $("#debit_m").text(debit);
                    $("#as_FromDate").text($('#date_from').val());
                    $("#as_ToDate").text($('#date_to').val());
                    $('#as_Opening').html($('#opening_'+id).text()); 
                    $('#as_Payment').html($('#payment'+id).text()); 
                    $('#as_TodayProfit').html($('#t_profit'+id).text()); 
                    $('#as_TPC').html($('#tpc'+id).text()); 
                    $('#as_Closing').html($('#closing_'+id).text());

                    var d = new Date();
                    minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes();
                    hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours();
                    ampm = d.getHours() >= 12 ? 'PM' : 'AM';

                    $("#as_ReportingTime").text(d.getDate()+'/'+ d.getMonth()+1 +'/'+d.getFullYear()+' '+hours+':'+minutes+ampm);
                    $('#footer').show();
                    $('#ShiftModal').modal('show');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

    $("#search").click(function(){

        var table = $('#mytable').DataTable();
        table.destroy();
        var html='';
        $("#report_data").empty();    

        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/all_shift_report`,
            enctype: 'multipart/form-data',
            data: {date_from:$('#date_from').val(),date_to:$('#date_to').val(),party_type:$('#party_type').val()},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    var html='';
                    var last_serial=0;
                    var limit=0;
                    var total=0;
                    var d_sale=0;
                    var a_sale=0;
                    var comm=0;
                    var o_dara=0;
                    var o_akhar=0;
                    var tpc=0;
                    var hissa=0;
                    var t_profit=0;
                    var opening=0;
                    var closing=0;
                    $.each(res.data, function (key, ledger) {
                        var serial=parseFloat(key)+1;
                        last_serial=serial;
                        var commission=ledger['commission'];
                        if (commission>0) {
                            commission="-"+commission;
                        }

                        var mobile=ledger['mobile'];
                        if (mobile<1) {
                            mobile='';
                        }
                        html +='<tr><td>'+serial+'</td><td onClick=open_details('+ledger['id']+') id="'+ledger['id']+'" style="cursor: pointer;background-color: lightgray;">'+ledger['name']+'</td><td>'+mobile+'</td><td>'+ledger['limit']+'</td><td id="opening_'+ledger['id']+'">'+ledger['opening']+'</td><td>'+ledger['total']+'</td><td>'+ledger['dara_total']+'</td><td>'+ledger['akhar_total']+'</td><td>'+commission+'</td><td>'+ledger['o_dara']+'</td><td>'+ledger['o_akhar']+'</td><td id="tpc'+ledger['id']+'">'+ledger['tpc']+'</td><td>'+ledger['hissa']+'</td><td id="t_profit'+ledger['id']+'">'+ledger['profit']+'</td><td id="payment'+ledger['id']+'">0</td><td id="closing_'+ledger['id']+'">'+ledger['closing']+'</td><td>'+ledger['name']+'</td></tr>';
                        
                        limit=parseFloat(limit)+parseFloat(ledger['limit']);
                        total=parseFloat(total)+parseFloat(ledger['total']);
                        d_sale=parseFloat(d_sale)+parseFloat(ledger['dara_total']);
                        a_sale=parseFloat(a_sale)+parseFloat(ledger['akhar_total']);
                        comm=parseFloat(comm)+parseFloat(ledger['commission']);
                        o_dara=parseFloat(o_dara)+parseFloat(ledger['o_dara']);
                        o_akhar=parseFloat(o_akhar)+parseFloat(ledger['o_akhar']);
                        tpc=parseFloat(tpc)+parseFloat(ledger['tpc']);
                        hissa=parseFloat(hissa)+parseFloat(ledger['hissa']);
                        t_profit=parseFloat(t_profit)+parseFloat(ledger['profit']);
                        opening=parseFloat(opening)+parseFloat(ledger['opening']);
                        closing=parseFloat(closing)+parseFloat(ledger['closing']);
                    });
                    $("#report_data").append(html);
                    $("#k_value").html(res.number);
                    $("#serial").text(last_serial);

                    $("#limit").text(limit);
                    $("#total_sale").text(total);
                    $("#d_sale").text(d_sale);
                    $("#a_sale").text(a_sale);

                    if (comm>0) {
                        comm="-"+comm
                    }
                    $("#comm").text(comm);
                    $("#o_dara").text(o_dara);
                    $("#o_akhar").text(o_akhar);
                    $("#tpc").text(tpc);
                    $("#hissa").text(hissa);
                    $("#t_profit").text(t_profit);
                    $("#opening").text(opening);
                    $("#closing").text(closing);
                    $('.footer').show();

                    $('#mytable').DataTable({
                        "ordering": false,
                        "searching": false,
                        "paging": true,
                        "info": false,
                        scrollY: 280,
                        "scroller":true,
                        "scrollX":true,
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
