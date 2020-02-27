<?php

namespace App\Http\Controllers;
use Storage;
use Illuminate\Http\Request;
use App\Support\Collection;


class ConsultController extends Controller
{



  public function showMovies(Request $request)
  {
    $json = Storage::disk('local')->get('jsons/trailers.json');
    $collection = collect(json_decode($json, true));

    $data = $collection;
    //genre filter start
    if ($request->genre) {
      $data = $collection->filter(function ($obj) use ($request) {
        return strtolower($obj['genre']) == strtolower($request->genre);
      });
    }
    //genre filter end
    //rating filter start
    if ($request->rating) {
      $data = $data->filter(function ($obj) use ($request) {
        return $obj['rating'] >= $request->rating;
      });
    }
    //rating filter end
    return response($data, 200);
  }



  public function advancedMovies(Request $request)
  {
    $json = Storage::disk('local')->get('jsons/movies.json');
    $collection = (new Collection(json_decode($json, true)));
    $data = $collection;

    if ($request->Major_Genre) {
      $data = $data->filter(function ($obj) use ($request) {
        return strtolower($obj['Major_Genre']) == strtolower($request->Major_Genre);
      });
    }

    return response($data->paginate(10), 200);
  }



  public function allWorldCup()
  {
    $json = Storage::disk('local')->get('jsons/fifa2018.json');
    $collection = (new Collection(json_decode($json, true)));
    $data = $collection;

    // if ($request->Major_Genre) {
    //   $data = $data->filter(function ($obj) use ($request) {
    //     return strtolower($obj['Major_Genre']) == strtolower($request->Major_Genre);
    //   });
    // }

    return response($data->paginate(10), 200);
  }


}
