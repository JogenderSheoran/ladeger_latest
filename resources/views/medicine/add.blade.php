@extends('layouts.master')
@section('content')
<link href="https://smhexch.com/demo_project/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
 <link href="https://smhexch.com/demo_project/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    .text-size {
        font-size: 12px !important;
        color: #736666;
        font-weight: bold;
        text-align: center;
    }

    .text-font {
        text-align: center;
        font-weight: 600;
    }

    .selectRow {
        display: block;
        padding: 20px;
    }

    .select2-container {
        width: 200px;
    }

    .select2-drop-active {
        margin-top: -25px;
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
                                <div class="">
                                    <form id="medicineForm" action="https://smhexch.com/demo_project/api/medicine-insert" method="post" >
                                     <div class="row" style="width:98%; margin-left:2px; margin-bottom:20px;">
                                        <div class="col-md-6">
                                            <label for="medicine_name">Medicine Name</label>
                                            <input required placeholder="Medicine Name"name="medicine_name" id="medicine_name" class="form-control" type="text">
                                        </div>
                                        <div class="col-md-6" style="margin-top:24px;" >
                                            <button class="btn btn-primary" type="submit" >Submit</button>
                                        </div>
                                     </div>
                                    </form>

                                    <!-- {{--<div class="col-md-2">
                                        <div class="page-title">
                                            <input type="text" autocomplete="off" name="search" id="search_ledger" class="form-control">
                                        </div>
                                        <div id="searchList"></div>
                                    </div>
                                    <div class="col-md-1" style="float:left;">
                                        <div class="page-title">
                                            <button class="btn sbold green" id="search">Search</button>
                                        </div>
                                    </div>--}} -->
                                    <!-- <div class="col-md-1" style="float:right;">
                                        <div class="btn-group fRight">
                                            <a href="javascript:;" id="addShiftButton"
                                                class="btn sbold green add_button"> Add (F2)
                                            </a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>




                        </div>

                        <div class="portlet-body table-both-scroll">
                        <form id="medicine_transaction" action="https://smhexch.com/demo_project/api/medicine-transaction-add" method="post">
    @csrf <!-- Include CSRF token -->

    <div class="container">
        <div class="row" style="width: 98%;">
            <input type="hidden" id="admin_id" name="admin_id" value="{{ Auth::user()->id }}">
            <input type="hidden" id="ledger_amount" name="ledger_amount" value="0">

            <div class="col-md-6">
                <label for="singleSelectExample">Select Ledger</label>
                <select required style="width: 100%;" name="ledger_id" id="singleSelectExample">
                    <option value="">Select Ledger</option>
                    <option value="1">Option 1</option>
                    <option value="2">Jogender</option>
                    <option value="3">Nippu</option>
                    <option value="4">Amit</option>
                    <option value="5">Option 5</option>
                </select>
            </div>

            <div class="col-md-6" style="display: grid;">
                <label for="medicineSelectExample">Select Mcine</label>
                <select required style="width: 100%;" name="medicine_id" id="medicineSelectExample">
                    <option value="">Select Medicine</option>
                    <option value="1">Option 1</option>
                    <!-- Add more options dynamically if needed -->
                </select>
            </div>
        </div>

        <div class="row" style="width: 98%; margin-top: 20px;">
            <div class="col-md-6">
                <label for="quantity">Quantity</label>
                <input required type="number" placeholder="Quantity" name="quantity" class="form-control" id="quantity">
                <span class="error-message" style="display:none;color:red" id="quantity-error">Please enter a valid number.</span>
            </div>
            <div class="col-md-6" style="display: grid;">
                <label for="price">Single Unit Price</label>
                <input required type="number" placeholder="Price" name="price" class="form-control" id="price" type="text">
            </div>
        </div>

        <div class="row" style="width: 98%; margin-top: 20px;">
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

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
            <form method="POST" action="{{ route('createAdmin') }}" id="add_shift">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="user_id" id="Wid" value="{{ Auth::user()->id }}">
                <div class="modal-body">
                    <div class="portlet-body">

                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Name</label>
                                            <input type="text" autocomplete="off" name="name" id="name" required
                                                class="form-control input" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Mobile</label>
                                            <input type="text" autocomplete="off" name="mobile" id="mobile" required
                                                class="form-control input" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="password_section">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label ledger-font">Password</label>
                                            <input type="password" autocomplete="off" name="password" id="password"
                                                required class="form-control input" />
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
<script src="https://select2.github.io/select2/select2-3.5.1/select2.js"></script>
<script src="https://select2.github.io/select2/select2-3.5.1/select2.css"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{URL::asset('assets/pages/scripts/table-bootstrap.min.js')}}" type="text/javascript"></script>
 <link href="https://smhexch.com/demo_project/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
 <link href="https://smhexch.com/demo_project/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
