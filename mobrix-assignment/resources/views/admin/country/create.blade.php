@extends('layouts.app')

@section('title', 'Country | Create')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Create Country</h1>
        </div>
        
        <!-- Form Section -->
        <div class="mb-5">
            <form action="#" id="country_create">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Country name">
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($countries) && count($countries) > 0)
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>{{ $country->country_name }}</td>
                                <td>
                                    @if ($country->status == 1)
                                        Active
                                    @else
                                        In-Active
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('country.edit', $country->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ route('country.delete', $country->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
        $("#country_create").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('country.store')}}",
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
                        if(errors['status']){
                            $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);
                        } else {
                            $("#status").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                    } else {
                        window.location.href = "{{route('country.create')}}"
                    }
                },
                error : function (error){
                    console.log(error.message);
                }
            }); 
        })
    </script>
@endsection
