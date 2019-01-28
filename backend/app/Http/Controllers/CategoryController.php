<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
  /**
   * Retrieve all categories.
   *
   * @return Response
   */
  public function index()
  {
    $categories = Category::all("categories.name");
    return response()->json($categories);
  }
}
