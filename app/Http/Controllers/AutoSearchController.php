<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AutoSearchController extends Controller
{
    public function searchUser(Request $request)
    {
          $query = $request->get('query');
          $filterResult = User::where('first_name', 'LIKE', '%'. $query. '%')
                                ->orWhere('last_name', 'LIKE', '%'. $query. '%')
                                ->get();
          return response()->json($filterResult);
    } 
}
