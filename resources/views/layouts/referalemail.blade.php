<!DOCTYPE html>
<html lang="en">

<head>
    <title>Unsubscribe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body style="margin: 15px; border: 2px dashed #4292CD; padding: 10px;">

    <div class="container" style="margin-top: 10px;">



        <div class="row">
            <div class="col-sm-12">
                <h3 style="text-align: center; margin: 0px;">
                    <img src="{{asset('/public/images/logo-register.png')}}" style=" width: 25%;">

                </h3>

                <div class="text-center">

                    <h3 style="color: #8C8C8C; font-weight: 500; font-size: 30px; text-align: center; margin: 0px; margin-top: 30px; margin-bottom: 30px;  ">
                        You're invited to try nichepractice <b></b></h3>

                    <p style="font-size: 23px; color: #747474; text-align: left; margin: 5px;  ">Your friend,{{$current_user_first_name }} wants you to try our software. Nichepractice enables doctors to choose a practice niche, then instantly execute marketing solutions to help differentiate their practice from the competition, grow their revenue and reputation and brand themselves as experts.</p>
                    <p style="font-size: 20px; color: #747474;  text-align:center; margin-top: 30px; margin-right: 23px; font-weight: 600; ">Sign up now to start your free two-week trial.</p>


                    <div style="text-align: center; margin-top: 30px;">
                    <a href="{{$baseurl.'/admin-register?u_id='.$u_id}}" style="
                            display: inline-block;
                            font-weight: 400;
                            color: #212529;
                            text-align: center;
                            vertical-align: middle;
                            cursor: pointer;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            background-color: transparent;
                            border: 1px solid transparent;
                            padding: .375rem .75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: .25rem;
                            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;

                            text-decoration: none; background-color: #2EA2DE; border: #2EA2DE; font-weight: 600; text-align: center; color: white; ">Sign up for Nichepractice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #7F7F7F; margin-top: 5rem; padding: 10px; color: white; text-align: center; ">
        <div class="container" style=" max-width: 800px; margin: auto; ">
{{--            <p style="padding-top: 20px; text-align: center; color: white;">This message was sent to <a class="email-color" style="color: #ffffff;">{{ $referalemail['email'] }}.</a> if you don't want to receive emails from nichepractice, please  <a href="{{ route('unsubscribe') }}" title="" style="color: white; text-decoration: underline;"> unsubscribe.</a> </p>--}}
            <p style="padding: 20px; color: white;" >Nichepractice Inc.   401 East Jackson Street,  Suite 2340, Tampa, FL 33602</p>
        </div>
    </div>
</body>

</html>
