@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">

                <div class="card-header">
                    Change Password
                </div>

                <div class="card-body">
                    @if(!empty($error))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                   
                    <form method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="current-password" class="col-md-4 col-form-label text-md-right">Current Password</label>
    
                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control " name="current_password" required autofocus>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="new-password" class="col-md-4 col-form-label text-md-right">New Password</label>
    
                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control " name="new_password" required>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="confirm-password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
    
                            <div class="col-md-6">
                                <input id="confirm-password" type="password" class="form-control " name="confirm_password" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"> Submit</button>
                            </div>
                        </div>

                    </form>
                    
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
