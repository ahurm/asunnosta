<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Listing;
use Illuminate\Support\Facades\Cookie;

class ListingsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Let unauthorized user to use only index and show
        //Unauthorized user cannot create, update or delete listings
        $this->middleware('auth', ['except' => ['index', 'show']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Show listings
        $listings = Listing::orderBy('created_at', 'desc')->get();
        return view('listings.index')->with('listings', $listings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Return create view
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate listing data when user has submitted it
        //Check and validate required data
        $this->validate($request, [
            'image' => 'image|nullable|max:1999',
            'address' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'size' => 'required|digits_between:0,9',
            'type' => 'required',
            'price' => 'required|digits_between:0,9',
        ]);

        // Price to integer
        $priceInt = (int)$request->input('price');

        // OpenCage Geocoding API to get coordinates from submitted address
        $geocoder = new \OpenCage\Geocoder\Geocoder('8582bc40ea1147dfa3e558676a10d122');
        $result = $geocoder->geocode($request->input('address'), ['language' => 'fi', 'countrycode' => 'fi']);
        if ($result && $result['total_results'] > 0) {
          $first = $result['results'][0];
          #e.g. 4.360081;43.8316276;6 Rue Massillon, 30020 Nîmes, Frankreich
            //Longtitude and latitude
          $lng = $first['geometry']['lng'];
          $lat = $first['geometry']['lat'];
          
        }
        
        //Check if user has uploaded image
        if($request->hasFile('image')){
            
            //Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Rename image using time() function to avoid two identically named images
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Store image to public/images
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

        } else {
            //If not use stock "No Image Available" image
           $fileNameToStore = "noimage.jpg";
        }
        
        //Create a new listing, insert data from request and save
        $listing = new Listing;
        $listing->user_id = auth()->user()->id;
        $listing->image = $fileNameToStore;
        $listing->address = $request->input('address');
        $listing->bedrooms = $request->input('bedrooms');
        $listing->bathrooms = $request->input('bathrooms');
        $listing->size = $request->input('size');
        $listing->type = $request->input('type');
        $listing->desc = $request->input('desc');
        $listing->price = $priceInt;
        $listing->latitude = $lng;
        $listing->longtitude = $lat;
        $listing->save();
        
        //Redirect to listings and show success message
        return redirect('/listings')->with('success', 'Listing created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Add currently viewing listing id to cookie
        //Using json_encode to save array into cookie and json_decode to read it
        $minutes = 10080; // Week
         if(Cookie::has('visited')) {
            $visited = json_decode(Cookie::get('visited'));
        } else {
            $visited = [];
        } 
        
        //Push current listing id to cookie
        array_push($visited, $id);
        //Slice array to only 3 recently added ids
        $visited = array_slice(array_unique($visited), -3);
        
        //Create cookie
        Cookie::queue(Cookie::make('visited', json_encode($visited), $minutes)); 
        
        //Show listing by id
        $listing = Listing::find($id);
        
        //Return listing
        return view('listings.show')->with('listing', $listing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Find listing by id
        $listing = Listing::find($id);
        
        //If user isn't creator of listing, redirect and show error message
        if(auth()->user()->id !== $listing->user_id) {
            return redirect('/listings')->with('error', 'Unauthorized page'); 
        }
        
        //Otherwise return to editing page
        return view('listings.edit')->with('listing', $listing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Update edited listing
        //Do similar validating as before when creating new
        
        //Validate listing data when user has submitted it
        //Check and validate required data
        $this->validate($request, [
            'image' => 'image|nullable|max:1999',
            'address' => 'required',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'size' => 'required|digits_between:0,9',
            'type' => 'required',
            'price' => 'required|digits_between:0,9',
        ]);

        // Price to integer
        $priceInt = (int)$request->input('price');

        // OpenCage Geocoding API to get coordinates from submitted address
        $geocoder = new \OpenCage\Geocoder\Geocoder('8582bc40ea1147dfa3e558676a10d122');
        $result = $geocoder->geocode($request->input('address'), ['language' => 'fi', 'countrycode' => 'fi']);
        if ($result && $result['total_results'] > 0) {
          $first = $result['results'][0];
          #e.g. 4.360081;43.8316276;6 Rue Massillon, 30020 Nîmes, Frankreich
            //Longtitude and latitude
          $lng = $first['geometry']['lng'];
          $lat = $first['geometry']['lat'];
          
        }
        //Check if user has uploaded image
        if($request->hasFile('image')){
            //Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Rename image using time() function to avoid two identically named images
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Store image to public/images
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

        } else {
            //If not use stock "No Image Available" image
           $fileNameToStore = "noimage.jpg";
        }
        //Create a new listing, insert data from request and save
        $listing = Listing::find($id);
        $listing->user_id = auth()->user()->id;
        $listing->image = $fileNameToStore;
        $listing->address = $request->input('address');
        $listing->bedrooms = $request->input('bedrooms');
        $listing->bathrooms = $request->input('bathrooms');
        $listing->size = $request->input('size');
        $listing->type = $request->input('type');
        $listing->desc = $request->input('desc');
        $listing->price = $priceInt;
        $listing->latitude = $lng;
        $listing->longtitude = $lat;
        $listing->save();
        
        //Redirect to listings and show success message
        return redirect('/listings')->with('success', 'Listing updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find listing by id
        $listing = Listing::find($id);
        
        //If user isn't creator of listing, redirect and show error message
        if(auth()->user()->id !== $listing->user_id) {
            return redirect('/listings')->with('error', 'Unauthorized page'); 
        }
        
        //Check if listing has stock image or uploaded to find image name
        if($listing->image != 'noimage.jpg'){
            //Delete image
            Storage::delete('public/images/'.$listing->image);
        }
        
        //Delete listing
        $listing->delete();
        
        //Redirect to listings with success message
        return redirect('/listings')->with('success', 'Listing Removed');
    }
}
