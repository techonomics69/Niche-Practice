@extends('admin.layout')

@section('title', 'Edit Task')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 task-page">
            <form class="validate-me" method="POST" action="{{ route('task.update', $task_id) }}" accept-charset="UTF-8">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <?php
                    $title = 'title';
                    $estimatedTime = 'estimated_time';
                    $credits = 'credits';
                    $creditsDescription = 'credits_description';
                    $description = 'description';
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Task</h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group">
                            <div class="col-md-12">
                                @if (session('message'))
                                    <div class="alert {{ (session('messageCode') != 200) ? 'alert-danger' : 'alert-success' }}">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has($title) ? ' has-error' : '' }}">
                            <label>Title</label>
                            <input type="text" id="{{$title}}" name="{{$title}}" value="{{ editFieldValue($records, $title) }}" class="form-control" data-required="true">
                            <span class="help-block {{ $errors->has($title) ? ' error' : '' }}">
                                <small>{{ $errors->first($title) }}</small>
                            </span>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has($description) ? ' has-error' : '' }}">
                            <label>Description</label>
                            <textarea id="{{$description}}" name="{{$description}}" class="form-control customize-editor">{{ $taskTitle = editFieldValue($records, $description) }}</textarea>
                            <span class="help-block {{ $errors->has($description) ? ' error' : '' }}">
                                <small>{{ $errors->first($description) }}</small>
                            </span>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('category') ? ' has-error' : '' }}">
                            <div class="col-md-3 {{ $errors->has($estimatedTime) ? ' has-error' : '' }}">
                                <label>Estimated Time / minutes</label>
                                <input type="text" id="estimated-time" name="estimated_time" value="{{ editFieldValue($records, $estimatedTime) }}" class="form-control" />
                                <span class="help-block {{ $errors->has($estimatedTime) ? ' error' : '' }}">
                                <small>{{ $errors->first($estimatedTime) }}</small>
                                </span>
                            </div>
                            <div class="col-md-4 nopadding">
                                <label>Link with Campaign Category</label>
                                <?php
                                $catTypeArray = [];
                                ?>
                                <select id="category" name="category" class="form-control group-search">
                                    <option></option>
                                    @if($categories)
                                        @foreach($categories as $indexR => $objectiveRow)
                                            <?php
                                            $catType = !empty($objectiveRow['type']) ? $objectiveRow['type'] : 'Default';
                                            ?>
                                            @if(in_array($catType, $catTypeArray) === false)
                                                <?php
                                                $catTypeArray[] = $catType;
                                                ?>
                                                <optgroup label="{{ ucfirst($catType) }}">
                                                    @endif
                                                    <option value="{{ $objectiveRow['id'] }}" {{ selectedChosenValue($objectiveRow['id'], $records['category'] ) }}>{{ $objectiveRow['id'] . ' - ' . $objectiveRow['name'] }}</option>
                                                    @if(in_array($catType, $catTypeArray) === false)
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Select Week</label>
                                <select class="form-control selectpicker" id="week" name="week">
                                    <option value=""></option>
                                    <?php
                                    $selectedWeek = '';
