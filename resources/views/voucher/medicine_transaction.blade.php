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
    @media only screen and (max-width: 600px) {
    .mobile{
        width:45% !important
    }  
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
        text-align: center;
    }

    /* Enhanced table styling for better spacing */
    #mytable {
        font-size: 13px;
        line-height: 1.6;
    }
    
    #mytable th {
        padding: 15px 12px !important;
        white-space: nowrap;
        font-weight: bold;
        font-size: 12px;
        text-align: center;
        vertical-align: middle;
        min-width: 100px;
    }
    
    #mytable td {
        padding: 12px 10px !important;
        vertical-align: middle;
        text-align: center;
        word-wrap: break-word;
        min-height: 50px;
    }
    
    /* Optimized column widths for better header display */
    #mytable th:nth-child(1), #mytable td:nth-child(1) { width: 6%; } /* Sr. No */
    #mytable th:nth-child(2), #mytable td:nth-child(2) { width: 9%; } /* Date */
    #mytable th:nth-child(3), #mytable td:nth-child(3) { width: 13%; } /* Medicine */
    #mytable th:nth-child(4), #mytable td:nth-child(4) { width: 11%; } /* Ledger */
    #mytable th:nth-child(5), #mytable td:nth-child(5) { width: 7%; } /* Type */
    #mytable th:nth-child(6), #mytable td:nth-child(6) { width: 11%; } /* Med. Amount */
    #mytable th:nth-child(7), #mytable td:nth-child(7) { width: 9%; } /* Amount */
    #mytable th:nth-child(8), #mytable td:nth-child(8) { width: 7%; } /* Rate */
    #mytable th:nth-child(9), #mytable td:nth-child(9) { width: 7%; } /* Rebate */
    #mytable th:nth-child(10), #mytable td:nth-child(10) { width: 11%; } /* Remark */
    #mytable th:nth-child(11), #mytable td:nth-child(11) { width: 9%; } /* Bill */
    #mytable th:nth-child(12), #mytable td:nth-child(12) { width: 6%; } /* Action */
    
    /* Table container improvements */
    .CustomFixedTbl {
        margin: 20px 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    /* DataTable wrapper improvements */
    .dataTables_wrapper {
        padding: 20px;
    }
    
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
        margin: 10px 0;
    }
    
    /* Enhanced button hover effects */
    #plusBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4) !important;
        background: linear-gradient(45deg, #20c997 0%, #5ce1a8 100%) !important;
    }
    
    #minusBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4) !important;
        background: linear-gradient(45deg, #e74c3c 0%, #ff7979 100%) !important;
    }
    
    #totalBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4) !important;
    }
    
    #save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4) !important;
        background: linear-gradient(45deg, #0056b3 0%, #339af0 100%) !important;
    }
    
    #wait:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4) !important;
    }
</style>