@section('js')

<script>
    $(document).ready(function() {
        $('#medicineForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request to API endpoint
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Handle success (redirect and show message)
                    alert('Medicine inserted successfully');
                    window.location.href = window.location.href; // Redirect to same page
                },
                error: function(xhr, status, error) {
                    // Handle error (show popup with error message)
                    var errorMessage = xhr.responseJSON.message;
                    alert('Error: ' + errorMessage);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#medicine_transaction').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request to API endpoint
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Handle success (redirect and show message)
                    alert('Medicine inserted successfully');
                    window.location.href = window.location.href; // Redirect to same page
                },
                error: function(xhr, status, error) {
                    // Handle error (show popup with error message)
                    var errorMessage = xhr.responseJSON.message;
                    alert('Error: ' + errorMessage);
                }
            });
        });
    });
</script>


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
                url: `{{ route('createAdmin') }}`,
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
    $('#search_ledger').keyup(function () {
        var query = $(this).val();
        if (query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: `${window.pageData.baseUrl}/api/autocompelete_ledger`,
                method: "POST",
                data: {
                    name: query,
                    _token: _token
                },
                success: function (data) {
                    $('#searchList').fadeIn();
                    $('#searchList').html(data.data);
                }
            });
        }
    });

    $(document).on('click', 'li', function () {
        $('#search_ledger').val($(this).text());
        $('#searchList').fadeOut();
    });



    $('#ledger_form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('body').on('keydown', 'input, select', function (e) {
        if (e.key === "Enter") {
            var self = $(this),
                form = self.parents('form:eq(0)'),
                focusable, next;
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this) + 1);
            console.log("check next", next);
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
            url: `{{ route('deleteNotes') }}`,
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
        $("#model_title").text("Edit Ledger").css({
            'font-weight': 'bold'
        });
        $('#addShift').modal('show');
        var ids = "#row" + id;
        var currentRow = $(ids).closest("tr");
        $("#id").val(id);
        $("#name").val(currentRow.find("td:eq(1)").text());
        $("#mobile").val(currentRow.find("td:eq(2)").text());
        $("#password_section").css('display', 'none');
    }

    $('#save').keypress((e) => {
        if (e.which === 13) {
            $('#ledger_form').submit();
        }
    });

    $('#myselect123').select2({
        placeholder: 'Select a month'
    });

</script>
<script>
    // Setting default configuration here or you can set through configuration object as seen below
    $.fn.select2.defaults = $.extend($.fn.select2.defaults, {
        allowClear: true, // Adds X image to clear select
        closeOnSelect: true, // Only applies to multiple selects. Closes the select upon selection.
        placeholder: 'Select...',
        minimumResultsForSearch: 15 // Removes search when there are 15 or fewer options
    });

    $(document).ready(

        function () {

            // Single select example if using params obj or configuration seen above
            var configParamsObj = {
                placeholder: 'Select an option...', // Place holder text to place in the select
                minimumResultsForSearch: 3 // Overrides default of 15 set above
            };
            $("#singleSelectExample").select2(configParamsObj);
        });

    $(document).ready(

        function () {

            // Single select example if using params obj or configuration seen above
            var medicineSelect = {
                placeholder: 'Medicine an option...', // Place holder text to place in the select
                minimumResultsForSearch: 3 // Overrides default of 15 set above
            };
            $("#medicineSelectExample").select2(medicineSelect);
        });

