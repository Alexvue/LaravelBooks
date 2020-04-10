<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function all() {
        return Book::all();
    }

    public function add(Request $request) {
        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->availabilty = true;

        $book->save();

        return redirect('/book');
    }


    public function delete($id) {
        $book = Book::findOrFail($id);
        $book->delete();
        return back();
    }

    public function changeAvailabilty($id) {
        $book = Book::find($id);
        $book->availability = !$book->availability;
        $book->save();
        return back();
    }
}
