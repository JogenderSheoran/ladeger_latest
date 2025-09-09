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

    .text-effect {
        position: relative;
    }

    .text-effect .corner-amount {
        position: absolute;
        top: 2px;
        right: 5px;
        font-size: 1rem;  /* बड़ा font size */
        font-weight: bold;
    }

</style>

@php
    $id = request()->route('id');
@endphp

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
                    <span>Transaction History</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMBS -->

            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="page-content-inner">


                <div class="row">

                    <form id="add_journal_voucher">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title">
                                  {{--  <div class="col-md-12" style="margin-bottom: 5px;">
                                        <div class="btn-group">
                                            <input type="date" id="date_from" name="date"
                                                class="input-group form-control form-control-inline"
                                                value="{{ date('Y-m-d')}}" autofocus/>
                                        </div>

                                        <input type="hidden" id="party1" name="ledger_id" />
                                        <input type="hidden" id="admin_id" name="admin_id" value='{{Auth::user()->id}}' />
                                        <div class="btn-group">
                                            <input type="text" autocomplete="off" placeholder="Ledger" 
                                                oninput='onInput_party()' list="party_balance_list" id="party_balance"
                                                name="ledger_name" class="input-group form-control form-control-inline"
                                                required>
                                            <datalist id="party_balance_list" name="ledger_id">
                                                @foreach($ledger as $l)
                                                <option value='{{$l->name}}'>{{$l->id}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="btn-group" style="width:8%">
                                            <input type="text" id="amount" name="amount" autocomplete="off"  placeholder="Amount"
                                                class="input-group form-control form-control-inline" required/>
                                        </div>
                                        <div class="btn-group">
                                            <select class="form-control" name="cr_dr" id="party_type">
                                                <option value="lene" selected>Lene</option>
                                                <option value="dene">Dene</option>
                                            </select>
                                        </div>
                                        <div class="btn-group">
                                            <select class="form-control" name="type" id="type">
                                                <option value="0" selected>Direct</option>
                                                <option value="1">Interchange</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="party2" name="ledger_id_2" />
                                        <div class="btn-group" style="display:none;" id="type_section">
                                            <input type="text" autocomplete="off" placeholder="Ledger"
                                                oninput='onInput_opposite()' list="opposite_party_list" id="opposite_party_balance"
                                                name="ledger_name_2" class="input-group form-control form-control-inline"
                                                >
                                            <datalist id="opposite_party_list" name="ledger_id2">
                                                @foreach($ledger as $l)
                                                <option value='{{$l->name}}'>{{$l->id}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="btn-group" style="width:8%">
                                            <input type="text" id="remark" autocomplete="off" name="remark" placeholder="remark"
                                                class="input-group form-control form-control-inline" />
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" id="save" class="btn green">Save</button>
                                            <button style="display:none;" id="wait" class="btn yellow"><i
                                                    class="icon-spinner"></i>Please Wait...</button>
                                        </div>
                                    </div>--}}
                    </form>
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light ">
                            <div class="table-responsive CustomFixedTbl">
                            <div class="d-flex justify-content-around my-3">
                            <!-- Plus Button -->
                            {{--<button id="plusBtn" class="btn" style="background: #1e7e34; color: white; font-weight: bold; border: 1px solid #155724; box-shadow: 0 2px 8px rgba(30, 126, 52, 0.3); ">
                                <i class="fa fa-plus-circle"></i> <strong>Plus: + {{ $total_plus }}</strong>
                            </button>

                            <!-- Minus Button -->
                            <button id="minusBtn" class="btn" style="background: #bd2130; color: white; font-weight: bold; border: 1px solid #721c24; box-shadow: 0 2px 8px rgba(189, 33, 48, 0.3); ">
                                <i class="fa fa-minus-circle"></i> <strong>Minus: - {{ $total_minus }}</strong>
                            </button>--}}

                            <!-- Total Button -->
                            <button id="totalBtn" class="btn" @if($total <= 0) style="background: #bd2130;float:right;color: white; font-weight: bold; border: 1px solid #721c24; box-shadow: 0 2px 8px rgba(189, 33, 48, 0.3); " @else style="background: #1e7e34;float:right;color: white; font-weight: bold; border: 1px solid #155724; box-shadow: 0 2px 8px rgba(30, 126, 52, 0.3); " @endif>
                                <i class="fa fa-calculator"></i> <strong>Medicine Bill: {{ $total }}</strong>
                            </button>
                        </div><br>

                                <table class="table table-bordered" id="mytable">
                                    <thead>
                                        <tr>
                                        <th class="text-effect">Sr. No.</th>
                                            <th class="text-effect">Date</th>
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Med.</th>
                                            <th class="text-effect">Cr/Dr</th>
                                            <th class="text-effect">Med. Amount</th>
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Status</th>
                                            <th class="text-effect">Opening Bal.</th>
                                            <th class="text-effect">Closing Bal.</th>
                                            <th class="text-effect">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-effect" id="table_body">

                                    @foreach($data as $key => $value)
                                        <tr id="row{{$value->id}}" @if($value->transaction_status==1) style="background-color:rgb(150 221 150)" @endif>
                                            <td class="text-effect">{{++$key}}</td>
                                            <td class="text-effect">{{date('d-m-Y',strtotime($value->date))}}</td>
                                            <td class="text-effect"> {{$value->ledger_name}}</td>
                                            <td class="text-effect">@if($value->medicine_transaction==1) {{$value->medicine_name}} @else  @endif</td>
                                            <td class="text-effect">
                                                @if($value->medicine_transaction=='' || $value->medicine_transaction==0)
                                                <span class="label label-sm label-success label-mini btn cr_dr  sbold" @if($value->cr_dr=='lene') style="background-color:red" @else style="background-color:green" @endif>
                                                    {{$value->cr_dr}}
                                                </span>
                                                @else
                                                <span class="label label-sm label-success label-mini btn cr_dr  sbold" @if($value->medicine_transaction_type=='minus') style="background-color:red" @else style="background-color:green" @endif>
                                                    @if($value->medicine_transaction_type=='minus')lene @else dene @endif</span>
                                                @endif

                                            </td>
                                            
                                            <td class="text-effect position-relative">
                                            @if($value->medicine_transaction==1)
                                                {{ substr_replace($value->medicine_amount, '.', -2, 0) }}
                                                <span class="corner-amount {{ ($total ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                                    {{ $total ?? '' }}
                                                </span>
                                            @endif
                                        </td>
                                            <td class="text-effect"> @if($value->medicine_transaction==0) {{substr_replace($value->amount,'.',-2,0)}} @else {{substr_replace($value->medicine_new_amount,'.',-2,0)}}  @endif</td>
                                            <td class="text-effect">{{$value->remark}} @if($value->remark1!='') ({{$value->remark1}}) @endif</td>

                                            <td class="text-effect"><input @if($value->transaction_status==1) checked @endif type="checkbox" id="t{{$value->id}}" class="form-control" style="height:15px;" onclick="change_status({{$value->id}})" ></td>
                                            <td class="text-effect">{{$value->opening_balance}}</td>
                                            <td class="text-effect">{{$value->closing_balance}}</td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="setArchieveId({{$value->id}})"><span class="label label-danger" style="background-color:red"><b>Archive</b></span></a>&nbsp;&nbsp;
                                                {{-- <a href="javascript:void(0)" onclick="showTransactionDetails({{$value->ledger_id}})"><i class="fa fa-eye" style="color:blue;"></i></a>
                                                <a href="javascript:void(0)" onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;
                                                @if($value->medicine_transaction==0)
                                                <a href="#"
                                                    onClick="editJournalVoucher({{$value->id}},{{$value->ledger_id}})"><i
                                                        class="fa fa-edit" style="color:blue;"></i></a>
                                                @endif--}}
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
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Med.</th>
                                            <th class="text-effect">Cr/Dr</th>
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Med. Amount</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Status</th>
                                            <th class="text-effect">Opening Bal.</th>
                                            <th class="text-effect">Closing Bal.</th>
                                            <th class="text-effect">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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
    <form id="edit_journal_voucher">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:blue;color:white;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="model_title"><b>Add Transaction</b></h4>
                </div>
                <input type="hidden" name="table_row" id="table_row" >
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="updatedBy" id="updatedBy" value="{{Auth::user()->company}}">
                <div class="modal-body">
                    <div class="portlet-body">
                        <input type="hidden" name="edit_ledger_id" id="edit_ledger_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date</label>
                                    <input type="date" autocomplete="off" name="edit_date" id="edit_date" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Amount</label>
                                    <div class="input-group">
                                        <input type="number" autocomplete="off" name="edit_amount" id="edit_amount" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Lene/Dene</label><br />
                                    <select class="form-control" id="edit_cr_dr" name="edit_cr_dr" required readonly>
                                        <option value="lene">Lene</option>
                                        <option value="dene">Dene</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="party1_section">
                                <div class="form-group">
                                    <label class="control-label">Ledger</label><br />
                                    <input type="text" autocomplete="off" oninput='onInput_party()'
                                        list="party_balance_list" id="edit_party_balance" name="edit_party_balance"
                                        class="input-group form-control form-control-inline" readonly>
                                    <datalist id="party_balance_list">
                                        @foreach($ledger as $l)
                                        <option value='{{$l->name}}'>{{$l->id}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Remark</label>
                                    <input type="text" name="remark" autocomplete="off" class="form-control" id="edit_remark" readonly>
                                    <span></span>
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
                                <th>Ledger Name</th>
                                <th>Medicine Name</th>
                                <th>Amount</th>
                                <th>Medicie Amount</th>
                                <th>Type</th>
                                <th>Rate</th>
                                <th>Rebate</th>
                            </tr>
                        </thead>
                        <tbody id="medicineTransactionsTableBody">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Total amounts display -->
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-success btn-lg">
                        <span class="badge badge-pill badge-light">+</span> Total Plus: <span id="totalPlus"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-lg">
                        <span class="badge badge-pill badge-light">-</span> Total Minus: <span id="totalMinus"></span>
                    </button>
                    <button type="button" class="btn btn-primary btn-lg">
                        Total Amount: <span id="totalAmount"></span>
                    </button>
                    <button type="button" id="generateBillButton" class="btn btn-primary btn-lg">
                        Generate Bill 
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ledgerId">
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
<script type="text/javascript">
    function showTransactionDetails(ledgerId) {
        $.ajax({
            url: '{{ route("ledgerMedicine") }}',
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
                    var amountDisplay = '';
                    var typeButton = '';
                    if (transaction.medicine_transaction_type === 'minus') {
                        amountDisplay = '<span style="color: red;">- ' + (typeof transaction.medicine_amount === 'number' ? transaction.medicine_amount.toFixed(2) : '') + '</span>';
                        typeButton = '<button class="btn btn-danger btn-sm">Minus</button>';
                    } else {
                        amountDisplay = '<span style="color: green;">+ ' + (typeof transaction.medicine_amount === 'number' ? transaction.medicine_amount.toFixed(2) : '') + '</span>';
                        typeButton = '<button class="btn btn-success btn-sm" style="background-color:green">Plus</button>';
                    }



                    var row = '<tr>' +
                        '<td>' + transaction.ledger_name + '</td>' +
                        '<td>' + transaction.medicine_name + '</td>' +
                        '<td>' + transaction.medicine_new_amount + '</td>' +
                        '<td>' + amountDisplay + '</td>' +
                        '<td>' + typeButton + '</td>' +
                        '<td>' + transaction.rate.toFixed(2) + '</td>' +
                        '<td>' + transaction.rebate.toFixed(2) + '</td>' +
                        '</tr>';
                    $('#medicineTransactionsTableBody').append(row);
                });

                // Display totals
                $('#totalPlus').text(response.totals.totalPlus.toFixed(2));
                $('#totalMinus').text(response.totals.totalMinus.toFixed(2));
                $('#totalAmount').text(response.totals.totalAmount.toFixed(2));
                $('#ledgerId').val(response.ledgerId);
                // Show the modal
                $('#medicineTransactionsModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching ledger medicine transactions:', error);
                // Handle error display or logging
            }
        });
    }

    $(document).on('click', '#generateBillButton', function() {
        var ledgerId = $('#ledgerId').val(); // Make sure you have the ledgerId value available

        $.ajax({
            url: '{{ route("ledgerBillUpdate") }}', // Route to your update status endpoint
            type: 'POST',
            data: {
                ledger_id: ledgerId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.status==true){
                    toastr.success('Bill generated successfully!', 'Success');
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000); // Reload after 2 seconds
                }
                else{
                    toastr.success(response.message, 'Error');
                }
               
                // Optionally, you can reload the page or update the UI accordingly
            },
            error: function(xhr, status, error) {
                console.error('Error updating ledger status:', error);
                // Handle error display or logging
            }
        });
    });
</script>
@endsection
