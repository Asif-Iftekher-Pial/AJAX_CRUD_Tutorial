@extends('welcome')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error_message"></div>
                    <ul id="errorList"></ul>
                    <div class="mb-3 row">
                        <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="enter name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputtext" class="col-sm-2 col-form-label">Age</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="age" placeholder="enter age">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputtext" class="col-sm-2 col-form-label">Number</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="number" placeholder="enter number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn saveButton btn-sm btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>Student Info</h4>
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addStudentModal">Add
                            student</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.saveButton').on('click', function(e) {
            e.preventDefault();
            //console.log('okey');
            var data = {
                'name': $('#name').val(),
                'age': $('#age').val(),
                'number': $('#number').val(),
            }
            // console.log(data);
            //have to insert this code
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //now save data via ajax
            $.ajax({
                type: "POST",
                url: "/saveData",
                data: data,
                dataType: "json", //sanding data type in json format
                success: function(response) {
                    // console.log(response);

                    //error handle and show the error 
                    if (response.status == 400) {
                        $('#error_message').html("")
                        $('#error_message').addClass('alert alert-danger') // error div will generate

                        $.each(response.error, function(key,
                            errorElement) { // showing earch error with for each loop
                            $('#error_message').append('<li>' + errorElement + '</li>')
                        });
                        swal("Oppss!!", "Something went wrong", "error");
                    } else {
                        $('#error_message').html("") // if previously error came that will be empty
                        $('#success_message').addClass('alert alert-success')
                        $('#success_message').text(response.message)
                        $('#addStudentModal').modal('hide'); // hide the modal after successfully save
                        $('#addStudentModal').find('input').val('') // make all the input field empty
                        swal("Good job!", "Data is saved", "success");
                        fetchData();
                    }

                }
            });
        })
    </script>
    <script>
        function fetchData() {
            $.ajax({
                type: "get",
                url: "/fetching-data",
                dataType: "json",
                success: function(response) {
                    //console.log(response.allStudents);
                    //first make the table empty 
                    $('tbody').html("");
                    //displaying data
                    $.each(response.allStudents, function(key, item) {
                        //setting data to the table body soo call the table body

                        $('tbody').append(
                            '<tr>\
                                <th scope="row">' + item.id + '</th>\
                                <td>' + item.name + '</td>\
                                <td>' + item.age + '</td>\
                                <td>' + item.number + '</td>\
                                <td><button type="button" value="' + item.id + '" class="btn btn-sm btn-success">edit</button>\
                                    <button type="button" value="' + item.id + '" class="btn btn-sm btn-danger">delete</button></td>\
                                </tr>'
                        )
                       

                    });
                }
            });
        }
        fetchData();
    </script>
@endsection
