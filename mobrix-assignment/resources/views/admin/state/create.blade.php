@extends('layouts.app')

@section('title', 'Country | Create')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Create State</h1>
        </div>
        
        <!-- Form Section -->
        <div class="mb-5">
            <form action="#" id="state_create">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"> State Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Country name">
                    <p></p>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select name="country" id="country" class="form-control" >
                        <option value="">Select</option>
                        @if (isset($countries))
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->country_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <p></p>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" >
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">In-Active</option>
                    </select>
                    <p></p>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
        
        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($states) && count($states) > 0)
                        @foreach ($states as $state)
                            <tr>
                                <td>{{ $state->id }}</td>
                                <td>{{ $state->state_name }}</td>
                                <td>{{ $state->country_name }}</td>
                                <td>
                                    @if ($state->status == 1)
                                        Active
                                    @else
                                        In-Active
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('state.edit', $state->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ route('state.delete', $state->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Record Not Found</td>
                        </tr>
                    @endif    
                    <!-- Table rows can be dynamically generated here -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $("#state_create").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('state.store')}}",
                type : 'post',
                data : formData,
                dataType : 'json',
                success : function (response){
                    if(response['status'] == false){
                        var errors = response['errors']
                        if(errors['name']){
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                        if(errors['country']){
                            $("#country").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['country']);
                        } else {
                            $("#country").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                        if(errors['status']){
                            $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);
                        } else {
                            $("#status").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                    } else {
                        window.location.href = "{{route('state.create')}}"
                    }
                },
                error : function (error){
                    console.log(error.message);
                }
            }); 
        })
    </script>
@endsection
