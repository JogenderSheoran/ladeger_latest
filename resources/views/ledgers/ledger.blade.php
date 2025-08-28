@extends('layouts.master')
@section('content')
<style>
    .dataTables_filter {
        display: none;
    }

    .table thead {
        background: #465cc2;
        color: #ffffff;
    }

    .modal-lg {
        width: 1100px !important;
    }

    .ledger-font {
        font-size: 11px;
        font-weight: 1000;
    }
    .text-size{
        font-size:12px !important;
        color:#736666;
        font-weight: bold;
        text-align:center;
    }
    .text-font{
       text-align:center;
       font-weight: 600;
    }
    /* Ensures the modal is centered vertically and horizontally on larger screens */
.modal-dialog {
    margin: 1.75rem auto;
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    .modal-dialog {
        width: 50%; /* Adjust width for small screens */
        margin: 0 auto; /* Center modal on smaller screens */
    }
    .modal-content {
        padding: 1rem; /* Add padding inside the modal */
    }
}

/* Adjustments for extra-small screens */
@media (max-width: 576px) {
    .modal-dialog {
        width: 40%; /* Full width for extra-small screens */
        margin: 0; /* Remove margin */
    }
    .modal-content {
        width: 37% !important;
        padding: 0.5rem; /* Reduced padding inside the modal */
    }
}

/* Ensure the modal is movable by ensuring overflow handling */
.modal {
    overflow-y: auto;
}

