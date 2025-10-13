<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Posts;

class SearchController extends Controller
{        
    public function index(Request $request){      
      $searchType = $request->search_type;
      $searchText = $request->search_text;
      switch ($searchType) {
        case 'products':           

          $products = Product::where(function ($query) use ($searchText) {
                $query->where('title', 'like', '%'.$searchText.'%')
                  ->orWhere('description', 'like', '%'.$searchText.'%');
            })
            ->where('is_confirmed', '=', 1)
            ->where('is_service', '=', 0)
            ->paginate(20);

          $data = [ 
            'searchText' => $searchText,                  
            'products' => $products,            
          ];      
          
          return view('search.products', $data); 

          break;
        case 'service-products':           

          $products = Product::where(function ($query) use ($searchText) {
                $query->where('title', 'like', '%'.$searchText.'%')
                  ->orWhere('description', 'like', '%'.$searchText.'%');
            })
            ->where('is_confirmed', '=', 1)
            ->where('is_service', '=', 1)
            ->paginate(20);

          $data = [ 
            'searchText' => $searchText,                  
            'products' => $products,            
          ];      
          
          return view('search.service-products', $data); 

          break;  
        case 'posts': 
          $posts = Posts::where(function ($query) use ($searchText) {
                $query->where('post_content', 'like', '%'.$searchText.'%')
                  ->orWhere('post_title', 'like', '%'.$searchText.'%');
            })
            ->paginate(20);

          $data = [ 
            'searchText' => $searchText,                  
            'posts' => $posts,            
          ];      
          
          return view('search.posts', $data);         
          break;
        default:          
          break;
      }
    } 
}