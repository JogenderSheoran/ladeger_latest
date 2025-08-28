
    $( window ).on( "load", function() {
        var scrollPos =  $(".select2").offset().top;
        $(window).scrollTop(scrollPos);
    });


    function clear_table(id){
        $("#"+id+" > tbody > tr").each(function(){
            $(this).find("input:text,textarea").each(function(){
                $(this).val('');
            });
        });
        $("#"+id+" > tfoot > tr").each(function(){
            $(this).find("input:text,textarea").each(function(){
                $(this).val('');
            });
        });
        $("#"+id+" > thead > tr").each(function(){
            $(this).find("input:text,textarea").each(function(){
                $(this).val('');
            });
        });
        $('.random_f8').find('input:text,textarea').val('');
        setRandomOld_TotalAmount();
        setCrossingCount();
        setFromTo_TotalAmount();
    }
    
    var AppliedNarration=[];
    var VerticalEnterMove = false;


    function add_field(number,amount){
        room++;
        var innerHTML = '<div class="row form-group removeclass'+room+'"><div class="col-md-5" style="padding-left:5px;padding-right:5px;"><input type="number" min="0" name="number[]" disabled placeholder="Number" class="form-control number" value="'+number+'" /> </div><div class="col-md-5" style="padding-left:5px;padding-right:5px;"><input type="number" min="0" name="amount[]" disabled placeholder="Amount" class="form-control amount"  value="'+amount+'"/> </div><div class="col-md-1" style="padding-left:5px;padding-right:5px;"><button type="button" class="btn red" onclick="remove_transaction_fields('+ room +');">X</button></div></div>';
        $('#transaction_fields').prepend(innerHTML)

        // calculate total and count
        calculation();
    }


    // ------ Start Random -----------//
    function TwoNumberWithSpaces(id, x) {
        var _value = x.replace(/\W/gi, '').replace(/(.{2})/g, '$1 ');
        $('#'+id).val(_value);
    }

    $('#RandomBahar_Number,#RandomAndar_Number').keyup(function() {
        CheckCrossingDuplicateNumber(this.id,this.value);
    });

    $('#Random_Number').keyup(function() {
        TwoNumberWithSpaces(this.id,this.value);
    });

    $("#Random_Number").bind('blur keydown', function(e) {
        if (e.which == 13){
            $('#Random_Amount').focus().select();
        }
    });

    $("#Random_Amount, #RandomBahar_Amount, #RandomAndar_Amount").bind('blur keyup', function(e) {
        setRandomTotal();
    });

    function setRandomTotal(){
        var Number = $('#Random_Number');
        var Amount = $('#Random_Amount');

        var BaharNumber = $('#RandomBahar_Number');
        var BaharAmount = $('#RandomBahar_Amount');

        var AndarNumber = $('#RandomAndar_Number');
        var AndarAmount = $('#RandomAndar_Amount');

        $('#Total_Random_Amount').text( "0" );

        if(Number.val().trim().length == 0 && Amount.val().length != 0){ 
            $('#Total_Random_Dara_Amount').text("");
            return false;
        }
        if(Number.val().trim().length != 0 && Amount.val().length == 0){ 
            $('#Total_Random_Dara_Amount').text("");
            return false;
        }
        var DaraNumber = Number.val().replace(/\s/g, '').trim();

        if((DaraNumber.length % 2) != 0){ 
            $('#Total_Random_Dara_Amount').text("Invalid No.");
            return false;
        }

        if(BaharNumber.val().trim().length == 0 && BaharAmount.val().length != 0){ 
            $('#Total_Random_Bahar_Amount').text("");
            return false;
        }
        if(BaharNumber.val().trim().length != 0 && BaharAmount.val().length == 0){ 
            $('#Total_Random_Bahar_Amount').text("");
            return false;
        }

        if(AndarNumber.val().trim().length == 0 && AndarAmount.val().length != 0){ 
            $('#Total_Random_Andar_Amount').text("");
            return false;
        }
        if(AndarNumber.val().trim().length != 0 && AndarAmount.val().length == 0){ 
            $('#Total_Random_Andar_Amount').text("");
            return false;
        }
        
        // Dara
        if(DaraNumber.trim().length != 0 && Amount.val().length != 0){ 
            var _NumberSplit = SplitNumber(DaraNumber.trim());
            var index = 0;
            var GenrateNumberArr = [];
            var IsTwoDigit = false;
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                if(IsTwoDigit==false)
                {
                    var _number = _NumberSplit[i];
                    IsTwoDigit = true;
                }else{
                    _number += ''+_NumberSplit[i];
                    GenrateNumberArr[index] = {
                        Number: parseInt((_number=="00" ? "100" : _number)),
                        Amount: Amount.val(),
                    }; 
                    index++;
                    IsTwoDigit = false;
                }
            }
            $('#Total_Random_Dara_Amount').text( (GenrateNumberArr.length*Amount.val()) );
        }
        // Bahar Akhar
        if(BaharNumber.val().trim().length != 0 && BaharAmount.val().length != 0){ 
            var _NumberSplit = SplitNumber(BaharNumber.val().trim());
            var index = 0;
            var GenrateNumberArr = [];
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                var _number = _NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i];
                GenrateNumberArr[index] = {
                    Number: _number,
                    Amount: BaharAmount.val(),
                }; 
                index++;
            }
            $('#Total_Random_Bahar_Amount').text( (GenrateNumberArr.length*BaharAmount.val()) );
            
        }
        // Andar Akhar
        if(AndarNumber.val().trim().length != 0 && AndarAmount.val().length != 0){ 
            var _NumberSplit = SplitNumber(AndarNumber.val().trim());
            var index = 0;
            var GenrateNumberArr = [];
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                var _number = _NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i];
                GenrateNumberArr[index] = {
                    Number: _number,
                    Amount: AndarAmount.val(),
                }; 
                index++;
            }
            $('#Total_Random_Andar_Amount').text( (GenrateNumberArr.length*AndarAmount.val()) );
        }
        var tDaraAmt = $('#Total_Random_Dara_Amount').text();
        var tAndarAmt = $('#Total_Random_Andar_Amount').text();
        var tBaharAmt = $('#Total_Random_Bahar_Amount').text();
        var mTotal  = Math.round(tDaraAmt) + Math.round(tAndarAmt) + Math.round(tBaharAmt);
        $('#Total_Random_Amount').text( mTotal );

    }

    function setRandom(){
        var Number = $('#Random_Number');
        var Amount = $('#Random_Amount');

        var BaharNumber = $('#RandomBahar_Number');
        var BaharAmount = $('#RandomBahar_Amount');

        var AndarNumber = $('#RandomAndar_Number');
        var AndarAmount = $('#RandomAndar_Amount');

        if(Number.val().trim().length == 0 && Amount.val().length != 0){ 
            toastr.error("Please enter a valid number!","error");
            setTimeout(function(){ Number.focus().select(); }, 10); 
            return false;
        }
        if(Number.val().trim().length != 0 && Amount.val().length == 0){ 
            toastr.error("Please enter a valid amount!","error");
            setTimeout(function(){ Amount.focus().select(); }, 10); 
            return false;
        }
        var DaraNumber = Number.val().replace(/\s/g, '').trim();

        if((DaraNumber.length % 2) != 0){ 
            toastr.error("Number should be pair of 2 digit!","error");
            setTimeout(function(){ Number.focus().select(); }, 10); 
            return false;
        }

        if(BaharNumber.val().trim().length == 0 && BaharAmount.val().length != 0){ 
            toastr.error("Please enter a valid number!","error");
            setTimeout(function(){ BaharNumber.focus().select(); }, 10); 
            return false;
        }
        if(BaharNumber.val().trim().length != 0 && BaharAmount.val().length == 0){ 
            toastr.error("Please enter a valid amount!","error");
            setTimeout(function(){ BaharAmount.focus().select(); }, 10); 
            return false;
        }

        if(AndarNumber.val().trim().length == 0 && AndarAmount.val().length != 0){ 
            toastr.error("Please enter a valid number!","error");
            setTimeout(function(){ AndarNumber.focus().select(); }, 10); 
            return false;
        }
        if(AndarNumber.val().trim().length != 0 && AndarAmount.val().length == 0){ 
            toastr.error("Please enter a valid amount!","error");
            setTimeout(function(){ AndarAmount.focus().select(); }, 10); 
            return false;
        }
        
        // Dara
        if(DaraNumber.trim().length != 0 && Amount.val().length != 0){ 
            var _NumberSplit = SplitNumber(DaraNumber.trim());
            var index = 0;
            var GenrateNumberArr = [];
            var IsTwoDigit = false;
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                if(IsTwoDigit==false)
                {
                    var _number = _NumberSplit[i];
                    IsTwoDigit = true;
                }else{
                    _number += ''+_NumberSplit[i];
                    GenrateNumberArr[index] = {
                        Number: parseInt((_number=="00" ? "100" : _number)),
                        Amount: Amount.val(),
                    }; 
                    index++;
                    IsTwoDigit = false;
                }
            }
            setData(GenrateNumberArr);
        }
        // Bahar Akhar
        if(BaharNumber.val().trim().length != 0 && BaharAmount.val().length != 0){ 
            var _NumberSplit = SplitNumber(BaharNumber.val().trim());
            var index = 0;
            var GenrateNumberArr = [];
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                var _number = _NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i];
                GenrateNumberArr[index] = {
                    Number: _number,
                    Amount: BaharAmount.val(),
                }; 
                index++;
            }
            setData(GenrateNumberArr);
        }
        // Andar Akhar
        if(AndarNumber.val().trim().length != 0 && AndarAmount.val().length != 0){ 
            var _NumberSplit = SplitNumber(AndarNumber.val().trim());
            var index = 0;
            var GenrateNumberArr = [];
            for(var i=0; i<parseInt(_NumberSplit.length); i++)
            {
                var _number = _NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i]+''+_NumberSplit[i];
                GenrateNumberArr[index] = {
                    Number: _number,
                    Amount: AndarAmount.val(),
                }; 
                index++;
            }
            setData(GenrateNumberArr);
        }

        Number.val("");
        BaharNumber.val("");
        AndarNumber.val("");
        Amount.val("");
        BaharAmount.val("");
        AndarAmount.val("");
        $("#RandomModal").modal('hide');
        $('#Total_Random_Amount').text( "0" );
        $('#Total_Random_Dara_Amount').text("");
        $('#Total_Random_Andar_Amount').text("");
        $('#Total_Random_Bahar_Amount').text("");
    }
    // ------ End Random -----------//


    // ------ Start From To ---------//
    function setFromTo_TotalAmount(){
        $("#FromToModalTotalAmount").text("0");
        var FromNumber = $('#From_Number');
        var ToNumber = $('#To_Number');
        var Amount = $('#FromTo_Amount');
        var AmountPlt = $('#FromTo_AmountPlt');
        if( parseInt(FromNumber.val()) > parseInt(ToNumber.val()) ){ 
            return false;
        }
        var Count = 0;
        var CountPlt = 0;
        if(FromNumber.val().length != 0 && ToNumber.val().length != 0  && Amount.val().length != 0){
            for(var i=parseInt(FromNumber.val()); i<=parseInt(ToNumber.val()); i++){
                Count++;
            }
        }
        if(AmountPlt.val().length != 0 && AmountPlt.val() !=0){ 
            for(var i=parseInt(FromNumber.val()); i<=parseInt(ToNumber.val()); i++)
            {
                var _NumberSplit = SplitNumber(i);
                var digitFirst = _NumberSplit[0];
                var digitTwo = _NumberSplit[1];
                if(digitFirst != digitTwo && i.toString().length <=2 ){
                    var newNumber = "";
                    if(digitTwo === undefined){
                        newNumber = digitFirst+'0';
                    }else{
                        newNumber = digitTwo+''+digitFirst;
                    }
                    CountPlt++;	
                }
            }
        }
        var mTotal = 0;
        if(Count != 0  && Amount.val().length != 0){
            mTotal =  Count*parseFloat(Amount.val());
        }
        if(CountPlt != 0  && AmountPlt.val().length != 0){
            mTotal +=  CountPlt*parseFloat(AmountPlt.val());
        }

        $("#FromToModalTotalAmount").text( mTotal );	

    }

    function setFromTo(){
        var FromNumber = $('#From_Number');
        var ToNumber = $('#To_Number');
        var Amount = $('#FromTo_Amount');
        var AmountPlt = $('#FromTo_AmountPlt');

        if(FromNumber.val().length == 0 || ToNumber.val().length == 0){ 
            toastr.error("Please enter a valid number!","error");
            setTimeout(function(){ FromNumber.focus().select(); }, 10); 
            return false;
        }
        if( parseInt(FromNumber.val()) > parseInt(ToNumber.val()) ){ 
            toastr.error("Please enter a valid From number!","error");
            setTimeout(function(){ FromNumber.focus().select(); }, 10); 
            return false;
        }
        if( parseInt(FromNumber.val()) <= 0){ 
            toastr.error("Please enter a valid From number!","error");
            setTimeout(function(){ FromNumber.focus().select(); }, 10); 
            return false;
        }
        if( parseInt(ToNumber.val()) > 100){ 
            toastr.error("Please enter a valid To number!","error");
            setTimeout(function(){ ToNumber.focus().select(); }, 10); 
            return false;
        }
        if(Amount.val().length == 0){ 
            toastr.error("Please enter a valid amount!","error");
            setTimeout(function(){ Amount.focus().select(); }, 10); 
            return false;
        }
        if(AmountPlt.val().length != 0 && AmountPlt.val() !=0){ 
            setAppliedNarration("P-From-To", FromNumber.val(), ToNumber.val(), "", Amount.val());
        }else{
            setAppliedNarration("From-To", FromNumber.val(), ToNumber.val(), "", Amount.val());
        }
        var index = 0;
        var GenrateNumberArr = [];
        for(var i=parseInt(FromNumber.val()); i<=parseInt(ToNumber.val()); i++)
        {
            GenrateNumberArr[index] = {
                Number: i,
                Amount: Amount.val(),
            }; 
            index++;	
        }
        if(AmountPlt.val().length != 0 && AmountPlt.val() !=0){ 
            for(var i=parseInt(FromNumber.val()); i<=parseInt(ToNumber.val()); i++)
            {
                var _NumberSplit = SplitNumber(i);
                var digitFirst = _NumberSplit[0];
                var digitTwo = _NumberSplit[1];
                if(digitFirst != digitTwo && i.toString().length <=2 ){
                    var newNumber = "";
                    if(digitTwo === undefined){
                        newNumber = digitFirst+'0';
                    }else{
                        newNumber = digitTwo+''+digitFirst;
                    }
                    GenrateNumberArr[index] = {
                        Number: newNumber,
                        Amount: AmountPlt.val(),
                    };
                    index++;	
                }
            }
        }
        setData(GenrateNumberArr);

        FromNumber.val("");
        ToNumber.val("");
        Amount.val("");
        AmountPlt.val("");
        $("#FromToModal").modal('hide');
    }
    // ------ End From To -----------//



    //------ Start Crossing Panel ------//

    $('#Cross_Number1,#Cross_Number2').keyup(function() {
        CheckCrossingDuplicateNumber(this.id,this.value);
    });

    function CreateCrossNumber(_Number1, _Number2, _Joda, _Amount)
    {
        var _NumberSplit1 = SplitNumber(_Number1);
        var _NumberSplit2 = SplitNumber(_Number2);
        
        var GenrateNumberArr = [];
        var index = 0;
        for(var i=0; i<_NumberSplit1.length; i++)
        {
            for(var s=0; s<_NumberSplit2.length; s++)
            {		
                var MainNumber = parseInt(_NumberSplit1[i]+''+_NumberSplit2[s]);
                MainNumber = MainNumber=='0' ? '100' : MainNumber;
                if(_NumberSplit1[i]==_NumberSplit2[s] && _Joda.toUpperCase()=="Y"){
                    GenrateNumberArr[index] = {
                        Number: MainNumber,
                        Amount: _Amount,
                    }; 
                    index++;
                }
                if(_NumberSplit1[i]!=_NumberSplit2[s] ){
                    GenrateNumberArr[index] = {
                        Number: MainNumber,
                        Amount: _Amount,
                    }; 
                    index++;
                }
            }
        }
        return GenrateNumberArr;
    }

    function CheckCrossingDuplicateNumber(id,_Number){
        if(_Number.length > 1)
        {
            var Old_NumberSplit = SplitNumber(_Number);
            var New_Number = _Number.substring(0, _Number.length - 1); 
            var _NumberSplit = SplitNumber(New_Number);
            
            var lastNumber = Old_NumberSplit[Old_NumberSplit.length-1];
            if(_NumberSplit.includes(lastNumber)){
                $('#'+id).val(New_Number);
            }
        }
    }

    function setCrossingCount()
    {
        var _Number1 = $('#Cross_Number1');
        var _Number2 = $('#Cross_Number2');
        var _Joda = $('#Cross_Joda');
        var _Amount = $('#Cross_Amount');
        if(_Number1.val().length == 0 || _Number2.val().length == 0){ 
            return false;
        }
        var GenrateNumberArr = CreateCrossNumber(_Number1.val(), _Number2.val(), _Joda.val(), _Amount.val());
        $("#CrossModalNumberCount").text(GenrateNumberArr.length);	
        
        $("#CrossModalTotalAmount").text("0");
        if(_Amount.val().length != 0){
            $("#CrossModalTotalAmount").text(GenrateNumberArr.length*parseFloat(_Amount.val()));	
        }
    }

    function setData(data){
        $.each(data, function(index,obj) { 
            add_field(obj.Number,obj.Amount);
        });
    }

    function setCrossing()
    {
        var _Number1 = $('#Cross_Number1');
        var _Number2 = $('#Cross_Number2');
        var _Joda = $('#Cross_Joda');
        var _Amount = $('#Cross_Amount');

        if(_Number1.val().length == 0 && _Number2.val().length == 0 && Math.round(_Amount.val()) > 0 && _Joda.val().toUpperCase() == "Y" ){ 
            var index = 0;
            var GenrateNumberArr = [];
            for(var i=0; i<=9; i++)
            {
                var no = i+''+i;
                GenrateNumberArr[index] = {
                    Number: (no == '00' ? '100' : no),
                    Amount: _Amount.val(),
                }; 
                index++;	
            }
            setData(GenrateNumberArr);
        }
        else{
            if(_Number1.val().length == 0 || _Number2.val().length == 0){ 
                
                toastr.error("Please enter a valid number!","error");
                setTimeout(function(){ _Number1.focus().select(); }, 10); 
                
                return false;
            }
            if(_Amount.val()!="" && _Amount.val() > 0)
            {
                setAppliedNarration("Cross", _Number1.val(), _Number2.val(), _Joda.val().toUpperCase(), _Amount.val());
                var GenrateNumberArr = CreateCrossNumber(_Number1.val(), _Number2.val(), _Joda.val(), _Amount.val());	
                setData(GenrateNumberArr);
                
            }else {
                setTimeout(function(){ _Amount.focus().select(); }, 50);
                toastr.error("Please enter a valid amount!","error");
                return false;
            }
        }

        // calculate total and count
        // calculation(); 

        _Number1.val("");
        _Number2.val("");
        _Joda.val("Y");
        _Amount.val("");
        $("#CrossModalNumberCount").text("");
        $("#random_f6_model").modal('hide');
    }
    //------- End Cross Panel --------//

    function setAppliedNarration(_Type, _Number1, _Number2, _Joda, _Amount)
    {
        var label = _Number1+" x "+_Number2+" / "+_Amount+" / "+_Joda;
        if(_Type=="Cross"){
            label = _Number1+" x "+_Number2+" / "+_Amount+" / "+(_Joda=='' ? 'N' : _Joda);
        }else if(_Type=="From-To"){
            label = _Number1+" To "+_Number2+" / "+_Amount;
        }
        
        AppliedNarration.unshift({
            Type: _Type,
            Number1: _Number1,
            Number2: _Number2,
            Joda: _Joda,
            Amount: _Amount,
            Label: label,
        }); 
        
        var List = "";
        $.each(AppliedNarration, function(index,obj) { 
            List+= '<tr>'
                + '<td width="110px">'+ obj.Type +'</td>' 
                + '<td>'+ obj.Label +'</td>' 
                + '</tr>';
        });	
        $('#AppliedNarrationPanel').html(List);
    }

    //-------- Start Old Random ------- //
    function Random_clone()
    {
        if($("#RandomTableOld tr:last input").val()!="")
        {
            $("#RandomTableOld ").append($("#RandomTableOld tr:last").clone(true));
            $("#RandomTableOld tr:last input").val("");
        }
    }

    function setRandomOld_TotalAmount()
    {
        $("#OldRandPanelTotalAmount").text("0");
        var Amount=$("#RandomAmountOld");
        var AmountPlt=$("#RandomAmountOldPlt").val();
        var Count = 0;
        var CountPlt = 0;
        var Numbers = document.getElementsByName('RandomNumberOld[]');
        for (var i = 0; i <Numbers.length; i++) {
            if(Numbers[i].value!=""){
                Count++;
            }
        }
        if(AmountPlt!="")
        {
            for (var i = 0; i <Numbers.length; i++) {
                var NumberElement = Numbers[i];
                var _number = NumberElement.value;
                if(_number!="")
                {
                    var _NumberSplit = SplitNumber(_number.trim());
                    var digitFirst = _NumberSplit[0];
                    var digitTwo = _NumberSplit[1];
                    if(digitFirst != digitTwo && _number.toString().length <=2 ){
                        var newNumber = "";
                        if(digitTwo === undefined){
                            newNumber = digitFirst+'0';
                        }else{
                            newNumber = digitTwo+''+digitFirst;
                        }
                        CountPlt++;
                    }
                }
            }
        }
        var mTotal = 0;
        if(Count != 0  && Amount.val().length != 0){
            mTotal = Count*parseFloat(Amount.val()) ;	
        }
        if(CountPlt != 0){
            mTotal += (CountPlt*parseFloat(AmountPlt)) ;	
        }
        $("#OldRandPanelTotalAmount").text( mTotal );	
    }

    function setRandomOld()
    {
        var KeyAmount=$("#RandomAmountOld").val();
        var KeyAmountPlt=$("#RandomAmountOldPlt").val();
        if(KeyAmount=="")
        {
            toastr.error("Please enter a valid amount!!","error");
            $("#RandomAmountOld").focus();
            return false;
        }
        var NumberValid = ["00","111","222","333","444","555","666","777","888","999","000","1111","2222","3333","4444","5555","6666","7777","8888","9999","0000"];
        for(var i=1; i<=100; i++){
            if(i<10){
                NumberValid.push("0"+i);
            }
            NumberValid.push(""+i);
        }
        var Numbers = document.getElementsByName('RandomNumberOld[]');
        for (var i = 0; i <Numbers.length; i++) {
            var NumberElement = Numbers[i];
            var _number = NumberElement.value;
            if(_number!="")
            {
                if(NumberValid.includes(""+_number)==false){
                    toastr.error("Please enter a valid Number!","error");
                    break;
                    return false;
                }
            }
        }
        
        for (var i = 0; i <Numbers.length; i++) {
            var NumberElement = Numbers[i];
            var _number = NumberElement.value;
            if(_number!="")
            {
                var my_number=(_number=="00" ? "100" : (_number.length == 2 ? parseInt(_number): _number))
                add_field(my_number,KeyAmount)
            }
        }
        if(KeyAmountPlt!="")
        {
            var Numbers = document.getElementsByName('RandomNumberOld[]');	
            for (var i = 0; i <Numbers.length; i++) {
                var NumberElement = Numbers[i];
                var _number = NumberElement.value;
                if(_number!="")
                {
                    var _NumberSplit = SplitNumber(_number.trim());
                    var digitFirst = _NumberSplit[0];
                    var digitTwo = _NumberSplit[1];
                    if(digitFirst != digitTwo && _number.toString().length <=2 ){
                        var newNumber = "";
                        if(digitTwo === undefined){
                            newNumber = digitFirst+'0';
                        }else{
                            newNumber = digitTwo+''+digitFirst;
                        }

                        var my_number=(newNumber=="00" ? "100" : (newNumber.length == 2 ? parseInt(newNumber): newNumber))
                        add_field(my_number,KeyAmount)
                    }
                }
            }
        }

        // calculate total and count
        calculation(); 

        $("#RandomAmountOld").val("");
        $("#RandomAmountOldPlt").val("");
        $("#RandomTableOld ").html($("#RandomTableOld tr:last").clone(true));
        $('#random_f4_model').modal('hide');
    }

    function SplitNumber(number)
    {
        var output = [],
            sNumber = number.toString();
        for (var i = 0, len = sNumber.length; i < len; i += 1) {
            output.push(+sNumber.charAt(i));
        }
        return output;
    }
    //------End old Random ---------//

    // Detecting functional keys
    // your keyCode contains the key code, F1 to F12 
    // is among 112 and 123. Just it.
    document.onkeyup = KeyCheck;
    function KeyCheck(e)
    {
        var KeyID = (window.event) ? event.keyCode : e.keyCode;

        if(KeyID == 40) // Key Down
        {
            if ($(".JantriInput").is( ":focus" )) {
                var OnlyNumber = LastFocusedControl_Id.replace('number_','');						
                if(parseInt(OnlyNumber) <= 90){
                    $("#number_"+(parseInt(OnlyNumber)+10)).focus().select();
                }else if(parseInt(OnlyNumber) >= 91 && parseInt(OnlyNumber) < 100){
                    $("#number_"+((parseInt(OnlyNumber)-90)+1)).focus().select();
                }else if(parseInt(OnlyNumber) == 100){
                    $("#number_111").focus().select();
                }
            }
            else{
                $("#party").focus();
            }
        }

        if(KeyID==38) // Arrow UP
        {
            if ($(".JantriInput").is( ":focus" )) {
                var OnlyNumber = LastFocusedControl_Id.replace('number_','');						
                if(parseInt(OnlyNumber) <= 10){
                    $("#number_"+((parseInt(OnlyNumber)+90)-1)).focus().select();
                }else if(parseInt(OnlyNumber) == 1){
                    $("#number_100").focus().select();
                }else{
                    $("#number_"+((parseInt(OnlyNumber))-10)).focus().select();
                }
            }
            else{
                $("#party").focus();
            }
        }

        if(KeyID == 113) // F2
        {
            $("#save").click();
        }

        if(KeyID == 123)  // F12
        {
            if ($('#view_type').val()=='normal') {
                $(".normal_view").hide();
                $(".jantri_view").show();
                $('#view_type').val('jantri');
            } else {
                $(".normal_view").show();
                $(".jantri_view").hide();
                $('#view_type').val('normal');
            }
        }

        if(KeyID == 115)  // F4 Random
        {
            $("#random_f4").click();
        }

        if(KeyID == 117)  // F6 Crossing
        {
            $("#random_f6_model").click();
        }

        if(KeyID == 118)  // F7  From-To
        {
            $("#FromToModal").click();
        }

        if(KeyID == 119)  // F8  Random
        {
            $("#RandomModal").click();
        }
    }

    // open model
    $("#random_f4").click(function(){
        $('#random_f4_model').modal('show');
    });
    $("#random_f6").click(function(){
        $('#random_f6_model').modal('show');
    });
    $("#random_f7").click(function(){
        $('#FromToModal').modal('show');
    });
    $("#random_f8").click(function(){
        $('#RandomModal').modal('show');
    });

    $("#clear").click(function(){

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
    });


    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if(charCode==46 || charCode==190){
            if(evt.target.value.includes('.')){
                return false;
            }else{
                return true;
            }
        }else{
            if (charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            }else{
                return true;
            }
        }
    }

    // set jantri view
    function setJantriSingleNumber(number)
    {
        MasterTotal();
    }

    // set jantri view
    function MasterTotal()
    {
        var numbers=[];
        var amounts=[];
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

            // add to DB array
            if ($('#number_'+no).val()) {
                numbers.push(no);
                amounts.push($('#number_'+no).val());
            }
        }
        
        for(var i=0; i<=9; i++)
        {
            var no = i+''+i+''+i;
            var AmountTotal = parseInt(($('#number_'+no).val()=="" ? 0 : $('#number_'+no).val()));
            BaharTotal += AmountTotal;

            // add to DB array
            if ($('#number_'+no).val()) {
                numbers.push(no);
                amounts.push($('#number_'+no).val());
            }
            
            var no = i+''+i+''+i+''+i;
            var AmountTotal = parseInt(($('#number_'+no).val()=="" ? 0 : $('#number_'+no).val()));
            AkharTotal += AmountTotal;


            // add to DB array
            if ($('#number_'+no).val()) {
                numbers.push(no);
                amounts.push($('#number_'+no).val());
            }
        }

        // Add data to Normal view
        $('#amount_count').text(numbers.length);
        $('#transaction_fields').empty();
        for(var t=0; t<numbers.length; t++){
            add_field(numbers[t],amounts[t])
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
        $('#total').text(GrandTotal.toLocaleString());
        $('#total_amount').val(GrandTotal.toLocaleString());
    }

    $('#party').on('change',function() {
        if ($('#party').val()) {
            $.ajax({		            	
                type: "POST",
                url: `${window.pageData.baseUrl}/api/party_info`,
                data: {party:$('#party').val()},                                     
                success: function(res)
                {
                    if(res.status == 'success'){
                        var data=res.data[0];
                        $('#rate').text("Rate: "+data.dara+"/"+data.dara_commission+"-"+data.akhar+"/"+data.akhar_commission); 
                        var limit=0;
                        if (data.limit_status=="Yes") {
                            limit=data.limit
                            if (limit<1) {
                                limit=0;
                            }
                        }           
                        $('#limit').text("Limit: "+limit); 
                    }
                    else{
                        toastr.error(res.message, 'Error');
                    }
                }
            });
        }
    })


    // Add new fields to normal view
	function transaction_fields() {

        var _Number = $('.number1').val();
        var _Amount = $('.amount1').val();

        if (_Number!='' && _Amount!='') {

            var NumberValid = ["00","111","222","333","444","555","666","777","888","999","000","1111","2222","3333","4444","5555","6666","7777","8888","9999","0000"];
            for(var i=1; i<=100; i++){
                if(i<10){
                    NumberValid.push("0"+i);
                }
                NumberValid.push(""+i);
            }
            if(_Number.length ==0 && Math.round(_Amount) != 0){
                toastr.error("Invalid Number, Please enter a valid number!", 'Error');
                return false;
            }
            if(_Number.length !=0 && Math.round(_Amount) == 0){
                toastr.error("Invalid Amount, Please enter a valid Amount!", 'Error');
                return false;
            }

            if(_Number.length !=0 && _Amount.length !=0){

                if(NumberValid.includes(""+_Number)==false){
                    toastr.error("Invalid Number, Please enter a valid number!", 'Error');
                    return false;
                }

                add_field(_Number,_Amount);

                $(".number1").focus();
                $('.number1').val('');
                $('.amount1').val('');
            }
        }
	}

	function remove_transaction_fields(rid) {
		$('.removeclass'+rid).remove();

        // calculate total and count
        calculation();
	}

    $("input[name='amount[]']").change(function(){
        // calculate total and count
        calculation();
    });

    function calculation()
    {
        var count=0;
        var total=0;
        $("input[name='amount[]']").map(function(){
            if ($(this).val()!="") {
                count++;
                total=parseFloat($(this).val())+parseFloat(total);
            }
        }).get();
        $('#amount_count').text(count);
        $('#total').text(total);
        $('#total_amount').val(total);
        
        var numbers=$("input[name='number[]']").map(function(){
            return $(this).val();
        }).get();

        var amounts=$("input[name='amount[]']").map(function(){
            return $(this).val();
        }).get();


        // Set data to jantri view
        for (let i = 0; i < numbers.length; i++) { //set null before filling value
            $('#number_'+numbers[i]).val('');
        }
        for (let i = 0; i < numbers.length; i++) {
            // console.log(parseFloat($('#number_'+numbers[i]).val())+"/"+parseFloat(amounts[i]));
            if ($('#number_'+numbers[i]).val()) {
                $('#number_'+numbers[i]).val(parseFloat($('#number_'+numbers[i]).val())+parseFloat(amounts[i]));
            } else {
                $('#number_'+numbers[i]).val(amounts[i]);
            }
        }      

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

    $("input,select,button,textarea").focus(function(){
		LastFocusedControl_Id = $(":focus").attr("id");
        // console.log(LastFocusedControl_Id);
	});
	
    ko.bindingHandlers.nextFieldOnEnter = {
        init: function(element, valueAccessor, allBindingsAccessor) {
            $(element).on('keydown', 'input, select', function (e) {
                var self = $(this)
                , form = $(element)
                  , focusable
                  , next
                ;
				LastFocusedControl_Id = $(":focus").attr("id");
                if (e.keyCode == 13) {
                    // console.log(LastFocusedControl_Id);
					focusable = form.find('input,select,button,textarea').filter(':visible');
					var nextIndex = 0;
					if(VerticalEnterMove == true){
						if ($(".JantriInput").is( ":focus" )) {
							var InputId = LastFocusedControl_Id;
							var OnlyNumber = InputId.replace('number_','');						
							if(parseInt(OnlyNumber) <= 90){
								$("#number_"+(parseInt(OnlyNumber)+10)).focus().select();
							}else if(parseInt(OnlyNumber) >= 91 && parseInt(OnlyNumber) < 100){
								$("#number_"+((parseInt(OnlyNumber)-90)+1)).focus().select();
							}else if(parseInt(OnlyNumber) == 100){
								$("#number_111").focus().select();
								VerticalEnterMove = false;
							}
						}
					}else{
						nextIndex = focusable.index(this) == focusable.length -1 ? 0 : focusable.index(this) + 1;
						next = focusable.eq(nextIndex);
						next.focus().select();
					}
					
					return false;
                }
            });
        }
    };
    ko.applyBindings({});

