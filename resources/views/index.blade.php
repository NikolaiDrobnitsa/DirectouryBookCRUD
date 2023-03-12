<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book directory</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

</head>
{{-- add new Book modal start --}}
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="add_book_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <div class="row">
                        <div class="col-lg">
                            <label for="title_book">Title book</label>
                            <input type="text" name="title_book" class="form-control" placeholder="Title_book" >
                        </div>
                        <div class="col-lg">
                            <label for="description_book">Description</label>
                            <input type="text" name="description_book" class="form-control" placeholder="Description" >
                        </div>
                        <div class="col-lg">
                            <label for="author_book">Author</label>
                            <input type="text" name="author_book" class="form-control" placeholder="Description" >
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="published_date">Published Date</label>
                        <input type="text" name="published_date" class="form-control" placeholder="Published Date" >
                    </div>

                    <div class="my-2">
                        <label for="book_avatars">Select Image</label>
                        <input type="file" name="book_avatars" class="form-control" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="add_book_btn" class="btn btn-primary">Add Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- add new book modal end --}}

{{-- edit book modal start --}}
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edit_book_form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="book_id" id="book_id">
                <input type="hidden" name="book_avatar" id="book_avatar">
                <div class="modal-body p-4 bg-light">
                    <div class="row">
                        <div class="col-lg">
                            <label for="title_book">Title book</label>
                            <input type="text" name="title_book" id="title_book" class="form-control" placeholder="Title book" required>
                        </div>
                        <div class="col-lg">
                            <label for="description_book">Description</label>
                            <input type="text" name="description_book" id="description_book" class="form-control" placeholder="Description" required>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="published_date">Published Date</label>
                        <input type="date" name="published_date" id="published_date" class="form-control" placeholder="Published Date" required>
                    </div>
                    <div class="my-2">
                        <label for="book_avatars">Select Image</label>
                        <input type="file" name="book_avatars" class="form-control">
                    </div>
                    <div class="mt-2" id="book_avatars">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_book_btn" class="btn btn-success">Update Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- edit employee modal end --}}

<body class="bg-light">
<div class="container">
    <div class="row my-5">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                    <h3 class="text-light">Manage Books</h3>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBookModal"><i
                            class="bi-plus-circle me-2"></i>Add New Book</button>
                </div>
                <div class="card-body" id="show_all_books">
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

        // add new book ajax request
        $("#add_book_form").submit(function(e) {
            console.log("start in add");
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_book_btn").text('Adding...');
            $.ajax({
                url: '{{ route('store') }}',
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
                            'Book Added Successfully!',
                            'success'
                        )
                        fetchAllBooks();
                    }


                    $("#add_book_btn").text('Add Book');
                    $("#add_book_form")[0].reset();
                    $("#addBookModal").modal('hide');
                },
                error: function (xhr, status, error){
                    // console.log("end in add");
                    // // console.log(JSON.stringify(response));
                    // console.log();
                    // console.table(response);
                    console.log(xhr.responseText);
                }
            });
        });

        // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.table($("#title_book").val(response.title));
                    $("#description_book").val(response.description);
                    $("#published_date").val(response.published_date);
                    $("#book_avatars").html(
                        `<img src="storage/images/${response.book_avatars}" width="100" class="img-fluid img-thumbnail">`);
                    $("#book_id").val(response.id);
                    $("#book_image").val(response.book_avatars);
                }
            });
        });

        // update book ajax request
        $("#edit_book_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_book_btn").text('Updating...');
            $.ajax({
                url: '{{ route('update') }}',
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
                            'Book Updated Successfully!',
                            'success'
                        )
                        fetchAllBooks();
                    }
                    $("#edit_book_btn").text('Update Book');
                    $("#edit_book_form")[0].reset();
                    $("#editBookModal").modal('hide');
                }
            });
        });

        // delete employee ajax request
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
                        url: '{{ route('delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            fetchAllBooks();
                        }
                    });
                }
            })
        });

        // fetch all books ajax request
        fetchAllBooks();

        function fetchAllBooks() {
            $.ajax({
                url: '{{ route('fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_books").html(response);
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
