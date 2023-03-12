<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-tokens" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Author ajax</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

</head>
{{-- add new author modal start --}}
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="add_author_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <div class="row">
                        <div class="col-lg">
                            <label for="AuthorLastName">Last Name</label>
                            <input type="text" name="AuthorLastName" class="form-control" placeholder="Last Name" required >
                        </div>
                        <div class="col-lg">
                            <label for="AuthorFirstName">First Name</label>
                            <input type="text" name="AuthorFirstName"  class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="AuthorMiddleName">Middle Name</label>
                        <input type="text" name="AuthorMiddleName" class="form-control" placeholder="Middle Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="add_author_btn" class="btn btn-primary">Add Author</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- add new author modal end --}}

{{-- edit author modal start --}}
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edit_author_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="auth_id" id="auth_id">
                <div class="modal-body p-4 bg-light">
                    <div class="row">
                        <div class="col-lg">
                            <label for="AuthorLastName">Last Name</label>
                            <input type="text" name="AuthorLastName" id="AuthorLastName" class="form-control" placeholder="Last Name" required >
                        </div>
                        <div class="col-lg">
                            <label for="AuthorFirstName">First Name</label>
                            <input type="text" name="AuthorFirstName" id="AuthorFirstName" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="AuthorMiddleName">Middle Name</label>
                        <input type="text" name="AuthorMiddleName" id="AuthorMiddleName" class="form-control" placeholder="Middle Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_author_btn" class="btn btn-success">Update Author</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- edit author modal end --}}

<body class="bg-light">
<div class="container">
    <div class="row my-5">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Directory Authors</h3>
                    <a href="/" class="btn btn-light" >Books Directory</a>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addAuthorModal"><i
                            class="bi-plus-circle me-2"></i>Add New Author</button>
                </div>
                <div class="card-body" id="show_all_authors">
                    <h1 class="text-center text-secondary my-5">Loading...</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {

        // add new author ajax request
        $("#add_author_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_author_btn").text('Adding...');
            $.ajax({
                url: '{{ route('storeAuthor') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Added!',
                            'Author Added Successfully!',
                            'success'
                        )
                        fetchAllAuthors();
                    }
                    $("#add_author_btn").text('Add Author');
                    $("#add_author_form")[0].reset();
                    $("#addAuthorModal").modal('hide');
                }
            });
        });

        // edit author ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            alert("edit in");
            $.ajax({
                url: '{{ route('editAuthor') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#AuthorFirstName").val(response.first_name);
                    $("#auth_id").val(response.id);

                },
                error: function(){
                    alert('error edit!');
                }

            });
        });

        // update author ajax request
        $("#edit_author_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_author_btn").text('Updating...');
            $.ajax({
                url: '{{ route('updateAuthor') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {
                        Swal.fire(
                            'Updated!',
                            'Author Updated Successfully!',
                            'success'
                        )
                        fetchAllAuthors();
                    }
                    $("#edit_author_btn").text('Update Author');
                    $("#edit_author_form")[0].reset();
                    $("#editAuthorModal").modal('hide');
                },
                error: function(){
                }
            });
        });

        // delete author ajax request
        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('deleteAuthor') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            fetchAllAuthors();
                        }
                    });
                }
            })
        });

        // fetch all authors ajax request
        fetchAllAuthors();

        function fetchAllAuthors() {
            $.ajax({
                url: '{{ route('fetchAllAuthor') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_authors").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
</body>

</html>
