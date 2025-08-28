@extends('layouts.master') 
@section('content')
    <style>
    .table-th{
        background-color:blue;
        color:white;
    }
    .td-small{
        font-size:10px;
        
    }
    .show {
  right: 5px;
}
.text-container {
  display: inline-block;
  position: relative;
  overflow: hidden;
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
                                <span>Shift</span>
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
                                            <span class="caption-subject bold uppercase">Shift</span>
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
                                                    <th>Shift Name</th>
                                                    <th>Open Date</th>
                                                    <th>Time</th>
                                                    <th>Next Day</th>
                                                    <th>IsActive</th>
                                                    <th>Update By</th>
                                                    <th>Update Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                                @foreach($data as $key => $value)
                                                    <tr id="row{{$value->id}}">
                                                        <td>{{++$key}}</td>
                                                        <td>{{$value->name}}</td>
                                                        <td>{{date('d-m-Y',strtotime($value->date))}}</td>
                                                        <td>{{$value->time}}</td>
                                                        <td>{{ucfirst($value->next_day)}}</td>
                                                        <td> <span class="btn btn-sm btn-circle @if($value->active == 'on') green @else red @endif" > @if($value->active == 'on') Active @else Inactive @endif </span>   </td>
                                                        <td>{{$value->updatedBy}}</td>
                                                        <td>{{date('d-m-Y h:i a',strtotime($value->updated_at))}}</td>
                                                        <td> <button class="btn btn-sm btn-circle btn-primary" onClick="editShift({{$value->id}})"> Action </button> </td>                                                        
                                                    </tr>   
                                                    <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title">Add Shift</h4>
            </div>
            <form id="add_shift">
                {{ csrf_field() }}
                <input type="hidden"   name="id" id="id"  value="">
                <input type="hidden"   name="updatedBy" id="updatedBy"  value="{{Auth::user()->company}}">
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">
                        <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th class="table-th">1</th>
                                                    <th class="table-th">2</th>
                                                    <th class="table-th">3</th>
                                                    <th class="table-th">4</th>
                                                    <th class="table-th">5</th>
                                                    <th class="table-th">6</th>
                                                    <th class="table-th">7</th>
                                                    <th class="table-th">8</th>
                                                    <th class="table-th">9</th>
                                                    <th class="table-th">10</th>
                                                    <th class="table-th">Total</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                                @foreach($data as $key => $value)
                                                    <tr>
                                                        <td class="td-small">
                                                            <div class="text-container">
                                                                <span id="clearBtn1" class="clearBtn show">X</span><input type="text" value="{{$key}}"></td>
                                                            </div>
                                                                <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td>
                                                        <td class="td-small">{{$key}}</td> 
                                                        <td class="td-small">{{$key}}</td>                                                        
                                                    </tr>   
                                                @endforeach
                                                <tr>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td>
                                                        <td class="table-th"></td> 
                                                        <td class="table-th"></td>                                                        
                                                    </tr>  
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td> 
                                                        <td></td>                                                        
                                                    </tr>   
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td> 
                                                        <td></td>                                                        
                                                    </tr>   

                                            </tbody>
                                            
                                            <tfooter>
                                                <tr>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">-</th>
                                                    <th class="table-th">Grand Total</th>
                                                    <th class="table-th"></th>
                                                </tr>
                                            </tfooter>
                                            
                                        </table>
                        </div>
                        <div class="row">
                            
                            
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
                    url: `${window.pageData.baseUrl}/api/add_shift`,
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
        $("#name").val(currentRow.find("td:eq(1)").text());
        $("#time").val(currentRow.find("td:eq(3)").text());
        $("#date").val($("#rowDate"+id).text());      

        $('select[name^="next_day"] option[value="'+currentRow.find("td:eq(4)").text()+'"]').attr("selected","selected");
        
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
@endsection
