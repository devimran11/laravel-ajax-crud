<!DOCTYPE html>
<html lang="en">
<head>
  <title>LARAVEL AJAX CRUD</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

</head>
<body> 
 
<div class="container" style="margin-top: 20px">
    <div class="row">
        <div class="col-md-8">
            <h3>All Data</h3>
            <div class="card">
                <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Institute</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($allData as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->institute}}</td>
                            <td>
                                <a href="">
                                    <button type="button" class="btn btn-primary">Edit</button>
                                </a>
                                <a href="">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                          </tr>
                        @endforeach --}}
                    </tbody>
                  </table>
            </div>
        </div>
        <div class="col-md-4">
            <h3 id="addHeader">Add Data</h3>
            <h3 id="updateHeader" style="padding: right">Update Data</h3> 
            <div class="card" style="mar">
                <div style="margin: 7px">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" class="form-control" placeholder="Enter Name" id="name" name="name">
                        <span class="text-danger" id="nameError"></span>
                      </div>
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input type="title" class="form-control" placeholder="Enter Title" id="title" name="title">
                        <span class="text-danger" id="titleError"></span>
                      </div>
                      <div class="form-group">
                          <label for="institute">Institute</label>
                          <input type="institute" class="form-control" placeholder="Enter Institute" id="institute" name="institute">
                          <span class="text-danger" id="instituteError"></span>
                        </div>
                        <input type="hidden" name="id" id="id">
                      <button type="submit" id="addButton" name="submit" onclick="addData()" class="btn btn-primary">Submit</button>
                      <button type="update" id="updateButton" name="update" onclick="updateData()" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#addHeader').show();
    $('#updateHeader').hide();
    $('#addButton').show();
    $('#updateButton').hide();
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
        } 
    })
    function allData(){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "all-teacher",
            success: function(response){
                var data = "";
                $.each(response, function(key, value){
                    data = data + "<tr>"
                        data = data + "<td>"+value.id+"</td>"
                        data = data + "<td>"+value.name+"</td>"
                        data = data + "<td>"+value.title+"</td>"
                        data = data + "<td>"+value.institute+"</td>"
                        data = data + "<td>"
                            data = data + "<button type='button' class='btn btn-primary' onclick='editData("+value.id+")'>Edit</button>"
                            data = data + "<button type='button' class='btn btn-danger' onclick='deleteData("+value.id+")'>Delete</button>"
                        data = data + "</td>"
                    data = data + "</tr>"
                })
                $('tbody').html(data);
            }
        })
    }
    allData();
    function clearData()
    {
        $('#name').val('');
        $('#title').val('');
        $('#institute').val('');
        $('#nameError').text('');
        $('#titleError').text('');
        $('#instituteError').text('');
    }
    function addData()
    {
        var name = $('#name').val();
        var title = $('#title').val();
        var institute = $('#institute').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {name:name, title:title, institute: institute},
            url: "store",
            success: function(data){
                clearData();
                allData();
                const msg = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })

                msg.fire({
                    type: 'success',
                    title: 'Data Added Succesfully',
                })
            },
            error: function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            }
        })
    }
    function editData(id){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "edit/"+id,
            success: function(data){
                $('#addHeader').hide();
                $('#addButton').hide();
                $('#updateHeader').show();
                $('#updateButton').show();
                $('#name').val(data.name);
                $('#title').val(data.title);
                $('#institute').val(data.institute);
                $('#id').val(data.id);

                
            }
        })
    }
    function updateData(){
        var id = $('#id').val();
        var name = $('#name').val();
        var title = $('#title').val();
        var institute = $('#institute').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {name:name, title:title, institute: institute},
            url: "update/"+id,
            success: function(data){
                $('#addHeader').show();
                $('#updateHeader').hide();
                $('#addButton').show();
                $('#updateButton').hide();
                clearData();
                allData();
                const msg = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })

                msg.fire({
                    type: 'success',
                    title: 'Data Updated Succesfully',
                })
            },
            error: function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#titleError').text(error.responseJSON.errors.title);
                $('#instituteError').text(error.responseJSON.errors.institute);
            } 
        })
    }

    function deleteData(id){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "delete/"+id,
            success: function(data){
                $('#addHeader').show();
                $('#updateHeader').hide();
                $('#addButton').show();
                $('#updateButton').hide();
                clearData();
                allData();
                const msg = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                })

                msg.fire({
                    type: 'success',
                    title: 'Data Deleted Succesfully',
                })
            }
        })
    }
</script>
</body>
</html>