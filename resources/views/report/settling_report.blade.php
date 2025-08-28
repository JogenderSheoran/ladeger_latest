@extends('layouts.master') 
@section('content')

<style>
    table, th, td {
        text-align: center;
    }
</style>

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
                <div class="container">

                    <!-- BEGIN PAGE CONTENT INNER -->
                    <div class="page-content-inner">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 5px;"> 
                                <div class="btn-group">
                                    <input type="date" id="date_from" name="date_from" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <input type="date" id="date_to" name="date_to" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <select class="form-control select2" id="party">
                                        <option value="" selected disable>Select Party</option>
                                        @foreach($ledgers as $ledger)
                                            <option value="{{$ledger->id}}">{{$ledger->name}}</option>
                                        @endforeach
                                    </select>                                
                                </div>
                                <div class="btn-group">
                                    <span class="label label-success" id="rate"> Rate: 90/10 | 20/80 </span>
                                </div>
                                <div class="btn-group">
                                    <span class="label label-success" id="balance"> Balance: 34234Dr </span>
                                </div>
                                <div class="btn-group">
                                    <span class="label label-success" id="limit"> Limit: 234Dr </span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class=" ">
                                    <div class="caption font-dark">
                                        <span class="caption-subject bold uppercase">Settling Report</span>
                                    </div>
                                    
                                    <div class="portlet-body">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                    <th style="text-align: center;">Date</th>
                                                    <th style="text-align: center;">OP-Bal</th>
                                                    <th style="text-align: center;">Total Sale</th>
                                                    <th style="text-align: center;">Dara Sale</th>
                                                    <th style="text-align: center;">Akhar Sale</th>
                                                    <th style="text-align: center;">Comm</th>
                                                    <th style="text-align: center;">D/A-Open</th>
                                                    <th style="text-align: center;">Hissa</th>
                                                    <th style="text-align: center;">TPC</th>
                                                    <th style="text-align: center;">HP-Amt</th>
                                                    <th style="text-align: center;">P&L	</th>
                                                    <th style="text-align: center;">Payment</th>
                                                    <th style="text-align: center;">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report_data">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
    </div>
    <!-- END CONTENT -->


    <div class="modal fade" id="ShiftModal" style="background: #fff;" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
        <div class="modal-header bg-blue bg-font-blue">
        <h5 class="modal-title"><span id="ShiftPartyName"></span> | <span id="as_ReportingTime">FROM</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body" style="padding:3px !important;">
        <div class="table-responsive">
            <div class="table-responsive table2excel CustomFixedTbl">
                <table style="width:99.9%;" class="table table-bordered">
                    <thead class="bg-blue bg-font-blue">
                        <tr style="border-top:1px solid #DDD;">
                        <th>SR.</th>
                        <th style="width:200px;">Shift</th>
                        <th class="text-center">RATE</th>
                        <th class="text-center">S-HISSA</th>
                        <th class="text-right">T-SALE</th>
                        <th class="text-right">D-SALE</th>
                        <th class="text-right">A-SALE</th>
                        <th class="text-right">COMM</th>
                        <th class="text-right">O-DARA</th>
                        <th class="text-right">O-AKHAR</th>
                        <th class="text-right">TPC</th>
                        <th class="text-right">HISSA</th>
                        <th class="text-right">DEBIT</th>
                        <th class="text-right">CREDIT</th>
                        </tr>
                    </thead>
                    <tbody id="ShiftListBodyPanel"></tbody>
                    <tfoot id="footer" class="bg-blue bg-font-blue" style="display: none">
                        <tr style="border-top:1px solid #DDD;">
                            <th id="serial_m">SR.</th>
                            <th style="width:200px;" id="shift_m">Shift</th>
                            <th class="text-center">RATE</th>
                            <th class="text-center">0</th>
                            <th class="text-right" id="total_sale_m">T-SALE</th>
                            <th class="text-right" id="d_sale_m">D-SALE</th>
                            <th class="text-right" id="a_sale_m">A-SALE</th>
                            <th class="text-right" id="comm_m">COMM</th>
                            <th class="text-right" id="o_dara_m">O-DARA</th>
                            <th class="text-right" id="o_akhar_m">O-AKHAR</th>
                            <th class="text-right" id="tpc_m">TPC</th>
                            <th class="text-right" id="hissa_m">HISSA</th>
                            <th class="text-right" id="debit_m">DEBIT</th>
                            <th class="text-right" id="credit_m">CREDIT</th>
                            </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        </div>
        </div>
        </div>
    </div>


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

    <input type="hidden" id="date" />

