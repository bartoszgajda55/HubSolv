<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\CategoryBook;
use http\Env\Response;
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
      $books = $this->getBooksByAuthorAndCategory($request->input("author"), $request->input("category"));
    } else if ($request->has("author")) {
      $books = $this->getBooksByAuthor($request->input("author"));
    } else if ($request->has("category")) {
      $books = $this->getBooksByCategory($request->input("category"));
    } else {
      $books = Book::all();
    }
    return response()->json($books);
  }

  /**
   * Store new book in the DB
   *
   * @param Request $request
   * @return Response response
   */
  public function store(Request $request)
  {
    try {
      $this->validate($request, [
          'isbn' => 'required|regex:/^[0-9]+(-[0-9]+)+$/',
          'title' => 'required|string',
          'author' => 'required|string',
          'category' => 'required|string',
          'price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json(["status" => "error", "message" => $e], 400);
    }

    $author = \App\Author::firstOrCreate(["name" => $request->input("author")]);
    $category = Category::firstOrCreate(["name" => $request->input("category")]);

    $book = new Book;
    $book->isbn = $request->input("isbn");
    $book->title = $request->input("title");
    $book->author = $author->id;
    $book->price = $request->input("price");

    if ($book->save() && $this->addCategoryToBook($category, $book)) {
      return response()->json($book, 201);
    }

    return response()->json(["status" => "error", "message" => "Server Error"], 500);
  }

  private function addCategoryToBook($category, $book) {
    $categoryBook = new CategoryBook;
    $categoryBook->book_id = $book->id;
    $categoryBook->category_id = $category->id;

    if ($categoryBook->save())
      return true;

    return false;
  }

  private function getBooksByAuthorAndCategory($author, $category)
  {
    return DB::table("books")
        ->select("books.isbn")
        ->join("categories_books", "categories_books.book_id", "=", "books.id")
        ->join("categories", "categories_books.category_id", "=", "categories.id")
        ->join("authors", "books.author", "=", "authors.id")
        ->where("categories.name", "=", $category)
        ->where("authors.name", "=", $author)
        ->get();
  }

  private function getBooksByAuthor($author)
  {
    return DB::table("books")
        ->select("books.isbn")
        ->join("authors", "books.author", "=", "authors.id")
        ->where("authors.name", "=", $author)
        ->get();
  }

  private function getBooksByCategory($category)
  {
    return DB::table("books")
        ->select("books.isbn")
        ->join("categories_books", "categories_books.book_id", "=", "books.id")
        ->join("categories", "categories_books.category_id", "=", "categories.id")
        ->where("categories.name", "=", $category)
        ->get();
  }
}
