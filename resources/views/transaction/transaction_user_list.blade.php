@extends('layouts.master') 
@section('content')
<link href="{{URL::asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
<div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container">
                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title">
                                        <h1>New User Profile | Account
                                            <small>user account page</small>
                                        </h1>
                                    </div>
                                    <!-- END PAGE TITLE -->
                                    <!-- BEGIN PAGE TOOLBAR -->
                                    <div class="page-toolbar">
                                        <!-- BEGIN THEME PANEL -->
                                        <div class="btn-group btn-theme-panel">
                                            <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-settings"></i>
                                            </a>
                                            <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <h3>THEME COLORS</h3>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <ul class="theme-colors">
                                                                    <li class="theme-color theme-color-default" data-theme="default">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Default</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-blue-hoki" data-theme="blue-hoki">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Blue Hoki</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-blue-steel" data-theme="blue-steel">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Blue Steel</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-yellow-orange" data-theme="yellow-orange">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Orange</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-yellow-crusta" data-theme="yellow-crusta">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Yellow Crusta</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <ul class="theme-colors">
                                                                    <li class="theme-color theme-color-green-haze" data-theme="green-haze">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Green Haze</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-red-sunglo" data-theme="red-sunglo">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Red Sunglo</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-red-intense" data-theme="red-intense">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Red Intense</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-purple-plum" data-theme="purple-plum">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Purple Plum</span>
                                                                    </li>
                                                                    <li class="theme-color theme-color-purple-studio" data-theme="purple-studio">
                                                                        <span class="theme-color-view"></span>
                                                                        <span class="theme-color-name">Purple Studio</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 seperator">
                                                        <h3>LAYOUT</h3>
                                                        <ul class="theme-settings">
                                                            <li> Theme Style
                                                                <select class="theme-setting theme-setting-style form-control input-sm input-small input-inline tooltips" data-original-title="Change theme style" data-container="body" data-placement="left">
                                                                    <option value="boxed" selected="selected">Square corners</option>
                                                                    <option value="rounded">Rounded corners</option>
                                                                </select>
                                                            </li>
                                                            <li> Layout
                                                                <select class="theme-setting theme-setting-layout form-control input-sm input-small input-inline tooltips" data-original-title="Change layout type" data-container="body" data-placement="left">
                                                                    <option value="boxed" selected="selected">Boxed</option>
                                                                    <option value="fluid">Fluid</option>
                                                                </select>
                                                            </li>
                                                            <li> Top Menu Style
                                                                <select class="theme-setting theme-setting-top-menu-style form-control input-sm input-small input-inline tooltips" data-original-title="Change top menu dropdowns style" data-container="body"
                                                                    data-placement="left">
                                                                    <option value="dark" selected="selected">Dark</option>
                                                                    <option value="light">Light</option>
                                                                </select>
                                                            </li>
                                                            <li> Top Menu Mode
                                                                <select class="theme-setting theme-setting-top-menu-mode form-control input-sm input-small input-inline tooltips" data-original-title="Enable fixed(sticky) top menu" data-container="body"
                                                                    data-placement="left">
                                                                    <option value="fixed">Fixed</option>
                                                                    <option value="not-fixed" selected="selected">Not Fixed</option>
                                                                </select>
                                                            </li>
                                                            <li> Mega Menu Style
                                                                <select class="theme-setting theme-setting-mega-menu-style form-control input-sm input-small input-inline tooltips" data-original-title="Change mega menu dropdowns style" data-container="body"
                                                                    data-placement="left">
                                                                    <option value="dark" selected="selected">Dark</option>
                                                                    <option value="light">Light</option>
                                                                </select>
                                                            </li>
                                                            <li> Mega Menu Mode
                                                                <select class="theme-setting theme-setting-mega-menu-mode form-control input-sm input-small input-inline tooltips" data-original-title="Enable fixed(sticky) mega menu" data-container="body"
                                                                    data-placement="left">
                                                                    <option value="fixed" selected="selected">Fixed</option>
                                                                    <option value="not-fixed">Not Fixed</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END THEME PANEL -->
                                    </div>
                                    <!-- END PAGE TOOLBAR -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">
                                    <!-- BEGIN PAGE BREADCRUMBS -->
                                    <ul class="page-breadcrumb breadcrumb">
                                        <li>
                                            <a href="index.html">Home</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <a href="#">Pages</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <span>User</span>
                                        </li>
                                    </ul>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN PROFILE SIDEBAR -->
                                                <div class="profile-sidebar">
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light profile-sidebar-portlet ">
                                                        <!-- SIDEBAR USERPIC -->
                                                        <div class="profile-userpic">
                                                            <img src="{{URL::asset('assets/pages/media/profile/profile_user.jpg')}}" class="img-responsive" alt=""> </div>
                                                        <!-- END SIDEBAR USERPIC -->
                                                        <!-- SIDEBAR USER TITLE -->
                                                        <div class="profile-usertitle">
                                                            <div class="profile-usertitle-name"> Admin </div>
                                                           
                                                        </div>
                                                        <!-- END SIDEBAR USER TITLE -->
                                                        <!-- SIDEBAR BUTTONS -->
                                                        <div class="profile-userbuttons">
                                                            <button type="button" class="btn btn-circle green btn-sm">Net Amount: 12345</button>
                                                        </div>
                                                        <!-- END SIDEBAR BUTTONS -->
                                                        <!-- SIDEBAR MENU -->
                                                        <div class="profile-usermenu">
                                                            <ul class="nav">
                                                                <li>
                                                                    <a href="page_user_profile_1.html">
                                                                        <i class="icon-home"></i> Overview </a>
                                                                </li>
                                                                <li class="active">
                                                                    <a href="page_user_profile_1_account.html">
                                                                        <i class="icon-settings"></i> Account Settings </a>
                                                                </li>
                                                                <li>
                                                                    <a href="page_user_profile_1_help.html">
                                                                        <i class="icon-info"></i> Help </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- END MENU -->
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                    <!-- PORTLET MAIN -->
                                                    <div class="portlet light ">
                                                        <!-- STAT -->
                                                        <div class="row list-separated profile-stat">
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 37 </div>
                                                                <div class="uppercase profile-stat-text"> Projects </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 51 </div>
                                                                <div class="uppercase profile-stat-text"> Tasks </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                                <div class="uppercase profile-stat-title"> 61 </div>
                                                                <div class="uppercase profile-stat-text"> Uploads </div>
                                                            </div>
                                                        </div>
                                                        <!-- END STAT -->
                                                        <div>
                                                            <h4 class="profile-desc-title">About Marcus Doe</h4>
                                                            <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-globe"></i>
                                                                <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-twitter"></i>
                                                                <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                                            </div>
                                                            <div class="margin-top-20 profile-desc-link">
                                                                <i class="fa fa-facebook"></i>
                                                                <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END PORTLET MAIN -->
                                                </div>
                                                <!-- END BEGIN PROFILE SIDEBAR -->
                                                <!-- BEGIN PROFILE CONTENT -->
                                                <div class="profile-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="portlet light ">
                                                                <div class="portlet-title tabbable-line">
                                                                    <div class="caption caption-md">
                                                                        <i class="icon-globe theme-font hide"></i>
                                                                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                                    </div>
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active">
                                                                            <a href="#tab_1_1" data-toggle="tab">Transaction</a>
                                                                        </li>
                                                                      
                                                                    </ul>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <div class="tab-content">
                                                                       
                                                                        <!-- END CHANGE PASSWORD TAB -->
                                                                        <!-- PRIVACY SETTINGS TAB -->
                                                                        <div class="tab-pane active" id="tab_1_1">
                                                                            <form action="#">
                                                                                <table class="table table-light table-hover">
                                                                                   
                                                                                    @foreach($ledger as $l)
                                                                                    <tr>
                                                                                        <td><h6><b>Amount:</b></td>
                                                                                        <td><h6><b>Date:</b></td>
                                                                                        <td><h6><b>By:</b></td>
                                                                                        <td>
                                                                                            <div class="mt-radio-inline">
                                                                                            <a href="javascript:;" class="btn red">Liye</a>
                                                                                            <a href="javascript:;" class="btn green">Diye</a>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                                </table>
                                                                                <!--end profile-settings-->
                                                                                <div class="margin-top-10">
                                                                                    <a href="javascript:;" class="btn red"> Save Changes </a>
                                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- END PRIVACY SETTINGS TAB -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END PROFILE CONTENT -->
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
@endsection
@section('js')
<script>

    

    function fetch_transaction(){
        var shift=$('#shift').val();

        var table = $('#mytable').DataTable();
        table.destroy();
        $('#transaction_data').empty();
        $('.footer').hide();

        if (shift) {
            $.ajax({		            	
                type: "POST",
                url: "{{route('fetch_transaction')}}",
                enctype: 'multipart/form-data',
                data: {shift:shift,date:$('#date').val(),keyword:$('#keyword').val(),staff:$('#staff').val(),status:$('#status').val(),"_token": "{{ csrf_token() }}","user":{{Auth::User()->id}}},                                     
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
                            if (value['status']==0) {
                                html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><a href="javascript:;" id="copy'+value['id']+'" class="btn btn-xs yellow" onclick="copy_transaction('+value['id']+')">Copy</a><a href="javascript:;" id="view'+value['id']+'" class="btn btn-xs green" onclick="transaction_detail('+value['id']+')">View</a><a href="'+url+'" id="edit'+value['id']+'" class="btn btn-xs blue">Edit</a><a href="javascript:;" id="delete'+value['id']+'" class="btn btn-xs red" onclick="delete_transaction('+value['id']+')"> Delete </a></td></tr>';
                            } else {
                                html +='<tr><td style="text-align: center;">'+serial+'</td><td style="text-align: center;">'+value['name']+'</td><td style="text-align: center;">'+value['dara']+'/'+value['dara_commission']+'-'+value['akhar']+'/'+value['akhar_commission']+'</td><td style="text-align: center;">'+value['total']+'</td><td style="text-align: center;"><span class="sbold">'+value['added_name']+'</span> </br> '+value['addedAt']+'</td><td style="text-align: center;"><span class="sbold">'+value['updated_name']+'</span> </br> '+value['updatedAt']+'</td><td style="text-align: center;"><spna style="color:red;">Deleted</span></td></tr>';
                            }
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

  
    $("#search").click(function(){
        fetch_transaction();
    });




</script>    
<script src="{{URL::asset('assets/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
@endsection
