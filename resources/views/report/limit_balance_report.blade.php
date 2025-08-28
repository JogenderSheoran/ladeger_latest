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
                            <div class="col-md-10" style="margin-bottom: 5px;">
                                <div class="btn-group">
                                    <select class="form-control" id="type">
                                        <option value="">All</option>
                                        <option value="sufficient">Sufficient</option>
                                        <option value="insufficient">Insufficient</option>
                                    </select>                                
                                </div>
                                <div class="btn-group">
                                    <a href="javascript:;" id="search" class="btn sbold green"> Search </a>
                                </div>
                            </div>
                            <!-- <div class="col-md-2" style="margin-bottom: 5px;">
                                <div class="btn-group fRight">
                                    <a href="javascript:;" id="excel" class="btn sbold green"> Excel </a>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Limit & Balance Report</span>
                                    </div>
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class=" dataTables_scrollHead">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Party</th>
                                                    <th>Balance</th>
                                                    <th>Limit</th>
                                                    <th>TransConsum</th>
                                                    <th>FinalLimit</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report_data">
                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                                <tr>
                                                    <th id="serial">0</th>
                                                    <th>Party</th>
                                                    <th id="balance">0</th>
                                                    <th id="limit">0</th>
                                                    <th id="tran_consum">0</th>
                                                    <th id="final_limit">0</th>
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
            url: `${window.pageData.baseUrl}/api/limit_balance_report`,
            enctype: 'multipart/form-data',
            data: {type:$('#type').val()},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    
                    var last_serial=0;
                    var balance_total=0;
                    var limit=0;
                    var tran_consum=0;
                    var final_limit=0;
                    $.each(res.data, function (key, balance) {
                        var serial=parseFloat(key)+1;
                        html +='<tr><td>'+serial+'</td><td>'+balance['name']+'</td><td>'+balance['balance']+'</td><td>'+balance['limit']+'</td><td>'+balance['TransConsum']+'</td><td>'+balance['TransConsum']+'</td></tr>';
                        last_serial=serial;
                        balance_total=parseFloat(balance_total)+parseFloat(balance['balance']);
                        limit=parseFloat(limit)+parseFloat(balance['limit']);
                        tran_consum=parseFloat(tran_consum)+parseFloat(balance['TransConsum']);
                        final_limit=parseFloat(final_limit)+parseFloat(balance['TransConsum']);
                    });
                    $("#report_data").append(html);
                    $("#serial").text(last_serial);
                    $("#balance").text(balance_total);
                    $("#limit").text(limit);
                    $("#tran_consum").text(tran_consum);
                    $("#final_limit").text(final_limit);
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