<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <!-- BEGIN PAGE CONTENT BODY -->
    <div class="page-content">
        <div class="container-fluid" style="max-width: 95%; padding: 0 20px;">

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
                                    <div class="col-md-12" style="margin-bottom: 5px;">
                                        <div class="btn-group">
                                            <input type="date" id="date_from" name="date"
                                                class="input-group form-control form-control-inline"
                                                value="{{ date('Y-m-d')}}"/>
                                        </div>

                                        <input type="hidden" id="party1" name="medicine_id" />
                                        <input type="hidden" name="admin_id" value="{{Auth::user()->id}}">
                                        <div class="btn-group">
                                            <input type="text" autocomplete="off" placeholder="Medicine" 
                                                oninput='onInput_party()' list="party_balance_list" id="party_balance"
                                                name="medicine_name" class="input-group form-control form-control-inline"
                                                required autofocus>
                                            <datalist id="party_balance_list" name="medicine_id">
                                                @foreach($medicine as $m)
                                                <option value='{{$m->medicine_name}}'>{{$m->id}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="btn-group mobile" style="width:8%">
                                            <input type="text" id="amount" name="amount" autocomplete="off"  placeholder="Amount"
                                                class="input-group form-control form-control-inline" required/>
                                        </div>
                                        <div class="btn-group">
                                            <select class="form-control" name="type" id="type">
                                                <option value="minus" selected>Minus</option>
                                                <option value="plus">Plus</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="party2" name="ledger_id_2" />
                                        <div class="btn-group" style="display:none;" id="type_section">
                                            <input type="text" autocomplete="off" placeholder="Medicine"
                                                oninput='onInput_opposite()' list="opposite_party_list" id="opposite_party_balance"
                                                name="ledger_name_2" class="input-group form-control form-control-inline"
                                                >
                                            <datalist id="opposite_party_list" name="ledger_id2">
                                                @foreach($medicine as $m)
                                                <option value='{{$m->medicine_name}}'>{{$m->id}}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="btn-group mobile" style="width:8%">
                                            <input type="text" id="remark" autocomplete="off" name="remark" placeholder="remark"
                                                class="input-group form-control form-control-inline" />
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" id="save" class="btn" style="background: linear-gradient(45deg, #007bff 0%, #4dabf7 100%); color: white; font-weight: bold; border: 2px solid #0056b3; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); border-radius: 8px; padding: 8px 20px; transition: all 0.3s ease;">Save</button>
                                            <button style="display:none;" id="wait" class="btn" style="background: linear-gradient(45deg, #ffc107 0%, #ffeb3b 100%); color: #212529; font-weight: bold; border: 2px solid #e0a800; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 8px 20px;"><i
                                                    class="icon-spinner"></i>Please Wait...</button>
                                        </div>
                                    </div>
                    </form>
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light ">

                        <div class="d-flex justify-content-around my-3">
                            <!-- Plus Button -->
                            <button id="plusBtn" class="btn btn-lg" style="background: linear-gradient(45deg, #28a745 0%, #6dd5a8 100%); color: white; font-weight: bold; border: 2px solid #20c997; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); border-radius: 25px; padding: 12px 30px; margin: 5px; transition: all 0.3s ease;">
                                <i class="fa fa-plus-circle"></i> <strong>Plus: + {{ $total_plus }}</strong>
                            </button>

                            <!-- Minus Button -->
                            <button id="minusBtn" class="btn btn-lg" style="background: linear-gradient(45deg, #dc3545 0%, #ff6b7a 100%); color: white; font-weight: bold; border: 2px solid #fd7e14; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); border-radius: 25px; padding: 12px 30px; margin: 5px; transition: all 0.3s ease;">
                                <i class="fa fa-minus-circle"></i> <strong>Minus: - {{ $total_minus }}</strong>
                            </button>

                            <!-- Total Button -->
                            <button id="totalBtn" class="btn btn-lg" @if($total <= 0) style="background: linear-gradient(45deg, #dc3545 0%, #ff6b7a 100%); color: white; font-weight: bold; border: 2px solid #fd7e14; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); border-radius: 25px; padding: 12px 30px; margin: 5px; transition: all 0.3s ease;" @else style="background: linear-gradient(45deg, #28a745 0%, #6dd5a8 100%); color: white; font-weight: bold; border: 2px solid #20c997; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); border-radius: 25px; padding: 12px 30px; margin: 5px; transition: all 0.3s ease;" @endif>
                                <i class="fa fa-calculator"></i> <strong>Total: {{ $total }}</strong>
                            </button>
                        </div><br>
                        
                            <div class="table-responsive CustomFixedTbl">
                                <table class="table table-bordered" id="mytable" style="width: 100%; table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th class="text-effect">Sr. No.</th>
                                            <th class="text-effect">Date</th>
                                            <th class="text-effect">Medicine</th>
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Type</th>
                                            <th class="text-effect">Med. Amount</th>
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Rate</th>
                                            <th class="text-effect">Rebate</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Bill</th>
                                            <th class="text-effect">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-effect" id="table_body">
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                    <tfoot class="dataTables_scrollHead">
                                        <tr>
                                            <th class="text-effect">Sr. No.</th>
                                            <th class="text-effect">Date</th>
                                            <th class="text-effect">Medicine</th>
                                            <th class="text-effect">Ledger</th>
                                            <th class="text-effect">Type</th>
                                            <th class="text-effect">Med. Amount</th>
                                            <th class="text-effect">Amount</th>
                                            <th class="text-effect">Rate</th>
                                            <th class="text-effect">Rebate</th>
                                            <th class="text-effect">Remark</th>
                                            <th class="text-effect">Bill</th>
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

<!-- Modal for Medicine Transactions -->
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
                                <th>Medicie Amount</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Rate</th>
                                <th>Rebate</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="medicineTransactionsTableBody">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Total amounts display -->
                <div class="text-center mt-3">
                    <!-- Hide Plus and Minus buttons, show only Total -->
                    <button id="totalAmountButton" type="button" class="btn btn-lg" style="background: linear-gradient(45deg, #667eea 0%, #764ba2 100%); color: white; font-weight: bold; border: none; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); border-radius: 25px; padding: 12px 30px; margin: 10px;">
                        <i class="fa fa-calculator"></i> <strong>Net Amount: <span id="totalAmount"></span></strong>
                    </button>

                    <button type="button" id="generateBillButton" class="btn btn-lg" style="background: linear-gradient(45deg, #11998e 0%, #38ef7d 100%); color: white; font-weight: bold; border: none; box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4); border-radius: 25px; padding: 12px 30px; margin: 10px;">
                        <i class="fa fa-file-text"></i> <strong>Generate Bill</strong>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




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
                                        @foreach($medicine as $m)
                                        <option value='{{$m->medicine_name}}'>{{$m->id}}</option>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTransactionModal" tabindex="-1" role="dialog" aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(45deg, #ff416c 0%, #ff4b2b 100%); color: white;">
                <h5 class="modal-title" id="deleteTransactionModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> <strong>Delete Transaction</strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fa fa-trash" style="font-size: 48px; color: #ff416c;"></i>
                </div>
                <h5><strong>Are you sure you want to delete this transaction?</strong></h5>
                <p class="text-muted">This action will:</p>
                <ul class="list-unstyled text-left" style="max-width: 300px; margin: 0 auto;">
                    <li><i class="fa fa-check text-warning"></i> Set the amount to <strong>0</strong></li>
                    <li><i class="fa fa-check text-warning"></i> Mark the transaction as <strong>deleted</strong></li>
                    <li><i class="fa fa-check text-info"></i> Keep the entry visible in the table</li>
                </ul>
                <div class="alert alert-warning mt-3">
                    <small><i class="fa fa-info-circle"></i> This action cannot be undone!</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" style="background: linear-gradient(45deg, #ff416c 0%, #ff4b2b 100%); border: none;">
                    <i class="fa fa-trash"></i> <strong>Yes, Delete Transaction</strong>
                </button>
            </div>
        </div>
    </div>
</div>

<!--Add shift modal -->
<!---- Delete model------>
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
                        $("#opposite_party_list").append('<option value="' + v.name + '">' + v.id +
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
    var isSubmitting = false;

    // Handle Enter key press for navigation between input fields
    $(document).ready(function () {
    var isSubmitting = false;

    // Handle Enter key press for navigation between input fields
    $('#add_journal_voucher').on('keypress', 'input, select, textarea', function (e) {
        if (e.which === 13) {
            e.preventDefault();

            // Check if the Enter key is pressed on the remark field
            var $this = $(this);
            if ($this.attr('id') === 'remark') {
                // Validate required fields
                var valid = true;
                $('#add_journal_voucher [required]').each(function () {
                    if (!$(this).val()) {
                        valid = false;
                        return false; // Exit each loop early
                    }
                });

                if (valid && !isSubmitting) {
                    isSubmitting = true; // Set the flag immediately
                    $('#add_journal_voucher').submit(); // Submit the form if all required fields are filled
                } else if (!valid) {
                    toastr.error('Please fill out all required fields.', 'Error');
                }
                return false;
            }

            var focusable = $('#add_journal_voucher').find('input, select, textarea').not('#date_from').filter(':visible');

            var next = focusable.eq(focusable.index(this) + 1);

            if (next.length) {
                next.focus();
            } else {
                // Validate required fields
                var valid = true;
                $('#add_journal_voucher [required]').each(function () {
                    if (!$(this).val()) {
                        valid = false;
                        return false; // Exit each loop early
                    }
                });

                if (valid && !isSubmitting) {
                    isSubmitting = true; // Set the flag immediately
                    $('#add_journal_voucher').submit(); // Submit the form if all required fields are filled
                } else if (!valid) {
                    toastr.error('Please fill out all required fields.', 'Error');
                }
            }
            return false;
        }
    });

    // Handle form submission
    $(document).ready(function () {
    var isSubmitting = false;
    var enterPressCount = 0;

    // Handle Enter key press for navigation between input fields
    $(document).ready(function () {
    var isSubmitting = false;
    var enterPressCount = 0;

    // Handle Enter key press for navigation between input fields
    $('#add_journal_voucher').on('keypress', 'input, select, textarea', function (e) {
        if (e.which === 13) {
            e.preventDefault();

            var $this = $(this);
            var focusable = $('#add_journal_voucher').find('input, select, textarea').not('#date_from').filter(':visible');
            var next = focusable.eq(focusable.index(this) + 1);

            // Check if the current field is the "remark" field
            if ($this.attr('id') === 'remark') {
                enterPressCount++;
                if (enterPressCount === 1) {
                    $('#save').focus(); // Move focus to the submit button
                }
                return false;
            }

            if (next.length) {
                next.focus();
            } else {
                $('#save').focus(); // Move focus to the submit button if no more focusable elements
            }
            return false;
        }
    });

    // Handle form submission
    $('#add_journal_voucher').submit(function (e) {
        e.preventDefault();

        if (isSubmitting) {
            return false;
        }

        isSubmitting = true;
        $("#save").prop('disabled', true);
        $("#save").hide();
        $("#wait").show();
        var form = $('#add_journal_voucher')[0];
        var data = new FormData(form);

        $.ajax({
            type: "POST",
            url: `${window.pageData.baseUrl}/api/add_medicine_transaction`,
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.type == 1 || data.status == true) {
                    window.location.reload();
                    toastr.success(data.message, 'success');
                } else {
                    toastr.error(data.message, 'Error');
                    $("#party_balance").val('');
                }

                isSubmitting = false;
                $("#save").prop('disabled', false);
                $("#save").show();
                $("#wait").hide();

                // Reset the Enter press count
                enterPressCount = 0;

                // Move focus to the medicine name input field
                $('#medicine_name').focus();
            },
            error: function() {
                isSubmitting = false;
                $("#save").prop('disabled', false);
                $("#save").show();
                $("#wait").hide();
                toastr.error('An error occurred. Please try again.', 'Error');

                // Reset the Enter press count
                enterPressCount = 0;

                // Move focus to the medicine name input field
                $('#medicine_name').focus();
            }
        });
    });

    // Reset the Enter press count when focus is on submit button
    $('#save').focus(function() {
        enterPressCount = 0;
    });
});

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
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('medicineTransactionsAjax') }}",
            "type": "POST",
            "data": function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        "columns": [
            { "data": "sr_no", "orderable": false },
            { "data": "date", "orderable": false },
            { "data": "medicine_name", "orderable": false },
            { "data": "ledger_name", "orderable": false },
            { "data": "type", "orderable": false },
            { "data": "medicine_amount", "orderable": false },
            { "data": "amount", "orderable": false },
            { "data": "rate", "orderable": false },
            { "data": "rebate", "orderable": false },
            { "data": "remark", "orderable": false },
            { "data": "bill", "orderable": false },
            { "data": "action", "orderable": false }
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data.row_style) {
                $(row).attr('style', data.row_style);
            }
            $(row).attr('id', 'row' + data.id);
        },
        "ordering": false,
        "searching": true,
        "paging": true,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "info": true,
        "language": {
            "processing": "Loading medicine transactions...",
            "search": "Search transactions:",
            "lengthMenu": "Show _MENU_ transactions per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ transactions",
            "infoEmpty": "No transactions found",
            "infoFiltered": "(filtered from _MAX_ total transactions)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
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
        $('#deleteVoucher').modal('hide');
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
    let transactionToDelete = null;

    function deleteTransaction(transactionId) {
        transactionToDelete = transactionId;
        $('#deleteTransactionModal').modal('show');
    }

    // Handle confirm delete button click
    $('#confirmDeleteBtn').click(function() {
        if (transactionToDelete) {
            $.ajax({
                type: "POST",
                url: "{{ route('deleteTransaction') }}",
                data: {
                    id: transactionToDelete,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#deleteTransactionModal').modal('hide');
                    if (response.status === 'success') {
                        toastr.success(response.message, 'Success');
                        // Reload the DataTable to show updated data
                        $('#mytable').DataTable().ajax.reload();
                        // Refresh the summary totals
                        refreshSummaryTotals();
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                    transactionToDelete = null;
                },
                error: function(xhr, status, error) {
                    $('#deleteTransactionModal').modal('hide');
                    toastr.error('Error deleting transaction: ' + error, 'Error');
                    transactionToDelete = null;
                }
            });
        }
    });

    // Reset transaction ID when modal is closed
    $('#deleteTransactionModal').on('hidden.bs.modal', function () {
        transactionToDelete = null;
    });

    // Function to refresh summary totals
    function refreshSummaryTotals() {
        $.ajax({
            type: "GET",
            url: "{{ route('getMedicineTotals') }}",
            success: function(response) {
                if (response.status === 'success') {
                    // Update Plus button
                    $('#plusBtn').html('<i class="fa fa-plus-circle"></i> <strong>Plus: + ' + response.total_plus + '</strong>');
                    
                    // Update Minus button
                    $('#minusBtn').html('<i class="fa fa-minus-circle"></i> <strong>Minus: - ' + response.total_minus + '</strong>');
                    
                    // Update Total button with conditional styling
                    var totalBtnStyle = response.total <= 0 
                        ? 'background: linear-gradient(45deg, #ff416c 0%, #ff4b2b 100%); color: white; font-weight: bold; border: none; box-shadow: 0 4px 15px rgba(255, 65, 108, 0.4); border-radius: 20px; padding: 10px 25px; margin: 5px;'
                        : 'background: linear-gradient(45deg, #56ab2f 0%, #a8e6cf 100%); color: white; font-weight: bold; border: none; box-shadow: 0 4px 15px rgba(86, 171, 47, 0.4); border-radius: 20px; padding: 10px 25px; margin: 5px;';
                    
                    $('#totalBtn').attr('style', totalBtnStyle).html('<i class="fa fa-calculator"></i> <strong>Total: ' + response.total + '</strong>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error refreshing totals: ' + error);
            }
        });
    }

    function showTransactionDetails (ledgerId) {
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
                    var amountColumn = '';

                    if (transaction.type === 'minus') {
                        amountDisplay = '<span style="color: red;">- ' + (typeof transaction.medicine_amount === 'number' ? transaction.medicine_amount : '') + '</span>';
                        typeButton = '<span class="label label-sm label-danger label-mini btn cr_dr sbold" style="background-color:red">lene</span>';
                        amountColumn = '<span style="color: red;">- ' + transaction.amount + '</span>';
                    } else {
                        amountDisplay = '<span style="color: green;">+ ' + (typeof transaction.medicine_amount === 'number' ? transaction.medicine_amount : '') + '</span>';
                        typeButton = '<span class="label label-sm label-success label-mini btn cr_dr sbold" style="background-color:green">dene</span>';
                        amountColumn = '<span style="color: green;">+ ' + transaction.amount + '</span>';
                    }

                    var row = '<tr>' +
                        '<td>' + transaction.ledger_name + '</td>' +
                        '<td>' + transaction.medicine_name + '</td>' +
                        '<td>' + amountColumn + '</td>' +
                        '<td>' + amountDisplay + '</td>' +
                        '<td>' + typeButton + '</td>' +
                        '<td>' + transaction.rate + '</td>' +
                        '<td>' + transaction.rebate + '</td>' +
                        '<td>' + transaction.remark + '</td>' +
                        '</tr>';
                    $('#medicineTransactionsTableBody').append(row);
                });

                // Display totals
                $('#totalPlus').text(response.totals.totalPlus.toFixed(2));
                $('#totalMinus').text(response.totals.totalMinus.toFixed(2));
                $('#totalAmount').text(response.totals.totalAmount.toFixed(2));
                if (response.totals.totalAmount >= 0) {
                    $('#totalAmountButton').css('background-color', 'green');  // Set green background for positive amount
                } else {
                    $('#totalAmountButton').css('background-color', 'red');    // Set red background for negative amount
                }

                if (response.totals.totalAmount >= 0) {
                    $('#totalMinusAmountButton').css('background-color', 'green');  // Set green background for positive amount
                } else {
                    $('#totalMinusAmountButton').css('background-color', 'red');    // Set red background for negative amount
                }

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
