@extends('admin.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title m-t-10">
                        Email Templates
                    </h3>
                    <div id="datatable_button_stack" class="pull-right text-right">
                        <button class="btn btn-primary ladda-button import-template" data-source="email_campaign">
                            <span class="ladda-label"><i class="fa fa-upload"></i> Import Template</span>
                        </button>
                        <a href="{{ route('admin.email-builder') }}" class="btn btn-primary ladda-button" data-style="zoom-in">
                            <span class="ladda-label"><i class="fa fa-plus"></i> Create Campaign</span>
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="overflow-x">
                                  <table id="taskTable" class="table table-bordered table-striped display dataTable" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th>Industry</th>
                                        <th>Niche</th>
                                        <th>Plan</th>
                                        <th>User Linked</th>
                                        <th>category</th>
                                        <th>Type</th>
                                        <th>Subject Line</th>
                                        <th>Status</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($records))
                                        @foreach($records as $record)
                                            <tr class="">
                                                <td>
                                                    @if(!empty($record['industry']))
                                                        {{ $record['industry']['name'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($record['niche']))
                                                        {{ $record['niche']['niche'] }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if(!empty($record['template_plans']))
                                                        <?php
                                                        $templatePlans = $record['template_plans'];
                                                        ?>
                                                        @foreach($templatePlans as $index => $plan)
                                                            <?php
                                                            $count = count($templatePlans);
                                                            ?>
                                                            {{--                                                             {{ $count }}--}}
                                                            {{--                                                             {{ $plan['plan'] }}--}}
                                                            {{ $plan['plan']  }}{{ ($count == $index+1) ? '' : ',' }}
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td>
                                                    @if( !empty($record['template_linked_user']['email']) )
                                                        {{  $record['template_linked_user']['email'] }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if(!empty($record['category']))
                                                        {{ $record['category']['name'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($record['template_type_link']))
                                                        {{ $record['template_type_link']['name'] }}
                                                    @endif
                                                </td>

                                                <td>{{ $record['subject'] }}</td>
                                                <td class="text-center status">
                                                    @if($record['status'] == 'drafts')
                                                        <span class="inactive change-status" data-target-id="{{ $record['id'] }}" data-status="active">Drafts</span>
                                                    @else
                                                        <span class="active change-status" data-target-id="{{ $record['id'] }}" data-status="drafts">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link copy-me" style="padding: 0 !important;" data-target-id="{{ $record['id'] }}"><i class="fa fa-clone" aria-hidden="true"></i> Copy</a>
                                                    <a href="{{ route('admin.email-builder', $record['id']) }}" class="btn btn-sm btn-link" style="padding: 0 !important;"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-link remove-me" style="padding: 0 !important;" data-target-id="{{ $record['id'] }}"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        @media only screen and (max-width:1200px){
            .overflow-x{
                overflow-x:scroll;
            }
            .overflow-x::-webkit-scrollbar{
                width:5px;
                height:6px;
            }
            .overflow-x::-webkit-scrollbar-thumb{
                background-color: #888;
            }
            .overflow-x::-webkit-scrollbar-track{
                background-color: #f1f1f1;
            }
        }
    </style>
@endsection

@section('after_scripts')


    <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

    <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>
    <script src="{{ asset('public/js/admin/admin-template-list.js') }}"></script>


@endsection
