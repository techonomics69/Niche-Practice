@extends('index')

@section('pageTitle', 'Monitor Reviews')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper user-profile-wrapper">
                <div class="page-head">
    <!--main content section-->
    <section class="main-form">

            <div class="row">
                <div class="col-md-11 col-12 ">

                    <div class="disp-end">
                        <div>
                   <h1 class="csv-imp">CSV Import History</h1>
                        </div>
                        <div>
                        <button class="btn btn-primary new-csv-imp" style="background-color:#3D4A9E; ">New CSV Import</button>
                        </div>
                    </div>
                    <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>CREATED</th>
                        <th>AUTO-TAG</th>
                        <th>TAGS</th>
                        <th>IMPORTED</th>
                        <th>STATUS</th>
                        <th>ERRORS</th>
                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
                    </div>
                </div>
            </div>

    </section>
                </div>
            </div>
        </div>
@endsection


@section('css')
    <style>
        @media (max-width: 500px) {
            .csv-imp{
                font-size: 30px;
            }
            .disp-end {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin-bottom: 10px;

            }
        }
        .setting-color{
            color: #8E909F;
            font-weight: bold;
        }
        .disp-end{
            display: flex;
            justify-content: space-between;
            margin-right: 20px;
        }
        th{
            font-weight: bold;
        }
        .csv-imp{
            font-weight: 600;
        }
        .new-csv-imp{
            font-weight: bold;
        }

    </style>

@endsection

@section('js')

@endsection
