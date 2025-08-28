@extends('layouts.master')
@section('content')
<style>
    .text-size{
        font-size:12px !important;
        color:#736666;
        font-weight: bold;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
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
                                        <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Shift</span>
                                     </div>
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 5px;"> 
                                        <div class="btn-group">
                                            <input type="text" id="shift_search" name="shift_name" class="input-group form-control form-control-inline">                                 
                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" id="search" class="btn sbold green"> Search </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="btn-group fRight">
                                        <a href="javascript:;" id="addShiftButton" class="btn sbold green add_button"> Add (F2) </a>
                                        </div>
                                    </div>
                                </div>
                               
                                {{-- Add Shift --}}
                                

                            </div>

                            
                            <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Shift Name</th>
                                            <th>Open Date</th>
                                            <th>Time</th>
                                            <th>Super Admin</th>
                                            <th>Admin</th>
                                            <th>All Data<br>Entry</th>
                                            <th>Data Entry</th>
                                            <th>Next Day</th>
                                            <th>IsActive</th>
                                            <th>Update By</th>
                                            <th>Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody  id="shift_body">

                                        @foreach($data as $key => $value)
                                        <tr id="row{{$value->id}}">
                                            <td class="text-size">{{++$key}}</td>
                                            <td class="text-size">{{$value->name}}</td>
                                            <td class="text-size">{{date('d-m-Y',strtotime($value->date))}}</td>
                                            <td class="text-size">{{$value->time}}</td>
                                            <td class="text-size">{{$value->super_admin_time}}</td>
                                            <td class="text-size">{{$value->admin_time}}</td>
                                            <td class="text-size">{{$value->all_data_entry_time}}</td>
                                            <td class="text-size">{{$value->data_entry_time}}</td>
                                            <td class="text-size">{{ucfirst($value->next_day)}}</td>
                                            <td class="text-size">
                                                 @if($value->active == 'on')
                                                 <button class="btn btn-primary btn-circle" style="background-color:green;border-color:green;"><b>Active</b></button>
                                                 @else 
                                                 <button class="btn btn-primary btn-circle" style="background-color:red;border-color:red;"><b>In Active</b></button>
                                                @endif 
                                            </td>
                                            <td class="text-size">{{$value->updatedBy}}</td>
                                            <td class="text-size">{{date('d-m-Y h:i a',strtotime($value->updated_at))}}</td>
                                            <td class="text-size"><a href="javascript:void(0)"  onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"
                                                   ></i></a>&nbsp;&nbsp;
                                                   <a href="javascript:void(0)"  onclick="editShift({{$value->id}})"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                        </tr>
                                        <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
                                        <span class="rowDate{{$value->id}} hide">{{$value->active}}</span>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                    <tr>
                                            <th>Sr. No.</th>
                                            <th>Shift Name</th>
                                            <th>Open Date</th>
                                            <th>Time</th>
                                            <th>Super Admin</th>
                                            <th>Admin</th>
                                            <th>All Data<br>Entry</th>
                                            <th>Data Entry</th>
                                            <th>Next Day</th>
                                            <th>IsActive</th>
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
            <div class="modal-header model_custom_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title">Add Shift</h4>
            </div>
            <form id="add_shift">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="updatedBy" id="updatedBy" value="{{Auth::user()->company}}">
                <div class="modal-body">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Shift Name</label>
                                    <input type="text" name="name" id="name" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Joined Date</label><br />
                                    <input type="date" id="date" name="joined_date"
                                        class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Next Day</label><br />
                                    <select class="form-control" id="next_day" name="next_day" required>
                                        <option value="No" selected>No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">OWNER</label> <br />
                                    <div class="input-group">
                                        <input type="time" name="time" id="time" class="form-control"
                                            value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Super Admin</label> <br />
                                    <div class="input-group">
                                        <input type="time" name="super_admin_time" id="super_admin_time"
                                            class="form-control" value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Admin</label> <br />
                                    <div class="input-group">
                                        <input type="time" name="admin_time" id="admin_time" class="form-control"
                                            value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">All Data Entry</label> <br />
                                    <div class="input-group">
                                        <input type="time" name="all_data_entry_time" id="all_data_entry_time"
                                            class="form-control" value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Data Entry</label> <br />
                                    <div class="input-group">
                                        <input type="time" name="data_entry_time" id="data_entry_time"
                                            class="form-control" value="{{date('H:i')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    <br />
                                    <label class="mt-radio">
                                        <input type="radio" name="active" id="active" value="on" checked=""> Active
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="active" id="inactive" value="off"> Inactive
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn green">Save</button>
                    <button style="display:none;" id="wait" class="btn yellow"><i class="icon-spinner"></i>Please
                        Wait...</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Delete shift modal -->
<div class="modal fade" id="deleteShift" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete Shift</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="shift_id" id="shift_id">
                        <p>Are you sure to delete this shift?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="deleteShift()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
@section('js')
<script>
    $(document).ready(function () {
                // F2
        document.onkeyup = KeyCheck;

        function KeyCheck(e) {
            var KeyID = (window.event) ? event.keyCode : e.keyCode;
            if (KeyID == 113) {
                $("#addShiftButton").click();
            }
        }

        // open model
        $("#addShiftButton").click(function () {
            $('#add_shift')[0].reset();
            $("#model_title").text("Add Shift").css({ 'font-weight': 'bold' });
            $('#addShift').modal('show');
        });

        // Add Shift
        $(document).ready(function () {

            $('#add_shift').submit(function (e) {
                e.preventDefault();
                var form = $('#add_shift')[0];
                var data = new FormData(form);
                $("#save").hide();
                $("#wait").show();
                $.ajax({
                    type: "POST",
                    url: `${window.pageData.baseUrl}/api/add_shift`,
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 'success') {
                            toastr.success(data.message, 'Success');
                            $('#addShift').modal('hide');
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
            });
        });

        // Edit Shift
      

       
    });
    function setId(id) {
            $('#deleteShift').modal('toggle');
            $("#shift_id").val(id);
        }
    
        function deleteShift() {
            $.ajax({
                type: "POST",
                url: `${window.pageData.baseUrl}/api/delete_shift`,
                enctype: 'multipart/form-data',
                data: {
                    id: $("#shift_id").val(),
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

        function editShift(id) {

            $("#model_title").text("Edit Shift").css({ 'font-weight': 'bold' });
            $('#addShift').modal('show');
            var ids = "#row" + id;
            var currentRow = $(ids).closest("tr");
            

            

            $("#id").val(id);
            $("#name").val(currentRow.find("td:eq(1)").text());
            $("#time").val(currentRow.find("td:eq(3)").text());
            $("#super_admin_time").val(currentRow.find("td:eq(4)").text());
            $("#admin_time").val(currentRow.find("td:eq(5)").text());
            $("#all_data_entry_time").val(currentRow.find("td:eq(6)").text());
            $("#data_entry_time").val(currentRow.find("td:eq(7)").text());
            $("#date").val($("#rowDate" + id).text());

            $('select[name^="next_day"] option[value="' + currentRow.find("td:eq(4)").text() + '"]').attr(
                "selected", "selected");

            var ActiveStatus = $(".rowDate" + id).text();
            if (ActiveStatus == "on") {
                $("#active").prop('checked', true);
                $("#inactive").prop('checked', false);
            } else {
                $("#active").prop('checked', false);
                $("#inactive").prop('checked', true);
            }



}
$("#search").click(function(){

$.ajax({		            	
    type: "POST",
    url: `${window.pageData.baseUrl}/api/search_shift`,
    enctype: 'multipart/form-data',
    data: {shift_name:$('#shift_search').val()},                                     
    success: function(res)
    {
        // console.log(res);
        if(res.status == 'success'){
           $("#shift_body").empty();
            var html='';
            var active='';
            var action='';
            console.log(res.data);
            $.each(res.data, function (key, shift) {
                var serial=parseFloat(key)+1;
                if(shift['active']=='on'){
                    active='<button class="btn btn-primary btn-circle" style="background-color:green;border-color:green;">Active</button>';
                }
                else{
                    active='<button class="btn btn-primary btn-circle" style="background-color:red;border-color:red;">In Active</button>';
                }
                action='<a href="javascript:void(0)"  onclick="setId('+shift[id]+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;'
                       +'<a href="javascript:void(0)"  onclick="editShift('+shift['id']+')"><i class="fa fa-edit" style="color:blue;"></i></a>';
                html +='<tr id="row'+shift['id']+'"><td class="text-size">'+serial+'</td><td class="text-size" id="shift_name">'+shift['name']+'</td><td class="text-size">'+shift['date']+'</td><td class="text-size" id="time">'+shift['time']+'</td><td class="text-size" id="shift_admin_time">'+shift['super_admin_time']+'</td><td class="text-size" id="shift_admin_time">'+shift['admin_time']+'</td><td class="text-size" id="shift_all_data_entry_time">'+shift['all_data_entry_time']+'</td class="text-size" id="shift_data_entry_time"><td>'+shift['data_entry_time']+'</td class="text-size" id="shift_next_day"><td>'+shift['next_day']+'</td class="text-size" id="shift_active"><td>'+active+'</td><td class="text-size">'+shift['updatedBy']+'</td><td class="text-size">'+shift['new_updated_at']+'</td><td class="text-size">'+action+'</td><span id="rowDate'+shift['id']+'" class="hide">'+shift['date']+'</span><span class="rowDate'+shift['id']+' hide">'+shift['active']+'</span></tr>';
            });
            $("#shift_body").append(html);
        }
        else{
            toastr.error(res.message, 'Error');
        }
    }
});
});
$('#mytable').DataTable({
    "ordering": false,
    "searching": false,
    "paging": true,
    "info": false,
    scrollY: 280,
    "scroller":true,
});

$("#shift_search").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#search").click();
    }
});
</script>
@endsection