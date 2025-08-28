@extends('layouts.master') 
@section('content')
<style>
    table,
    th,
    td {
        text-align: center;
    }

    table tbody {
        display: block;
        height: 300px !important;
        overflow-y: scroll;
    }

    table thead,
    table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>

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
                                <span>Punter ID</span>
                            </li>
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    
                                    <div class="portlet-title">
                                    <div class="row">

                                    <div class="col-md-1">
                                        <h6><b>Search</b></h6>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="page-title">
                                            <input type="text" name="search" id="search_punter_id" class="form-control">
                                        </div>
                                        <div id="searchList"></div>
                                    </div>
                                    <div class="col-md-1" style="float:left;">
                                        <div class="page-title">
                                            <button class="btn sbold green" id="search">Search</button>
                                        </div>
                                    </div>
                                        <div class="btn-group fRight">
                                            <a  href="javascript:;" id="addShiftButton" class="btn sbold green add_button"> Add (F2) </a>
                                        </div>
                                    </div>
                                        
                                        {{-- Add Shift --}}
                                           
                                        
                                    </div>
                                    
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-striped table-bordered table-hover order-column" id="mytable">
                                        <thead class="dataTables_scrollHead" style="width:98.7% !important">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Company</th>
                                                    <th style="width:190px;">Email</th>
                                                    <th>Mobile</th>
                                                    <th>Ledger</th>
                                                    <th>Type</th>
                                                    <th>Guarantor</th>
                                                    <th>Address</th>
                                                    <th>IsActive</th>
                                                    <th>Update By</th>
                                                    <th>Update Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="punter_body">
                                                
                                                @foreach($data as $key => $value)
                                                    <tr id="row{{$value->id}}">
                                                        <td>{{++$key}}</td>
                                                        <td>{{$value->name}}</td>
                                                        <td style="width:190px;">{{$value->email}}</td> 
                                                        <td>{{$value->mobile}}</td>
                                                        <td>{{$value->ledger_name}}</td>
                                                        <td>{{$value->type}}</td> 
                                                        <input type="hidden" id="ledger_id" value="{{$value->ledger_id}}">
                                                        <td>{{$value->guarantor}}</td>
                                                        <td class="short">{{$value->address}}</td>
                                                        <td> <span class="btn btn-sm btn-circle @if($value->active == 'on') green @else red @endif" > @if($value->active == 'on') Active @else Inactive @endif </span>   </td>
                                                        <td>{{$value->updatedBy}}</td>
                                                        <td>{{date('d-m-Y h:i a',strtotime($value->updated_at))}}</td>                                                     
                                                        <td> <button class="btn btn-sm btn-circle btn-primary" onClick="editShift({{$value->id}})"> Action </button> </td>                                                        
                                                    </tr>   
                                                    <span id="rowAgent{{$value->id}}" class="hide">{{$value->agent}}</span>
                                                    <span class="rowDate{{$value->id}} hide" >{{$value->active}}</span>
                                                @endforeach

                                            </tbody>

                                           
                                        </table>
                                    </div>
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

    <div class="modal fade bs-modal-lg" id="addShift"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header model_custom_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title"><b>Add Punter Id</b></h4>
            </div>
            <form id="add_shift">
                {{ csrf_field() }}
                <input type="hidden"   name="id" id="id"  value="">
                <input type="hidden"   name="user_id"   value="{{Auth::user()->id}}">
                <input type="hidden"   name="updatedBy" id="updatedBy"  value="{{Auth::user()->company}}">
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Company Name</label>
                                        <input type="text" name="name" id="name" required class="form-control"/> 
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" id="email" required class="form-control"/> 
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <div class="form-group">
                                        <label class="control-label">Password</label><br/>
                                        <input type="password" id="password" name="password" class="input-group form-control form-control-inline" value="" required >                  
                                    </div>
                                </div>
                            </div>

                          
                            <div class="col-md-3">
                                <div class="form-group">
                                <div class="form-group">
                                        <label class="control-label">Mobile</label>
                                        <input type="text" name="mobile" id="mobile" required class="form-control"/> 
                                    </div>
                                </div> 
                            </div>

                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Guarantor</label>
                                <input type="text" name="guarantor" id="guarantor"  class="form-control"/> 
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <input type="text" name="address" id="address"  class="form-control"/> 
                            </div>
                        </div> 
                  

                        <div class="col-md-3">
                            <div class="form-group">
                            <label class="control-label">Leger</label><br/>
                                <select id="span_small" name="ledger" class="form-control select2">
                                     <option>Select Ledger</option>
                                    @foreach($ledger as $l)
                                    <option value="{{$l->id}}">{{$l->name}}</option>
                                    @endforeach                              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Type</label><br/>
                                <select name="type" id="app_type" class="form-control" name="group" required>
                                    <option>Select Type</option>
                                    <option value="mobile">Mobile</option>
                                    @if(Auth::user()->is_admin!='id_cutter')
                                    <option value="web">Web</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Status</label>
                                            <br/>
                                            <label class="mt-radio">
                                                <input type="radio" name="active" id="active" value="on" checked=""> Active
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                <input type="radio" name="active" id="inactive" value="off" > Inactive
                                                <span></span>
                                            </label>
                                        </div> 
                                </div>
                            </div>
                    </div>
                    </div>
                </div>

                <div class="modal-footer">               
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn green">Save</button> 
                    <button style="display:none;" id="wait" class="btn yellow"><i class="icon-spinner"></i>Please Wait...</button>    
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal-dialog -->
</div>


