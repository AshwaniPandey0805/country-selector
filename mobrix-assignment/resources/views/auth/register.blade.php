@extends('layouts.app')
@section('title', 'Register Page')
@section('content')
    <div class="container" >
        <div>
            <h1>Register Page</h1>
        </div>
        <form action="#" id="registerForm">
            @csrf
            <div class="row" >
                <div class="col-md-12">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <p></p>
                </div>
                <div class="col-md-12">
                    <label for="email">Email</label>
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
        $("#registerForm").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('register.process')}}",
                type : 'post',
                data : formData,
                datatype : 'json',
                success : function (response){
                    if(response['status'] == false){
                        var errors = response['errors'];
                        if(errors['name']){
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                        
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
                        window.location.href = "{{route('login.page')}}"
                    }

                },
                error : function (error){
                    console.log(error.message);
                }
            })
        })
    </script>
@endsection
