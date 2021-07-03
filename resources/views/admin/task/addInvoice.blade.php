@extends('admin.layout')

@section('title', 'Client info')

@section('content')
    <form>
        <input type="hidden" name="token" value="" >
        <div class="row client-dropdown-container">
            <div class="col-sm-9 col-md-5">
                <select id="selectUserid" class="form-control selectize selectize-client-search selectized"
                        data-value-field="id" data-active-label="Active" data-inactive-label="Inactive" placeholder="Start Typing to Search Clients" tabindex="-1" >
                    <option value="1" selected="selected"> Alex Dave-#1</option>
                </select>

            </div>
        </div>
    </form>
    </br> </br>
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs client-tabs" role="tablist">
                <li class="tab">
                    <a href="{{ route('admin.clientInfo') }}" >Summary</a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.addInvoice') }}">Invoices</a>
                </li>
                <li class="tab">
                    <a href="{{ route('admin.NotesInfo') }}">Notes(0)</a>
                </li>
            </ul>
            <div class = "tab-content client-tabs">
                <div class="tab-pane active" role="tabpanel">
                    <div id="clientsummarycontainer">
                        <div class="row client-summary-panels">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div id="crudTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="overflow-x">
                                                      <table id="notesTable" class="table table-bordered table-striped display dataTable " role="grid">
                                                        <thead>
                                                        <tr role="row">
                                                            <th>ID</th>
                                                            <th>Description</th>
                                                            <th>Hours </th>
                                                            <th>Amount ($)</th>
                                                            <th>Invoice Action</th>
                                                            <th width="20"></th>
                                                            <th width="20"> </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class=" ">
                                                            <td> </td>
                                                            <td> </td>
                                                            <td> </td>
                                                            <td>  </td>
                                                            <td> </td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>


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

                    </div>
                </div>
        </div>
    </div>
@endsection
        @yield('css_before')

        <link rel="stylesheet" href="{{asset('public/css/addInvoice.css')}}">
        <link rel="stylesheet" href="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
        <link rel="stylesheet" href="{{asset('public/css/sidebar.css')}}">
        @yield('css_after')

        @section('after_scripts')


            <script src="{{ asset('public/admin/adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>

            <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}"></script>

            <script src="{{ asset('public/admin/adminlte/plugins/datatables/dataTables.initiate.js') }}"></script>
            <script>

                $(document).ready(function() {
                    $('#notesTable').DataTable( {
//             responsive: true,
                        "ordering": false,
                        "searching" : false,
                        "pagingType" : "simple",
                        "dom": 'lrtip',
                        "oLanguage": {
                            "oPaginate": {
                                "sNext": "Next page",
                                "sPrevious" : "Previous page"
                            }
                        }
                    } );
                } );
            </script>

@endsection
