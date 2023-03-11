<?php

namespace App\Http\Controllers;

use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
    // set index page view
    public function index() {
        return view('index');
    }

    // handle fetch all eamployees ajax request
    public function fetchAll() {
        $books = Book::all();
        $output = '';
        if ($books->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($books as $book) {
                $output .= '<tr>
                <td>' . $book->id . '</td>
                <td><img src="storage/images/' . $book->image . '" width="50" class="img-thumbnail" alt="" "></td>
                <td>' . $book->title .'</td>
                <td>' . $book->description . '</td>
                <td>' . $book->published_date . '</td>
                <td>
                  <a href="#" id="' . $book->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $book->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new employee ajax request
    public function store(Request $request) {
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);

        $bookData = ['title' => $request->title, 'description' => $request->description, 'published_date' => $request->published_date, 'image' => $fileName];
        Book::create($bookData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an employee ajax request
    public function edit(Request $request) {
        $id = $request->id;
        $book = Book::find($id);
        return response()->json($book);
    }

    // handle update an employee ajax request
    public function update(Request $request) {
        $fileName = '';
        $book = Book::find($request->book_id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if ($book->image) {
                Storage::delete('public/images/' . $book->image);
            }
        } else {
            $fileName = $request->book_image;
        }

        $bookData = ['title' => $request->title, 'description' => $request->description, 'published_date' => $request->published_date, 'image' => $fileName];

        $book->update($bookData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an employee ajax request
    public function delete(Request $request) {
        $id = $request->id;
        $book = Book::find($id);
        if (Storage::delete('public/images/' . $book->image)) {
            Book::destroy($id);
        }
    }
}
