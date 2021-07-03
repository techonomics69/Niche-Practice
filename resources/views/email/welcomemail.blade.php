<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Pinpoint Email Template</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

    <style type="text/css">
        html {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        .temp-main {
            background-position: 0 70%;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .box-shadow {
            box-shadow: 0px 4px 40px rgba(0, 0, 0, 0.08);
        }


        @media only screen and (min-device-width: 750px) {
            .table750 {
                width: 750px !important;
            }
        }

        @media only screen and (max-device-width: 750px), only screen and (max-width: 750px) {
            table[class="table750"] {
                width: 100% !important;
            }

            .mob_b {
                width: 93% !important;
                max-width: 93% !important;
                min-width: 93% !important;
            }

            .mob_b1 {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 100% !important;
            }

            .mob_left {
                text-align: left !important;
            }

            .mob_soc {
                width: 50% !important;
                max-width: 50% !important;
                min-width: 50% !important;
            }

            .mob_menu {
                width: 50% !important;
                max-width: 50% !important;
                min-width: 50% !important;
                box-shadow: inset -1px -1px 0 0 rgba(255, 255, 255, 0.2);
            }

            .mob_center {
                text-align: center !important;
            }

            .top_pad {
                height: 15px !important;
                max-height: 15px !important;
                min-height: 15px !important;
            }

            .mob_pad {
                width: 15px !important;
                max-width: 15px !important;
                min-width: 15px !important;
            }

            .mob_div {
                display: block !important;
            }
        }

        @media only screen and (max-device-width: 550px), only screen and (max-width: 550px) {
            .mod_div {
                display: block !important;
            }
        }

        .table750 {
            width: 750px;
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">

<table cellpadding="0" cellspacing="0" border="0" width="100%"
       style="background: #f3f3f3; min-width: 350px; font-size: 1px; line-height: normal;">
    <tr>
        <td align="center" valign="top">
            <!--[if (gte mso 9)|(IE)]>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" valign="top" width="750"><![endif]-->
            <table cellpadding="0" cellspacing="0" border="0" width="750" class="table750"
                   style="width: 100%; max-width: 750px; min-width: 350px; background: #ffffff;">
                <tr>
                    <td class="temp-main" align="center" valign="top">

                        <table cellpadding="0" cellspacing="0" border="0" width="100%"
                               style="width: 100% !important; min-width: 100%; max-width: 100%; background: #f3f3f3;">
                            <tr>
                                <td align="right" valign="top">
                                    <div class="top_pad" style="height: 25px; line-height: 25px; font-size: 23px;">
                                        &nbsp;
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="center" valign="top" class="box-shadow">
                                    <div style="height: 20px;">&nbsp;</div>
                                    <a href="#" target="_blank" style="display: block;">
                                        <img src="{{ asset('public/images/logo-new.png') }}" alt="img" width="40%"
                                             border="0" style="display: block;"/>
                                    </a>
                                    <div style="height: 20px;">&nbsp;</div>
                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="88%"
                               style="width: 88% !important; min-width: 88%; max-width: 88%;">
                            <tr>
                                <div style="height: 30px;">&nbsp;</div>
                                <td align="left" valign="top">

										<span style="font-family: 'Roboto', sans-serif;
 color: #000000; font-size: 18px; line-height: 26px;"> Hi {{ $firstName }}</span>

                                    <div style="height: 10px; line-height: 33px; font-size: 31px;">&nbsp;</div>

                                    <span style="font-family: 'Roboto', sans-serif;
 color: #000000; font-size: 18px; line-height: 26px;">
We are so excited that you chose NichePractice to help maximize your digital marketing plan for your business! We're committed to providing you with outstanding support and resources so that you will get the most out of your experience with the NichePractice platform. You're going to be thrilled with all that we have in store for you. Now what are you waiting for? Use the info provided below to log into your account for the first time and start exploring everything that NichePractice can do.


</span>

                                    <div style="height: 20px; line-height: 20px; font-size: 18px;">&nbsp;</div>

                                    <span style="font-family: 'Roboto', sans-serif;
 color: #1a1a1a; font-size: 22px; line-height: 60px; font-weight: 600;">Your Account Information</span>


                                    <div style="height: 0px;">&nbsp;</div>

                                    <span style="font-family: 'Roboto', sans-serif;
 color: #00000; font-size: 18px; line-height: 35px;">You're account is now active.  You can login right here: <br>
URL: http://nichepractice.net/login
											<br>
Email: {{$email}}%
											<br>
Password: %password%
<div style="height: 33px; line-height: 33px; font-size: 31px;">&nbsp;</div>
											<span style="font-family: 'Roboto', sans-serif;
 color: #000000; font-size: 18px; line-height: 26px;"><strong>Note: </strong>For security reasons, we highly recommend that you change your password once you're logged in.<br>

							</span>
</span>
                                    <div style="height: 30px;">&nbsp;</div>
                                    <span style="font-family: 'Roboto', sans-serif;
 color: #1a1a1a; font-size: 18px; line-height: 26px;">Be on the lookout for an email in the next couple of days from your assigned customer support team member to officially start your onboarding experience! If any issues arise between now and then please do not hesitate to reach out!</span>
                                    <div style="height: 30px;">&nbsp;</div>
                                    <span style="font-family: 'Roboto', sans-serif;
 color: #00000; font-size: 18px; line-height: 35px;"><strong>Regards,</strong> <br>
Customer Support<a href="#" target="_blank" style="text-decoration: none">
																	<span style="font-family: 'Roboto', sans-serif;
 color: #262F71; font-size: 18px; line-height: 20px;font-weight: 600">- support@nichepractice.net</span>
															</a>
											<br>
Contact us by phone<a href="#" target="_blank" style="text-decoration: none">
																	<span style="font-family: 'Roboto', sans-serif;
 color: #262F71; font-size: 18px; line-height: 20px;font-weight: 600">- 678-789-7898</span>
															</a>
											<br>
Follow us on<a href="#" target="_blank" style="text-decoration: none">
																	<span style="font-family: 'Roboto', sans-serif;
 color: #262F71; font-size: 18px; line-height: 20px;font-weight: 600">Facebook</span>
															</a>

							</span>
                                    </span>
                                </td>
                            </tr>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="left" valign="top">
                                    <div style="height: 15px; line-height: 15px; font-size: 13px;">&nbsp;</div>
                                </td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                            <tr>
                                <td align="center" valign="top">
                                    <a href="#" target="_blank" style="display: block; max-width: 25px;">
                                        <img src="http://34.237.166.80/public_images/facebook-icon.png" alt="img"
                                             width="25" border="0" style="display: block; width: 25px;">
                                    </a>
                                </td>
                                <td width="15" style="width: 15px; max-width: 15px; min-width: 15px;">&nbsp;</td>
                                <td align="center" valign="top">
                                    <a href="#" target="_blank" style="display: block; max-width: 25px;">
                                        <img src="http://34.237.166.80/public_images/instagram-icon.png" alt="img"
                                             width="25" border="0" style="display: block; width: 25px;">
                                    </a>
                                </td>
                                <td width="15" style="width: 15px; max-width: 15px; min-width: 15px;">&nbsp;</td>
                                <td align="center" valign="top">
                                    <a href="#" target="_blank" style="display: block; max-width: 25px;">
                                        <img src="http://34.237.166.80/public_images/youtube-icon.png" alt="img"
                                             width="25" border="0" style="display: block; width: 25px;">
                                    </a>
                                </td>

                            </tr>


                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%"
                               style="width: 100% !important; min-width: 100%; max-width: 100%;">
                            <tr>
                                <td align="center" valign="top">
                                    <div style="height: 15px; line-height: 34px; font-size: 32px;">&nbsp;</div>

                                </td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0" border="0" width="90%"
                               style="width: 90% !important; min-width: 90%; max-width: 90%;">
                            <tr>
                                <td align="center" valign="top">
										<span style="font-family: 'Roboto', sans-serif;
color: #868686;font-size: 14px;line-height: 30px;">Address Should Enter here <br>
Copyright 2019 NichePractice </span>
                                </td>
                            </tr>
                        </table>


                        <table cellpadding="0" cellspacing="0" border="0" width="100%"
                               style="width: 100% !important; min-width: 100%; max-width: 100%;">
                            <tr>
                                <td align="center" valign="top">
                                    <div style="height: 34px; line-height: 34px; font-size: 32px;">&nbsp;</div>

                                </td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%"
                               style="width: 100% !important; min-width: 100%; max-width: 100%; background: #f3f3f3;">
                            <tbody>
                            <tr>
                                <td align="right" valign="top">
                                    <div class="top_pad" style="height: 25px; line-height: 25px; font-size: 23px;">
                                        &nbsp;
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr>
            </table><![endif]-->
        </td>
    </tr>
</table>
</body>
</html>
