<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{
    public function index()
    {
        //Show recently viewed listings by id saved in cookie
        //Check if cookie exists and then find listings
        if(Cookie::has('visited')) {
            $visited = json_decode(Cookie::get('visited'));
            $visited = array_reverse($visited);
            $listings = Listing::whereIn('id', $visited)->get();
        } else {
            $visited = null;
            $listings = null;
        }  
        //Return listings to frontpage
        return view('pages.frontpage')->with('listings', $listings);
    }
    public function about()
    {
        //Return about view
        return view('pages.about');
    }
}
