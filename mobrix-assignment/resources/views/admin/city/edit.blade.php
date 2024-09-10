@extends('layouts.app')

@section('title', 'Country | Create')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center p-3" >
            <div class="mb-4">
                <h1>Update Country</h1>
            </div>
            <div>
                <a href="{{route('state.create')}}"><Button class="btn btn-primary" >Back</Button></a>
            </div>
        </div>
        
        <!-- Form Section -->
        <div class="mb-5">
            <form action="#" id="city_update">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" value="{{$city->city_name}}"  id="name" class="form-control" placeholder="Enter Country name">
                    <p></p>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select name="country" id="country" class="form-control" >
                        <option value="">Select</option>
                        @if (isset($countries))
                            @foreach ($countries as $country)
                                <option {{ ($city->country_id == $country->id) ? 'selected' : '' }}  value="{{$country->id}}">{{$country->country_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <p></p>
                </div>
                <div class="mb-3" >
                    <label for="state" class="form-label">State</label>
                    <select name="state" id="state" class="form-control" >
                        <option value="{{$state->id}}">{{$state->state_name}}</option>
                    </select>
                    <p></p>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" >
                        <option value="">Select</option>
                        <option {{ ($city->status == 1) ? 'selected' : '' }}  value="1">Active</option>
                        <option {{ ($city->status == 0) ? 'selected' : '' }}  value="0">In-Active</option>
                    </select>
                    <p></p>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        
        <!-- Table Section -->
        {{-- <div class="table-responsive">
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
                    @if (isset($countries))
                        @foreach ($countries as $contry)
                            <tr>
                                <td>{{$county->id}}</td>
                                <td>{{$county->name}}</td>
                                @if ($country->status == 1)
                                    <td>Active</td>
                                @else
                                    <td>In-Active</td>
                                @endif
                                <td>
                                    <a href=""><button class="btn btn-success" >Edit</button></a>
                                    <a href=""><button class="btn btn-danger" >Delete</button></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" >Record Not found</td>
                        </tr>
                    @endif    
                    <!-- Table rows can be dynamically generated here -->
                </tbody>
            </table>
        </div> --}}
    </div>
@endsection
@section('custom-js')
    <script>
        $("#city_update").submit(function(event){
            event.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                url : "{{route('city.update',$city->id)}}",
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
