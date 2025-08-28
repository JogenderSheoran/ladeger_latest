@extends('layouts.master')
@section('content')
<style>
    .ledger-list {
        height: 100px;
        width: 18%;
    }

    .ledger-list {
        overflow: hidden;
        overflow-y: scroll;
    }

    .dropdown-menu {
        min-width: 193px;
    }
</style>
<style>
    .dataTables_filter {
        display: none;
    }

    .text-effect {
        text-align: center;
        font-weight: 600;
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

    .text-size {
        font-size: 12px !important;
        color: #736666;
        font-weight: bold;
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
                    <span>Medicine Transaction History</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->

            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">


                <div class="row">

                    
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light ">

                           
                            <div class="table-responsive CustomFixedTbl">
                            <table class="table table-bordered" id="mytable">
                                    <thead>
                                        <tr>
                                            <th class="text-effect">Sr. No.</th>
                                            <th class="text-effect">Date</th>
                                            <th class="text-effect">Medicine</th>
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Type</th>
                                            {{--<th class="text-effect">Ledger Amount</th>--}}
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Medicine Amount</th>
                                            <th class="text-effect">Rate</th>
                                            <th class="text-effect">Rebate</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-effect" id="table_body">

                                        @foreach($data as $key => $value)
                                        <tr id="row{{$value->id}}" @if($value->transaction_status==1) style="background-color:rgb(150 221 150)" @endif>
                                            <td class="text-effect">{{++$key}}</td>
                                            <td class="text-effect">{{date('d-m-Y',strtotime($value->date))}}</td>
                                            <td class="text-effect">{{$value->medicine_name}}</td>
                                            <td class="text-effect"> {{$value->ledger_name}}</td>
                                            <td class="text-effect"><span class="label label-sm label-success label-mini btn cr_dr  sbold" @if($value->type=='minus') style="background-color:red" @else style="background-color:green" @endif>{{$value->type}}</span></td>
                                            {{--<td class="text-effect">{{$value->ledger_amount}}</td>--}}
                                            <td class="text-effect">{{$value->amount}}</td>
                                            <td class="text-effect">{{$value->medicine_amount}}</td>
                                            <td class="text-effect">{{$value->rate}}</td>
                                            <td class="text-effect">{{$value->rebate}}</td>
                                            <td class="text-effect">{{$value->remark}} @if($value->remark!='') ({{$value->remark}}) @endif</td>

                                           
                                            {{--<td>
                                                <a href="javascript:void(0)" onclick="setArchieveId({{$value->id}})"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;
                                                <a href="javascript:void(0)" onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;
                                                <a href="#"
                                                    onClick="editJournalVoucher({{$value->id}},{{$value->ledger_id}})"><i
                                                        class="fa fa-edit" style="color:blue;"></i></a>
                                            </td>--}}
                                            <td class="text-effect">
                                                <a href="javascript:void(0)" onclick="showTransactionDetails({{$value->id}})"><i class="fa fa-eye" style="color:blue;"></i></a>
                                            </td>
                                        </tr>
                                        <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
                                        <span class="rowDate{{$value->id}} hide">{{$value->active}}</span>
                                        @endforeach

                                    </tbody>
                                    <tfoot class="dataTables_scrollHead">
                                        <tr>
                                            <th class="text-effect">Sr. No.</th>
                                            <th class="text-effect">Date</th>
                                            <th class="text-effect">Medicine</th>
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Type</th>
                                            {{--<th class="text-effect">Ledger Amount</th>--}}
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Medicine Amount</th>
                                            <th class="text-effect">Rate</th>
                                            <th class="text-effect">Rebate</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-4">
                                    <button class="btn btn-success btn-block" style="background-color:green;">Total Plus: <?php echo $totalPlus; ?></button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-error btn-block" style="background-color:red;color:white;">Total Minus: - <?php echo $totalMinus; ?></button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-dark btn-block">Ledger Amount: <?php echo $ledgerAmount; ?></button>
                                </div>
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
<!-- END CONTENT -->


<div class="modal fade bs-modal-lg" id="addJournal" tabindex="-1" role="dialog" aria-hidden="true">
 
</div>
<!-- /.modal-content -->
</div>
</div>

<div class="modal fade bs-modal-sm" id="deleteVoucher" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete Transaction</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="voucher_id" id="voucher_id">
                        <p>Are you sure to delete this transaction?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="deleteVoucher()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-sm" id="archieveVoucher" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color:white;background-color:blue;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>UnArcheive Transaction</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="voucher_id" id="voucher_id">
                        <p>Are you sure to unarchieve this transaction?</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                <button type="button" class="btn green" onclick="archeiveVoucher()">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Add shift modal -->
<!---- Delete model------>
@endsection
@section('js')
<script>
    function onInput_opposite() {
        $('#party2').val('');
        var val = document.getElementById("opposite_party_balance").value;
        var opts = document.getElementById('opposite_party_list').childNodes;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                $('#party2').val(opts[i].text);
                break;
            }
        }
        var party2 = $("#party2").val();
        onChangDataList(party2);

    }

    function onInput_party() {
        $('#party1').val('');
        var val = document.getElementById("party_balance").value;
        var opts = document.getElementById('party_balance_list').childNodes;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                $('#party1').val(opts[i].text);
                break;
            }
        }
        var party1 = $("#party1").val();
        onChangDataList(party1);
    }

    function onInput_party2() {
        $('#party2').val('');
        var val = document.getElementById("party_balance2").value;
        var opts = document.getElementById('party_balance_list2').childNodes;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                $('#party2').val(opts[i].text);
                break;
            }
        }
        var party2 = $("#party2").val();
        onChangDataList(party2);
    }

    function onChangDataList(id) {
        $.ajax({
            type: "POST",
            url: "{{route('get_ledger')}}",
            enctype: 'multipart/form-data',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function (data) {
                console.log(data.status);
                if (data.status == true) {
                    $("#opposite_party_list").empty();
                    $.each(data.data, function (k, v) {
                        console.log(v.name);
                        $("#opposite_party_list").append('<option value=' + v.name + '>' + v.id +
                            '</option>');
                    });
                } else {
                    toastr.error(data.message, 'Error');
                }

                $("#save").show();
                $("#wait").hide();

            }
        });
    }


    // F2
    document.onkeyup = KeyCheck;

    function KeyCheck(e) {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if (KeyID == 113) {
            $("#addJournalButton").click();
        }
    }

    function setId(id) {
        $('#deleteVoucher').modal('show');
        $("#voucher_id").val(id);
    }

    function setArchieveId(id) {
        $('#archieveVoucher').modal('show');
        $("#voucher_id").val(id);
    }

    // open model
    $("#addJournalButton").click(function () {
        $('#add_journal_voucher')[0].reset();
        $('#addJournal').modal('show');
    });

    // Add Shift
    $(document).ready(function () {

        $('#add_journal_voucher').submit(function (e) {
            e.preventDefault();
            var form = $('#add_journal_voucher')[0];
            var data = new FormData(form);
            console.log(data);
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
                success: function (data) {
                    if(data.type==1){
                        window.location.reload();
                    }
                    if (data.status == 'success') {
                        $.each(data.data, function (k, data) {
                            if(data['remark']===null || data['remark']===undefined){
                                var remark='';
                            }
                            else{
                                remark=data['remark'];
                            }
                            
                            if(data['cr_dr']=='lene'){
                            var cr_dr='<span class="label label-sm label-success label-mini btn  sbold" style="background-color:red">'+data['cr_dr']+' </span>';
                            }
                            else{
                            var cr_dr='<span class="label label-sm label-success label-mini btn  sbold" style="background-color:green">'+data['cr_dr']+' </span>';
                            }
                            var table = $('#mytable').DataTable();
                            var row='<tr id="row'+data['id']+'"><td class="text-effect">'+data['id']+'</td><td class="text-effect">'+data['date']+'</td><td class="text-effect">'+data['ledger_name']+'</td><td class="text-effect">'+cr_dr+'</td> <td class="text-effect">'+data['amount']+'</td><td class="text-effect">'+remark+'</td>'
                            +'<td><a href="javascript:void(0)" onclick="setArchieveId('+data['id']+')"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="setId('+data['id']+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;<a href="#" onClick="editJournalVoucher('+data['id']+','+data['ledger_id']+')"><i class="fa fa-edit" style="color:blue;"></i></a></td></tr>';
                            var dvTable = $("#table_body");
                            dvTable.prepend(row);
                            $("#amount").val('');
                            $("#remark").val('');
                            $("#party_balance").val('');
                            $("#opposite_party_balance").val(''); 
                            $("#party_balance").focus();
                           
                    });
                        
                        toastr.success(data.message, 'Success');
                    } else {
                        toastr.error(data.message, 'Error');
                        $("#party_balance").val('');
                    }

                    $("#save").show();
                    $("#wait").hide();

                }
            });
        });
    });

    $('#amount').keypress(function(e){ 
    if (this.value.length == 0 && e.which == 48 ){
        return false;
    }
    });

    //edit transaction
    $(document).ready(function () {

$('#edit_journal_voucher').submit(function (e) {
    e.preventDefault();
    var form = $('#edit_journal_voucher')[0];
    var data = new FormData(form);
    console.log(data);
    $("#save").hide();
    $("#wait").show();
    $.ajax({
        type: "POST",
        url: `${window.pageData.baseUrl}/api/edit_journal_voucher`,
        enctype: 'multipart/form-data',
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if (data.status == 'success') {
                var id_val=$("#id").val();
                $('#row'+id_val).remove();
                $('#addJournal').modal('hide');
                $.each(data.data, function (k, data) {
                    var id='row'+data['id'];
                    if(data['remark']===null || data['remark']===undefined){
                        var remark='';
                    }
                    else{
                        remark=data['remark'];
                    }
                    
                    if(data['cr_dr']=='lene'){
                            var cr_dr='<span class="label label-sm label-success label-mini btn  sbold" style="background-color:red">'+data['cr_dr']+' </span>';
                            }
                            else{
                            var cr_dr='<span class="label label-sm label-success label-mini btn  sbold" style="background-color:green">'+data['cr_dr']+' </span>';
                            }
                    
                    var row='<tr id="row'+data['id']+'"><td class="text-effect">'+data['id']+'</td><td class="text-effect">'+data['date']+'</td><td class="text-effect">'+data['ledger_name']+'</td><td class="text-effect">'+cr_dr+'</td> <td class="text-effect">'+data['amount']+'</td><td class="text-effect">'+remark+'</td>'
                    +'<td><a href="javascript:void(0)" onclick="setId('+data['id']+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;<a href="#" onClick="editJournalVoucher('+data['id']+','+data['ledger_id']+')"><i class="fa fa-edit" style="color:blue;"></i></a></td></tr>';
                
                    var dvTable = $("#table_body");
                    dvTable.prepend(row);
                    var table = $('#mytable').DataTable();
            });
                
                toastr.success(data.message, 'Success');
            } else {
                toastr.error(data.message, 'Error');
            }

            $("#save").show();
            $("#wait").hide();

        }
    });
});
});

    $('#mytable').DataTable({
        "ordering": false,
        "searching": false,
        "paging": true,
        "info": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
    });

    function search_ledger(type) {
        var keyword = $("#party_balance").val();
        if (type == 'opposite_party') {
            var keyword = $("#opposite_party").val();
        }

        if (keyword.length > 0) {
            $.ajax({
                type: "POST",
                url: `${window.pageData.baseUrl}/api/search_ledger`,
                enctype: 'multipart/form-data',
                data: {
                    keyword: keyword,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.data == 1) {

                    } else {
                        if (type == 'party_balance') {
                            $("#party_balance").val("");
                        } else {
                            $("#opposite_party").val("");
                        }

                        toastr.error('Invalid party name', 'Error');
                    }
                }
            });
        }

    }

    function deleteVoucher() {
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/delete_voucher`,
            enctype: 'multipart/form-data',
            data: {
                id: $("#voucher_id").val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success');
                    $('#deleteVoucher').modal('hide');
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

    function archeiveVoucher() {
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/archieve_voucher`,
            enctype: 'multipart/form-data',
            data: {
                id: $("#voucher_id").val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success');
                    $('#archieveVoucher').modal('hide');
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

    function change_status(id) {
        var status=0;
        if($("#t"+id).prop('checked') == true){
               status=1;
        }
        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/change_status`,
            enctype: 'multipart/form-data',
            data: {
                id: id,
                status:status,
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Transaction update successfully');
                    if(data.t_status==1){
                        $("#row"+id).css("background-color", "rgb(150 221 150)");
                    }
                    else{
                        $("#row"+id).css("background-color", "white");
                    }
                    
                    // setInterval(function () {
                    //     location.reload();
                    // }, 2000);
                } else {
                    toastr.error(data.message, 'Error');
                }
            }
        });
    }



    // Edit Shift
    function editJournalVoucher(id,ledger_id) {
        $("#model_title").text("Edit Transaction");
        var ids = "#row" + id;
        var currentRow = $(ids).closest("tr");
        

        $("#id").val(id);
        $("#edit_date").val($("#rowDate" + id).text());
        $("#edit_ledger_id").val(ledger_id);
        $("#edit_party_balance").val(currentRow.find("td:eq(2)").text());
        
        
        
        $("#edit_cr_dr").val(currentRow.find("td:eq(3)").text());
        var amount_value = currentRow.find("td:eq(4)").text();
         $("#edit_amount").val(amount_value);
         $("#edit_remark").val(currentRow.find("td:eq(5)").text());
        // var opposite_party = currentRow.find("td:eq(3)").text();
        // $("#opposite_party_balance").val(opposite_party.trim());
        // $("#remark").val(currentRow.find("td:eq(6)").text());
        // if (entry_type == 1) {
        //     $("input[name=entry_type][value='" + entry_type + "']").prop("checked", true);
        //     $('#party1_section').css('display', 'block');
        // }
        // if (entry_type == 0) {
        //     $("input[name=entry_type][value='" + entry_type + "']").prop("checked", true);
        //     $('#party1_section').css('display', 'none');
        // }




        // var ActiveStatus = $(".rowDate" + id).text();
        // if (ActiveStatus == "on") {
        //     $("#active").prop('checked', true);
        //     $("#inactive").prop('checked', false);
        // } else {
        //     $("#active").prop('checked', false);
        //     $("#inactive").prop('checked', true);
        // }

        // onInput_opposite();
        // onInput_party();
        $('#addJournal').modal('show');
    }

    $('input[type=radio][name=entry_type]').change(function () {
        if (this.value == '0') {
            $("#party1_section").css('display', 'none');
            $("#party_balance").prop('required', false);
        } else if (this.value == '1') {
            $("#party1_section").css('display', 'block');
            $("#party_balance").prop('required', true);
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

    $(function() {
    $("#type").change(function() {
      if(this.value==1){
          $("#type_section").css('display','inline-block');
      }
      else{
          $("#type_section").css('display','none');
      }
    });
});



</script>
@endsection
