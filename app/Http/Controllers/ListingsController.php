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
        $this->middleware('auth', ['except' => ['index', 'show']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        // OpenCage Geocoding API
        $geocoder = new \OpenCage\Geocoder\Geocoder('8582bc40ea1147dfa3e558676a10d122');
        $result = $geocoder->geocode($request->input('address'), ['language' => 'fi', 'countrycode' => 'fi']);
        if ($result && $result['total_results'] > 0) {
          $first = $result['results'][0];
          # 4.360081;43.8316276;6 Rue Massillon, 30020 Nîmes, Frankreich
          $lng = $first['geometry']['lng'];
          $lat = $first['geometry']['lat'];
          
        }

        if($request->hasFile('image')){

            $filenameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

        } else {

           $fileNameToStore = "noimage.jpg";
        }

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

/*         return Storage::get('public/images/kerrostalo8_1575377423.jpg'); */
        $minutes = 10080; // Week
         if(Cookie::has('visited')) {
            $visited = json_decode(Cookie::get('visited'));
        } else {
            $visited = [];
        } 

        array_push($visited, $id);
        $visited = array_slice(array_unique($visited), -3);

        Cookie::queue(Cookie::make('visited', json_encode($visited), $minutes)); 
        $listing = Listing::find($id);
        

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
        $listing = Listing::find($id);

        if(auth()->user()->id !== $listing->user_id) {
            return redirect('/listings')->with('error', 'Unauthorized page'); 
        }

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

        // OpenCage Geocoding API
        $geocoder = new \OpenCage\Geocoder\Geocoder('8582bc40ea1147dfa3e558676a10d122');
        $result = $geocoder->geocode($request->input('address'), ['language' => 'fi', 'countrycode' => 'fi']);
        if ($result && $result['total_results'] > 0) {
          $first = $result['results'][0];
          # 4.360081;43.8316276;6 Rue Massillon, 30020 Nîmes, Frankreich
          $lng = $first['geometry']['lng'];
          $lat = $first['geometry']['lat'];
          
        }

        if($request->hasFile('image')){

            $filenameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

        } else {

           $fileNameToStore = "noimage.jpg";
        }

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
        $listing = Listing::find($id);

        if(auth()->user()->id !== $listing->user_id) {
            return redirect('/listings')->with('error', 'Unauthorized page'); 
        }

        if($listing->image != 'noimage.jpg'){
            Storage::delete('public/images/'.$listing->image);
        }

        $listing->delete();
        return redirect('/listings')->with('success', 'Listing Removed');
    }
}