@endsection
@section('js')
<script>



    // F2
    document.onkeyup = KeyCheck;
    function KeyCheck(e)
    {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if(KeyID == 113)
        {
            $("#addShiftButton").click();
        }
    }

    // open model
    $("#addShiftButton").click(function(){
        $('#add_shift')[0].reset();
        $('#addShift').modal('show');
    });

    //Dara + Commission
    $('#dara').on("keyup", function(e) {
        if(e.keyCode >= 37 && e.keyCode <= 40) {
            e.stopImmediatePropagation();
            return;
        }
        var dara_rate=$("#dara").val();
        if(dara_rate < 0 || dara_rate > 100 || dara_rate==''){
            $("#dara").val('');
            $("#dara_commission").val('');
        }
        else{
            var dara_commission=100-dara_rate;
            $("#dara_commission").val(dara_commission);
        }
    });

    $('#dara_commission').on("keydown", function(e) {   
        e.preventDefault();
    });

    // Add Shift
    $(document).ready(function() {

        $('#add_shift').submit(function(e){
            e.preventDefault();
            var form = $('#add_shift')[0];
            var data = new FormData(form);            
            $("#save").hide(); 
            $("#wait").show(); 
            $.ajax({		            	
                type: "POST",
                url: `${window.pageData.baseUrl}/api/add_id_cutter`,
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,                                       
                success: function(data)
                {
                    if(data.status == 'success'){
                        toastr.success(data.message, 'Success');
                        $('#addShift').modal('hide');
                        setInterval(function() {
                            location.reload();
                        }, 2000);                            
                    }
                    else{
                        toastr.error(data.message, 'Error');
                    }
                    
                    $("#save").show(); 
                    $("#wait").hide();

                }
            });
        });
    });

    // Edit Shift
    function editShift(id){

        var ledger_id=$("#ledger_id").val();
        $("#model_title").text("Edit Punter ID");
        $('#addShift').modal('show');
        var ids="#row"+id; 
        var currentRow=$(ids).closest("tr");
            
      
      
        $('#password').removeAttr('required');

       
        $("#id").val(id);
        $("#name").val(currentRow.find("td:eq(1)").text());
        $("#email").val(currentRow.find("td:eq(2)").text());
        $("#mobile").val(currentRow.find("td:eq(3)").text());  
        $("#guarantor").val(currentRow.find("td:eq(6)").text());  
        $("#address").val(currentRow.find("td:eq(7)").text());
        // $('select[name^="ledger"] option[value="'+$("#ledger_id").val()+'"]').attr("selected","selected");
        $("#span_small").select2("val",$("#ledger_id").val());
        $('select[name^="type"] option[value="'+currentRow.find("td:eq(5)").text()+'"]').attr("selected","selected");
               
        var ActiveStatus = $(".rowDate"+id).text();
        if(ActiveStatus == "on"){
            $("#active").prop('checked', true);
            $("#inactive").prop('checked', false);
        }else{
            $("#active").prop('checked', false);
            $("#inactive").prop('checked', true);
        }
    }

    

</script>    
<script>

 $('#search_punter_id').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url: `${window.pageData.baseUrl}/api/autocompelete_punter_id`,
          method:"POST",
          data:{name:query, _token:_token},
          success:function(data){
            $('#searchList').fadeIn();  
            $('#searchList').html(data.data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#search_punter_id').val($(this).text());  
        $('#searchList').fadeOut();  
    }); 

    $("#search").click(function(){
    $.ajax({		            	
        type: "POST",
        url: "{{route('search_punter_data')}}",
        enctype: 'multipart/form-data',
        data: {punter_name:$('#search_punter_id').val(),_token: '{!! csrf_token() !!}',},                                     
        success: function(res)
        {
            // console.log(res);
            if(res.status == 'success'){
            $("#punter_body").empty();
                var html='';
                var company='';
                var active='';
                var address='';
                var action='';
                $.each(res.data, function (key, punter) {
                var serial=parseFloat(key)+1;
                if(punter['address']==''){
                    address='';
                }
                else{
                    address=punter['address'];
                }
                if(punter['active']=='on'){
                    active='<button class="btn btn-primary btn-circle" style="background-color:green;border-color:green;">Active</button>';
                }
                else{
                    active='<button class="btn btn-primary btn-circle" style="background-color:red;border-color:red;">In Active</button>';
                }
                action='<button class="btn btn-sm btn-circle btn-primary" onclick="editShift('+punter['id']+')">Action</button>';

                    html +='<tr id="row'+punter['id']+'"><input type="hidden" id="ledger_id" value="'+punter['ledger_id']+'"><td class="text-size">'+serial+'</td><td class="text-size" id="punter_name">'+punter['name']+'</td><td class="text-size" style="width:190px;">'+punter['email']+'</td><td class="text-size">'+punter['mobile']+'</td><td class="text-size">'+punter['ledger_name']+'</td><td class="text-size">'+punter['type']+'</td><td class="text-size">'+punter['guarantor']+'</td><td></td><td>'+active+'</td><td class="text-size">'+punter['updated_by']+'</td><td class="text-size">'+punter['new_updated_at']+'</td><td class="text-size">'+action+'</td></tr>';
                });
                $("#punter_body").append(html);
            }
            else{
                toastr.error(res.message, 'Error');
            }
        }
    });
}); 

  

</script>
@endsection
