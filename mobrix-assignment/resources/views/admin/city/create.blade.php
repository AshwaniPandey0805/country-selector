@extends('layouts.app')

@section('title', 'Country | Create')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Create City</h1>
        </div>
        
        <!-- Form Section -->
        <div class="mb-5">
            <form action="#" id="city_create">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"> City Name</label>
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
                <div class="mb-3" >
                    <label for="state" class="form-label">State</label>
                    <select name="state" id="state" class="form-control" >
                        <option value="">Select</option>
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
                        <th>state</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($cities) && count($cities) > 0)
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->city_name }}</td>
                                <td>{{ $city->state_name }}</td>
                                <td>{{ $city->country_name }}</td>
                                <td>
                                    @if ($city->status == 1)
                                        Active
                                    @else
                                        In-Active
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('city.edit', $city->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ route('city.delete', $city->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Record Not Found</td>
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
        $("#city_create").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('city.store')}}",
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
                        if(errors['state']){
                            $("#state").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['state']);
                        } else {
                            $("#state").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                        if(errors['status']){
                            $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['status']);
                        } else {
                            $("#status").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html();
                        }
                    } else {
                        window.location.href = "{{route('city.create')}}"
                    }
                },
                error : function (error){
                    console.log(error.message);
                }
            }); 
        })

        $("#country").click(function(){
            var id  = $(this).val();
            $.ajax({
                url : "{{route('city.getStates')}}",
                type : 'post',
                data : {
                        id : id,
                        _token: "{{ csrf_token() }}"  // Add the CSRF token here
                    },
                dataType : 'json',
                success : function (response){
                    console.log(response.data);
                    var data = response.data;
                    $("#state").html('')  
                    var html = '';  // Initialize an empty string

                    data.forEach(element => {
                        html += `<option value="${element.id}">${element.state_name}</option>`;  // Append to html
                    });

                    $("#state").append(html) // Output the final html string
                },
                error : function (error){
                    console.log(error);
                }
            })
        })
    </script>
@endsection
