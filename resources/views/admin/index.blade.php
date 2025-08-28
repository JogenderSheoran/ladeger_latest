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
                            <div class="portlet-title">
                            <div class="">
                                <div class="row">

                                    <div class="col-md-1">
                                        <h6><b>Search</b></h6>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="page-title">
                                            <div class="btn-group" id="type_section">
                                            <input type="text" autocomplete="off"  name="search" id="search_ledger" placeholder="Admin"
                                                oninput='onInput_opposite()' list="opposite_party_list" id="opposite_party_balance"
                                                name="ledger_name_2" class="input-group form-control form-control-inline"
                                                >
                                            <datalist id="opposite_party_list" name="ledger_id2">
                                                @foreach($data as $d)
                                                <option value='{{$d->name}}'>{{$d->id}}</option>
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
                    </div>




                        </div>

                        <div class="portlet-body table-both-scroll">

                        <table class="table table-striped table-bordered table-hover order-column" id="mytable">
                                <thead>
                                    <tr> 
                                        <th class="text-font">Sr. No.</th>
                                        <th class="text-font">Name</th>
                                        <th class="text-font">Mobile</th>
                                        <th class="text-font">Date</th>
                                        <th class="text-font">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="ledger_body">
                                    @foreach($data as $key => $value)
                                    <tr id="row{{$value->id}}">
                                        <td class="text-size">{{++$key}}</td>
                                        <td class="text-size">{{$value->name}}</td>
                                        <td class="text-size">{{$value->mobile}}</td>
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
                <h4 class="modal-title" id="model_title"><b>Add Admin</b></h4>
            </div>
            <form method="POST" action="{{route('createAdmin')}}" id="add_shift">
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
                                            <label class="control-label ledger-font">Name</label>
                                            <input type="text" autocomplete="off" name="name" id="name" required class="form-control input" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Mobile</label>
                                            <input type="text" autocomplete="off" name="mobile" id="mobile" required class="form-control input" />
                                        </div>
                                    </div>
                                </div> 
                                <div class="row" id="password_section">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Password</label>
                                            <input type="password" autocomplete="off" name="password" id="password" required class="form-control input" />
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
                        <p>Are you sure to delete this admin?</p>

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

@endsection
@section('js')
<script>
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

    $('#addShift').on('hidden.bs.modal', function () {
        $('#add_shift')[0].reset(); 
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
                url: `{{route('createAdmin')}}`,
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
</script>

<script>
     $(document).ready(function () {
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
});

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
                url: `{{route('deleteAdmin')}}`,
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
    $("#model_title").text("Edit Admin").css({ 'font-weight': 'bold' });
    $('#addShift').modal('show');
    var ids = "#row" + id;
    var currentRow = $(ids).closest("tr");
    $("#id").val(id);
    $("#name").val(currentRow.find("td:eq(1)").text());
    $("#mobile").val(currentRow.find("td:eq(2)").text());
    $("#password_section").css('display','block');
}

$('#save').keypress((e) => {
  if (e.which === 13) {
      $('#ledger_form').submit();
  }
});

</script>
<script>
$("#search").click(function(){
    $.ajax({		            	
        type: "POST",
        url: "{{route('search_admin_data')}}",
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
                  
                    if(ledger['mobile']===null){
                        var mobile='';
                    }else{
                        var mobile=ledger['mobile'];
                    }
                  
                    html +='<tr id="row'+ledger['id']+'"><td class="text-size">'+serial+'</td><td class="text-size" id="shift_name">'+ledger['name']+'</td><td class="text-size">'+ledger['mobile']+'</td><td class="text-size">'+ledger['new_updated_at']+'</td><td>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="setId('+ledger['id']+')"><i class="fa fa-trash" style="color:red;"></i></a>&nbsp;&nbsp;</a>&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="editShift('+ledger['id']+')"><i class="fa fa-edit" style="color:blue;"></i></a></td></tr>';
                });
                $("#ledger_body").append(html);
            }
            else{
                toastr.error(res.message, 'Error');
            }
        }
    });
});
</script>
<scirpt src="http://select2.github.io/select2/select2-3.5.1/select2.js"></script>

@endsection