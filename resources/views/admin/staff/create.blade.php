@extends('layouts.master')

@section('content')


    <div class="row" >
        <div class="col-md-6-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Create Staff member</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ url('/dashboard/staffs') }}" method="POST">
                        {{csrf_field()}}

                        <div class="form-group">
                            <div class="input-group">
                                <label for="number">First name</label>
                                <input type="text" name="first_name" placeholder="first name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <label for="number">Last name</label>
                                <input type="text" name="last_name" placeholder="last name" class="form-control" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="submit" value="Create" class="btn btn-success pull-right">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
