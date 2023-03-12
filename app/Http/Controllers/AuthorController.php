<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function indexAuthor() {
        return view('author');
    }

    // handle fetch all authors ajax request
    public function fetchAllAuthor() {
        $authors = Author::all();
        $output = '';
        if ($authors->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($authors as $author) {
                $output .= '<tr>
                <td>' . $author->id . '</td>
                <td>' . $author->last_name .'</td>
                <td>' . $author->first_name . '</td>
                <td>' . $author->middle_name . '</td>
                <td>
                  <a href="#" id="' . $author->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editAuthorModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $author->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // handle insert a new author ajax request
    public function storeAuthor(Request $request) {


        $AuthData = ['last_name' => $request->AuthorLastName, 'first_name' => $request->AuthorFirstName, 'middle_name' => $request->AuthorMiddleName];
        Author::create($AuthData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an author ajax request
    public function editAuthor(Request $request) {
        $id = $request->id;
        $author = Author::find($id);
        return response()->json($author);
    }

    // handle update an author ajax request
    public function updateAuthor(Request $request) {
        $author = Author::find($request->auth_id);

      $AuthData = ['last_name' => $request->AuthorLastName, 'first_name' => $request->AuthorFirstName, 'middle_name' => $request->AuthorMiddleName];

        $author->update($AuthData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an author ajax request
    public function deleteAuthor(Request $request) {
        $id = $request->id;
        Author::destroy($id);
    }
}
