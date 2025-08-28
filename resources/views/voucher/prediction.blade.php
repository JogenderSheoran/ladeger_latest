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
                                        @php dd($prediction); @endphp
                                        <div class="col-md-2" style="float:left;">
                                            <div class="page-title">
                                                <select class="form-control" id="shift" name="shift" required>
                                                    <option  selected>Select Shift</option>
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
                                              <input type="date" name="date" class="form-control">
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
                                                <div class="col-md-4">
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
                                                </div>
                                               
                                                <div class="col-md-4">
                                                <!-- BEGIN BORDERED TABLE PORTLET-->
                                                    <div class="portlet light portlet-fit ">
                                                    
                                                        <div class="portlet-body">
                                                            <div class="table-scrollable">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan="5">Number:0 | Loss:0</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th > Sr </th>
                                                                            <th> Party </th>
                                                                            <th> Sale </th>
                                                                            <th> P & L </th>
                                                                            <th> Last Win </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                           
                                                                        </tr>
                                                                    
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- END BORDERED TABLE PORTLET-->
                                                </div>

                                                <div class="col-md-4">
                                                <!-- BEGIN BORDERED TABLE PORTLET-->
                                                    <div class="portlet light portlet-fit ">
                                                    
                                                        <div class="portlet-body">
                                                            <div class="table-scrollable">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th > Number </th>
                                                                            <th> <input type="text" class="form-control"> </th>
                                                                            <th> <button class="btn btn-primary"> Declare </button></th>
                                                                            <th></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th > Date </th>
                                                                            <th>  Result </th>
                                                                            <th>  Action </th>
                                                                            <th>  Action </th>
                                                                           
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td > 1 </td>
                                                                            <td> Mark </td>
                                                                            <td> Otto </td>
                                                                            <td> makr124 </td>
                                                                            
                                                                        </tr>
                                                                    
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

@endsection
@section('js')
<script src="{{URL::asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{URL::asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{URL::asset('assets/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
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

    // Add Shift
    $(document).ready(function() {

        $('#add_journal_voucher').submit(function(e){
            e.preventDefault();
            var form = $('#add_journal_voucher')[0];
            var data = new FormData(form);            
            $("#save").hide(); 
            $("#wait").show(); 
            $.ajax({		            	
                    type: "POST",
                    url: `${window.pageData.baseUrl}/api/add_journal_voucher`,
                    enctype: 'multipart/form-data',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,                                       
                    success: function(data)
                    {
                        if(data.status == 'success'){
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
