<?php

namespace App\Http\Controllers;

use App\users;

use Illuminate\Http\Request;
use App\Http\Resources\usersResource;

class usersController extends Controller
{
    public function index()
        {
              $users = users::orderBy('created_at', 'desc')->get();
              return usersResource::collection($users);
        }

        public function store(Request $request)
            {
                  $users = users::create([
                      'name' => $request->name
                  ]);
                  return $users;
            }

            public function delete($id)
                {
                      users::destroy($id);
                      return 'success';
                }
            public function update(Request $request)
                { 
                    // dd($request->name);
                      $users = users::findOrFail($request->name);
                      $users->update([
                          'name' => $request->name
                      ]);
                         return response()->json([
                        'message'=>'Your note was updated',
                        'user'=>$users,
                    ]);
                // return ('hallo');
                }
}