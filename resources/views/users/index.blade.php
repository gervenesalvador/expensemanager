@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <user-component></user-component>
        </div>
        
        {{-- <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    Update Users
                </div>

                <div class="card-body">

                    <form action="/users" method="POST" id="userEditForm">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="NameHelp" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role_id">
                                <option value="" disabled selected>Select role...</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

            </div>
        </div> --}}
    </div>
</div>

@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            const editform = $("#userEditForm");

            $('.edit-user').on('click', function(e) {
                e.preventDefault();
                var _this = $(this),
                user_id = _this.data('id');
                editform.attr("action", '/users/' + user_id);

                $("#user_id").val(user_id);
                $("#name").val(_this.data('name'));
                $("#email").val(_this.data('email'));
                $("#role").val(_this.data('role_id'));
            });
        });
    </script>
@endpush --}}