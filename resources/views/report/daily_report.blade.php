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
                            <div class="col-md-8" style="margin-bottom: 5px;">
                            <div class="col-md-3">
                                   {{-- <div class="page-title">
                                        <input type="text" placeholder="Search ledger" autocomplete="off" name="search" id="search_ledger" class="form-control" required autofocus>
                                    </div>
                                    <div id="searchList"></div>--}}
                                    <input type="text" autocomplete="off" placeholder="Select party" 
                                                oninput='onInput_party()' list="party_balance_list" id="search_ledger"
                                                name="search" class="input-group form-control form-control-inline"
                                                required>
                                            <datalist id="party_balance_list" name="search">
                                               <option value='all'>All</option>
                                                @foreach($ledger as $l)
                                                <option value='{{$l->name}}'>{{$l->name}}</option>
                                                @endforeach
                                            </datalist>
                                </div>
                                <div class="btn-group">
                                    <input type="date" id="date" name="date" autocomplete="off" class="input-group form-control form-control-inline" value="{{ date('Y-m-d')}}" />                                 
                                </div>
                                <div class="btn-group">
                                    <a href="javascript:;" id="search" class="btn sbold green"> Search </a>
                                </div>
                            </div>

                            <input type="hidden" id="admin_id" value="{{Auth::user()->id}}">
                           
                           
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light ">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <div class="caption font-dark">
                                            <span class="caption-subject bold uppercase">Daily Report</span>
                                        </div>
                                      </div>
                                    </div>
                                   
                                   
                                    
                                    <div class="portlet-body table-both-scroll">
                                        <table class="table table-bordered" id="mytable">
                                            <thead class="dataTables_scrollHead">
                                                <tr>
                                                <th class="text-effect">Sr. No.</th>
                                                <th class="text-effect">Date</th>
                                                <th class="text-effect">Ledger</th>
                                                <th class="text-effect">Med.</th>
                                                <th class="text-effect">Cr/Dr</th>
                                                <th class="text-effect">Med. Amount</th>
                                                <th class="text-effect">Amount</th>
                                                <th class="text-effect">Opening Bal.</th>
                                                <th class="text-effect">Closing Bal.</th>
                                                <th class="text-effect">Remark</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody id="report_data">

                                            </tbody>
                                            <tfoot class="dataTables_scrollHead footer" style="display:none;">
                                            <tr>
                                                <th class="text-effect">Sr. No.</th>
                                                <th class="text-effect">Date</th>
                                                <th class="text-effect">Ledger</th>
                                                <th class="text-effect">Med.</th>
                                                <th class="text-effect">Cr/Dr</th>
                                                <th class="text-effect">Med. Amount</th>
                                                <th class="text-effect">Amount</th>
                                                <th class="text-effect">Opening Bal.</th>
                                                <th class="text-effect">Closing Bal.</th>
                                                <th class="text-effect">Remark</th>
                                                
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-4">
                                                    <div class="btn-group">
                                                        <button class="btn sbold green" id="plus" style="display:none;">Profit : 0</button>
                                                    </div>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="btn-group">
                                                        <button class="btn sbold red" id="minus" style="display:none;">Loss : 0</button>
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
    </div>
    <!-- END CONTENT -->

  



