@extends('layouts.master') 
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
                <div class="container">

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <select class="form-control" id="shift" onChange="fetch_transaction()">
                                        <option value="" selected disable>Select Shift</option>
                                       
                                    </select>                                
                                </div> 
                                <div class="btn-group">
                                    <input type="text" id="date" name="date" readonly class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <input type="text" id="keyword" name="keyword" class="input-group form-control form-control-inline" placeholder="Search Party" />                                 
                                </div> 
                                <div class="btn-group">
                                    <select class="form-control" id="staff" name="staff" onChange=fetch_transaction()>
                                       
                                    </select>                                
                                </div>
                                <div class="btn-group">
                                                                
                                </div> 
                                <div class="btn-group">
                                    <a href="javascript:;" id="search" class="btn sbold green"> Search (F5) </a>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Live Transaction</span>
                                    </div>
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                    <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Party</th>
                                                    <th style="text-align: center;">Opposite Party</th>
                                                    <th style="text-align: center;">Type</th>
                                                    <th style="text-align: center;">amount</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="transaction_data">
                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                                <tr>
                                                <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Party</th>
                                                    <th style="text-align: center;">Opposite Party</th>
                                                    <th style="text-align: center;">Type</th>
                                                    <th style="text-align: center;">amount</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="portlet-title"> 
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <select class="form-control" id="status" name="status" onChange=fetch_transaction()>
                                                <option value="0" selected>Active</option>
                                                <option value="1">Delete</option>
                                            </select>
                                        </div>
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f7" class="btn btn-success"> Main Jantri (F7) </a>
                                        </div>
                                        {{-- <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="hpl_jantri" class="btn btn-success"> HPL-Jantri </a>
                                        </div> --}}
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f3" class="btn btn-success"> Jantri View (F3) </a>
                                        </div>
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f2" class="btn btn-success"> Add (F2) </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row" style="margin-bottom: 1px;text-align: center;">
                                    <div class="col-md-12 bg-blue bg-font-blue"">
                                        <h5 class="sbold">Party</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 bg-blue bg-font-blue" style="text-align: center;">
                                        <h5 class="sbold">Number</h5>
                                    </div>
                                    <div class="col-md-6 bg-blue bg-font-blue"  style="text-align: center;">
                                        <h5 class="sbold">Amount</h5>
                                    </div>
                                </div>
                                <div class="details" style="height:370px; overflow-y: scroll;">

                                </div>
                            </div>
                        </div>           
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END PAGE CONTENT BODY -->
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection
@section('js')
<script>

    

    function fetch_transaction(){
        var shift=$('#shift').val();

        var table = $('#mytable').DataTable();
        table.destroy();
        $('#transaction_data').empty();
        $('.footer').hide();

        if (shift) {
            $.ajax({		            	
                type: "POST",
                url: "{{route('fetch_transaction')}}",
                enctype: 'multipart/form-data',
                data: {shift:shift,date:$('#date').val(),keyword:$('#keyword').val(),staff:$('#staff').val(),status:$('#status').val(),"_token": "{{ csrf_token() }}","user":{{Auth::User()->id}}},                                     
                success: function(res)
                {
                    if(res.status == 'success'){
                        var html='';
                        var last_serial=0;
                        var total=0;
                        $.each(res.data, function (key, value) {
                            var serial=parseFloat(key)+1;
                            last_serial=serial;
                            var url="{{url('edit-transaction')}}/"+value['id'];
                            if (value['status']==0) {
                                html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><a href="javascript:;" id="copy'+value['id']+'" class="btn btn-xs yellow" onclick="copy_transaction('+value['id']+')">Copy</a><a href="javascript:;" id="view'+value['id']+'" class="btn btn-xs green" onclick="transaction_detail('+value['id']+')">View</a><a href="'+url+'" id="edit'+value['id']+'" class="btn btn-xs blue">Edit</a><a href="javascript:;" id="delete'+value['id']+'" class="btn btn-xs red" onclick="delete_transaction('+value['id']+')"> Delete </a></td></tr>';
                            } else {
                                html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><spna style="color:red;">Deleted</span></td></tr>';
                            }
                            total=parseFloat(total)+parseFloat(value['total']);
                        });
                        $("#transaction_data").append(html)
                        $("#total").text(total);
                        $("#serial").text(last_serial);
                        $('.footer').show();

                        $('#mytable').DataTable({
                            "ordering": false,
                            "searching": false,
                            "paging": true,
                            "info": false,
                            scrollY: 250,
                            "scroller":true,
                        });
                    }
                    else{
                        toastr.error(res.message, 'Error');
                    }
                }
            });
        }
    }

    function delete_transaction(id){
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/delete_transaction`,
            enctype: 'multipart/form-data',
            data: {id:id},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    $('#delete'+id).hide();
                    toastr.success("Transaction deleted successfully", 'Success');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

    function transaction_detail(id){
        $(".details").empty()
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/transaction_detail`,
            enctype: 'multipart/form-data',
            data: {id:id},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    var numbers=JSON.parse(res.data.number);
                    var amounts=JSON.parse(res.data.amount);
                    $('#numbers').val(res.data.number);
                    $('#amounts').val(res.data.amount);
                    var html='';
                    for (let index = 0; index < amounts.length; index++) {
                        html +='<div class="row"><div class="col-md-6" style="text-align: center;"><h5 class="sbold">'+numbers[index]+'</h5></div><div class="col-md-6"  style="text-align: center;"><h5 class="sbold">'+amounts[index]+'</h5></div></div>';
                    }
                    $(".details").append(html)
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

  
    $("#search").click(function(){
        fetch_transaction();
    });


</script>    
@endsection
