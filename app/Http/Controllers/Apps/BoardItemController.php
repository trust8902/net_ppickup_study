<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardItemResource;
use App\Http\Resources\PageCollection;
use App\Models\Board;
use App\Models\BoardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardItemController extends Controller
{
    public function lists(Request $request, $alias) {
        $title = $request->input('title');
        $contents = $request->input('contents');
        $perPage = $request->input('per_page', 10);

        $users = BoardItem::with([
                'board' => function($query) use($alias) {
                    $query->where('alias', $alias);
                },
                'user',
                'boardComments',
            ])
            ->when($title, function($query) use($title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($contents, function($query) use($contents) {
                $query->where('contents', 'like', '%' . $contents . '%');
            })
            ->orderBy('created_at', 'asc');

        return $request->has('page') ?
            BoardItemResource::collection($users->paginate($perPage)) :
            new PageCollection(BoardItemResource::collection($users->get()));
    }

    public function view(Request $request, $alias, $boardItemId) {
        return new BoardItemResource(
                BoardItem::with([
                    'board' => function($query) use($alias) {
                        $query->where('alias', $alias);
                    },
                    'user',
                    'boardComments',
                ])
                ->withTrashed()
                ->where(['id' => $boardItemId])
                ->firstOrFail());
    }

    public function store(Request $request, $alias) {
        $board = Board::where('alias', $alias)->firstOrFail();

        $boardItem = new BoardItem();
        $boardItem->board_id = $board->id;
        $boardItem->user_id = $request->input('user_id');
        $boardItem->title = $request->input('title');
        $boardItem->contents = $request->input('contents');
        $boardItem->is_hidden = $request->input('is_hidden') >= 1 ? 1 : 0;
        $boardItem->save();

        return $this->view($request, $alias, $boardItem->id);
    }

    public function update(Request $request, $alias, $boardItemId) {
        $boardItem = BoardItem::with([
                'board' => function($query) use($alias) {
                    $query->where('alias', $alias);
                }
            ])
            ->where('board_item_id', $boardItemId)
            ->firstOrFail();

        $boardItem->update([
            'title' => $request->input('title'),
            'contents' => $request->input('contents'),
            'is_hidden' => $request->input('is_hidden'),
        ]);

        return $this->view($request, $alias, $boardItemId);
    }

    public function destroy(Request $request, $alias, $boardItemId) {
        $boardItem = BoardItem::with([
                'board' => function($query) use($alias) {
                    $query->where('alias', $alias);
                }
            ])
            ->where('board_item_id', $boardItemId)
            ->firstOrFail();

        DB::beginTransaction();
        $boardItem->delete();
        DB::commit();
    }
}