</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">
            <!-- Display Error Messages -->
            @if(session('error'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('error') }}
            </div>
            @endif

            <!-- Display Success Messages -->
            @if(session('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('success') }}
            </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light ">

                        <div class="portlet-title">
                            <div class="">
                                <div class="row">

                                    <div class="col-md-1">
                                        <h6><b>Search</b></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="page-title">
                                            <div class="btn-group" id="type_section">
                                            <input type="text" autocomplete="off"  name="search" id="search_ledger" placeholder="Ledger"
                                                oninput='onInput_opposite()' list="opposite_party_list" id="opposite_party_balance"
                                                name="ledger_name_2" class="input-group form-control form-control-inline"
                                                >
                                            <datalist id="opposite_party_list" name="ledger_id2">
                                                @foreach($ledger as $l)
                                                <option value='{{$l->name}}'>{{$l->id}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        </div>
                                        <div id="searchList"></div>
                                    </div>
                                    <div class="col-md-1" style="float:left;">
                                        <div class="page-title">
                                            <button class="btn sbold green" id="search">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="float:right;">
                                        <div class="btn-group fRight">
                                            <a href="javascript:;" id="addShiftButton" class="btn sbold green add_button"> Add (F2)
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="portlet-body table-both-scroll">

                            <table class="table table-striped table-bordered table-hover order-column" id="mytable">
                                <thead>
                                    <tr> 
                                        <th class="text-font">Sr. No.</th>
                                        <th class="text-font">Name</th>
                                        <th class="text-font">Admin</th>
                                        <th class="text-font">Real Name</th>
                                        <th class="text-font">Grantor Name</th>
                                        <th class="text-font">Mobile</th>
                                        <th class="text-font">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="ledger_body">
                                    @foreach($ledger as $key => $value)
                                    <tr id="row{{$value->id}}">
                                        <td class="text-size">{{++$key}}</td>
                                        <td class="text-size">{{$value->name}}</td>
                                        <td class="text-size">{{$value->admin}}</td>
                                        <td class="text-size">{{$value->username}}</td>
                                        <td class="text-size">{{$value->grantor}}</td>
                                        <td class="text-size">{{$value->mobile}}</td>
                                        <td class="text-size">
                                        @if($value->primary==0)
                                        {{--<a href="javascript:void(0)"  onclick="setArchieveId({{$value->id}})"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;</a>--}}&nbsp;&nbsp;
                                        <a href="javascript:void(0)"  onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)"  onclick="editShift({{$value->id}})"><i class="fa fa-edit" style="color:blue;"></i></a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="showMedicineList({{$value->id}})"><i class="fa fa-eye" style="color:blue;"></i></a></td>
                                        @endif
                                        </td>
                                    </tr>
                                    <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
                                    <span class="rowDate{{$value->id}} hide">{{$value->active}}</span>
                                    @endforeach

                                </tbody>
                                <tfoot class="dataTables_scrollHead">
                                    <tr>
                                    <th class="text-font">Sr. No.</th>
                                        <th class="text-font">Name</th>
                                        <th class="text-font">Admin</th>
                                        <th class="text-font">Real Name</th>
                                        <th class="text-font">Grantor Name</th>
                                        <th class="text-font">Mobile</th>
                                        <th class="text-font">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- Add shift modal -->
                            <div class="modal fade bs-modal-sm" id="addShift" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header model_custom_header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="model_title"><b>Add Ledger</b></h4>
                                        </div>
                                        <form method="POST" action="{{ route('submit_ledger') }}" id="ledger_form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="id" value="">
                                            <input type="hidden" name="user_id" id="Wid" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="updated_by" id="updatedBy" value="{{ Auth::user()->company }}">
                                            <div class="modal-body">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label ledger-font">Ledger Name</label>
                                                                        <input type="text" autocomplete="off" name="name" id="name" required class="form-control input" />
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="admin_id" name="admin_id" value="{{ Auth::user()->id }}">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label ledger-font">Real Name</label>
                                                                        <input type="text" autocomplete="off" name="username" id="username" class="form-control input" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label ledger-font">Grantor Name</label>
                                                                        <input type="text" autocomplete="off" name="grantor_name" id="grantor_name" class="form-control input" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label ledger-font">Mobile</label>
                                                                        <input type="number" autocomplete="off" name="mobile" id="mobile" class="form-control input" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="field_wrapper">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label ledger-font">Medicine Name</label>
                                                                            <input type="text" autocomplete="off" name="medicine_name[]" id="medicine_name"  class="form-control input" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label ledger-font">Rate</label>
                                                                            <input type="text" autocomplete="off" name="medicine_rate[]" id="medicine_rate" class="form-control input numeric-only"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label class="control-label ledger-font">Rebate</label>
                                                                            <input type="text" autocomplete="off" name="medicine_rebate[]" id="medicine_rebate" class="form-control input numeric-only"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 d-flex align-items-end">
                                                                        <a href="javascript:void(0);" class="add_button_md" title="Add field"><i class="fa fa-plus"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="save" class="btn btn-success">Save</button>
                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                <button style="display:none;" id="wait" class="btn btn-warning"><i class="icon-spinner"></i> Please Wait...</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

<!--Add shift modal -->
                        </div>
                    </div>
                </div>
            </div>




            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!---- Delete model------>
<div class="modal fade" id="deleteLedger" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete Ledger</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="ledger_id" id="ledger_id">
                        <p>Are you sure to delete this ledger?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="deleteLedger()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<input type="hidden" id="adminName" value="{{Auth::user()->name}}">

<div class="modal fade" id="archieveLedger" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Archieve Ledger</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="archieve_ledger_id" id="archieve_ledger_id">
                        <p>Are you sure to archieve this ledger?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="archieveLedger()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="medicineTransactionsModal" tabindex="-1" role="dialog" aria-labelledby="medicineTransactionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="medicineTransactionsModalLabel">Medicine Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive CustomFixedTbl">
                    <table class="table table-bordered" id="mytable">
                        <thead>
                            <tr>
                                <th>Medicine Name</th>
                                <th>Rate</th>
                                <th>Rebate</th>
                            </tr>
                        </thead>
                        <tbody id="medicineTransactionsTableBody">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection
@section('js')
<script>
$("#search").click(function(){
    $.ajax({		            	
        type: "POST",
        url: "{{route('search_ledger_data')}}",
        enctype: 'multipart/form-data',
        data: {ledger_name:$('#search_ledger').val(),_token: '{!! csrf_token() !!}',},                                     
        success: function(res)
        {
            // console.log(res);
            if(res.status == 'success'){
            $("#ledger_body").empty();
                var html='';
                $.each(res.data, function (key, ledger) {
                    var adminName = $("#adminName").val();
                   
                    
                    
                    var serial=parseFloat(key)+1;
                    if(ledger['username']===null){
                        var username='';
                    }else{
                        var username=ledger['username'];
                    }
                    if(ledger['grantor']===null){
                        var grantor='';
                    }else{
                        var grantor=ledger['grantor'];
                    }
                    if(ledger['mobile']===null){
                        var mobile='';
                    }else{
                        var mobile=ledger['mobile'];
                    }
                  
                    html +='<tr id="row'+ledger['id']+'"><td class="text-size">'+serial+'</td><td class="text-size" id="">'+ledger['name']+'</td><td class="text-size" id="shift_name">'+adminName+'</td><td class="text-size">'+username+'</td><td class="text-size">'+grantor+'</td><td class="text-size">'+mobile+'</td><td class="text-size"><a href="javascript:void(0)"  onclick="setArchieveId('+ledger['id']+')"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="setId('+ledger['id']+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="editShift('+ledger['id']+')"><i class="fa fa-edit" style="color:blue;"></i></a></td></tr>';
                });
                $("#ledger_body").append(html);
            }
            else{
                toastr.error(res.message, 'Error');
            }
        }
    });
});
    document.onkeyup = KeyCheck;

    function KeyCheck(e) {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if (KeyID == 113) {
            $("#addShiftButton").click();
        }
    }

    // open model
    $("#addShiftButton").click(function () {
        $('#ledger_form')[0].reset();
        $('#addShift').modal('show');
    });

    $('#addShift').on('hidden.bs.modal', function () {
        location.reload(); 
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
                url: `${window.pageData.baseUrl}/api/add_ledger`,
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
    // function editShift(id) {
    //     $("#model_title").text("Edit Shift");
    //     $('#addShift').modal('show');
    //     var ids = "#row" + id;
    //     var currentRow = $(ids).closest("tr");
    //     $("#id").val(id);
    //     $("#name").val(currentRow.find("td:eq(1)").text());
    //     $("#username").val(currentRow.find("td:eq(2)").text());
    //     // $('select[name^="group"] option[value="'+currentRow.find("td:eq(3)").text()+'"]').attr("selected","selected");
    //     $("#group option:contains(" + currentRow.find("td:eq(3)").text() + ")").attr("selected", true);
    //     var dara = currentRow.find("td:eq(4)").text();
    //     var akhar = currentRow.find("td:eq(5)").text();
    //     var dara_val = dara.split("/");
    //     var akhar_val = akhar.split("/");
    //     $("#dara").val(dara_val[1]);
    //     $("#dara_commission").val(dara_val[0]);
    //     $("#akhar").val(akhar_val[1]);
    //     $("#akhar_commission").val(akhar_val[0]);
    //     $("#tp").val(currentRow.find("td:eq(6)").text());
    //     $("#rebate").val(currentRow.find("td:eq(7)").text());
    //     $("#tp_r").val(currentRow.find("td:eq(8)").text());
    //     $("#hissa").val(currentRow.find("td:eq(9)").text());
    //     $("#grantor").val(currentRow.find("td:eq(10)").text());
    //     $("#mobile").val(currentRow.find("td:eq(11)").text());
    //     $("#address").val(currentRow.find("td:eq(12)").text());

    // }
</script>

<!-- Dara rate and Dara Comssion Js  -->
<script>
    $('#dara').on("keyup", function (e) {
        if (e.keyCode >= 37 && e.keyCode <= 40) {
            e.stopImmediatePropagation();
            return;
        }
        var dara_rate = $("#dara").val();
        if (dara_rate < 0 || dara_rate > 100 || dara_rate == '') {
            $("#dara").val('');
            $("#dara_commission").val('');
        } else {
            var dara_commission = 100 - dara_rate;
            $("#dara_commission").val(dara_commission);
        }
    });

    $('#dara_commission').on("keydown", function (e) {
       if(e.keyCode!==13){
        e.preventDefault();
       }
    });
</script>

<!-- Dara rate and Dara Comssion Js  -->
<script>
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
        if (e.keyCode >= 37 && e.keyCode <= 40 && e.keyCode!=13) {
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

    $('#akhar_commission').on("keydown", function (e) {
        if(e.keyCode!==13 && e.keyCode!==9){
            e.preventDefault();
        }
    });

    // $('#dara_commission').on("keydown", function (e) {
    //     e.preventDefault();
    // });

    $("#tp,#tp_r,#hissa").on("keypress", function (evt) {
        if (evt.keyCode == 121 || evt.keyCode == 110) {
            if (evt.KeyCode == 121) {
                $("#tp_r").val("Yes");
            } else if (evt.KeyCode == 110) {
                $("tp_r").val("No");
            } else {
                evt.preventDefault();
                return;
            }
        } else {
            // alert("no");
            evt.preventDefault();
            return;
        }
    });

   

   

    $(document).ready(function () {

// Function to handle Enter key press
function handleEnterPress(event) {
    if (event.keyCode === 13) { // Enter key
        event.preventDefault(); // Prevent form submission

        // Find the next input field
        var inputs = $(':input:visible');
        var nextInput = inputs.eq(inputs.index(this) + 1);
        
        if (nextInput.length) {
            nextInput.focus(); // Focus on the next input
        } else {
            // If it's the last input, submit the form
            $('#add_shift').submit();
        }
    }
}

// Attach the keydown event to all input fields in the form
$('#add_shift :input').keydown(handleEnterPress);

$('#add_shift').submit(function (e) {
    e.preventDefault();
    var form = $('#add_shift')[0];
    var data = new FormData(form);
    $("#save").hide();
    $("#wait").show();
    $.ajax({
        type: "POST",
        url: '{{route('add_ledger')}}',
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

</script>
<script>
    
    $('#limit').on('change', function (e) {
        var value = $("#limit").val();
        if (value == "Yes") {
            $('#limit_section').css('display','block');
        }
    });
    $('#hissa').on('change', function (e) {
        var value = $("#hissa").val();
        if (value == "Yes") {
            $('#hissa_modal').modal('show');
        }
    });
    $('#tp_r').on('change', function (e) {
        var value = $("#tp_r").val();
        if (value == "Yes") {
            $('#third_party_rebate').modal('show');
        }
    });
    $('#tp_commission').on('change', function (e) {
        var value = $("#tp_commission").val();
        if (value == "Yes") {
            $('#third_party_commission_modal').modal('show');
        }
    });
</script>
<script>
    $(document).ready(function() {
    var max_fields      = 25; //maximum input boxes allowed
    var wrapper         = $(".thpc_table"); //Fields wrapper
    var selfwrapper     = $(".thpc_self_table");
    var add_button      = $(".add_thpc_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
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
                 $(wrapper).append('<tr id="'+wrapper_id+'"><td><input type="text" class="form-control" value="'+thpc_name+'" name="thpc_name[]"></td><td><input type="text" class="form-control" value="'+thpc_dara+'" name="thpc_dara[]"></td><td><input type="text" class="form-control" value="'+thpc_aakhar+'" name="thpc_aakhar[]"><input type="hidden" class="form-control" value="'+thpc_id+'" name="thpc_id[]"></td><tr>'); //add input box
                 $(selfwrapper).append('<tr id="'+selfwrapper_id+'"><td><input type="text" class="form-control" value="'+thpc_name+'">'
                                        +'<td><input type="number" class="form-control" value="'+thpc_dara+'"></td>'
                                        +'<td><input type="number" class="form-control" value="'+thpc_aakhar+'"></td><td><button class="btn btn-danger remove_field" data-key="'+data_id+'">*</button></td><tr>');
                $("#thpc_name, #thpc_dara, #thpc_aakhar").val("");  
               
            }

                                 
        }
    });

   

    $(selfwrapper).on("click",".remove_field", function(e){ //user click on remove text
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
                $(wrapper).append('<tr id="'+wrapper_id+'"><td><input type="text" class="form-control" value="'+party+'" name="hissa_party[]"></td><td><input type="text" class="form-control" value="'+hissa+'" name="hissa_value[]"><input type="hidden" class="form-control" value="'+hissa_id+'" name="hissa_id[]"></td><tr>'); //add input box
                $(selfwrapper).append('<tr id="'+selfwrapper_id+'"><td><input type="text" class="form-control" value="'+party+'" ></td>'
                                        +'<td><input type="text" class="form-control" value="'+hissa+'"></td>'
                                        +'<td><button class="btn btn-danger remove_field" data-key="'+data_id+'">*</button></td><tr>');

                $("#hissa_party, #hissa_value").val("");  
            }                      
        }
    });

    $('#mytable').DataTable({
        "autoWidth": false,
        "ordering": false,
        "searching": false,
        "paging": true,
        "info": false,
        // scrollY: 280,
        // "scroller":true,
        // "scrollX":true,
    });

   

    $(selfwrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
        var key_value=$(".remove_field").attr("data-key");
        $("#wrapper"+key_value).remove();
        $("#selfwrapper"+key_value).remove();
        x--;
    })
});


function isNumberKey(evt){
        // var charCode = (evt.which) ? evt.which : event.keyCode;
        // if(charCode==46 || charCode==190){
        //     if(evt.target.value.includes('.')){
        //         return false;
        //     }else{
        //         return true;
        //     }
        // }else{

        //     if (charCode > 31 && (charCode < 48 || charCode > 57)){
        //         return false;
        //     }else{
        //         return true;
        //     }
        // }
    }
</script>
<script>

 $('#search_ledger').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url: `${window.pageData.baseUrl}/api/autocompelete_ledger`,
          method:"POST",
          data:{name:query,admin_id:$("#admin_id").val(),_token:_token},
          success:function(data){
            $('#searchList').fadeIn();  
            $('#searchList').html(data.data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#search_ledger').val($(this).text());  
        $('#searchList').fadeOut();  
    });  

   

    $('#ledger_form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });

    $('body').on('keydown', 'input, select', function(e) {
        if (e.key === "Enter") {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this)+1);
            console.log("check next",next);
            if (next.length) {
                next.focus();
                // next.css('background-color','#ffc107');
            } 
            return false;
        }
    });

    function setId(id) {
            $('#deleteLedger').modal('toggle');
            $("#ledger_id").val(id);
    }

    function setArchieveId(id) {
            $('#archieveLedger').modal('toggle');
            $("#ledger_id").val(id);
    }

    function deleteLedger() {
            $.ajax({
                type: "POST",
                url: `${window.pageData.baseUrl}/api/delete_ledger`,
                enctype: 'multipart/form-data',
                data: {
                    id: $("#ledger_id").val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message, 'Success');
                        $('#deleteLedger').modal('hide');
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

        function archieveLedger() {
            $.ajax({
                type: "POST",
                url: `${window.pageData.baseUrl}/api/archieve_ledger`,
                enctype: 'multipart/form-data',
                data: {
                    id: $("#archieve_ledger_id").val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.status == 'success') {
                        toastr.success(data.message, 'Success');
                        $('#archieveLedger').modal('hide');
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
<script>
function editShift(id) {
    $("#model_title").text("Edit Ledger").css({ 'font-weight': 'bold' });
    var ids = "#row" + id;
    var currentRow = $(ids).closest("tr");
    var idVal = id;
    var name = currentRow.find("td:eq(1)").text();
    var username = currentRow.find("td:eq(3)").text();
    var grantorName = currentRow.find("td:eq(4)").text();
    var mobile = currentRow.find("td:eq(5)").text();

    // Set values in form inputs
    $("#id").val(idVal);
    $("#name").val(name);
    $("#username").val(username);
    $("#grantor_name").val(grantorName);
    $("#mobile").val(mobile);
    $.ajax({
    type: "POST",
    url: "{{ route('getLedgerMedicine') }}",
    data: { 'id': id,"_token": "{{ csrf_token() }}" },
    success: function(response) {
        if(response.status === 'success') {
            var medicineList = response.data;
            var fieldWrapper = $(".field_wrapper");
            fieldWrapper.empty(); // Clear previous fields
            
            if (medicineList.length === 0) {
                // No medicine returned, show one empty row with add button
                var emptyHtml = '<div class="row">' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="control-label ledger-font">Medicine Name</label>' +
                    '<input type="text" autocomplete="off" name="medicine_name[]" class="form-control input" value=""  />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="control-label ledger-font">Rate</label>' +
                    '<input type="text" autocomplete="off" name="medicine_rate[]" class="form-control input numeric-only" value=""  />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form-group">' +
                    '<label class="control-label ledger-font">Rebate</label>' +
                    '<input type="text" autocomplete="off" name="medicine_rebate[]" class="form-control input numeric-only" value=""  />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3" style="margin-top:25px;">' +
                    '<a href="javascript:void(0);" class="add_button_md" title="Add field"><i class="fa fa-plus"></i></a>' +
                    '</div>' +
                    '</div>'; // Closing row div
                
                fieldWrapper.append(emptyHtml);
            } else {
                // Loop through medicine list and populate fields
                $.each(medicineList, function(index, medicine) {
                    var html = '<div class="row">' +
                        '<div class="col-md-3">' +
                        '<div class="form-group">' +
                        '<label class="control-label ledger-font">Medicine Name</label>' +
                        '<input type="text" autocomplete="off" name="medicine_name[]" class="form-control input" value="' + medicine.medicine_name + '" required />' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                        '<div class="form-group">' +
                        '<label class="control-label ledger-font">Rate</label>' +
                        '<input type="text" autocomplete="off" name="medicine_rate[]" class="form-control input numeric-only" value="' + medicine.medicine_rate + '" required />' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                        '<div class="form-group">' +
                        '<label class="control-label ledger-font">Rebate</label>' +
                        '<input type="text" autocomplete="off" name="medicine_rebate[]" class="form-control input numeric-only" value="' + medicine.medicine_rebate + '" required />' +
                        '</div>' +
                        '</div>';

                    // Check if it's the first item
                    if (index === 0) {
                        html += '<div class="col-md-3" style="margin-top:25px;">' +
                            '<a href="javascript:void(0);" class="add_button_md" title="Add field"><i class="fa fa-plus"></i></a>' +
                            '</div>';
                    } else {
                        html += '<div class="col-md-3" style="margin-top:25px;">' +
                                   
                                    '<a href="javascript:void(0);" class="add_button_md" title="Add field">' +
                                        '<i class="fa fa-plus"></i>' +
                                    '</a>&nbsp;&nbsp;' +
                                    '<a href="javascript:void(0);" class="remove_button_md" title="Remove field">' +
                                        '<i class="fa fa-minus"></i>' +
                                    '</a>' +
                                '</div>;'
                    }

                    html += '</div>' + // Closing row div
                        '</div>'; // Closing container div

                    
                    fieldWrapper.append(html);

                    $('.field_wrapper .row:last-child input[name="medicine_name[]"]').focus();
                });
            }

            $('#addShift').modal('show');
        } else {
            console.error("Error fetching medicine list:", response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error(xhr.responseText);
    }
});

}
$('#save').keypress((e) => {
  if (e.which === 13) {
      $('#ledger_form').submit();
  }
});

</script>



 </script>
 <script>
$(document).ready(function(){
    // Bind click event for adding fields
    $('.field_wrapper').on('click', '.add_button_md', function(){
        var x = $('.field_wrapper .row').length + 1; // Increment field counter
        var maxField = 30; // Maximum number of fields

        // Check if the maximum number of fields has been reached
        if(x <= maxField){ 
            var fieldHTML = '<div class="row">' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '<label class="control-label ledger-font">Medicine Name</label>' +
                '<input type="text" autocomplete="off" name="medicine_name[]" class="form-control input" value=""  />' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '<label class="control-label ledger-font">Rate</label>' +
                '<input type="text" autocomplete="off" name="medicine_rate[]" class="form-control input numeric-only" value=""  />' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<div class="form-group">' +
                '<label class="control-label ledger-font">Rebate</label>' +
                '<input type="text" autocomplete="off" name="medicine_rebate[]" class="form-control input numeric-only" value=""  />' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3" style="margin-top:25px;">' +
                '<a href="javascript:void(0);" class="add_button_md" title="Add field">' +
                                        '<i class="fa fa-plus"></i>' +
                                    '</a>&nbsp;&nbsp;<a href="javascript:void(0);" class="remove_button_md" title="Add field"><i class="fa fa-minus"></i></a>'+
                '</div>' +
                '</div>';

            // Append the new field HTML to the wrapper
            $('.field_wrapper').append(fieldHTML);
            $('.field_wrapper .row:last-child input[name="medicine_name[]"]').focus();
        } else {
            alert('A maximum of '+maxField+' fields are allowed to be added.');
        }
    });

    // Bind click event for removing fields
    $('.field_wrapper').on('click', '.remove_button_md', function(){
        $(this).closest('.row').remove(); // Remove the closest row when remove button is clicked
    });
});


function removeDiv(id){
        var id ="#dynamic_field"+id;
        $(id).remove();
    }
</script>

<script>
    $(document).ready(function() {
        $('.numeric-only').on('keypress', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            var value = $(this).val();

            // Allow only numbers and one decimal point
            if ((charCode < 48 || charCode > 57) && charCode !== 46 || (charCode === 46 && value.indexOf('.') !== -1)) {
                event.preventDefault();
            }
        });

        $('.numeric-only').on('paste', function(event) {
            var clipboardData = event.originalEvent.clipboardData || window.clipboardData;
            var pastedData = clipboardData.getData('Text');

            // Allow only numbers and one decimal point
            if (!/^\d*\.?\d*$/.test(pastedData)) {
                event.preventDefault();
            }
        });

        $('.numeric-only').on('input', function() {
            // Allow only numbers and one decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');

            // Allow only one decimal point
            if ((this.value.match(/\./g) || []).length > 1) {
                this.value = this.value.slice(0, this.value.lastIndexOf('.'));
            }
        });
    });
</script>

<script type="text/javascript">
    function showMedicineList(ledgerId) {
        $.ajax({
            url: '{{ route("ledgerMedicineList") }}',
            type: 'POST',
            data: {
                ledger_id: ledgerId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Clear existing table rows
                $('#medicineTransactionsTableBody').empty();

                // Populate table with fetched data
                $.each(response.data, function(index, transaction) {
                    



                    var row = '<tr>' +
                        '<td>' + transaction.medicine_name + '</td>' +
                        '<td>' + transaction.medicine_rate + '</td>' +
                        '<td>' + transaction.medicine_rebate + '</td>' +
                        '</tr>';
                    $('#medicineTransactionsTableBody').append(row);
                });

                // Show the modal
                $('#medicineTransactionsModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching ledger medicine transactions:', error);
                // Handle error display or logging
            }
        });
    }
</script>
<scirpt src="http://select2.github.io/select2/select2-3.5.1/select2.js"></script>

@endsection