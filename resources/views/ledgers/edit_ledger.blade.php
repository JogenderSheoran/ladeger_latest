@extends('layouts.master')
@section('css')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{URL::asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet"
    type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{URL::asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components"
    type="text/css" />
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
            <div class="page-title">
                <h1>Ledger
                   
                </h1>
            </div>
            <!-- END PAGE TITLE -->
            <!-- BEGIN PAGE TOOLBAR -->
            <div class="page-toolbar">
                <!-- BEGIN THEME PANEL -->
                <div class="btn-group btn-theme-panel">
                    <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-settings"></i>
                    </a>
                    <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <h3>THEME COLORS</h3>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <ul class="theme-colors">
                                            <li class="theme-color theme-color-default" data-theme="default">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Default</span>
                                            </li>
                                            <li class="theme-color theme-color-blue-hoki" data-theme="blue-hoki">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Blue Hoki</span>
                                            </li>
                                            <li class="theme-color theme-color-blue-steel" data-theme="blue-steel">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Blue Steel</span>
                                            </li>
                                            <li class="theme-color theme-color-yellow-orange"
                                                data-theme="yellow-orange">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Orange</span>
                                            </li>
                                            <li class="theme-color theme-color-yellow-crusta"
                                                data-theme="yellow-crusta">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Yellow Crusta</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <ul class="theme-colors">
                                            <li class="theme-color theme-color-green-haze" data-theme="green-haze">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Green Haze</span>
                                            </li>
                                            <li class="theme-color theme-color-red-sunglo" data-theme="red-sunglo">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Red Sunglo</span>
                                            </li>
                                            <li class="theme-color theme-color-red-intense" data-theme="red-intense">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Red Intense</span>
                                            </li>
                                            <li class="theme-color theme-color-purple-plum" data-theme="purple-plum">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Purple Plum</span>
                                            </li>
                                            <li class="theme-color theme-color-purple-studio"
                                                data-theme="purple-studio">
                                                <span class="theme-color-view"></span>
                                                <span class="theme-color-name">Purple Studio</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 seperator">
                                <h3>LAYOUT</h3>
                                <ul class="theme-settings">
                                    <li> Theme Style
                                        <select
                                            class="theme-setting theme-setting-style form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Change theme style" data-container="body"
                                            data-placement="left">
                                            <option value="boxed" selected="selected">Square corners</option>
                                            <option value="rounded">Rounded corners</option>
                                        </select>
                                    </li>
                                    <li> Layout
                                        <select
                                            class="theme-setting theme-setting-layout form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Change layout type" data-container="body"
                                            data-placement="left">
                                            <option value="boxed" selected="selected">Boxed</option>
                                            <option value="fluid">Fluid</option>
                                        </select>
                                    </li>
                                    <li> Top Menu Style
                                        <select
                                            class="theme-setting theme-setting-top-menu-style form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Change top menu dropdowns style" data-container="body"
                                            data-placement="left">
                                            <option value="dark" selected="selected">Dark</option>
                                            <option value="light">Light</option>
                                        </select>
                                    </li>
                                    <li> Top Menu Mode
                                        <select
                                            class="theme-setting theme-setting-top-menu-mode form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Enable fixed(sticky) top menu" data-container="body"
                                            data-placement="left">
                                            <option value="fixed">Fixed</option>
                                            <option value="not-fixed" selected="selected">Not Fixed</option>
                                        </select>
                                    </li>
                                    <li> Mega Menu Style
                                        <select
                                            class="theme-setting theme-setting-mega-menu-style form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Change mega menu dropdowns style" data-container="body"
                                            data-placement="left">
                                            <option value="dark" selected="selected">Dark</option>
                                            <option value="light">Light</option>
                                        </select>
                                    </li>
                                    <li> Mega Menu Mode
                                        <select
                                            class="theme-setting theme-setting-mega-menu-mode form-control input-sm input-small input-inline tooltips"
                                            data-original-title="Enable fixed(sticky) mega menu" data-container="body"
                                            data-placement="left">
                                            <option value="fixed" selected="selected">Fixed</option>
                                            <option value="not-fixed">Not Fixed</option>
                                        </select>
                                    </li>
                                </ul>
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
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">Ledger</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Edit Ledger</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-shopping-cart"></i>Edit Ledger</div>
                                    <div class="actions btn-set">
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tabbable-bordered">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_general" data-toggle="tab"> Info </a>
                                            </li>
                                           
                                        </ul>
                                        
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_general">
                                                
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="col-md-3">
                                                            <label>Ledger</label>
                                                            <input type="text" class="form-control"
                                                                value="{{$data->name}}" id="ledger_name" name="name" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                    <input type="hidden" id="ledger_id" value="{{$data->id}}">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Real Name</label>
                                                            <input type="text" id="realname" class="form-control" name="realname"
                                                                value="{{$data->username}}" placeholder="">
                                                        </div>
                                                      
                                                        <div class="col-md-2">
                                                            <label>Mobile</label>
                                                            <input type="text" id="mobile" class="form-control" name="mobile"
                                                                value="{{$data->mobile}}" placeholder="">
                                                        </div>
                                                       

                                                    </div><br>
                                                    <button type="button" id="update_basic_detail" class="btn btn-success">
                                                    <i class="fa fa-check"></i>Save</button>
                                                </div>
                                            </div>
                                            
                                           
                                            
                                        </div>
                                      
                                    </div>
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
<script src="{{URL::asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.js')}}" type="text/javascript">
</script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{URL::asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{URL::asset('assets/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')}}"
    type="text/javascript"></script>
<script src="{{URL::asset('assets/pages/scripts/ui-confirmations.min.js')}}" type="text/javascript"></script>
<script>
    // F2
    document.onkeyup = KeyCheck;

    function KeyCheck(e) {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if (KeyID == 113) {
            $("#addJournalButton").click();
        }
    }
    // open model
    $("#addJournalButton").click(function () {
        $('#add_shift')[0].reset();
        $('#addJournal').modal('show');
    });

    $('#akhar').on("keyup", function (e) {
        if (e.keyCode >= 37 && e.keyCode <= 40) {
            e.stopImmediatePropagation();
            return;
        }
        var akhar_rate = $("#akhar").val();
        if (akhar_rate < 0 || akhar_rate == '' || akhar_rate > 10) {
            $("#akhar").val('');
            $("#akhar_commission").val('');
        } else {
            var akhar_commission = (10- akhar_rate) * 10;
            $("#akhar_commission").val(akhar_commission);
        }
    });

    $('#dara').on("keyup", function (e) {
        if (e.keyCode >= 37 && e.keyCode <= 40) {
            e.stopImmediatePropagation();
            return;
        }
        var dara_rate = $("#dara").val();
        if (dara_rate < 0 || dara_rate == '') {
            $("#dara").val('');
            $("#dara_commission").val('');
        } else {
            var dara_commission = 100 - dara_rate;
            $("#dara_commission").val(dara_commission);
        }
    });
   

   

    // Edit Shift

    $(document).ready(function() {
    var max_fields      = 25; //maximum input boxes allowed
    var wrapper         = $(".thpc_table"); //Fields wrapper
    var selfwrapper     = $(".thpc_self_table");
    var add_button      = $(".add_thpc_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        // alert("hi");
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            
            var data_id = Math.floor(1000 + Math.random() * 9000);

            var wrapper_id="wrapper"+data_id;
            var selfwrapper_id="selfwrapper"+data_id;

            var thpc_id=$("#thpc_name").val();
            // alert(thpc_id);
            var thpc_name=$('select[name=thpc_name]').find(':selected').text();
            // alert(thpc_name);
            var thpc_dara=$("#thpc_dara").val();
            var thpc_aakhar=$("#thpc_aakhar").val();

            if(thpc_name!='' && thpc_dara!='' && thpc_aakhar!=''){
                //  $(wrapper).append('<tr id="'+wrapper_id+'"><td><input type="text" class="form-control" value="'+thpc_name+'" name="thpc_name[]"></td><td><input type="text" class="form-control" value="'+thpc_dara+'" name="thpc_dara[]"></td><td><input type="text" class="form-control" value="'+thpc_aakhar+'" name="thpc_aakhar[]"><input type="hidden" class="form-control" value="'+thpc_id+'" name="thpc_id[]"></td><tr>'); //add input box
                 $(selfwrapper).append('<tr id="'+selfwrapper_id+'"><td><input type="text" class="form-control" name="thpc_name[]" value="'+thpc_name+'">'
                                        +'<td><input type="number" class="form-control" name="thpc_dara[]" value="'+thpc_dara+'"></td>'
                                        +'<td><input type="number" class="form-control" name="thpc_aakhar[]" value="'+thpc_aakhar+'"><input type="hidden" class="form-control" value="'+thpc_id+'" name="thpc_id[]"></td><td><button class="btn btn-danger remove_field" data-key="'+data_id+'">*</button></td><tr>');
                $("#thpc_name, #thpc_dara, #thpc_aakhar").val("");  
               
            }

                                 
        }
    });
    $(selfwrapper).on("click",".remove_field", function(e){ //user click on remove text
        // alert("in thpc table");
        e.preventDefault();
        var key_value=$(".remove_field").attr("data-key");
        $("#wrapper"+key_value).remove();
        $("#selfwrapper"+key_value).remove();
        x--;
    })
});





