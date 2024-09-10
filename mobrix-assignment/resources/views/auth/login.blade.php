@extends('layouts.app')
@section('title', 'Login Page')
@section('content')
    <div class="container" >
        <div>
            <h1>Login Page</h1>
        </div>
        <form action="#" id="loginForm">
            @csrf
            <div class="row" >
                <div class="col-md-12">
                    <label for="email">Name</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <p></p>
                </div>
                <div class="col-md-12">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <p></p>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" >Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('custom-js')
    <script>
        $("#loginForm").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('login.process')}}",
                type : 'post',
                data : formData,
                datatype : 'json',
                success : function (response){
                    if(response['status'] == false){
                        var errors = response['errors'];
                        if(errors['email']){
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }

                        if(errors['password']){
                            $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
                        } else {
                            $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }

                    } else {
                        window.location.href = "{{route('admin.dashboard')}}"
                    }

                },
                error : function (error){
                    console.log(error.message);
                }
            })
        })
    </script>
@endsection
