<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Listing;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $sort = 'asc';
        $prop = 'created_at';
        $sortby = $request->input('sortby');

        $types = $request->input('types');
        $rooms = $request->input('rooms');
        $priceMin = (int) $request->input('priceMin');
        $priceMax = (int) $request->input('priceMax');
        $sizeMin = (int) $request->input('sizeMin');
        $sizeMax = (int) $request->input('sizeMax');

        switch ($sortby) {
            case 'Recent':
                $sort = 'desc';
                $prop = 'created_at';
            break;
            case 'Oldest':
                $sort = 'asc';
                $prop = 'created_at';
            break;
            case 'Price ascending':
                $sort = 'asc';
                $prop = 'price';
            break;
            case 'Price descending':
                $sort = 'desc';
                $prop = 'price';
            break;
            case 'Size ascending':
                $sort = 'asc';
                $prop = 'size';
            break;
            case 'Size descending':
                $sort = 'desc';
                $prop = 'size';
            break;
            default: 
            $sort = 'asc';
            $prop = 'created_at';
        }



        $listings = Listing::
        where(function ($query) use ($types) {

            if ($types != null) {
                $query->whereIn('type', $types);
            } else {
                $query->whereNotNull('type');
            }
        })
        ->where(function ($query) use ($rooms) {

            if ($rooms != null) {
                $query->whereIn('bedrooms', $rooms);
            } else {
                $query->whereNotNull('bedrooms');
            }
        })
        ->where(function ($query) use ($priceMin, $priceMax) {
            if ($priceMin != null && $priceMax == null) {
                $query->where('price', '>=', $priceMin);
            }
            if ($priceMin == null && $priceMax != null) {
                $query->where('price', '<=', $priceMax);
            }
            if ($priceMin != null && $priceMax != null) {
                $query->whereBetween('price', [$priceMin, $priceMax]);
            }
        })
        ->where(function ($query) use ($sizeMin, $sizeMax) {
            if ($sizeMin != null && $sizeMax == null) {
                $query->where('size', '>=', $sizeMin);
            }
            if ($sizeMin == null && $sizeMax != null) {
                $query->where('size', '<=', $sizeMax);
            }
            if ($sizeMin != null && $sizeMax != null) {
                $query->whereBetween('size', [$sizeMin, $sizeMax]);
            }
        })
        ->orderBy($prop, $sort)

        ->get();




        return view('listings.index')->with('listings', $listings);
    }
}
