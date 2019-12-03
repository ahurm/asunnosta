<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    public function index()
    {

        if(Cookie::has('visited')) {
            $visited = json_decode(Cookie::get('visited'));
            $visited = array_reverse($visited);
            $listings = Listing::whereIn('id', $visited)->get();
        } else {
            $visited = null;
            $listings = null;
        }  
        
        return view('pages.frontpage')->with('listings', $listings);
    }
    public function about()
    {
        $title = "About Us";
        return view('pages.about')->with('title', $title);
    }
}
