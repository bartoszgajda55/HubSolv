<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Category;

class BookController extends Controller
{
  /**
   * Retrieve books with filters if given.
   *
   * @param string author
   * @param string category
   * @return Response response
   */
  public function show($author = null, $category = null)
  {
    if ($author != null) {
      $author = urldecode($author);
      $authorId = Author::all("id")->where("name", $author);
    }
    if ($category != null) {
      $category = urldecode($category);
      $categoryId = Category::all("id")->where("name", $category);
    }
    // TODO create query according to variables and return as json
    return response()->json(null);
  }
}
