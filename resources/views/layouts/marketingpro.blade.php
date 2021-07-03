@extends('index')

@section('pageTitle', 'Credits Plans')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid marketing-container-width dashboarbgtitle upgrade-plan-container">
            <div class="">
                <div class="page-head" style="margin-top: 40px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="marketing-title text-center" style="font-weight: 400  ;" >Marketing Pro Services</h4>
                            <h3 class="marketing-pro-des m-t-15" >We've created an amazing marketing support team of experts that will give you access to professionally written content, digital marketing solutions and well-researched marketing strategies based on your practice needs.</h3>
                        </div>
                    </div>
                </div>

                @if(!empty($list))
                <div class="marketing-plan-wrapper credits-wrapper cards-center-fold">
                <?php
                    ob_start();
                    ?>
                @foreach($list as $index => $pro)
                        @if($index != 0 && $index%4 == 0)
                            </div><div class="marketing-plan-wrapper credits-wrapper cards-center-fold">
                        @endif

                            <div class="marketing-pro-box" data-target="{{ base64_encode($pro['id']) }}">
                                <div class="text-center bg-white marketing-pro-shadow" style="">
                                 @if(!empty($pro['thumbnail']))
                                    <img src="{{ uploadImagePath('public/'.$pro['thumbnail']) }}"  alt="Avatar" class="image marketing-pro-img" style="width:80px; height:90px">
                                 @else
                                        <img  src="<?php echo e(asset('public/images/marketing-pro/marketing5.png')); ?>" alt="Avatar" class="image marketing-pro-img" style="width:80px; height:90px;">
                                 @endif
                                    <h6 class="marketing-pro-title" style="">{{ $pro['title'] }}</h6>
                                </div>
                            </div>

                    @endforeach
                    <?php
                    $html = ob_get_contents();
                    ob_end_clean();

                    echo $html;
                    ?>
                @endif
                </div>

                <div class="marketing-plan-wrapper credits-wrapper cards-center-fold" style="display: none;">

                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing5.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing6.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing7.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing8.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                </div>

                <div class="marketing-plan-wrapper credits-wrapper cards-center-fold" style="margin-bottom: 50px;display: none;">

                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing9.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing10.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing11.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img  src="<?php echo e(asset('public/images/marketing-pro/marketing12.png')); ?>" alt="Avatar" class="image marketing-pro-img">
                            <h6 class="marketing-pro-title" style="" >Reputation management</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/stripe-base.css?ver='.$appFileVersion) }}">
    <link rel="stylesheet" href="{{ asset('public/payment-checkout/css/style.css?ver='.$appFileVersion) }}">
    <style>

        .marketing-plan-wrapper{
            display: flex;
            justify-content: center;
        }

        .marketing-title{
            font-size: 29px;
            font-weight: 600 !important;
        }
        .marketing-pro-des{
            font-weight: 500;
            max-width: 805px;
            text-align: center;
            margin: auto;
            color: #3C3C3E;
            font-size: 14px;
        }
        .marketing-pro-title{
            font-weight: 700;
            margin: 0;
            padding: 10px 30px 20px 30px;
            line-height: 15px;
            height: 7vh;
            font-size: 14px;
        }
        .marketing-pro-img{
            padding: 20px 0px 0px 0px;
        }
        .marketing-pro-box{
            cursor: pointer;
            /*padding: 20px 15px 10px 15px;*/
            width: 200px;
            height: 130px;
            margin-bottom: 50px;
        }
        .marketing-pro-shadow{
            /*box-shadow: rgba(80, 80, 80, 0.50) 0px 2px 6px 3px;*/
            border-radius: 3px;
            border: 1px solid #EAEAEA;
            -webkit-box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
            -moz-box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
            box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
            margin: 10px;
        }
        @media screen and (max-width: 839px){
            .marketing-pro-title{
                padding: 10px 20px 20px 20px;
            }
        }

        @media screen and (max-width: 767px){
            .marketing-pro-box{
                display: inline-table;
            }
            .marketing-plan-wrapper{
                display: block;
            }
        }
        @media screen and (max-width: 425px){
            .marketing-pro-title{
                padding: 10px 10px 20px 10px;
            }
            .container-fluid.dashboarbgtitle{
                margin-bottom: 50px;
            }
            .marketing-pro-box{
                margin-bottom: 0px;
            }
        }
        @media screen and (max-width: 414px){
            .marketing-pro-box{
                width: 190px;

            }
        }
        @media screen and (max-width: 375px){
            .marketing-pro-box{
                width: 176px;
            }
        }
        @media screen and (max-width: 360px){
            .marketing-pro-box {
                width: 168px;
            }
        }
        @media screen and (max-width: 320px){
            .marketing-pro-box {
                width: 148px;
            }
        }

        /*mycode*/

        @media (max-width: 280px) {
            .cards-center-fold{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;

            }
        }

        /*@media screen and (min-width: 1875px){*/
        /*    .marketing-container-width{*/
        /*        width: 50vw;*/
        /*    }*/
        /*}*/
        /*@media screen and (min-width: 1440px) and (max-width: 1874px){*/
        /*    .marketing-container-width{*/
        /*        width: 65vw;*/
        /*    }*/
        /*    .marketing-pro-title{*/
        /*        height: 7.5vh;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1439px){*/
        /*    .marketing-container-width{*/
        /*        width: 72vw;*/
        /*    }*/
        /*    .marketing-pro-title{*/
        /*        height: 7vh;*/
        /*    }*/
        /*}*/
        /*@media screen and ( max-width: 1280px){*/
        /*    .marketing-pro-title{*/
        /*        padding: 10px 6px 20px 6px;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1024px){*/
        /*    .marketing-container-width{*/
        /*        width: auto;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1200px){*/
        /*    .marketing-pro-title{*/
        /*        padding: 10px 2px 20px 2px;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 425px){*/
        /*    .marketing-last-box{*/
        /*        margin-bottom: 20px;*/
        /*    }*/
        /*}*/
        /*.marketing-plan-wrapper {*/
        /*    margin: 50px 175px 50px 50px;*/
        /*}*/
        /*@media screen and (max-width: 1463px){*/
        /*    .marketing-plan-wrapper{*/
        /*        margin: 50px 140px 50px 140px;*/
        /*    }*/
        /*    .marketing-pro-title{*/
        /*        height: 8vh;*/
        /*        padding: 10px 5px 20px 5px;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1366px){*/
        /*    .marketing-plan-wrapper{*/
        /*        margin: 50px 170px 50px 115px;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1280px){*/
        /*    .marketing-plan-wrapper{*/
        /*        margin: 50px 170px 50px 60px;*/
        /*    }*/
        /*    .marketing-pro-title{*/
        /*        height: 7vh;*/
        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1200px){*/
        /*    #page-wrapper {*/
        /*        position: inherit;*/
        /*        margin: 60px 0 0px 190px !important;*/

        /*    }*/
        /*}*/
        /*@media screen and (max-width: 1024px){*/
        /*    .marketing-plan-wrapper{*/
        /*        margin: 50px 0px 50px 0px;*/
        /*    }*/
        /*}*/


    </style>
@endsection

@section('js')
    <script>
        $(".marketing-pro-box").click(function () {
            var baseUrl = $('#hfBaseUrl').val();
            var target = $(this).attr("data-target");
            location.href = baseUrl+'/marketing-pro/'+target;
        });
    </script>
@endsection
