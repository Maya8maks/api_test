<?php

namespace App\Http\Controllers; 

use App\Product;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Response;
use DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [

                'price_min' => 'sometimes|integer',
                'price_max' => 'sometimes|integer',
                'count' => 'sometimes|integer',
                'timeStart' => 'sometimes|date_format:"Y-m-d 00:00:00"|before:timeEnd',
                'timeEnd' => 'sometimes|date_format:"Y-m-d 23:59:59"|after:timeStart',
                'sort_name' => 'sometimes|string',
                'sort_way' => 'sometimes|in:ASC,DESC'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()], 401);
            }
            $price_min_db = DB::table('products')->min('price');
            $price_max_db = DB::table('products')->max('price');
            $timeStart_db = DB::table('products')->min('created_at');
            $timeEnd_db = DB::table('products')->max('created_at');


            $price_min = $request->has('price_min') ? $request->input('price_min') : $price_min_db;
            $price_max = $request->has('price_max') ? $request->input('price_max') : $price_max_db;
            $count = $request->has('count') ? $request->input('count') : null;
            $timeStart = $request->has('timeStart') ? $request->input('timeStart') : $timeStart_db;
            $timeEnd = $request->has('timeEnd') ? $request->input('timeEnd') : $timeEnd_db;
            $sort_name = $request->has('sort_name') ? $request->input('sort_name') : 'name';
            $sort_way = $request->has('sort_way') ? $request->input('sort_way') : '';


            $products = Product::where('price', '>=', $price_min)->where('price', '<=', $price_max)
                ->where('created_at', '>=', $timeStart)->where('created_at', '<=', $timeEnd)->orderby($sort_name, $sort_way)
                ->take($count)->get();


            return response()->json([
                'products' => $products
            ], 200);

        }
    }

}
