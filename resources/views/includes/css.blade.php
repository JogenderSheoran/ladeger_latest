 <!-- BEGIN GLOBAL MANDATORY STYLES -->
 <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
 <!-- END GLOBAL MANDATORY STYLES -->


 <!-- BEGIN PAGE LEVEL PLUGINS -->
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" />


 <link href="{{ URL::asset('/assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css" /> 
 <link href="{{ URL::asset('/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
 
 <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <link href="{{ URL::asset('/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ URL::asset('/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

 <!-- BEGIN THEME GLOBAL STYLES -->
 <link href="{{ URL::asset('/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
 <link href="{{ URL::asset('/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
 <!-- END THEME GLOBAL STYLES -->

 <!-- BEGIN THEME LAYOUT STYLES -->
 <link href="{{ URL::asset('/assets/layouts/layout3/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ URL::asset('/assets/layouts/layout3/css/themes/default.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
 <link href="{{ URL::asset('/assets/layouts/layout3/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
 <!-- END THEME LAYOUT STYLES -->

<style>
.dt-buttons{
    display: none;
}

.fRight{
    float: right;
}

.fLeft{
    float: left;
}

.Toppadding{
    padding:7px;
}
.hide{
    display:none;
}

.dataTables_scrollHead{
    
    background: #4861C2;
    color: #fff;
    position: relative;
    border: 0px;
    width: 100%;
}
    
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

.blink_text
{
    animation:1s blinker linear infinite;
    -webkit-animation:1s blinker linear infinite;
    -moz-animation:1s blinker linear infinite;
}

@-moz-keyframes blinker
{  
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
}

@-webkit-keyframes blinker
{  
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
}

@keyframes blinker
{  
    0% { opacity: 1.0; }
    50% { opacity: 0.0; }
    100% { opacity: 1.0; }
 }
</style>
<style>
    .model_custom_header{
        background-color:blue;
        color:white;
        font-weight:bold;
    }
    .add_button{
        border-radius:5px !important;
        padding:5px;
    }
    .short {
        max-width: 50px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
}
</style>