@endsection
@section('js')
<script>

    function open_jantri(id){
        $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/ledger_daily_report`,
            enctype: 'multipart/form-data',
            data: {shift:$('#shift').val(),date:$('#date').val(),ledger:id,admin_id:$('#admin_id').val()},                                     
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

    $("#search").click(function(){
        $("#plus").text('');
        $("#minus").text('');
        $("#plus").css('display','none');
        $("#minus").css('display','none');
        
        var table = $('#mytable').DataTable();
        table.destroy();
        var html='';
        $("#report_data").empty();  
        var search_ledger=$('#search_ledger').val();

        if(search_ledger!= ''){
            $.ajax({		            	
            type: "POST",
            url: `${window.pageData.baseUrl}/api/daily_report`,
            enctype: 'multipart/form-data',
            data: {search:$('#search_ledger').val(),date:$('#date').val(),admin_id:$('#admin_id').val()},                                     
            success: function(res)
            {
               
                if(res.status == 'success'){

                    if(res.plus===0 && res.minus===0){
                      $("#plus").css('display','none');
                      $("#minus").css('display','none'); 
                    }
                    else if(res.plus===0 && res.minus!=0){
                        $("#minus").css('display','block'); 
                        $("#minus").text('Loss :'+res.minus);
                    }
                    else if(res.plus!=0 && res.minus===0){
                        $("#plus").css('display','block');
                        $("#plus").text('Profit :'+res.plus);
                    }
                    // $("#plus").text('Lene :'+res.lene);
                    // $("#minus").text('Dene :'+res.dene);
                    console.log(res.data);
                    $.each(res.data, function (key, ledger) {
                        console.log(ledger);
                        
                        var serial=parseFloat(key)+1;
                        last_serial=serial;

                        var type;
                            if (ledger['medicine_transaction'] == '' || ledger['medicine_transaction'] == 0) {
                                if (ledger['cr_dr'] == 'lene') {
                                    type = '<span class="label label-sm label-success label-mini" style="background-color:red"><b>Lene</b></span>';
                                } else {
                                    type = '<span class="label label-sm label-success label-mini" style="background-color:green"><b>Dene</b></span>';
                                }
                            } else {
                                if (ledger['medicine_transaction_type'] == 'minus') {
                                    type = '<span class="label label-sm label-success label-mini" style="background-color:red"><b>lene</b></span>';
                                } else {
                                    type = '<span class="label label-sm label-success label-mini" style="background-color:green"><b>dene</b></span>';
                                }
                            }

                        if(ledger['remark']=='null' || ledger['remark']===null){
                            var remark=''
                        }
                        else{
                            var remark=ledger['remark'];
                        }
                        
                        
                        if(ledger['medicine_transaction']==1){
                            var medicine_name=ledger['medicine_name'];
                        }
                        else{
                            var medicine_name='';
                        }

                        var medicineAmount = '';
                        var regularAmount = '';

                        if (ledger['medicine_transaction'] == 1) {
                            // For medicine transactions, show medicine_new_amount in Med. Amount column
                            let medAmount = ledger['amount'] ?? '0';
                            medicineAmount = Math.floor(parseFloat(medAmount));
                            
                            // Also show normal amount in Amount column for medicine transactions
                            let amount = ledger['medicine_new_amount'] ?? '0';
                            regularAmount = Math.floor(parseFloat(amount));
                        } else {
                            // For non-medicine transactions, show only regular amount
                            let amount = ledger['amount'] ?? '0';
                            regularAmount = Math.floor(parseFloat(amount));
                            medicineAmount = ''; // Don't show medicine amount for regular transactions
                        }

                        // Format opening and closing balance without decimal points
                        let openingBalance = Math.floor(parseFloat(ledger['opening_balance'] ?? '0'));
                        let closingBalance = Math.floor(parseFloat(ledger['closing_balance'] ?? '0'));

                        html +='<tr><td>'+serial+'</td><td>'+ledger['date']+'</td><td>'+ledger['ledger_name']+'</td><td>'+medicine_name+'</td><td>'+type+'</td><td>'+medicineAmount+'</td><td>'+regularAmount+'</td><td>'+openingBalance+'</td><td>'+closingBalance+'</td><td>'+remark+'</td></tr>';                     
                    });

                    $("#report_data").append(html);

                   
                    $('.footer').show();

                    $('#mytable').DataTable({
                        "ordering": false,
                        "searching": false,
                        "paging": true,
                        "info": false,
                    });
                }
                else{
                    toastr.error(res.message, 'Error');
                }
            }
        });
        }
        else{
            $('#search_ledger').focus();
        }
        });

        
              
       

    $('#search_ledger').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url: `${window.pageData.baseUrl}/api/autocompelete_transaction_ledger`,
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
         $('#search_ledger').focus(); 
    });  

    $(document).on('keypress', 'input,select,button', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});

function onInput_party() {
       
       var val = document.getElementById("search_ledger").value;
       var opts = document.getElementById('party_balance_list').childNodes;
       for (var i = 0; i < opts.length; i++) {
           if (opts[i].value === val) {
               $('#search_ledger').val(opts[i].text);
               break;
           }
       }
   }

   $(document).ready(function () {
        $('#search_ledger').focus();
    }); 


</script>    
@endsection
