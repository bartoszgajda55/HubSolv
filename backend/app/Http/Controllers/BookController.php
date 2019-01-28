<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
  /**
   * Retrieve books with filters if given.
   *
   * @param Request $request
   * @return Response response
   */
  public function show(Request $request)
  {
    if ($request->has("author") && $request->has("category")) {
      $books = DB::table("books")
          ->select("books.isbn")
          ->join("categories_books", "categories_books.book_id", "=", "books.id")
          ->join("categories", "categories_books.category_id", "=", "categories.id")
          ->join("authors", "books.author", "=", "authors.id")
          ->where("categories.name", "=", $request->input("category"))
          ->where("authors.name", "=", $request->input("author"))
          ->get();
    } else if ($request->has("author")) {
      $books = DB::table("books")
          ->select("books.isbn")
          ->join("authors", "books.author", "=", "authors.id")
          ->where("authors.name", "=", $request->input("author"))
          ->get();
    } else if ($request->has("category")) {
      $books = DB::table("books")
          ->select("books.isbn")
          ->join("categories_books", "categories_books.book_id", "=", "books.id")
          ->join("categories", "categories_books.category_id", "=", "categories.id")
          ->where("categories.name", "=", $request->input("category"))
          ->get();
    } else {
      $books = Book::all();
    }
    return response()->json($books);
  }
}
