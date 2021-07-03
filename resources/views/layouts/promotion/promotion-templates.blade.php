@extends('index')

@section('pageTitle', 'Promotion Templates')

@section('content')
    <div id="page-wrapper" style="min-height: 281px;">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper promotion-template-chosen">
                <div class="page-head">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title"> Promotion Templates </h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-table" style="min-height: 250px;">
                            <div class="email-templates-filters">
                                <div class="row">
                                    <div class="col-md-12" style="display: none;">
                                        {{-- @if(!empty($type)) --}}
                                            {{-- @foreach($type as $row) --}}
                                            <a href="javascript:void(0)" class="btn template-link" data-id="1">Free Templates</a>
                                            <a href="javascript:void(0)" class="btn template-link" data-id="2">Premium Templates</a>
                                            {{-- @endforeach --}}
                                        {{-- @endif --}}
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10" style="display: none">
                                        <div class="right-filters">
                                            <div class="form-group list-filter">
                                                <label>List</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        All
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                            <div class="form-group type-filter">
                                                <label>Type</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        All
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                            <div class="form-group category-filter">
                                                <div class="dropdown">
                                                    <label>Category</label>
                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        All
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="search-template">
                                                <a href="javascript:void(0);"><i class="fa fa-search"></i></a>
                                                <input type="text" class="form-control" placeholder="Search templates">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="email-templates-container">
                                <div class="templates-box-container">
                                    <div class="row promotion-row">

{{--                                        <div class="col-sm-2">--}}
{{--                                            <div class="template-box-new">--}}
{{--                                                <div class="tempate-new-content">--}}
{{--                                                    <a href="{{ route('image-builder') }}"><i class="fa fa-plus"></i>--}}
{{--                                                        <h3>Create a Template</h3>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                    @if(!empty($templates))
                                        @foreach($templates as $index => $template)

                                            <div class="col-sm-3 template-box-container-col-sm-3 {{ 'list-'.$template['template_type'] }}">
                                                <div class="template-box">
                                                    <div class="t-image-container">
                                                        @if(!empty($template['thumbnail']))
                                                            <img src="{{ uploadImagePath($template['thumbnail']) }}" alt="Avatar" class="image">
                                                        @else
                                                            <img src="{{ asset('public/images/promotion-thumb.png') }}" alt="Avatar" class="image">
                                                        @endif
                                                        <div class="t-image-overlay">
                                                            <div class="text promotionText">
                                                                <?php
                                                                $showOrderBtn = false;
                                                                $text = '';
                                                                ?>
                                                                {{-- 2 means premium 1 means free --}}
                                                                @if($template['template_type'] == 2)
                                                                    @php
                                                                        $creditHistoryRec = \Modules\User\Models\CreditsHistory::where(['user_id' => $userData['id'], 'module_used_credits' => 'promotion_templates_pre_order', 'module_id' => $template['id']])->first();
                                                                    if(empty($creditHistoryRec))
                                                                    {
                                                                        $showOrderBtn = true;
                                                                    }
                                                                    else
                                                                        {
                                                                            $text = 'Purchased';
                                                                        }
                                                                    @endphp

                                                                @endif
                                                                @if($showOrderBtn == true)
                                                                    <a data-module-credits-used="promotion_templates_pre_order" data-target-id="{{ $template['id'] }}" href="javascript:void(0)" class="btn btn-template-edit template-order">
                                                                        Order
                                                                    </a>
                                                                    @else
                                                                    <?php
                                                                        $uid =  base64_encode('syx') .  base64_encode($template['id']);
                                                                    ?>
                                                                    <a href="{{ route('image-builder', $uid) }}" class="btn btn-template-edit promotion-button">
                                                                        Edit
                                                                    </a>
                                                                    @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="template-name">
                                                   @if(!empty($template['title']))
                                                      {{ $template['title'] }}
                                                   @else
                                                       Template {{ $index+1 }}
                                                   @endif
                                                   @if(!empty($template['credits']))
                                                       {{ ' $'.$template['credits'] }}
                                                   @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                            <p>No Promotions found. Promotions will show here once listed.</p>
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
@endsection

@section('css')

@endsection

@section('js')
<script>
        // toggle free and premium template
        $(document).ready(function () {
            $('.template-link').click(function () {
                var id = $(this).attr('data-id');
                $(".template-link").removeClass('template-link-active');

                $(this).addClass('template-link-active');
                $(".template-box-container-col-sm-3").hide();
                $(".list-"+id).show();
             });
        });

        // not enough credit cancel
        $(document.body).on('click', '.order-credit-cancel', function () {
            var mainModel = $('.modal-alert-credit');
            $(".fa-exclamation-triangle", mainModel).remove();
            mainModel.modal('hide');
        });

        $(window).on('load', function () {
            $('.template-link[data-id=1]').click();
        });

</script>
@endsection
