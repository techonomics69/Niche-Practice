@extends('admin.layout')

@section('title', 'Edit Task')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1 task-page">
            <form class="validate-me" method="POST" action="{{ route('pro.update', $task_id) }}" accept-charset="UTF-8">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <?php
                    $title = 'title';
                    $description = 'description';
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Service</h3>
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
                        <div class="form-group col-md-12">
                            <div class="col-md-4 nopadding">
                                <label>Priority</label>
                                <select class="form-control selectpicker" id="priority" name="priority">
                                    <option value=""></option>
                                    @for($i=1; $i<=100;$i++)
                                        <option value="{{ $i }}" {{ selectedChosenValue($records['priority'], $i) }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

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

                            <a href="{{ route('pro.list') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbspCancel</a>
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
