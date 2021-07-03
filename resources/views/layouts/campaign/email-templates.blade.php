@extends('index')

@section('pageTitle', 'Campaign List')

@section('content')
    <div id="page-wrapper" style="min-height: 281px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper email-template-choosen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Email Campaigns <a class="page-help" href="javascript:void(0)"><i
                                        class="fa fa-question-circle-o"
                                        style="color: #7d8080;/* transform: scaleX(-1); */margin-right: 5px;"></i></a>
                            </h4>
                        </div>
                        {{--<div class="col-md-6">--}}
                        {{--<div class="page-instructions">--}}
                        {{--<label>Page Instructions</label><a href="javascript:void(0);"><i class="fa fa-question-circle-o"></i></a>--}}
                        {{--</div>--}}

                        {{--</div>--}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-table">
                            <div class="email-templates-filters">
                                <div class="row">
                                    <div class="col-md-12" style="display: none;">
                                        @if(!empty($type))
                                            @foreach($type as $row)
                                                <a href="javascript:void(0)" class="btn template-link "
                                                   data-toggle="tab" data-id="{{ $row['id'] }}">{{ $row['name'] }}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-md-2" style="display: none"></div>
                                    <div class="col-md-10" style="display: none">
                                        <div class="right-filters">
                                            <div class="form-group type-filter">
                                                <label>Type</label>
                                                <select class="btn btn-default type-filter-dropdown">
                                                    <option value="">ALL</option>
                                                    @if(!empty($type))
                                                        @foreach($type as $row)
                                                            <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                {{--                                                <div class="dropdown">--}}
                                                {{--                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                                                {{--                                                        All--}}
                                                {{--                                                        <span class="caret"></span>--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                    <ul class="dropdown-menu">--}}
                                                {{--                                                        <li><a href="javascript:void(0)">Action</a></li>--}}
                                                {{--                                                    </ul>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                            <div class="form-group category-filter">
                                                <div class="dropdown">
                                                    <label>Category</label>
                                                    <select class="btn btn-default category-filter-dropdown">
                                                        <option value="">ALL</option>

                                                        @if(!empty($category))
                                                            @foreach($category as $row)
                                                                <option
                                                                    value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    {{--                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">--}}
                                                    {{--                                                        All--}}
                                                    {{--                                                        <span class="caret"></span>--}}
                                                    {{--                                                    </button>--}}
                                                    {{--                                                    <ul class="dropdown-menu">--}}
                                                    {{--                                                        <li><a href="#">Action</a></li>--}}
                                                    {{--                                                        <li><a href="#">Another action</a></li>--}}
                                                    {{--                                                        <li><a href="#">Something else here</a></li>--}}
                                                    {{--                                                    </ul>--}}
                                                </div>
                                            </div>

                                            <div class="search-template">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                                <input type="text" class="form-control" placeholder="Search templates">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="email-templates-container">
                                <div class="templates-box-container">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="template-box-new">
                                                <div class="tempate-new-content">
                                                    <a href="{{ route('email-builder') }}"><i class="fa fa-plus"></i>
                                                        <h3>Create a Template</h3>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($templates))
                                            @foreach($templates as $template)
                                                <?php
                                                $uid = base64_encode('syx') . base64_encode($template['id']);
                                                ?>
                                                <?php
                                                $templateTypeLink = (!empty($template['template_type_link'])) ? $template['template_type_link'] : '';
                                                ?>
                                                <div
                                                    class="col-sm-3 template-box-container <?php if (!empty($template['template_type_link'])) {
                                                        echo 'list-' . $template['template_type_link']['id'];
                                                    } ?> <?php if (!empty($template['category'])) {
                                                        echo 'category-' . $template['category'];
                                                    } ?>">
                                                    <?php
                                                    $listClass = !empty($template['template_type_link']) ? 'list-' . $template['template_type_link']['id'] : '';
                                                    $categoryClass = !empty($template['category']) ? 'list-' . $template['category'] : '';
                                                    ?>
                                                    <div class="template-box">
                                                        <div class="t-image-container">
                                                            @if(!empty($template['thumbnail']))
                                                                <img src="{{ uploadImagePath($template['thumbnail']) }}"
                                                                     alt="Avatar" class="image">
                                                            @else
                                                                <img src="{{ asset('public/images/screen-85.jpg') }}"
                                                                     alt="Avatar" class="image">
                                                            @endif

                                                            <div class="t-image-overlay">
                                                                <div class="text emailText">
                                                                    <?php
                                                                    $showOrderBtn = false;
                                                                    $text = '';
                                                                    ?>
                                                                    @if( !empty($templateTypeLink) &&
                                                                        (strtolower($templateTypeLink['name']) == 'premium' || strtolower($templateTypeLink['name']) == 'premium templates')
                                                                        )
                                                                        <?php
                                                                        $creditHistoryRec = \Modules\User\Models\CreditsHistory::where(['user_id' => $userData['id'], 'module_used_credits' => 'email_templates_pre_order', 'module_id' => $template['id']])->first();
                                                                        if (empty($creditHistoryRec)) {
                                                                            $showOrderBtn = true;
                                                                        } else {
                                                                            $text = 'Purchased';
                                                                        }
                                                                        ?>
                                                                    @endif

                                                                    @if($showOrderBtn == true)
                                                                        <a data-module-credits-used="email_templates_pre_order"
                                                                           data-target-id="{{ $template['id'] }}"
                                                                           href="javascript:void(0)"
                                                                           class="btn btn-template-edit template-order">
                                                                            Order
                                                                        </a>
                                                                    @else
                                                                        {{--                                                                    <a href="{{ route('email-builder',['templateId' => $template['id']] ) }}" class="btn btn-template-edit">--}}
                                                                        {{--                                                                        Edit--}}
                                                                        {{--                                                                    </a>--}}
                                                                        <a href="{{ route('email-builder',$uid ) }}"
                                                                           class="btn btn-template-edit">
                                                                            Edit
                                                                        </a>
                                                                    @endif

                                                                    <a style="display: table; margin: 0px auto;"
                                                                       href="javascript:void(0)"
                                                                       data-campaign-id="{{ $template['id'] }}"
                                                                       class="btn btn-template-preview preview-template">
                                                                        Preview
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="template-name">{{ $template['title'] }}
                                                        @if($showOrderBtn == true)
                                                            - {{ $template['credits'] }} Credits
                                                        @elseif(!empty($text))
                                                            {{ $text }}
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="template-modal" class="modal fade in modal-manager show-app-interface" tabindex="-1" role="dialog"
         data-backdrop="static" data-keyboard="false" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body modal-preview">
                    <div id="app" class="create steps-section"
                         style=" width: 100%; height: 100vh; display: block;"></div>
                </div>
                <form class="wizard-container" method="POST" action="#" id="js-wizard-form">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .btn.active, .btn:active {
            font-weight: 800;
            font-size: 15px;
            background-image: none;
            outline: 0 !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
            color: #333 !important;
            /*color:#ffffff!important;*/
            font-weight: 500;
            font-size: 15px;
        }

        /*.btn:hover{*/
        /*    color: #165683!important;*/
        /*}*/
    </style>
@endsection

@section('js')
    <script>
        window.CurrentSourceTarget = 'email-templates';
    </script>
    <script src="https://d5aoblv5p04cg.cloudfront.net/mjml4-editor/loader/build.js" type="text/javascript"></script>
    <script src="{{ asset('public/js/topol-manager.js?ver='.$appFileVersion) }}"></script>
    <script>
        $(function () {
            $(document).ready(function () {
                $('.template-link:first-child').click();
                console.log('testing123')
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.template-link').click(function () {
                var id = $(this).attr('data-id');
                $(".template-link").removeClass('template-link-active');
                $(this).addClass('template-link-active');
                $(".template-box-container").hide();
                $(".list-" + id).show();
            });
        });
        // $(document).on('change',".category-filter-dropdown, .type-filter-dropdown",function (e){
        //     var typeFilter = $(".type-filter-dropdown").val();
        //     var categoryFilter = $(".category-filter-dropdown").val();
        //     console.log("type " + typeFilter);
        //     console.log("categoryFilter " + categoryFilter);
        //
        //     if(typeFilter !== ''  && categoryFilter !== '')
        //     {
        //         console.log("both not empty Test");
        //     }
        // });

        $(document).on('change', ".category-filter-dropdown, .type-filter-dropdown", function (e) {
            filterTemplate();
        });

        $(document.body).on('click', '.order-credit-cancel', function () {
            var mainModel = $('.modal-alert-credit');
            $(".fa-exclamation-triangle", mainModel).remove();
            mainModel.modal('hide');
        });

        function filterTemplate() {
            var typeFilter = $(".type-filter-dropdown").val();
            // var categoryFilter = $(".category").val();
            var categoryFilter = $(".category-filter-dropdown").val();

            // console.log("hi");
            // console.log("type " + typeFilter);
            // console.log("categoryFilter " + categoryFilter);

            $(".template-box-container").hide();

            if (typeFilter !== '' && categoryFilter !== '') {
                // console.log("both not empty");
                $(".list-" + typeFilter + ".category-" + categoryFilter).show();
            } else if (typeFilter !== '') {
                // console.log("typeFilter not empty");
                $(".list-" + typeFilter).show();
            } else if (categoryFilter !== '') {
                // console.log("categoryFilter not empty");
                $(".category-" + categoryFilter).show();
            } else {
                // console.log("else");
                $(".template-box-container").show();
            }
        }
    </script>
@endsection
