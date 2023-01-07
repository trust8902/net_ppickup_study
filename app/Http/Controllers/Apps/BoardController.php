<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardResource;
use App\Http\Resources\PageCollection;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function lists(Request $request) {
        $alias = $request->input('alias');
        $status = $request->input('status');
        $perPage = $request->input('per_page', 10);

        $users = Board::when($alias, function($query) use($alias) {
                $query->where('alias', 'like', '%' . $alias . '%');
            })
            ->when($status, function($query) use($status) {
                $query->where('status', 'like', '%' . $status . '%');
            })
            ->orderBy('created_at', 'asc');

        return $request->has('page') ?
            BoardResource::collection($users->paginate($perPage)) :
            new PageCollection(BoardResource::collection($users->get()));
    }

    public function view(Request $request, $boardId) {
        return new BoardResource(
            Board::withTrashed()
                ->where(['id' => $boardId])
                ->firstOrFail());
    }

    public function store(Request $request) {
        $board = new Board();
        $board->name = $request->input('name');
        $board->alias = $request->input('alias');
        $board->description = $request->input('description');
        $board->custom_fields = $request->input('custom_fields');
        $board->status = $request->input('status');
        $board->save();

        return $this->view($request, $board->id);
    }

    public function update(Request $request, $boardId) {
        $board = Board::findOrFail($boardId);

        $board->update([
            'name' => $request->input('name'),
            'alias' => $request->input('alias'),
            'description' => $request->input('description'),
            'custom_fields' => $request->input('custom_fields'),
            'status' => $request->input('status'),
        ]);

        return $this->view($request, $boardId);
    }

    public function destroy(Request $request, $boardId) {
        $board = Board::findOrFail($boardId);

        DB::beginTransaction();
        $board->delete();
        DB::commit();
    }
}