</script>
<script>
</script>

<script>
    $(document).ready(function() {
        // Function to fetch data from API and populate options
        function fetchAndPopulateOptions() {
            $.get(`${window.pageData.baseUrl}/api/medicine-list`, function(response) {
                var selectElement = $('#medicineSelectExample');
                
                // Clear existing options except the first placeholder option
                selectElement.find('option:not(:first-child)').remove();

                // Append new options based on received data
                response.medicines.forEach(function(option) {
                    selectElement.append($('<option>', {
                        value: option.id,
                        text: option.medicine_name
                    }));
                });
            }).fail(function(xhr, status, error) {
                console.error('Error fetching data:', error);
            });
        }

        // Fetch and populate options on page load
        fetchAndPopulateOptions();

        // Optionally, you can refresh options on a button click or other event
        $('#refreshOptionsBtn').click(fetchAndPopulateOptions);
    });
</script>

<script>
    $(document).ready(function() {
        // Function to fetch data from API and populate options
        function fetchAndPopulateOptions() {
            $.get(`${window.pageData.baseUrl}/api/ledger-list`, function(response) {
                // console.log("res",response);
                var selectElement = $('#singleSelectExample');
                
                // Clear existing options except the first placeholder option
                selectElement.find('option:not(:first-child)').remove();

                // Append new options based on received data
                response.ledger.forEach(function(option) {
                    selectElement.append($('<option>', {
                        value: option.id,
                        text: option.name
                    }));
                });
            }).fail(function(xhr, status, error) {
                console.error('Error fetching data:', error);
            });
        }

        // Fetch and populate options on page load
        fetchAndPopulateOptions();

        // Optionally, you can refresh options on a button click or other event
        $('#refreshOptionsBtn').click(fetchAndPopulateOptions);
    });
</script>


<script>
    function getPrice() {
        var selectedMedicineId = $('#medicineSelectExample').val();
        var selectedLedgerId = $('#singleSelectExample').val(); // Assuming this is the ID of another select element
        var selectedadminId = $('#admin_id').val(); // Assuming this is the ID of another select element

        console.log('Selected Medicine ID:', selectedMedicineId);
        console.log('Selected Ledger ID:', selectedLedgerId);
        console.log('Selected admin ID:', selectedadminId);

        // Only make the AJAX request if both IDs are valid
        if (selectedMedicineId && selectedLedgerId) {
            $.ajax({
                url: `${window.pageData.baseUrl}/api/get-last-price`,
                method: 'post',
                data: {
                    medicine_id: selectedMedicineId,
                    ledger_id: selectedLedgerId,
                    admin_id: selectedadminId
                },
                
                success: function(response) {
                    if(response.data){
                        $('#price').val(response.data);
                        $('#price').prop('disabled', true);
                    }else{
                        $('#price').val(" ");
                        $('#price').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching price:', error);
                }
            });
        } else {
            console.warn('Invalid IDs: Both medicine_id and ledger_id are required.');
        }
    }

    $(document).ready(function() {
        // Attach onchange event handlers to the select elements using jQuery
        $('#medicineSelectExample').change(function() {
            getPrice(); // Call getPrice() function when the medicine select element value changes
        });

        $('#singleSelectExample').change(function() {
            getPrice(); // Call getPrice() function when the ledger select element value changes
        });
    });

    $('#quantity').on('keypress', function(event) {
            var charCode = event.which ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
                $('#quantity-error').show();
            } else {
                $('#quantity-error').hide();
            }
        });
</script>




@endsection
