<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardCommentResource;
use App\Http\Resources\PageCollection;
use App\Models\BoardComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardCommentController extends Controller
{
    public function lists(Request $request, $alias, $boardItemId) {
        $contents = $request->input('contents');
        $isHidden = $request->input('is_hidden', false);
        $perPage = $request->input('per_page', 10);

        $users = BoardComment::with([
                'user',
            ])
            ->where('board_item_id', $boardItemId)
            ->when($contents, function($query) use($contents) {
                $query->where('contents', 'like', '%' . $contents . '%');
            })
            ->where('is_hidden', $isHidden)
            ->orderBy('created_at', 'asc');

        return $request->has('page') ?
            BoardCommentResource::collection($users->paginate($perPage)) :
            new PageCollection(BoardCommentResource::collection($users->get()));
    }

    public function view(Request $request, $alias, $boardCommentId) {
        return new BoardCommentResource(
            BoardComment::with([
                    'user',
                ])
                ->withTrashed()
                ->where('id', $boardCommentId)
                ->firstOrFail());
    }

    public function store(Request $request, $alias) {
        $boardComment = new BoardComment();
        $boardComment->board_id = $request->input('board_id');
        $boardComment->board_item_id = $request->input('board_item_id');
        $boardComment->user_id = $request->input('user_id');
        $boardComment->contents = $request->input('contents');
        $boardComment->is_hidden = $request->input('is_hidden') >= 1 ? 1 : 0;
        $boardComment->save();

        return $this->view($request, $boardComment->id);
    }

    public function destroy(Request $request, $alias, $boardItemId, $boardCommentId) {
        $boardComment = BoardComment::where('board_item_id', $boardItemId)
            ->where('id', $boardCommentId)
            ->firstOrFail();

        DB::beginTransaction();
        $boardComment->delete();
        DB::commit();
    }
}
