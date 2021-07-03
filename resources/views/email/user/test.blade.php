
<div style="font-family: Arial, Helvetica, sans-serif;
/*width: 80%;*/
/*max-width: 802px;*/
/*padding-right: 100px;*/
/*padding-left: 120px;*/
box-sizing: border-box;">
    <div style="width: 100%;
    max-width: 415px;
    margin: auto;
    box-sizing: border-box;
    border-bottom: 1px #f0f2f3 solid;
">
    @if ($logo)
    <img src="{{ $logosrc }}" alt="" style="height:64px; width:auto;">

    @else
        <h1 style="
        color: rgb(75,84,89)!important;
        font-size: 26px !important;
        line-height: 26px !important;
        font-weight: 400 !important;
        padding: 16px 0px 10px !important;
        max-width: 415px !important;
        margin: auto !important;
        /*font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;*/
            font-family: -apple-system,BlinkMacSystemFont, Segoe UI,Roboto, Helvetica Neue ,Ubuntu,sans-serif;
        ">{{ $practice_name }}</h1>
    @endif

        </div>
{{--        <hr style="border: #F0F2F3 1px solid;">--}}
        <div style="width: 100%;
       /* padding-right: 15px;
        padding-left: 15px;*/
        margin-right: auto;

        color:#4B5459;
        box-sizing: border-box;">
            <h1 style="
            color: rgb(75,84,89)!important;
            font-size: 26px;
            line-height: 26px;
            font-weight: normal;
            margin-bottom: 0px;
            padding: 33px 0px 12px 0px;
            max-width: 415px;
            margin: auto;
            /*font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;*/
             font-family: -apple-system,BlinkMacSystemFont, Segoe UI,Roboto, Helvetica Neue ,Ubuntu,sans-serif;
">We'd love your feedback</h1>
        </div>
        <div style="width: 100%;
        padding-right: 15px;
        margin-right: auto;
        margin-left: auto;
        box-sizing: border-box;
        font-size:24px;
        color: #666E71;
font-size: 13px !important;
    font-weight: 400 !important;
    line-height: 22px !important;
    color: rgb(95, 103, 107) !important;
        max-width: 415px;
    margin: auto;
     font-family: -apple-system,BlinkMacSystemFont, Segoe UI,Roboto, Helvetica Neue ,Ubuntu,sans-serif;
">
            @if(empty($emailMessage))
{{--                <p>Hi {{ $firstName }},</p>--}}
                <p> Thanks for getting in touch with {{ $BusinessName }} recently! We're always striving to improve and would love your feedback on the experience.</p>
                <br>
            @else
                <p style="  font-size: 14px; font-weight: 400; line-height: 22px; color: rgb(95, 103, 107); font-family: -apple-system,BlinkMacSystemFont, Segoe UI,Roboto, Helvetica Neue ,Ubuntu,sans-serif;">
                    <?php
                    $emailMessage = 'Hi {{name}}!<br>' . $emailMessage;
                    if(!empty($firstName))
                    {
                        $fullName = $firstName;
//                        if(!empty($lastName))
//                        {
//                            $fullName = $firstName . ' ' .$lastName;
//                        }

                        $emailMessage = str_replace('{{name}}', $fullName, $emailMessage);
                    }
//                    else if(!empty($lastName))
//                    {
//                        $fullName = $lastName;
//
//                        $emailMessage = str_replace('{{name}}', $fullName, $emailMessage);
//                    }
                    else
                    {
                        $formatToReplace = array(' {{name}}', '{{name}}');
                        $replaceFormat = array('', '');

                        $emailMessage = str_replace($formatToReplace, $replaceFormat, $emailMessage);
                    }

                    echo $emailMessage;
                    ?>
                </p><br>
            @endif
        </div>
    </div>
        <div style="font-family: Arial, Helvetica, sans-serif;
        /*width: 100%;*/
        /*max-width: 802px;*/
        padding-right: 15px;
        padding-left: 15px;
        /*margin-right: auto;*/
        /*margin-left: auto;*/
        box-sizing: border-box;
        color:#C4C9CC;
        font-size:22px;
        text-align: center;
        margin-bottom:30px;
        text-align: center;
        background-color:#FAFAFB;
        border-top:#F0F2F3 1px solid;
        padding-top: 20px;
    padding-bottom: 20px;
/*margin-left: 20px;*/
">
            <h4 style="
                    font-size: 14px !important;
    font-weight: 400 !important;
    line-height: 25px !important;
    color: rgb(193, 198, 201) !important;
        margin: 0px !important;
    padding: 0px 0px 18px !important;
    font-family: -apple-system,BlinkMacSystemFont, Segoe UI,Roboto, Helvetica Neue ,Ubuntu,sans-serif;
" >How was the quality of your care?</h4>
            <div style="display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            box-sizing: border-box;
            width: 100%;
            margin: auto;">
                <div style="position: relative;
                width: 50%;
                padding-right: 15px;
                padding-left: 15px;
                box-sizing: border-box;
                text-align: right;">
                    <a href="{{ url('business-review/'.$email.'/'.$varificationCode.'/'.$businessId.'/'.$reviewId.'/positive') }}"><img style="width: 70px;"  src="{{ $thumbupimg }}" alt=""></a>
                </div>
                <div style="position: relative;
                width: 50%;
                padding-right: 15px;
                padding-left: 15px;
                box-sizing: border-box;
                text-align: left;">
                    <a href="{{ url('business-review/'.$email.'/'.$varificationCode.'/'.$businessId.'/'.$reviewId.'/negative') }}"><img style="width: 70px;" src="{{ $thumbdownimg }}" alt=""></a>
                </div>
            </div>
        </div>

{{-- <p style="color: grey; text-align: center; margin-bottom:30px;">Do not reply to this email. Click on link below to leave your review.</p> --}}
