@extends('index')

@section('pageTitle', 'Monitor Reviews')

@section('content')
    <!--main content section-->
    <div id="page-wrapper">
        <div class="container-fluid dashboarbgtitle">
            <div class="dashboard-wrapper user-profile-wrapper">
                <div class="page-head">
    <section class="main-form">

            <div class="row">



                <div class="col-md-6 col-12">

                    <h1 class="team-heading">Team</h1>
                    <p class="add-a-team">Add a team member</p>

                    <!--            form-->
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input  class="form-control">
                            <!--                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">First Name</label>
                            <input  class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Last Name</label>
                            <input  class="form-control" >
                        </div>

                        <div class="form-group ">
                            <label for="inputState">User Type</label>
                            <select id="inputState" class="form-control mb-3">
                                <option selected>Select...</option>
                                <option>...</option>
                            </select>


                        </div>
                        <p class="form-text text-muted ">Standard team members cannot edit team or billing settings.</p>


                        <button type="submit" class="btn btn-primary font-weight-bold" style="background-color: #2F55A9;border: 1px solid #2F55A9; font-weight: bold;">Save</button>
                        <h3 class="exist-margin">Existing Team Members  </h3>
                        <p ><b>1drewpbdre@gmail.com</b> -tom tree <span class="admins-color btn-sm">ADMIN</span></p>
                    </form>






                </div>

            </div>

    </section>
                </div>
            </div>
        </div>
@endsection


@section('css')
    <style>

        .setting-color{
            color: #8E909F;
            font-weight: bold;
        }
        .team-heading{
            font-weight: 600;
        }
        .add-a-team{
            font-size: 30px;
        }
        .exist-margin{
            margin-top: 30px;
            font-weight: 600;
            font-size: 23px;
        }
        .admins-color {
            background-color: #2F55A9;
            color: white;
            border-radius: 3px;

            padding-right: 4px;
            padding-left: 4px;
            padding-bottom: 4px;
            padding-top: 0px;
        }
    </style>

@endsection

@section('js')

@endsection
