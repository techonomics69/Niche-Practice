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
                        </div>
                    </div>
                </div>
                <div class="marketing-plan-wrapper">
                <div class="credits-wrapper ">

                    <div class="marketing-pro-box">
                        <div class="text-center bg-white marketing-pro-shadow" style="">
                            <img src="{{ uploadImagePath('public/'.$records['thumbnail']) }}"  alt="Avatar" class="image marketing-pro-img" style="width:60px; height:70px">
                            <h6 class="marketing-pro-title" style="" >{{ $records['title'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class=" marketing-details-text ">
                    <div class="description-area">
                    {!! $records['description'] !!}
                    </div>

                    @if($records['service_credits'])
                    <div class=" m-t-15 credit-box-btn" style="display: flex;flex-wrap: wrap; margin-bottom: 50px;">
                          @foreach($records['service_credits'] as $service)
                              @if( !empty($service['credits']) || !empty($service['title']) )
                                  <?php
                                $creditHistoryRec = \Modules\User\Models\CreditsHistory::where(['user_id' => $userData['id'], 'module_used_credits' => 'marketing_pro_service', 'module_id' => $service['id']])->first();
                                ?>
                                <div class="marketing-details-order-box ">
                                    <p class="words m-b-0">{{ !empty($service['title']) ? $service['title'] : 'Order service' }}</p>

                                    <hr style="width: 90%; margin-top: 0px; margin-bottom: 5px;">

                                    <div class="d-flex justify-content-between ">
                                        <p class="m-b-0" style="font-weight: bold">{{ !empty($service['credits']) ? $service['credits'] : 0 }} Credits</p>

                                        @if(!empty($creditHistoryRec))
                                            <button type="button" class="btn btn-sm connect-button  align-items-center btn-success"
                                                    style="margin-right: 8px; margin-bottom: 5px; ">Ordered
                                            </button>
                                       @else
                                            <button data-module-credits-used="marketing_pro_service" data-after-purchased="Ordered" data-target-id="{{ $service['id'] }}" type="button" class="btn btn-sm connect-button  align-items-center template-order"
                                                    style="margin-right: 8px; margin-bottom: 5px; font-size: 14px; ">Order Now
                                            </button>
                                       @endif
                                    </div>

                                </div>
                              @endif
                           @endforeach
                    @endif
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
        .description-area
        {
            width: 100%;
            display: inline-block;
        }
        .marketing-details-text{
            width: 670px;
        }
        .marketing-plan-wrapper{
            display: flex;
            justify-content: center;
        }
        .marketing-title{
            font-size: 29px;
            font-weight: 600 !important;
        }
        .connect-button{
            background-color: #ff8f73;
            border: none;
            color: #ffffff !important;
            padding: 8px;
            font-size: 12px;
            line-height: 14px;
            height: 25px;
            display: flex;
            text-align: center;
        }

        .connect-button:hover{
            color: white;
            opacity: 0.9;
        }
        .marketing-details-order-box .words{
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            /*width: 150px;*/
            width: 100%;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
        }
        .marketing-details-order-box p{
            padding-left: 10px;
            color: #3C3C3E;
            font-size: 13px;

            display: inline-block;
            width: 95px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .marketing-details-order-box{
            background: white;
            border-radius: 10px;
            margin-right: 10px;
            /*width: 170px;*/
            /*width: 200px;*/
            width: 100%;
            margin-bottom: 20px;

        }

        .marketing-pro-box{
            width: 200px;
            height: 130px;
            margin-right: 20px;
        }

        .marketing-details-p{
            font-weight: bold;
            font-weight: bold;
            max-width: 555px;
            color: #313236;
        }


        .marketing-pro-des{
            font-weight: 600;
            max-width: 550px;
            text-align: center;
            margin: auto;
            color: #3C3C3E;
        }
        .marketing-pro-title{
            font-weight: 700;
            margin: 0;
            padding: 10px 20px 20px 20px;
            line-height: 15px;
            height: 7vh;
            font-size: 14px;
        }
        .marketing-pro-img{
            padding: 20px 0px 0px 0px;
        }
        .marketing-pro-box{
            padding: 6px 15px 10px 15px;
        }
        .marketing-pro-shadow{
            /*box-shadow: rgba(80, 80, 80, 0.50) 0px 2px 6px 3px;*/
            border-radius: 3px;
            border: 1px solid #EAEAEA;
            -webkit-box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
            -moz-box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
            box-shadow: 0px 0px 5px 3px rgba(208,210,212,1);
        }
        @media screen and (max-width: 1200px){
            .marketing-details-text {
                width: 600px;
            }
        }
        @media screen and (max-width: 768px){
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
            .credits-wrapper{
                display: flex;
                justify-content: center;
            }
            .credit-box-btn{
                justify-content: center;
            }
            .marketing-pro-box{
                margin-right: 0px;
                margin-bottom: 0px;
            }
            .marketing-details-text{
                width: 100%;
            }
        }



    </style>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>

@endsection