@endsection
@section('js')
<script>

    function open_jantri(id){
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/ledger_daily_report`,
            enctype: 'multipart/form-data',
            data: {shift:id,date:$('#date').val(),ledger:$('#party').val()},                                     
            success: function(res)
            {
                if(res.status == 'success'){

                    clear();

                    var numbers=res.numbers;
                    var amounts=res.amounts;

                    for (let i = 0; i < numbers.length; i++) {
                        $('#number_'+numbers[i]).val(amounts[i]);
                    }        

                    // Set data to jantri view
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

                    $('#random_f3_model').modal('show');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }


    function clear(){

        $('#transaction_fields').empty();
        $('#amount_count').text(0);
        $('#total').text(0);
        $('#total_amount').val(0);
        $('#rate').text("Rate: 0/0-0/0");                          
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

    function open_details(date){

        $("#date").val(date);

        $("#ShiftListBodyPanel").empty();
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/profit_loss_data`,
            enctype: 'multipart/form-data',
            data: {date_from:date,date_to:date,'ledger_id':$('#party').val()},                                     
            success: function(res)
            {
                if(res.status == 'success'){
                    var html='';
                    var total=0;
                    var d_sale=0;
                    var a_sale=0;
                    var comm=0;
                    var o_dara=0;
                    var o_akhar=0;
                    var tpc=0;
                    var hissa=0;
                    var credit=0;
                    var debit=0;
                    $.each(res.data, function (key, shift) {
                        var serial=parseFloat(key)+1;
                        var commission=shift['commission'];
                        if (commission>0) {
                            commission="-"+commission;
                        }
                        html +='<tr><td>'+serial+'</td><td style="cursor: pointer;background-color: lightgray;" onClick="open_jantri('+shift['id']+')">'+shift['name']+'</td><td>'+res.ledger['dara']+'/'+res.ledger['dara_commission']+'</td><td>0</td><td>'+shift['total']+'</td><td>'+shift['dara_total']+'</td><td>'+shift['akhar_total']+'</td><td>'+commission+'</td><td>'+shift['o_dara']+'</td><td>'+shift['o_akhar']+'</td><td>'+shift['tpc']+'</td><td>'+shift['hissa']+'</td><td>'+shift['debit']+'</td><td>'+shift['credit']+'</td></tr>';

                        total=parseFloat(total)+parseFloat(shift['total']);
                        d_sale=parseFloat(d_sale)+parseFloat(shift['dara_total']);
                        a_sale=parseFloat(a_sale)+parseFloat(shift['akhar_total']);
                        comm=parseFloat(comm)+parseFloat(shift['commission']);
                        o_dara=parseFloat(o_dara)+parseFloat(shift['o_dara']);
                        o_akhar=parseFloat(o_akhar)+parseFloat(shift['o_akhar']);
                        tpc=parseFloat(tpc)+parseFloat(shift['tpc']);
                        hissa=parseFloat(hissa)+parseFloat(shift['hissa']);
                        credit=parseFloat(credit)+parseFloat(shift['credit']);
                    });
                    $("#ShiftListBodyPanel").append(html);
                    $('#ShiftPartyName').html($('#party option:selected').text()); 
                    $("#serial_m").text(res.data.length);
                    $("#total_sale_m").text(total);
                    $("#d_sale_m").text(d_sale);
                    $("#a_sale_m").text(a_sale);
                    $("#comm_m").text(comm);
                    $("#o_dara_m").text(o_dara);
                    $("#o_akhar_m").text(o_akhar);
                    $("#tpc_m").text(tpc);
                    $("#hissa_m").text(hissa);
                    $("#credit_m").text(credit);
                    $("#debit_m").text(debit);
                    $("#as_ReportingTime").text(date);

                    $('#footer').show();
                    $('#ShiftModal').modal('show');
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    }

    $("#party").on('change',function(){
        if ($('#party').val()=='') {
            toastr.error('Select any shift to get data!!', 'Error');
            return false;
        }

        var table = $('#mytable').DataTable();
        table.destroy();
        var html='';
        $("#report_data").empty();
        
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/settling_report`,
            enctype: 'multipart/form-data',
            data: {party:$('#party').val(),date_from:$('#date_from').val(),date_to:$('#date_to').val()},                                     
            success: function(res)
            {
                // console.log(res.data);
                if(res.status == 'success'){

                    $.each(res.data, function (key, ledger) {
                        var commission=ledger['commission'];
                        if (commission>0) {
                            commission="-"+commission;
                        }
                        html +='<tr><td onClick=open_details("'+ledger['date']+'") style="cursor: pointer;background-color: lightgray;">'+ledger['date']+'</td><td>'+ledger['opening']+'</td><td>'+ledger['total']+'</td><td>'+ledger['dara_total']+'</td><td>'+ledger['akhar_total']+'</td><td>'+commission+'</td><td>'+ledger['o_dara']+'/'+ledger['o_akhar']+'</td><td>'+ledger['hissa']+'</td><td>'+ledger['tpc']+'</td><td></td><td>'+ledger['profit']+'</td><td></td><td>'+ledger['closing']+'</td></tr>';
                    });
                    $("#rate").html("Rate: "+res.party.dara+'/'+res.party.dara_commission+" | "+res.party.akhar+"/"+res.party.akhar_commission);
                    $("#limit").html("Limit: "+res.party.limit);
                    $("#report_data").append(html);

                    $('#mytable').DataTable({
                        "ordering": false,
                        "searching": false,
                        "paging": true,
                        "info": false,
                        scrollY: 280,
                        "scroller":true,
                    });
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
    });

</script>    
@endsection
