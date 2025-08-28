@extends('layouts.master') 
@section('css')
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <link href="{{URL::asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="{{URL::asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
  <link href="{{URL::asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
@endsection
@section('content')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <div class="container">
                <!-- BEGIN PAGE TITLE -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="page-title">
                            <h4><b>Live Prediction</b></h4>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="page-title">
                            <h4><b>Shift</b></h4>
                        </div>
                    </div>
                    
                    <div class="col-md-2" style="float:left;">
                        <div class="page-title">
                            <select class="form-control" id="shift" name="shift" onchange="shift_data()" required>
                                <option  value="">Select Shift</option>
                                @foreach($shift as $s)
                                    <option  value="{{$s->id}}">{{ucfirst($s->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="page-title">
                            <h4><b>Date</b></h4>
                        </div>
                    </div>
                    <div class="col-md-2" style="float:left;">
                        <div class="page-title">
                            <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-md-2" style="float:left;">
                        <div class="page-title">
                            <button class="btn sbold green">Search</button>
                        </div>
                    </div>
                </div>
                <!-- END PAGE TITLE -->
                <!-- BEGIN PAGE TOOLBAR -->
                <div class="page-toolbar">
                    <!-- BEGIN THEME PANEL -->
                    <div class="btn-group btn-theme-panel">
                        <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
                    
                        </a>
                        <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <h3>THEME COLORS</h3>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- END THEME PANEL -->
                </div>
                <!-- END PAGE TOOLBAR -->
            </div>
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    
                    <div class="mt-bootstrap-tables">
                        
                        <div class="row">
                           {{-- <div class="col-md-2">
                                <div class="portlet light ">
                                    <div class="portlet-body">
                                        <table data-toggle="table"  data-height="299" data-sort-name="name" data-sort-order="desc">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-align="right" data-sortable="true">Result</th>
                                                    <th data-field="name" data-align="center" data-sortable="true">Number</th>
                                                    <th data-field="price" data-sortable="true">Sale</th>
                                                    <th data-field="amount" data-sortable="true">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>--}}
                            
                         

                            <div class="col-md-8">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                                <div class="portlet light portlet-fit ">
                                
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                    <form id="declare_number">
                                                        {{ csrf_field() }}
                                                        <th > Number </th>
                                                        <th> <input type="text" class="form-control" name="number" required> </th>
                                                        <th> <button type="submit" class="btn btn-primary"> Declare </button></th>
                                                        <th></th>
                                                    </form>
                                                    </tr>
                                                    <tr>
                                                        <th > Date </th>
                                                        <th>  Result </th>
                                                        <th>  Action </th>
                                                        <th>  Action </th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody id="prediction_data">
                                                    
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <!-- END BORDERED TABLE PORTLET-->
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
    <div id="myModal_autocomplete" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">ReDeclare Number</h4>
                </div>
                <div class="modal-body form">
                    <form id="redeclare_number" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Enter Number</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" id="" name="number" class="form-control" />
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="shift_id" name="shift_id">
                                </div>
                                <p class="help-block"> </p>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn green">
                        <i class="fa fa-check"></i> Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete modal -->
    <div id="deleteModal" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Delete Number</h4>
                </div>
                <div class="modal-body form">
                    <form id="delete_number" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <p>Are you sure to delete this number?</p>
                                    <input type="hidden" id="delete_id" name="id">
                                </div>
                                <p class="help-block"> </p>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">No</button>
                    <button type="submit" class="btn green">
                        <i class="fa fa-check"></i>Yes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script src="{{URL::asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{URL::asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{URL::asset('assets/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/pages/scripts/ui-confirmations.min.js')}}" type="text/javascript"></script>
<script>

    // F2
    document.onkeyup = KeyCheck;
    function KeyCheck(e)
    {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if(KeyID == 113)
        {
            $("#addJournalButton").click();
        }
    }
    // open model
    $("#addJournalButton").click(function(){
        $('#add_shift')[0].reset();
        $('#addJournal').modal('show');
    });

    // Declare number
    $(document).ready(function() {
        $('#declare_number').submit(function(e){

            if (!$("#shift").val()) {
                toastr.error('Select any shift to draw number!!', 'Error');
                return false;
            }
            e.preventDefault();
            var form = $('#declare_number')[0];
            var data = new FormData(form);    
            data.append('shift',$("#shift").val());       
            $("#save").hide(); 
            $("#wait").show(); 
            $.ajax({		            	
                type: "POST",
                url: `${window.pageData.baseUrl}/api/declare_number`,
                enctype: 'multipart/form-data',
                data: data,
                processData: false,
                contentType: false,
                cache: false,                                       
                success: function(data)
                {
                    if(data.status == true){
                        toastr.success(data.message, 'Success');
                        $('#addJournal').modal('hide');
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

    $(document).ready(function() {
        $('#redeclare_number').submit(function(e){
            e.preventDefault();
            var form = $('#redeclare_number')[0];
            var data = new FormData(form);          
            $("#save").hide(); 
            $("#wait").show(); 
            $.ajax({		            	
                    type: "POST",
                    url: `${window.pageData.baseUrl}/api/redeclare_number`,
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,                                       
                    success: function(data)
                    {
                        if(data.status == true){
                            toastr.success(data.message, 'Success');
                            $('#myModal_autocomplete').modal('toggle');
                            shift_data();                            
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

    $(document).ready(function() {
        $('#delete_number').submit(function(e){
            e.preventDefault();
            var form = $('#delete_number')[0];
            var data = new FormData(form);          
            $("#save").hide(); 
            $("#wait").show(); 
            $.ajax({		            	
                    type: "POST",
                    url: `${window.pageData.baseUrl}/api/remove_number`,
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,                                       
                    success: function(data)
                    {
                        if(data.status == true){
                            toastr.success(data.message, 'Success');
                            $('#addJournal').modal('hide');
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

    function shift_data(){
         var shift = $('#shift').val();
          var date = $('#date').val();
          $.ajax({		            	
                  type: "POST",
                  url: `${window.pageData.baseUrl}/api/prediction_data`,
                  enctype: 'multipart/form-data',
                  data: { shift: shift,date:date },
                  success: function(data)
                  {
                      console.log(data.today_count);
                    $("#prediction_data").empty();
                      if(data.status==true){
                          var html='';
                        for(var i=0; i<data['data'].length;i++){
                            var id=data['data'][i]['id'];
                            var shift_id=data['data'][i]['shift_id'];
                             html +='<tr><td>'+data['data'][i]['date']+'</td><td>'+data['data'][i]['number']+'</td><td><a href="#myModal_autocomplete" onclick="redeclare('+id+','+shift_id+')" role="button" class="label  label-sm label-success" data-toggle="modal">ReDeclare</a></td><td><a href="#deleteModal" onclick="delete_number('+id+')" role="button" class="label  label-sm label-danger" data-toggle="modal">Remove</a></td></tr>';
                        }
                        $("#prediction_data").append(html);
                      }

                      if(data.today_count > 0){
                          $('#date').val('dd-mm-yyyy');
                      }
                      
                  }
          });
  }

  

  //Redeclare number
  function redeclare(id,shift_id){
    $("#shift_id").val(shift_id);
    $("#id").val(id);
  }

  function delete_number(id){
    $("#delete_id").val(id);
  }

    // Edit Shift
    function editJournalVoucher(id){

        $("#model_title").text("Edit Shift");
        $('#addJournal').modal('show');
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