$(document).ready(function() {
    var max_fields      = 25; //maximum input boxes allowed
    var wrapper         = $(".hisaa_table"); //Fields wrapper
    var selfwrapper     = $(".hissa_self_table");
    var add_button      = $(".add_hissa_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            
            var data_id = Math.floor(1000 + Math.random() * 9000);

            var wrapper_id="wrapper"+data_id;
            var selfwrapper_id="selfwrapper"+data_id;

            var hissa_id=$("#hissa_party").val();

           
            // alert(thpc_id);
            var party=$('select[name=hissa_party]').find(':selected').text();

          
            var hissa=$("#hissa_value").val();
            
            if(party!='' && hissa!=''){
                // $(wrapper).append('<tr id="'+wrapper_id+'"><td><input type="text" class="form-control" value="'+party+'" name="hissa_party[]"></td><td><input type="text" class="form-control" value="'+hissa+'" name="hissa_value[]"><input type="hidden" class="form-control" value="'+hissa_id+'" name="hissa_id[]"></td><tr>'); //add input box
                $(selfwrapper).append('<tr id="'+selfwrapper_id+'"><td><input type="text" class="form-control" name="hissa_party[]" value="'+party+'" ></td>'
                                        +'<td><input type="text" class="form-control" name="hissa_value[]" value="'+hissa+'"></td>'
                                        +'<input type="hidden" class="form-control" value="'+hissa_id+'" name="hissa_id[]">'
                                        +'<td><button class="btn btn-danger remove_hissa_field" data-key="'+data_id+'">*</button></td><tr>');

                $("#hissa_party, #hissa_value").val("");  
            }                      
        }
    });

   

    $(selfwrapper).on("click",".remove_hissa_field", function(e){ //user click on remove text
        e.preventDefault();
        var key_value=$(".remove_hissa_field").attr("data-key");
        $("#selfwrapper"+key_value).remove();
        x--;
    })
});
</script>
<script>
    $(document).ready(function () {
    $('#update_basic_detail').click(function(e){
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/update_basic_ledger`,
            enctype: 'multipart/form-data',
            data: {ledger:$("#ledger_name").val(),mobile:$("#mobile").val(),
            realname:$("#realname").val(),ledger_id:$("#ledger_id").val(),"_token": "{{ csrf_token() }}"},
            success: function (data) {
                if (data.status == 200) {
                    toastr.success(data.message, 'Success');
                    setInterval(function () {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message, 'Error');
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#update_reconfig_rate').click(function(e){
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/update_reconfig_rate`,
            enctype: 'multipart/form-data',
            data: {dara:$("#dara").val(),dara_commission:$("#dara_commission").val(),akhar:$("#akhar").val(),akhar_commission:$("#akhar_commission").val(),rebate:$("#rebate").val(),
            ledger_id:$("#ledger_id").val(),"_token": "{{ csrf_token() }}"},
            success: function (data) {
                if (data.status == 200) {
                    toastr.success(data.message, 'Success');
                    setInterval(function () {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message, 'Error');
                }
            }
        });
    });
});
</script>
@endsection