<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/demo/favicon.png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/theme/assets/vendors/material-icons/material-icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/theme/assets/vendors/mono-social-icons/monosocialiconsfont.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/theme/assets/vendors/feather-icons/feather.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('/theme/assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <style>
        .margin4{
            margin: 4px;
        }

        .black{
            color: black
        }

        *{
	padding: 0;
	margin: 0;
}


p{
	display: inline;
	margin-right: 5px;
}

#success, #fail{
	display: none;

}

#message, #success, #fail{
	margin-top: 10px;
	margin-bottom: 10px;
}

.container{
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%);
}
  




button:disabled{
	opacity: .5;
	cursor: default;
}
    </style>
</head>

<body class="body-bg-full profile-page" style="background-color: #2b80d3;">
    <div id="wrapper" class="row wrapper">
        
        @yield('content')


    </div>
    <!-- /.body-container -->
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ URL::asset('/theme/assets/js/material-design.js')}}"></script>

    <script>

        var total;

        function getRandom(){return Math.ceil(Math.random()* 20);}

        function createSum(){
                var randomNum1 = getRandom(),
                    randomNum2 = getRandom();
                    total =randomNum1 + randomNum2;
                    $( "#question" ).text( randomNum1 + " + " + randomNum2 + "=" );  
                $("#ans").val('');
                checkInput();
        }

        function checkInput(){
                var input = $("#ans").val(), 
                slideSpeed = 200,
            hasInput = !!input, 
            valid = hasInput && input == total;
            $('#message').toggle(!hasInput);
            $('button[type=submit]').prop('disabled', !valid);  
            $('#success').toggle(valid);
            $('#fail').toggle(hasInput && !valid);
        }

        $(document).ready(function(){
            //create initial sum
            createSum();
            // On "reset button" click, generate new random sum
            $('.reset').click(createSum);
            // On user input, check value
            $( "#ans" ).keyup(checkInput);
        });
    </script>
</body>

</html>