//                                    $recurringWeek = [
//                                        0 => 'Introduction',
//                                        1 => 'Week 1',
//                                        2 => 'Week 2',
//                                        3 => 'Week 3',
//                                        4 => 'Week 4',
//                                        5 => 'Optional',
//                                        6 => 'Campaign Completed',
//                                        7 => 'Resources',
//                                        8 => 'Tips / Guide',
//                                        9 => 'Marketing Tasks'
//                                    ];

                                    $recurringWeek = \Modules\Admin\Models\WeekCategory::orderBy('priority')->get()->toArray();

                                    foreach($recurringWeek as $index => $weekRow) {
                                        ?>
                                    <option value="{{ $weekRow['id'] }}" {{ selectedChosenValue($records['week'], $weekRow['id']) }}>{{ $weekRow['name'] }}</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Priority</label>
                                <select class="form-control selectpicker" id="impact" name="impact">
                                    <option value=""></option>
                                    @for($i=1; $i<=100;$i++)
                                        <option value="{{ $i }}" {{ selectedChosenValue($records['impact'], $i) }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Recurring</label>
                                <select class="form-control selectpicker" id="recurring" name="recurring_days">
                                    <option value=""></option>
                                    <?php
                                    $selected = '';
                                    $recurringData = [
                                        '3' => '3 days',
                                        '7' => '7 days',
                                        '14' => '14 days',
                                        '30' => '30 days',
                                        '90' => '90 days'
                                    ];
                                    foreach($recurringData as $index => $recurringRow) {
                                    ?>
                                    <option value="{{ $index }}" {{ selectedChosenValue($records['recurring_days'], $index) }}>{{ $recurringRow }}</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Credits</label>
                                <input type="number" id="Credits" name="Credits" value="{{ editFieldValue($records, $credits) }}" class="form-control" />
                                <span class="help-block {{ $errors->has($credits) ? ' error' : '' }}">
                                <small>{{ $errors->first($credits) }}</small>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has($creditsDescription) ? ' has-error' : '' }}">
                            <label>Credits Description</label>
                            <textarea id="{{$creditsDescription}}" name="{{$creditsDescription}}" class="form-control customize-editor">{{ $taskTitle = editFieldValue($records, $creditsDescription) }}</textarea>
                            <span class="help-block {{ $errors->has($creditsDescription) ? ' error' : '' }}">
                                <small>{{ $errors->first($creditsDescription) }}</small>
                            </span>
                        </div>

{{--                        <div class="form-group col-md-12">--}}
{{--                            <div class="col-md-4 nopadding">--}}
{{--                                <label>Month</label>--}}
{{--                                <select class="form-control selectpicker" id="month" name="month">--}}
{{--                                    <option value=""></option>--}}
{{--                                    @for($i=1; $i<=5;$i++)--}}
{{--                                        <option value="month-{{ $i }}" {{ selectedChosenValue($records['month'], 'month-'.$i) }}>Month-{{ $i }}</option>--}}
{{--                                    @endfor--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-12">--}}
{{--                            <div class="col-md-4 nopadding">--}}
{{--                                <label>Priority</label>--}}
{{--                                <select class="form-control selectpicker" id="impact" name="impact">--}}
{{--                                    <option value=""></option>--}}
{{--                                    @for($i=1; $i<=100;$i++)--}}
{{--                                        <option value="{{ $i }}" {{ selectedChosenValue($records['impact'], $i) }}>{{ $i }}</option>--}}
{{--                                    @endfor--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Status</label>
                                <select class="form-control" id="sys_status" name="sys_status">
                                    <option value="1" {{ selectedChosenValue($records['sys_status'], 1) }}>Active</option>
                                    <option value="0" {{ selectedChosenValue($records['sys_status'], 0) }}>Inactive</option>>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div id="saveActions" class="form-group">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-save" aria-hidden="true"></span> &nbsp;<span>Save</span>
                                </button>
                            </div>

                            <a href="{{ route('task.list') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbspCancel</a>
                        </div>
                        <span class="help-block hide-me"><strong>Required fields must be filled.</strong></span>
                    </div><!-- /.box-footer-->
                </div><!-- /.box -->
            </form>
        </div>
    </div>
@endsection

@section('after_styles')
{{--    <link rel="stylesheet" href="{{ asset('public/css/mad-validation.css') }}" />--}}
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote.css') }}" />

    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-select/bootstrap-select.css') }}" />
@endsection

@section('after_scripts')
    <script src="{{ asset('public/plugins/bower_components/jquery-duplicate/jquery.duplicate.js') }}"></script>

    <script src="{{ asset('public/admin/task/custom-validation.js') }}"></script>
    <script src="{{ asset('public/plugins/summernote/summernote.js') }}"></script>
    <script src="{{ asset('public/admin/task/variable-feature.js?ver='.$appFileVersion) }}"></script>

    <script src="{{ asset('public/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('public/admin/base.js') }}"></script>
@endsection
