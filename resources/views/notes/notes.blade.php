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
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container">

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

                                    {{--<div class="col-md-2">
                                        <div class="page-title">
                                            <input type="text" autocomplete="off" name="search" id="search_ledger" class="form-control">
                                        </div>
                                        <div id="searchList"></div>
                                    </div>
                                    <div class="col-md-1" style="float:left;">
                                        <div class="page-title">
                                            <button class="btn sbold green" id="search">Search</button>
                                        </div>
                                    </div>--}}
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
                                        <th class="text-font">Title</th>
                                        <th class="text-font">Remark</th>
                                        <th class="text-font">Date</th>
                                        <th class="text-font">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="ledger_body">
                                    @foreach($data as $key => $value)
                                    <tr id="row{{$value->id}}">
                                        <td class="text-size">{{++$key}}</td>
                                        <td class="text-size">{{$value->title}}</td>
                                        <td class="text-size">{{$value->remark}}</td>
                                        <td class="text-size">{{ $value->updated_at->format('Y-m-d H:i:s') }}</td>
                                        <td class="text-size">
                                            <a href="javascript:void(0)"  onclick="editShift({{$value->id}})"><i class="fa fa-edit" style="color:blue;"></i></a>
                                            <a href="javascript:void(0)"  onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;</td>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot class="dataTables_scrollHead">
                                    <tr>
                                    <th class="text-font">Sr. No.</th>
                                        <th class="text-font">Title</th>
                                        <th class="text-font">Remark</th>
                                        <th class="text-font">Date</th>
                                        <th class="text-font">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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


<!-- Add shift modal -->
<div class="modal fade bs-modal-sm" id="addShift" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header model_custom_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title"><b>Add Notes</b></h4>
            </div>
            <form method="POST" action="{{route('createNotes')}}" id="add_shift">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="user_id" id="Wid" value="{{Auth::user()->id}}">
                <div class="modal-body">
                    <div class="portlet-body">

                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Title</label>
                                            <input type="text" autocomplete="off" name="title" id="title" required class="form-control input" />
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Remark</label>
                                            <textarea type="text" autocomplete="off" name="remark" id="remark" class="form-control input"></textarea>
                                        </div>
                                    </div>
                                 
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="save" class="btn green">Save</button>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button style="display:none;" id="wait" class="btn yellow"><i class="icon-spinner"></i>Please
                        Wait...</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Add shift modal -->

