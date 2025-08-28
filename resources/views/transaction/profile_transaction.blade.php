@extends('layouts.master') 
@section('content')
<link href="{{URL::asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
<div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container" style="height:0px;">
                                    <!-- BEGIN PAGE TITLE -->
                                  
                                    <!-- END PAGE TITLE -->
                                    <!-- BEGIN PAGE TOOLBAR -->
                                   
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
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="table-responsive CustomFixedTbl">
                                            <table class="table table-bordered" id="mytable">
                                           <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Date</th>
                                                    <th>Party1</th>
                                                    <th>Party2</th>
                                                    <th>Cr/Dr</th>
                                                    <th>Amount</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                
                                                @foreach($data as $key => $value)
                                                    <tr id="row{{$value->id}}">
                                                        <td>{{++$key}}</td>
                                                        <td>{{date('d-m-Y',strtotime($value->date))}}</td>
                                                        <td> {{$value->party1}}</td>
                                                        <td> {{$value->party2}}</td>
                                                        <td>{{$value->cr_dr}}</td>
                                                        <td>{{$value->amount}}</td>
                                                        <td>{{$value->remark}}</td>
                                                      
                                                    <td>
                                                            <a href="javascript:void(0)"  onclick="setId({{$value->id}})"><i class="fa fa-trash" style="color:red;"
                                                            ></i></a>&nbsp;&nbsp;
                                                            <a href="#" onClick="editJournalVoucher({{$value->id}})"><i class="fa fa-edit" style="color:blue;"></i></a>    
                                                    </td>
                                                    </tr>   
                                                    <span id="rowDate{{$value->id}}" class="hide">{{$value->date}}</span>
                                                    <span class="rowDate{{$value->id}} hide" >{{$value->active}}</span>
                                                @endforeach

                                            </tbody>
                                            <tfoot class="dataTables_scrollHead">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Date</th>
                                                    <th>Party</th>
                                                    <th>Liye/Diye</th>
                                                    <th>Amount</th>
                                                    <th>Opposite Party</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    <div class="modal fade bs-modal-md" id="addJournal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:blue;color:white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="model_title"><b>Add Journal Voucher</b></h4>
            </div>
            <form id="add_journal_voucher">
                {{ csrf_field() }}
                <input type="hidden"   name="id" id="id"  value="">
                <input type="hidden"   name="updatedBy" id="updatedBy"  value="{{Auth::user()->company}}">
                <div class="modal-body">  
                    <div class="portlet-body">
                        {{-- <div class="row">
                            <div class="mt-radio-inline" style="margin-left:18px;">
                                <label class="mt-radio">
                                    <input class="form-control" type="radio" name="entry_type" value="admin" checked/> Admin
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input class="form-control" type="radio" name="entry_type" value="entry"/> Entry
                                    <span></span>
                                </label>
                            </div>
                        </div> --}}
                        <input type="hidden" name="ledger_id" id="ledger_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date</label>
                                    <input type="date" name="date" id="date" required class="form-control" value="{{ date('Y-m-d')}}"/> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Amount</label> <br/>
                                    <div class="input-group">
                                        <input type="number" name="amount" id="amount"  class="form-control" required>                                        
                                    </div>
                                </div>
                        </div> 
                          
                            <input type="hidden" id="party1" name="party1"/>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Liye/Diye</label><br/>
                                    <select class="form-control" id="cr_dr" name="cr_dr" required>
                                        <option value="liye" selected>Liye</option>
                                        <option value="diye">Diye</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Party 1</label><br/>
                                    <input type="text" autocomplete="off" oninput='onInput_party()' list="party_balance_list"  id="party_balance" name="party_balance"  class="input-group form-control form-control-inline"  required >                                 
                                    <datalist id="party_balance_list">
                                        @foreach($ledger as $l)
                                            <option value='{{$l->name}}'>{{$l->id}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        <div class="col-md-4"  id="party_second">
                                <div class="form-group">
                                    <label class="control-label">Party 2</label>
                                        <input type="text" list="opposite_party_list" oninput='onInput_opposite()' name="opposite_party_balance" class="form-control" id="opposite_party_balance">
                                        <datalist id="opposite_party_list">
                                        @foreach($ledger as $l)
                                            <option value='{{$l->name}}'>{{$l->id}}</option>
                                        @endforeach
                                    </datalist>
                                </div> 
                            </div>
                            <input type="hidden" id="party2" name="party2" />
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Remark</label>
                                        <input type="text" name="remark" class="form-control" id="remark">
                                        <span></span>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">               
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn green">Save</button> 
                    <button style="display:none;" id="wait" class="btn yellow"><i class="icon-spinner"></i>Please Wait...</button>    
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section('js')
<script>

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

    $(".addJournalButton").click(function(){
        $('#add_journal_voucher')[0].reset();
        $('#addJournal').modal('show');
    });

    function setId(id){
       $("#ledger_id").val(id);
    }

    // $('input[type=radio][name=entry_type]').change(function() {
    //     if (this.value == 'admin') {
    //         $("#party_second").css('display','none');
    //         $('#opposite_party_balance').removeAttr('required');
    //     }
    //     else if (this.value == 'entry') {
    //        $("#party_second").css('display','block');
    //        $('#opposite_party_balance').prop('required',true);
           
    //     }
    // });

    function onInput_opposite() 
    {
        $('#party2').val('');
        var val = document.getElementById("opposite_party_balance").value;
        var opts = document.getElementById('opposite_party_list').childNodes;
        for (var i = 0; i < opts.length; i++) {
        if (opts[i].value === val) {
            $('#party2').val(opts[i].text);
            break;
        }
        

        }
    }

    function onInput_party() 
    {
        var datalist=$('[name="party_balance"]').val();
        $('#party1').val('');
        var val = document.getElementById("party_balance").value;
        var opts = document.getElementById('party_balance_list').childNodes;
        for (var i = 0; i < opts.length; i++) {
        if (opts[i].value === val) {
            $('#party1').val(opts[i].text);
            break;
        }
        }
        var party1=$("#party1").val();
        onChangDataList(party1);
      
    }

    function onChangDataList(id){
        $.ajax({		            	
            type: "POST",
            url: "{{route('get_ledger')}}",
            enctype: 'multipart/form-data',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },                                      
            success: function(data)
            {
                console.log(data.status);
                if(data.status == true){
                    $("#opposite_party_list").empty();
                    $.each(data.data, function(k, v) {
                         $("#opposite_party_list").append('<option value=' + v.name + '>' + v.id + '</option>');
                    });                           
                }
                else{
                    toastr.error(data.message, 'Error');
                }
                
                $("#save").show(); 
                $("#wait").hide();

            }
    });
    }

    $('#mytable').DataTable({
    "ordering": false,
    "searching": false,
    "paging": true,
    "info": false,
});


</script>    
<script src="{{URL::asset('assets/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
@endsection
