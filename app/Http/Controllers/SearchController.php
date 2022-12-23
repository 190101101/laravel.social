<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query = $request->input('query');

        if(!$query){
            redirect()->route('home');
        }

        $users = User::where(DB::raw("CONCAT (firstname, ' ', lastname)"), 'LIKE', "%{$query}%")
            ->orWhere('username', 'LIKE', "%{%query}%")->get();

        return view('search.results')->with('users', $users);
    }
}
