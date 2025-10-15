<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class MemoController extends Controller
{
    private const COLOR_PALETTE = [
        'slate',
        'rose',
        'amber',
        'emerald',
        'sky',
        'violet',
    ];

    public function index(): View
    {
        $memos = Memo::query()
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->get();

        return view('memos.index', [
            'memos' => $memos,
            'palette' => self::COLOR_PALETTE,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateMemo($request);

        Memo::create($data);

        return to_route('memos.index')->with('status', 'メモを追加しました。');
    }

    public function update(Request $request, Memo $memo)
    {
        $data = $this->validateMemo($request);

        $memo->update($data);

        return to_route('memos.index')->with('status', 'メモを更新しました。');
    }

    public function destroy(Memo $memo)
    {
        $memo->delete();

        return to_route('memos.index')->with('status', 'メモを削除しました。');
    }

    private function validateMemo(Request $request): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:120'],
            'content' => ['required', 'string', 'max:5000'],
            'color' => ['nullable', 'string', 'in:' . implode(',', self::COLOR_PALETTE)],
            'is_pinned' => ['sometimes', 'boolean'],
        ];

        $validated = $request->validate($rules);

        $validated['color'] = $validated['color'] ?? Arr::first(self::COLOR_PALETTE);
        $validated['is_pinned'] = (bool) ($validated['is_pinned'] ?? false);

        return $validated;
    }
}
