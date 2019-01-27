<?php

namespace App\Http\Controllers;

use App\Book;

class BookController extends Controller
{
  /**
   * Retrieve all books.
   *
   * @return Response
   */
  public function index()
  {
    $books = Book::all();
    return response()->json($books);
  }
}