<!---- Delete model------>
<div class="modal fade" id="deleteLedger" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete Notes</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="notes_id" id="notes_id">
                        <p>Are you sure to delete this notes?</p>

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
                  
                    html +='<tr id="row'+ledger['id']+'"><td class="text-size">'+serial+'</td><td class="text-size" id="shift_name">'+ledger['name']+'</td><td class="text-size">'+username+'</td><td class="text-size">'+grantor+'</td><td class="text-size">'+mobile+'</td><td class="text-size"><a href="javascript:void(0)"  onclick="setArchieveId('+ledger['id']+')"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="setId('+ledger['id']+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="editShift('+ledger['id']+')"><i class="fa fa-edit" style="color:blue;"></i></a></td></tr>';
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
        // $('#add_shift')[0].reset();
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
                url: `{{route('createNotes')}}`,
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
    function editShift(id) {
        $("#model_title").text("Edit Shift");
        $('#addShift').modal('show');
        var ids = "#row" + id;
        var currentRow = $(ids).closest("tr");
        $("#id").val(id);
        $("#name").val(currentRow.find("td:eq(1)").text());
        $("#username").val(currentRow.find("td:eq(2)").text());
        // $('select[name^="group"] option[value="'+currentRow.find("td:eq(3)").text()+'"]').attr("selected","selected");
        $("#group option:contains(" + currentRow.find("td:eq(3)").text() + ")").attr("selected", true);
        var dara = currentRow.find("td:eq(4)").text();
        var akhar = currentRow.find("td:eq(5)").text();
        var dara_val = dara.split("/");
        var akhar_val = akhar.split("/");
        $("#dara").val(dara_val[1]);
        $("#dara_commission").val(dara_val[0]);
        $("#akhar").val(akhar_val[1]);
        $("#akhar_commission").val(akhar_val[0]);
        $("#tp").val(currentRow.find("td:eq(6)").text());
        $("#rebate").val(currentRow.find("td:eq(7)").text());
        $("#tp_r").val(currentRow.find("td:eq(8)").text());
        $("#hissa").val(currentRow.find("td:eq(9)").text());
        $("#grantor").val(currentRow.find("td:eq(10)").text());
        $("#mobile").val(currentRow.find("td:eq(11)").text());
        $("#address").val(currentRow.find("td:eq(12)").text());

    }
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
        $("#rebate").keyup(function (event) {
            // Allow only backspace and delete
            // if (event.keyCode == 46 || event.keyCode == 8) {
            //     // let it happen, don't do anything
            // } else {
            //     // Ensure that it is a number and stop the keypress
            //     if (event.keyCode < 48 || event.keyCode > 57) {
            //         event.preventDefault();
            //     }
            // }
            if ($("#rebate").val() > 100){
                $("#rebate").val('');
            }
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
    var max_fields      = 10; //maximum input boxes allowed
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

// //third party rebate
// $(document).ready(function() {
//     var max_fields      = 10; //maximum input boxes allowed
//     var wrapper         = $(".thpr_table"); //Fields wrapper
//     var selfwrapper     = $(".thpr_self_table");
//     var add_button      = $(".add_thpr_button"); //Add button ID

//     var x = 1; //initlal text box count
//     $(add_button).click(function(e){ //on add input button click
//         e.preventDefault();
//         if(x < max_fields){ //max input box allowed
//             x++; //text box increment
            
//             var data_id = Math.floor(1000 + Math.random() * 9000);

//             var wrapper_id="wrapper"+data_id;
//             var selfwrapper_id="selfwrapper"+data_id;


//             var thpr_id=$("#thpr_name").val();
//             // alert(thpc_id);
//             var thpr_name=$('select[name=thpr_name]').find(':selected').text();

//             // alert(thpr_id);
//             // alert(thpr_name);

//             var thpr_p=$("#thpr_p").val();
            
//             if(thpr_name!='' && thpr_p!=''){
//                 $(wrapper).append('<tr id="'+wrapper_id+'"><td><input type="text" class="form-control" value="'+thpr_name+'" name="thpr_name[]"></td><td><input type="text" class="form-control" value="'+thpr_p+'" name="thpr_p[]"><input type="hidden" class="form-control" value="'+thpr_id+'" name="thpr_id[]"></td><tr>'); //add input box
//                 $(selfwrapper).append('<tr id="'+selfwrapper_id+'"><td><input type="text" class="form-control" value="'+thpr_name+'" ></td>'
//                                         +'<td><input type="text" class="form-control" value="'+thpr_p+'"></td>'
//                                         +'<td><button class="btn btn-danger remove_field" data-key="'+data_id+'">*</button></td><tr>');

//                 $("#thpr_name, #thpr_p").val(""); 
//                 $("#thpr_name").select2("val",currentRow.find("td:eq(4)").text());
//             }                       
//         }
//     });

   

//     $(selfwrapper).on("click",".remove_field", function(e){ //user click on remove text
//         e.preventDefault();
//         var key_value=$(".remove_field").attr("data-key");
//         $("#wrapper"+key_value).remove();
//         $("#selfwrapper"+key_value).remove();
//         x--;
//     })
// });

//Hissa vlaue
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
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
          data:{name:query, _token:_token},
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
            $("#notes_id").val(id);
    }

    function setArchieveId(id) {
            $('#archieveLedger').modal('toggle');
            $("#ledger_id").val(id);
    }

    function deleteLedger() {
            $.ajax({
                type: "POST",
                url: `{{route('deleteNotes')}}`,
                enctype: 'multipart/form-data',
                data: {
                    id: $("#notes_id").val(),
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
    $('#addShift').modal('show');
    var ids = "#row" + id;
    var currentRow = $(ids).closest("tr");
    $("#id").val(id);
    $("#title").val(currentRow.find("td:eq(1)").text());
    $("#remark").val(currentRow.find("td:eq(2)").text());
}
$('#save').keypress((e) => {
  if (e.which === 13) {
      $('#ledger_form').submit();
  }
});

</script>



 </script>
<scirpt src="http://select2.github.io/select2/select2-3.5.1/select2.js"></script>

@endsection