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
                                   
                                    <!-- END PAGE TITLE -->
                                    <!-- BEGIN PAGE TOOLBAR -->
                                    <div class="page-toolbar">
                                        <!-- BEGIN THEME PANEL -->
                                       
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
                                    <ul class="page-breadcrumb breadcrumb">
                                        <li>
                                            <a href="index.html">Home</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <a href="#">Pages</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <span>User</span>
                                        </li>
                                    </ul>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="profile">
                                            <div class="row">
                                                <div class="col-md-4">
                                            
                                                <div class="tabbable-line tabbable-full-width">
                                                <form action="{{route('change_password')}}" method="POST">
                                                {{ csrf_field() }}
                                                    <label class="control-label">New Password</label>
                                                    <input type="password" name="password" class="form-control" /> </div>
                                                        <div class="margin-top-10">
                                                            <button type="submit" class="btn green"> Change Password </button>
                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
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
