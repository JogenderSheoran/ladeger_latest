@extends('layouts.master') 
@section('content')
<style>
    .text-size{
        font-size:12px !important;
        color:#736666;
        font-weight: bold;
    }
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
                                <span>Staff</span>
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
                                        <div class="caption font-dark">
                                            <span class="caption-subject bold uppercase">Staff</span>
                                        </div>
                                        <div class="tools"> </div>
                                        
                                        {{-- Add Shift --}}
                                            <div class="btn-group fRight">
                                                <a  href="javascript:;" id="addShiftButton" class="btn sbold green add_button"> Add (F2) </a>
                                            </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="portlet-body table-both-scroll">
                                <table class="table table-striped table-bordered table-hover order-column" id="mytable">
                                    <thead class="dataTables_scrollHead" style="width:98.7% !important">
                                        <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Username</th>
                                                    <th style="display:none;">Email</th>
                                                    <th>Role</th>
                                                    <th>Mobile</th>
                                                    <th>Address</th>
                                                    <th>IsActive</th>
                                                    <th>Update By</th>
                                                    <th>Update Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody style="text-align:center">
                                                
                                                @foreach($data as $key => $value)
                                                    <tr id="row{{$value->id}}">
                                                        <td class="text-size">{{++$key}}</td>
                                                        <td class="text-size">{{$value->name}}</td>
                                                        <td class="text-size" style="display:none;">{{$value->email}}</td>
                                                        <td class="text-size">{{$value->is_admin}}</td> 
                                                        <td class="text-size">{{$value->mobile}}</td>
                                                        <td class="text-size short">{{$value->address}}</td>
                                                        <td class="text-size"><button @if($value->active == 'on')<button class="btn btn-primary btn-circle" style="background-color:green;border-color:green;"><b>Active</b></button>@else <button class="btn btn-primary btn-circle" style="background-color:red;border-color:red;"><b>In Active</b></button> @endif </td>
                                                        <td class="text-size">{{$value->updatedBy}}</td>
                                                        <td class="text-size">{{date('d-m-Y h:i a',strtotime($value->updated_at))}}</td>                                                     
                                                        <td class="text-size">
                                                        <a href="javascript:void(0)"  onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"
                                                            ></i></a>&nbsp;&nbsp;    
                                                        <a href="javascript:void(0)"><i class="fa fa-edit" style="color:blue;" onClick="editShift({{$value->id}})"> </i></a>
                                                         </td>                                                        
                                                    </tr>   
                                                    {{--<span id="rowAgent{{$value->id}}" class="hide">{{$value->agent}}</span>--}}
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


<!-- Add shift modal -->
<div class="modal fade bs-modal-lg" id="addShift" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header model_custom_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title">Add Staff</h4>
            </div>
            <form id="add_shift">
                {{ csrf_field() }}
                <input type="hidden"   name="id" id="id"  value="">
                <input type="hidden"   name="user_id"   value="{{Auth::user()->id}}">
                <input type="hidden"   name="updatedBy" id="updatedBy"  value="{{Auth::user()->name}}">
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
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
                                    <label class="control-label">Password</label><br/>
                                    <input type="password" id="password" name="password" class="input-group form-control form-control-inline" value="" required >                  
                                               
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" required class="form-control"/> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Role</label><br/>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="super_admin" selected>Super Admin</option>
                                        <option value="admin">Admin</option>
                                        <option value="all_data_entry">All Data Entry</option>
                                        <option value="data_entry">Data Entry</option>
                                    </select>
                                </div>
                            </div>

                           {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Agent</label><br/>
                                    <select class="form-control" id="agent" name="agent" required>
                                        @foreach($agents as $Akey => $Aval)
                                            <option value="{{$Aval->id}}" >{{$Aval->agent}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>--}}

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input type="text" name="address" id="address"  class="form-control"/> 
                                </div>
                            </div> 

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
<!--Add shift modal -->
<!--Delete shift modal -->
<div class="modal fade" id="deleteStaff" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete Staff</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="staff_id" id="staff_id">
                        <p>Are you sure to delete this staff?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="deleteStaff()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
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
        $("#model_title").text("Add Staff").css({ 'font-weight': 'bold' });
        $('#addShift').modal('show');
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
                    url: `${window.pageData.baseUrl}/api/add_shaff`,
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

        $("#model_title").text("Edit Staff").css({ 'font-weight': 'bold' });
        $('#addShift').modal('show');
        var ids="#row"+id; 
        var currentRow=$(ids).closest("tr");

        $("#id").val(id);
        $("#name").val(currentRow.find("td:eq(1)").text());
        $("#email").val(currentRow.find("td:eq(2)").text());
        $("#mobile").val(currentRow.find("td:eq(4)").text());   
        $("#address").val(currentRow.find("td:eq(5)").text());      

        $('select[name^="role"] option[value="'+currentRow.find("td:eq(2)").text()+'"]').attr("selected","selected");
        
        // var agentID = $("#rowAgent"+id).text();

        // $('select[name^="agent"] option[value="'+agentID+'"]').attr("selected","selected");
        
        var ActiveStatus = $(".rowDate"+id).text();
        if(ActiveStatus == "on"){
            $("#active").prop('checked', true);
            $("#inactive").prop('checked', false);
        }else{
            $("#active").prop('checked', false);
            $("#inactive").prop('checked', true);
        }
        
    }
    function setId(id) {
            $('#deleteStaff').modal('toggle');
            $("#staff_id").val(id);
        }
    
        function deleteStaff() {
            $.ajax({
                type: "POST",
                url: `${window.pageData.baseUrl}/api/delete_staff`,
                enctype: 'multipart/form-data',
                data: {
                    id: $("#staff_id").val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message, 'Success');
                        $('#deleteShift').modal('hide');
                        setInterval(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(data.message, 'Error');
                    }

                    $("#save").show();
                    $("#wait").hide();

                }
            });
        }

</script>    
@endsection
