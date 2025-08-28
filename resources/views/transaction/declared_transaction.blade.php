@extends('layouts.master') 
@section('content')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
                <div class="container">

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <select class="form-control" id="shift" onChange="fetch_transaction()">
                                        <option value="" selected disable>Select Shift</option>
                                        @foreach($shifts as $shift)
                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                        @endforeach
                                    </select>                                
                                </div> 
                                <div class="btn-group">
                                    <input type="date" id="date" name="date" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <input type="text" id="keyword" name="keyword" class="input-group form-control form-control-inline" placeholder="Search Party" />                                 
                                </div> 
                                <div class="btn-group">
                                    <select class="form-control" id="staff" name="staff" onChange=fetch_transaction()>
                                        <option value="" selected>All Staff</option>
                                        @foreach($staff as $stf)
                                            <option value="{{$stf->id}}">{{$stf->name}}</option>
                                        @endforeach
                                    </select>                                
                                </div>
                                <div class="btn-group">
                                    <select class="form-control" id="type" name="type">
                                        <option value="" selected>All</option>
                                        <option value="mistake">Mistake</option>
                                    </select>                                
                                </div> 
                                <div class="btn-group">
                                    <a href="javascript:;" id="search" class="btn sbold green"> Search (F5) </a>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Live Transaction</span>
                                    </div>
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                    <th style="text-align: center;">Sr. No.</th>
                                                    <th style="text-align: center;">Party</th>
                                                    <th style="text-align: center;">Rate</th>
                                                    <th style="text-align: center;">Amount</th>
                                                    <th style="text-align: center;">Added</th>
                                                    <th style="text-align: center;">Updated</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="transaction_data">
                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                                <tr>
                                                    <th id="serial">0</th>
                                                    <th>Party</th>
                                                    <th>Rate</th>
                                                    <th id="total">0</th>
                                                    <th>Added</th>
                                                    <th>Updated</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="portlet-title"> 
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <select class="form-control" id="status" name="status" onChange=fetch_transaction()>
                                                <option value="0" selected>Active</option>
                                                <option value="1">Delete</option>
                                            </select>
                                        </div>
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f7" class="btn btn-success"> Main Jantri (F7) </a>
                                        </div>
                                        {{-- <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="hpl_jantri" class="btn btn-success"> HPL-Jantri </a>
                                        </div> --}}
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f3" class="btn btn-success"> Jantri View (F3) </a>
                                        </div>
                                        <div class="btn-group fRight" style="margin-left: 5px;">
                                            <a  href="javascript:;" id="random_f2" class="btn btn-success"> Add (F2) </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row" style="margin-bottom: 1px;text-align: center;">
                                    <div class="col-md-12 bg-blue bg-font-blue"">
                                        <h5 class="sbold">Party</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 bg-blue bg-font-blue" style="text-align: center;">
                                        <h5 class="sbold">Number</h5>
                                    </div>
                                    <div class="col-md-6 bg-blue bg-font-blue"  style="text-align: center;">
                                        <h5 class="sbold">Amount</h5>
                                    </div>
                                </div>
                                <div class="details" style="height:370px; overflow-y: scroll;">

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


    <!-- Copy modal -->
    <div class="modal fade bs-modal-sm" id="copy_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="model_title">Copy Transaction</h4>
                </div>
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="bg-blue bg-font-blue">Sr.</th>
                                        <th class="bg-blue bg-font-blue">
                                            <label class="mt-checkbox">
                                                <input type="checkbox" id="all" value="all"><span></span>
                                            </label>
                                        </th>
                                        <th class="bg-blue bg-font-blue">Shift</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shifts as $key=>$shift)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>                                                    
                                                <label class="mt-checkbox">
                                                    <input type="checkbox" name="shifts" id="inlineCheckbox{{$shift->id}}" value="{{$shift->id}}" class="checkbox"><span></span>
                                                </label>
                                            </td>
                                            <td>{{$shift->name}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">               
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="button" id="save_copy" class="btn green">Save</button> 
                </div>
            </div>
        </div>
    </div>
    <!-- Copy modal -->



    <!-- Add Jantri modal -->
    <div class="modal fade bs-modal-lg" id="random_f3_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="model_title">Jantri View</h4>
                </div>
                <div class="modal-body">  
                    <div class="portlet-body">
                        <div class="row">
                            <table class="table main_jantri_item" style="margin-bottom: 0px !important;display:none;">
                                <thead>
                                    <tr>
                                        <td style="width: 120px;vertical-align: middle;padding: 0.5rem 0.75rem;border: 0;"><b>Amount Less</b></td>
                                        <td style="width: 120px;">
                                            <input id="MainJantriAmount" class="form-control form-control-sm" type="text" placeholder="">
                                        </td>
                                        <td style="width: 100px;vertical-align: middle;padding: 0.5rem 0.75rem;border: 0;" class="text-right"><b>Less %age</b></td>
                                        <td style="width: 100px;">
                                            <input id="MainJantriPercentage" class="form-control form-control-sm" maxlength="2" type="text" placeholder="">
                                        </td>
                                        <td style="width: 60px; display:none;" class="text-right"><b>Up</b></td>
                                        <td style="width: 100px; display:none;">
                                            <input id="MainJantriMultiplyUp" class="form-control form-control-sm" maxlength="3" type="text" placeholder="">
                                        </td>
                                        <td style="width: 150px;">
                                            <button onclick="getMainJantri()" class="btn btn-info btn-block" type="button">Submit <span id="ajax_loader_maiin_jantri"></span></button>
                                        </td>
                                        <td style="width: 100px; display:none;"></td>
                                        <td></td>
                                        <td style="width:150px;"></td>
                                    </tr>
                                </thead>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">1</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">2</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">3</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">4</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">5</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">6</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">7</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">8</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">9</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">10</th>
                                        <th class="bg-blue bg-font-blue" style="text-align: center;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">1</span>
                                            <input id="number_1" onkeyup="setJantriSingleNumber(1)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">2</span>
                                            <input id="number_2" onkeyup="setJantriSingleNumber(2)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">3</span>
                                            <input id="number_3" onkeyup="setJantriSingleNumber(3)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">4</span>
                                            <input id="number_4" onkeyup="setJantriSingleNumber(4)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">5</span>
                                            <input id="number_5" onkeyup="setJantriSingleNumber(5)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">6</span>
                                            <input id="number_6" onkeyup="setJantriSingleNumber(6)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important;position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">7</span>
                                            <input id="number_7" onkeyup="setJantriSingleNumber(7)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">8</span>
                                            <input id="number_8" onkeyup="setJantriSingleNumber(8)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">9</span>
                                            <input id="number_9" onkeyup="setJantriSingleNumber(9)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">10</span>
                                            <input id="number_10" onkeyup="setJantriSingleNumber(10)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th id="JantriRow_1" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">11</span>
                                        <input id="number_11" onkeyup="setJantriSingleNumber(11)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">12</span>
                                        <input id="number_12" onkeyup="setJantriSingleNumber(12)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">13</span>
                                        <input id="number_13" onkeyup="setJantriSingleNumber(13)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">14</span>
                                        <input id="number_14" onkeyup="setJantriSingleNumber(14)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">15</span>
                                        <input id="number_15" onkeyup="setJantriSingleNumber(15)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">16</span>
                                        <input id="number_16" onkeyup="setJantriSingleNumber(16)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">17</span>
                                        <input id="number_17" onkeyup="setJantriSingleNumber(17)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">18</span>
                                        <input id="number_18" onkeyup="setJantriSingleNumber(18)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">19</span>
                                        <input id="number_19" onkeyup="setJantriSingleNumber(19)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">20</span>
                                        <input id="number_20" onkeyup="setJantriSingleNumber(20)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_2" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">21</span>
                                        <input id="number_21" onkeyup="setJantriSingleNumber(21)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">22</span>
                                        <input id="number_22" onkeyup="setJantriSingleNumber(22)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">23</span>
                                        <input id="number_23" onkeyup="setJantriSingleNumber(23)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">24</span>
                                        <input id="number_24" onkeyup="setJantriSingleNumber(24)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">25</span>
                                        <input id="number_25" onkeyup="setJantriSingleNumber(25)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">26</span>
                                        <input id="number_26" onkeyup="setJantriSingleNumber(26)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">27</span>
                                        <input id="number_27" onkeyup="setJantriSingleNumber(27)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">28</span>
                                        <input id="number_28" onkeyup="setJantriSingleNumber(28)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">29</span>
                                        <input id="number_29" onkeyup="setJantriSingleNumber(29)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">30</span>
                                        <input id="number_30" onkeyup="setJantriSingleNumber(30)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th id="JantriRow_3" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">31</span>
                                        <input id="number_31" onkeyup="setJantriSingleNumber(31)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">32</span>
                                        <input id="number_32" onkeyup="setJantriSingleNumber(32)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">33</span>
                                        <input id="number_33" onkeyup="setJantriSingleNumber(33)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">34</span>
                                        <input id="number_34" onkeyup="setJantriSingleNumber(34)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">35</span>
                                        <input id="number_35" onkeyup="setJantriSingleNumber(35)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">36</span>
                                        <input id="number_36" onkeyup="setJantriSingleNumber(36)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">37</span>
                                        <input id="number_37" onkeyup="setJantriSingleNumber(37)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">38</span>
                                        <input id="number_38" onkeyup="setJantriSingleNumber(38)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">39</span>
                                        <input id="number_39" onkeyup="setJantriSingleNumber(39)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">40</span>
                                        <input id="number_40" onkeyup="setJantriSingleNumber(40)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_4" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">41</span>
                                        <input id="number_41" onkeyup="setJantriSingleNumber(41)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">42</span>
                                        <input id="number_42" onkeyup="setJantriSingleNumber(42)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">43</span>
                                        <input id="number_43" onkeyup="setJantriSingleNumber(43)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">44</span>
                                        <input id="number_44" onkeyup="setJantriSingleNumber(44)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">45</span>
                                        <input id="number_45" onkeyup="setJantriSingleNumber(45)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">46</span>
                                        <input id="number_46" onkeyup="setJantriSingleNumber(46)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">47</span>
                                        <input id="number_47" onkeyup="setJantriSingleNumber(47)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">48</span>
                                        <input id="number_48" onkeyup="setJantriSingleNumber(48)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">49</span>
                                        <input id="number_49" onkeyup="setJantriSingleNumber(49)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">50</span>
                                        <input id="number_50" onkeyup="setJantriSingleNumber(50)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_5" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">51</span>
                                        <input id="number_51" onkeyup="setJantriSingleNumber(51)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">52</span>
                                        <input id="number_52" onkeyup="setJantriSingleNumber(52)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">53</span>
                                        <input id="number_53" onkeyup="setJantriSingleNumber(53)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">54</span>
                                        <input id="number_54" onkeyup="setJantriSingleNumber(54)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">55</span>
                                        <input id="number_55" onkeyup="setJantriSingleNumber(55)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">56</span>
                                        <input id="number_56" onkeyup="setJantriSingleNumber(56)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">57</span>
                                        <input id="number_57" onkeyup="setJantriSingleNumber(57)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">58</span>
                                        <input id="number_58" onkeyup="setJantriSingleNumber(58)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">59</span>
                                        <input id="number_59" onkeyup="setJantriSingleNumber(59)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">60</span>
                                        <input id="number_60" onkeyup="setJantriSingleNumber(60)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_6" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">61</span>
                                        <input id="number_61" onkeyup="setJantriSingleNumber(61)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">62</span>
                                        <input id="number_62" onkeyup="setJantriSingleNumber(62)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">63</span>
                                        <input id="number_63" onkeyup="setJantriSingleNumber(63)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">64</span>
                                        <input id="number_64" onkeyup="setJantriSingleNumber(64)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">65</span>
                                        <input id="number_65" onkeyup="setJantriSingleNumber(65)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">66</span>
                                        <input id="number_66" onkeyup="setJantriSingleNumber(66)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">67</span>
                                        <input id="number_67" onkeyup="setJantriSingleNumber(67)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">68</span>
                                        <input id="number_68" onkeyup="setJantriSingleNumber(68)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">69</span>
                                        <input id="number_69" onkeyup="setJantriSingleNumber(69)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">70</span>
                                        <input id="number_70" onkeyup="setJantriSingleNumber(70)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_7" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">71</span>
                                        <input id="number_71" onkeyup="setJantriSingleNumber(71)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">72</span>
                                        <input id="number_72" onkeyup="setJantriSingleNumber(72)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">73</span>
                                        <input id="number_73" onkeyup="setJantriSingleNumber(73)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">74</span>
                                        <input id="number_74" onkeyup="setJantriSingleNumber(74)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">75</span>
                                        <input id="number_75" onkeyup="setJantriSingleNumber(75)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">76</span>
                                        <input id="number_76" onkeyup="setJantriSingleNumber(76)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">77</span>
                                        <input id="number_77" onkeyup="setJantriSingleNumber(77)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">78</span>
                                        <input id="number_78" onkeyup="setJantriSingleNumber(78)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;">
                                        <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">79</span>
                                        <input id="number_79" onkeyup="setJantriSingleNumber(79)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">80</span>
                                        <input id="number_80" onkeyup="setJantriSingleNumber(80)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_8" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">81</span>
                                        <input id="number_81" onkeyup="setJantriSingleNumber(81)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">82</span>
                                        <input id="number_82" onkeyup="setJantriSingleNumber(82)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">83</span>
                                        <input id="number_83" onkeyup="setJantriSingleNumber(83)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">84</span>
                                        <input id="number_84" onkeyup="setJantriSingleNumber(84)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">85</span>
                                        <input id="number_85" onkeyup="setJantriSingleNumber(85)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">86</span>
                                        <input id="number_86" onkeyup="setJantriSingleNumber(86)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">87</span>
                                        <input id="number_87" onkeyup="setJantriSingleNumber(87)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">88</span>
                                        <input id="number_88" onkeyup="setJantriSingleNumber(88)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">89</span>
                                        <input id="number_89" onkeyup="setJantriSingleNumber(89)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">90</span>
                                        <input id="number_90" onkeyup="setJantriSingleNumber(90)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_9" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th></tr><tr><th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">91</span>
                                        <input id="number_91" onkeyup="setJantriSingleNumber(91)" class="form-control form-control-sm input-text-right ColIndex_1 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">92</span>
                                        <input id="number_92" onkeyup="setJantriSingleNumber(92)" class="form-control form-control-sm input-text-right ColIndex_2 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">93</span>
                                        <input id="number_93" onkeyup="setJantriSingleNumber(93)" class="form-control form-control-sm input-text-right ColIndex_3 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">94</span>
                                        <input id="number_94" onkeyup="setJantriSingleNumber(94)" class="form-control form-control-sm input-text-right ColIndex_4 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">95</span>
                                        <input id="number_95" onkeyup="setJantriSingleNumber(95)" class="form-control form-control-sm input-text-right ColIndex_5 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">96</span>
                                        <input id="number_96" onkeyup="setJantriSingleNumber(96)" class="form-control form-control-sm input-text-right ColIndex_6 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">97</span>
                                        <input id="number_97" onkeyup="setJantriSingleNumber(97)" class="form-control form-control-sm input-text-right ColIndex_7 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">98</span>
                                        <input id="number_98" onkeyup="setJantriSingleNumber(98)" class="form-control form-control-sm input-text-right ColIndex_8 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">99</span>
                                        <input id="number_99" onkeyup="setJantriSingleNumber(99)" class="form-control form-control-sm input-text-right ColIndex_9 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">100</span>
                                        <input id="number_100" onkeyup="setJantriSingleNumber(100)" class="form-control form-control-sm input-text-right ColIndex_10 JantriInput" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriRow_10" class="jantri-total bg-blue bg-font-blue" style="padding:5px!important; border-right:1px solid #FFF; color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_1" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_2" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_3" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_4" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_5" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_6" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_7" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_8" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_9" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriCol_10" style="padding:5px!important; border-right:1px solid #FFF; text-align:right;">0</th>
                                        <th class=" bg-blue bg-font-blue" id="JantriDaraTotal" style="padding:5px!important; border-top:1px solid #FFF; text-align:right;">0</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B1</span>
                                            <input id="number_111" onkeyup="setJantriSingleNumber(111)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B2</span>
                                            <input id="number_222" onkeyup="setJantriSingleNumber(222)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;">
                                            <span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B3</span>
                                            <input id="number_333" onkeyup="setJantriSingleNumber(333)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0">
                                        </th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B4</span>
                                        <input id="number_444" onkeyup="setJantriSingleNumber(444)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B5</span>
                                        <input id="number_555" onkeyup="setJantriSingleNumber(555)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B6</span>
                                        <input id="number_666" onkeyup="setJantriSingleNumber(666)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B7</span>
                                        <input id="number_777" onkeyup="setJantriSingleNumber(777)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B8</span>
                                        <input id="number_888" onkeyup="setJantriSingleNumber(888)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B9</span>
                                        <input id="number_999" onkeyup="setJantriSingleNumber(999)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">B0</span>
                                        <input id="number_000" onkeyup="setJantriSingleNumber(000)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriBaharTotal" class="jantri-total  bg-blue bg-font-blue" style="padding:5px!important;  color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                    <tr>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A1</span>
                                        <input id="number_1111" onkeyup="setJantriSingleNumber(1111)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A2</span>
                                        <input id="number_2222" onkeyup="setJantriSingleNumber(2222)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A3</span>
                                        <input id="number_3333" onkeyup="setJantriSingleNumber(3333)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A4</span>
                                        <input id="number_4444" onkeyup="setJantriSingleNumber(4444)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A5</span>
                                        <input id="number_5555" onkeyup="setJantriSingleNumber(5555)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A6</span>
                                        <input id="number_6666" onkeyup="setJantriSingleNumber(6666)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A7</span>
                                        <input id="number_7777" onkeyup="setJantriSingleNumber(7777)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A8</span>
                                        <input id="number_8888" onkeyup="setJantriSingleNumber(8888)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A9</span>
                                        <input id="number_9999" onkeyup="setJantriSingleNumber(9999)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th style="padding:1px!important; position:relative;"><span style="position:absolute; background:#fada82; width:18px; font-size:9px; text-align:center;">A0</span>
                                        <input id="number_0000" onkeyup="setJantriSingleNumber(0000)" class="form-control form-control-sm input-text-right" type="number" maxlength="7" onkeypress="return isNumberKey(event)" min="0"></th>
                                        <th id="JantriAndarTotal" class="jantri-total  bg-blue bg-font-blue" style="padding:5px!important;  color: #ffffff; text-align:right;">0</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Add Jantri modal -->

    <input type="hidden" id="numbers" value="" />
    <input type="hidden" id="amounts" value="" />
    <input type="hidden" id="transaction" value="" />


@endsection
@section('js')
<script>

    function getMainJantri(){
        clear();
        $.ajax({		            	
            type: "POST",
            url: "{{route('fetch_mainjantri_transaction')}}",
            enctype: 'multipart/form-data',
            data: {shift:$('#shift').val(),date:$('#date').val(),"_token": "{{ csrf_token() }}"},                            
            success: function(res)
            {
                if(res.status == 'success'){
                    // set data to main jantri
                    $.each(res.data, function (key, value) {
                        var numbers=JSON.parse(value['number']);
                        var amounts=JSON.parse(value['amount']);
                        for (let index = 0; index < numbers.length; index++) {
                            var amount=0;
                            if ($('#number_'+numbers[index]).val()!='') {
                                amount=$('#number_'+numbers[index]).val();
                            }
                            var total_amount=parseFloat(amount)+parseFloat(amounts[index]);
                            $('#number_'+numbers[index]).val(total_amount);
                        }
                    });

                    // calculate if less amount or less precentage is given
                    if ($('#MainJantriAmount').val()!='') {
                        for(var i=1; i<=100; i++)
                        {
                            if ($('#number_'+i).val()!='') {
                                $('#number_'+i).val(parseFloat($('#number_'+i).val())-parseFloat($('#MainJantriAmount').val()));
                            }
                        }
                        
                        for(var i=0; i<=9; i++)
                        {
                            var no = i+''+i+''+i;
                            if ($('#number_'+no).val()!='') {
                                $('#number_'+no).val(parseFloat($('#number_'+no).val())-parseFloat($('#MainJantriAmount').val()));
                            }
                            
                            var no = i+''+i+''+i+''+i;
                            if ($('#number_'+no).val()!='') {
                                $('#number_'+no).val(parseFloat($('#number_'+no).val())-parseFloat($('#MainJantriAmount').val()));
                            }
                        }
                    }
                    if ($('#MainJantriPercentage').val()!='') {
                        for(var i=1; i<=100; i++)
                        {
                            if ($('#number_'+i).val()!='') {
                                $('#number_'+i).val(parseFloat($('#number_'+i).val())-parseFloat($('#number_'+i).val())*parseFloat($('#MainJantriPercentage').val()/100));
                            }
                        }
                        
                        for(var i=0; i<=9; i++)
                        {
                            var no = i+''+i+''+i;
                            if ($('#number_'+no).val()!='') {
                                $('#number_'+no).val(parseFloat($('#number_'+no).val())-parseFloat($('#number_'+no).val())*parseFloat($('#MainJantriPercentage').val()/100));
                            }
                            
                            var no = i+''+i+''+i+''+i;
                            if ($('#number_'+no).val()!='') {
                                $('#number_'+no).val(parseFloat($('#number_'+no).val())-parseFloat($('#number_'+no).val())*parseFloat($('#MainJantriPercentage').val()/100));
                            }
                        }
                    }

                    calculate_jantri_total();
                }
                else{
                    toastr.error(res.message, 'Error');
                    return false;
                }
            }
        });       
    }


    function calculate_jantri_total(){

        var GrandTotal = 0;
        var DaraTotal=0;
        var BaharTotal=0;
        var AkharTotal=0;
        var RowTotal=0;
        var x = 1;
        for(var i=1; i<=100; i++)
        {
            var no = i;
            var AmountTotal = parseInt(($('#number_'+no).val()=="" ? 0 : $('#number_'+no).val()));
            DaraTotal += AmountTotal;
            
            if(x<=10){
                RowTotal += AmountTotal;	
            }
            x++;
            if(x==11){
                var Row = Math.floor(((no)*10)/100);
                $('#JantriRow_'+Row).text(RowTotal);
                x=1;
                RowTotal = 0;
            }
        }
        
        for(var i=0; i<=9; i++)
        {
            var no = i+''+i+''+i;
            var AmountTotal = parseInt(($('#number_'+no).val()=="" ? 0 : $('#number_'+no).val()));
            BaharTotal += AmountTotal;
            
            var no = i+''+i+''+i+''+i;
            var AmountTotal = parseInt(($('#number_'+no).val()=="" ? 0 : $('#number_'+no).val()));
            AkharTotal += AmountTotal;
        }
        
        // Horizontal Total
        for(var i=1; i<=10; i++){
            var Total = 0;
            $('.ColIndex_'+i).each(function() {
                Total += parseInt(($(this).val()=="" ? 0 : $(this).val()));
                $('#JantriCol_'+i).text(Total);
            });
        }
        
        $('#JantriDaraTotal').text(DaraTotal);
        $('#JantriBaharTotal').text(BaharTotal);
        $('#JantriAndarTotal').text(AkharTotal);
        
        GrandTotal = DaraTotal+BaharTotal+AkharTotal;
            
        $('#GrandTotal').text(GrandTotal.toLocaleString());
    }


    // open Main jantri view
    $("#random_f7").click(function(){
        
        if ($('#shift').val()=='') {
            toastr.error("Please select any shift to view main jantri!!", 'Error');
            return false;
        }

        $('#model_title').text("Main Jantri | "+$("#shift option:selected").text()+" | "+$('#date').val());
        $('.main_jantri_item').show();
        clear();
        $('#random_f3_model').modal('show');
    });


    $("#save_copy").click(function(){

        var shifts=[];
        $.each($("input[name='shifts']:checked"), function(){
            shifts.push($(this).val());
        });

        if (shifts.length<1) {
            toastr.error("Select atleast one shift to copy transaction!!", 'Error');
            return false;
        }

        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/copy_transaction`,
            enctype: 'multipart/form-data',
            data: {id:$('#transaction').val(),shifts:shifts,user:{{Auth::User()->id}}},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    $('#copy_model').modal('hide');
                    toastr.success("Transaction copied successfully", 'Success');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    });

    $("#all").click(function(){
        $('.checkbox').not(this).prop('checked', this.checked);
    });

    function copy_transaction(id) {
        $('#transaction').val(id);
        $('#copy_model').modal('show');
    }

    function delete_transaction(id){
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/delete_transaction`,
            enctype: 'multipart/form-data',
            data: {id:id},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    $('#delete'+id).hide();
                    toastr.success("Transaction deleted successfully", 'Success');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

    function fetch_transaction(){
        var shift=$('#shift').val();

        var table = $('#mytable').DataTable();
        table.destroy();
        $('#transaction_data').empty();
        $('.footer').hide();

        if (shift) {
            $.ajax({		            	
                type: "POST",
                url: `${window.pageData.baseUrl}/api/fetch_transaction`,
                enctype: 'multipart/form-data',
                data: {shift:shift,date:$('#date').val(),keyword:$('#keyword').val(),staff:$('#staff').val(),status:$('#status').val()},                                     
                success: function(res)
                {
                    if(res.status == 'success'){
                        var html='';
                        var last_serial=0;
                        var total=0;
                        $.each(res.data, function (key, value) {
                            var serial=parseFloat(key)+1;
                            last_serial=serial;
                            var url="{{url('edit-transaction')}}/"+value['id'];
                            // if (value['status']==0) {
                                html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><a href="javascript:;" id="copy'+value['id']+'" class="btn btn-xs yellow" onclick="copy_transaction('+value['id']+')">Copy</a><a href="javascript:;" id="view'+value['id']+'" class="btn btn-xs green" onclick="transaction_detail('+value['id']+')">View</a><a href="'+url+'" id="edit'+value['id']+'" class="btn btn-xs blue">Edit</a><a href="javascript:;" id="delete'+value['id']+'" class="btn btn-xs red" onclick="delete_transaction('+value['id']+')"> Delete </a></td></tr>';
                                // html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><a href="javascript:;" id="copy'+value['id']+'" class="btn btn-xs yellow" onclick="copy_transaction('+value['id']+')">Copy</a><a href="javascript:;" id="view'+value['id']+'" class="btn btn-xs green" onclick="transaction_detail('+value['id']+')">View</a></td></tr>';
                            // } else {
                            //     html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><spna style="color:red;">Deleted</span></td></tr>';
                            // }
                            total=parseFloat(total)+parseFloat(value['total']);
                        });
                        $("#transaction_data").append(html)
                        $("#total").text(total);
                        $("#serial").text(last_serial);
                        $('.footer').show();

                        $('#mytable').DataTable({
                            "ordering": false,
                            "searching": false,
                            "paging": true,
                            "info": false,
                            scrollY: 250,
                            "scroller":true,
                        });
                    }
                    else{
                        toastr.error(res.message, 'Error');
                    }
                }
            });
        }
        else{
            toastr.error("Select any shift to get transactions!!", 'Error');
        }
    }

    function transaction_detail(id){
        $(".details").empty()
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/transaction_detail`,
            enctype: 'multipart/form-data',
            data: {id:id},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    var numbers=JSON.parse(res.data.number);
                    var amounts=JSON.parse(res.data.amount);
                    $('#numbers').val(res.data.number);
                    $('#amounts').val(res.data.amount);
                    var html='';
                    for (let index = 0; index < amounts.length; index++) {
                        html +='<div class="row"><div class="col-md-6" style="text-align: center;"><h5 class="sbold">'+numbers[index]+'</h5></div><div class="col-md-6"  style="text-align: center;"><h5 class="sbold">'+amounts[index]+'</h5></div></div>';
                    }
                    $(".details").append(html)
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

    // F2
    document.onkeyup = KeyCheck;
    function KeyCheck(e)
    {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        if(KeyID == 113) // Add
        {
            $("#random_f2").click();
        }

        if(KeyID == 40) // Key Down
        {
            $("#shift").focus();
        }

        if(KeyID == 114) // Normal jantri view  (F3)
        {
            $("#random_f3").click();
        }

        if(KeyID == 118) // Main jantri view (F7)
        {
            $("#random_f7").click();
        }
        
        if(KeyID == 116) // Search (F5)
        {
            $("#search").click();
        }
    }


    $("#search").click(function(){
        fetch_transaction();
    });

    // open model jantri view
    $("#random_f3").click(function(){
        if ($('#numbers').val()=='') {
            toastr.error("Please select any transaction to view!!", 'Error');
            return false;
        }

        $('.main_jantri_item').hide();
        clear();

        var numbers=JSON.parse($("#numbers").val());
        var amounts=JSON.parse($("#amounts").val());

        for (let i = 0; i < numbers.length; i++) {
            $('#number_'+numbers[i]).val(amounts[i]);
        }        

        // Set total to jantri view
        calculate_jantri_total();

        $('#random_f3_model').modal('show');
    });

    // save link
    $("#random_f2").click(function(){
        var shift=$('#shift').val();
        if (shift) {
            window.open("{{url('add-transaction')}}"+"/"+shift,"_blank");
        } else {
            toastr.error("Please select a valid shift!!", 'Error');
        }
    });

    function clear(){

        $('#transaction_fields').empty();
        $('#amount_count').text(0);
        $('#total').text(0);
        $('#total_amount').val(0);
        $('#rate').text("Rate: 0/0-0/0");                          
        $('#party').val('');
        $('.number1').val('');
        $('.amount1').val('');

        var numbers=$("input[name='number[]']").map(function(){
            return $(this).val();
        }).get();

        for (let i = 0; i < numbers.length; i++) {
            $('#number_'+numbers[i]).val('');
        }        

        // Set data to jantri view
        var x = 1;
        for(var i=1; i<=100; i++)
        {
            var no = i;
            $('#number_'+no).val('');
            
            var Row = Math.floor(((no)*10)/100);
            $('#JantriRow_'+Row).text(0);
        }

        for(var i=0; i<=9; i++)
        {
            var no = i+''+i+''+i;
            $('#number_'+no).val('');
            
            var no = i+''+i+''+i+''+i;
            $('#number_'+no).val('');
        }

        // Horizontal Total
        for(var i=1; i<=10; i++){
            $('.ColIndex_'+i).each(function() {
                $('#JantriCol_'+i).text(0);
            });
        }

        $('#JantriDaraTotal').text(0);
        $('#JantriBaharTotal').text(0);
        $('#JantriAndarTotal').text(0);            
        $('#GrandTotal').text(0);
    }

</script>    
@endsection
