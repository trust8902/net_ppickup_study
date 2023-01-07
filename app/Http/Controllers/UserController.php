<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function lists(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $perPage = $request->input('per_page', 10);

        $users = User::when($id, function($query) use($id) {
                $query->where('id', $id);
            })
            ->when($name, function($query) use($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'asc');

        return $request->has('page') ?
            UserResource::collection($users->paginate($perPage)) :
            new PageCollection(UserResource::collection($users->get()));
    }
}
