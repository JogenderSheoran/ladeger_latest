@extends('layouts.master') 
@section('content')
<style>
    .dataTables_filter{
        display:none;
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
                                <span>Agents</span>
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
                                            <span class="caption-subject bold uppercase">Agents</span>
                                        </div>
                                        <div class="tools"> </div>
                                        
                                        {{-- Add Shift --}}
                                            <div class="btn-group fRight">
                                                <a  href="javascript:;" id="addShiftButton" class="btn sbold green"> Add (F2) </a>
                                            </div>
                                        
                                    </div>
                                    
                                    
                                    <div class="portlet-body">
                                        
                                        <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Group</th>
                                                    <th>Agent</th>
                                                    <th>Parent Agent</th>
                                                    <th>Update By</th>
                                                    <th>Update Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                                @foreach($data as $key => $value)
                                                    <tr id="row{{$value->id}}">
                                                        <td>{{++$key}}</td>
                                                        <td>{{$value->group}}</td>
                                                        <td>{{$value->agent}}</td>
                                                        <td>{{$value->parent_agent}}</td>
                                                        <td>{{$value->updated_by}}</td>
                                                        <td>{{date('d-m-Y h:i a',strtotime($value->updated_at))}}</td>  
                                                        <td> <button class="btn btn-sm btn-circle btn-primary" onClick="editShift({{$value->id}})"> Action </button> </td>                                                        
                                                    </tr>   
                                                    <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
                                                    <span class="rowDate{{$value->id}} hide" >{{$value->active}}</span>
                                                @endforeach

                                            </tbody>

                                            <tfoot class="dataTables_scrollHead">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Group</th>
                                                    <th>Agent</th>
                                                    <th>Parent Agent</th>
                                                    <th>Update By</th>
                                                    <th>Update Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title">Add Shift</h4>
            </div>
            <form id="add_shift">
                {{ csrf_field() }}
                <input type="hidden"   name="id" id="id"  value="">
                <input type="hidden"   name="updated_by" id="updatedBy"  value="{{Auth::user()->company}}">
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Agent Name</label>
                                    <input type="text" name="agent" id="agent" required class="form-control"/> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Main Agent Name</label>
                                    <input type="text" name="maine_agent" id="maine_agent" required class="form-control"/> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Parent Agent Name</label><br/>
                                    <input type="text" name="parent_agent" id="parent_agent"  class="form-control"/> 
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
                    url: `${window.pageData.baseUrl}/api/add_agent`,
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

        $("#model_title").text("Edit Shift");
        $('#addShift').modal('show');
        var ids="#row"+id; 
        var currentRow=$(ids).closest("tr");

        $("#id").val(id);
        $("#agent").val(currentRow.find("td:eq(1)").text());
        $("#maine_agent").val(currentRow.find("td:eq(2)").text());
        $("#parent_agent").val(currentRow.find("td:eq(3)").text());   

    }

</script>    
@endsection
