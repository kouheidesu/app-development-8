@extends('layouts.app')

@section('content')
    @php
        use Illuminate\Support\Str;

        $colorGradients = [
            'slate' => 'from-slate-500 via-slate-600 to-slate-700',
            'rose' => 'from-rose-400 via-rose-500 to-rose-600',
            'amber' => 'from-amber-400 via-amber-500 to-amber-600',
            'emerald' => 'from-emerald-400 via-emerald-500 to-emerald-600',
            'sky' => 'from-sky-400 via-sky-500 to-sky-600',
            'violet' => 'from-violet-400 via-violet-500 to-violet-600',
        ];
    @endphp

    <div class="mx-auto flex max-w-6xl flex-col gap-16">
        <section class="flex flex-col gap-8 text-center">
            <div class="flex flex-col items-center gap-5">
                <span class="inline-flex items-center gap-3 rounded-full bg-white px-5 py-2 text-sm font-medium text-slate-600 shadow-sm ring-1 ring-slate-200">
                    <span class="text-lg">📝</span>
                    あなたのアイデアをスタイリッシュに残そう
                </span>
                <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                    Memórie Memo App
                </h1>
                <p class="max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    ひらめいた言葉やタスク、インスピレーションをサクッと記録。
                    Tailwind CSS でデザインしたシンプルでおしゃれなメモアプリです。
                </p>
            </div>
        </section>

        @if ($errors->any())
            <div class="mx-auto w-full max-w-4xl rounded-3xl border border-rose-200 bg-white/90 p-6 shadow-lg backdrop-blur">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-rose-500">入力内容を確認してください</h2>
                <ul class="mt-3 space-y-1 text-sm text-rose-600">
                    @foreach ($errors->all() as $error)
                        <li>・{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="mx-auto w-full max-w-4xl">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/40">
                <div class="flex flex-col gap-6 bg-slate-50/60 p-8 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-col gap-2 text-left">
                        <h2 class="text-lg font-semibold text-slate-900 sm:text-xl">新しいメモを書く</h2>
                        <p class="text-sm text-slate-500">
                            タイトルと本文を入力し、あなたらしいカラーを選びましょう。
                        </p>
                    </div>
                    <div class="hidden h-20 w-20 shrink-0 rounded-2xl bg-gradient-to-br from-sky-400 via-violet-500 to-rose-500 text-white sm:flex sm:items-center sm:justify-center">
                        <span class="text-3xl">✨</span>
                    </div>
                </div>

                @php
                    $createFromUpdate = old('memo_id') !== null;
                    $createTitle = $createFromUpdate ? '' : old('title', '');
                    $createColor = $createFromUpdate ? 'slate' : old('color', 'slate');
                    $createContent = $createFromUpdate ? '' : old('content', '');
                    $createPinned = $createFromUpdate ? false : (bool) old('is_pinned', false);
                @endphp
                <form action="{{ route('memos.store') }}" method="POST" class="flex flex-col gap-6 p-8">
                    @csrf
                    <div class="grid gap-6 sm:grid-cols-2">
                        <label class="flex flex-col gap-2 text-sm font-medium text-slate-700">
                            タイトル
                            <input
                                type="text"
                                name="title"
                                value="{{ $createTitle }}"
                                required
                                maxlength="120"
                                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-base text-slate-800 shadow-sm ring-0 transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-slate-400/60"
                                placeholder="例: 次のミーティング用アイデア"
                            >
                        </label>
                        <label class="flex flex-col gap-2 text-sm font-medium text-slate-700">
                            カラー
                            <div class="flex flex-wrap gap-3">
                                @foreach ($palette as $color)
                                    @php
                                        $selected = $createColor === $color;
                                    @endphp
                                    <label class="group relative">
                                        <input
                                            type="radio"
                                            name="color"
                                            value="{{ $color }}"
                                            class="peer sr-only"
                                            {{ $selected ? 'checked' : '' }}
                                        >
                                        <span
                                            class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-transparent bg-gradient-to-br {{ $colorGradients[$color] ?? $colorGradients['slate'] }} text-white shadow transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-400 peer-checked:border-white peer-checked:ring-4 peer-checked:ring-slate-900/10"
                                            title="{{ Str::ucfirst($color) }}"
                                        >
                                            @if ($selected)
                                                <span class="text-xl">★</span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </label>
                    </div>
                    <label class="flex flex-col gap-2 text-sm font-medium text-slate-700">
                        本文
                        <textarea
                            name="content"
                            required
                            rows="5"
                            maxlength="5000"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-base text-slate-800 shadow-sm transition focus:border-transparent focus:outline-none focus:ring-2 focus:ring-slate-400/60"
                            placeholder="ひらめいたこと、やること、心に残った言葉などを自由に書き留めましょう。"
                        >{{ $createContent }}</textarea>
                    </label>
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <label class="inline-flex items-center gap-3 text-sm font-medium text-slate-600">
                            <input type="checkbox" name="is_pinned" value="1" class="h-5 w-5 rounded border-slate-300 text-slate-800 focus:ring-slate-500" {{ $createPinned ? 'checked' : '' }}>
                            メモをピン留めする
                        </label>
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-700"
                        >
                            <span>メモを追加</span>
                            <span class="text-lg">→</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <section class="mx-auto flex w-full max-w-6xl flex-col gap-6">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-xl font-semibold text-slate-900 sm:text-2xl">保存されたメモ</h2>
                <p class="text-sm text-slate-500">{{ $memos->count() }} 件</p>
            </div>

            @if ($memos->isEmpty())
                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50/60 p-12 text-center text-slate-500">
                    まだメモがありません。新しいアイデアを追加してみましょう！
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($memos as $memo)
                        <article
                            class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg shadow-slate-200/60 transition hover:-translate-y-1 hover:shadow-xl"
                        >
                            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r {{ $colorGradients[$memo->color] ?? $colorGradients['slate'] }}"></div>
                            <div class="flex flex-col gap-4 p-7">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $memo->title }}</h3>
                                        <p class="mt-1 text-xs text-slate-400">
                                            更新: {{ $memo->updated_at->format('Y/m/d H:i') }}
                                        </p>
                                    </div>
                                    @if ($memo->is_pinned)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            📌 PINNED
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm leading-relaxed text-slate-600 whitespace-pre-line">
                                    {{ $memo->content }}
                                </p>
                                <details class="group/edit rounded-2xl border border-slate-200 bg-slate-50/80 p-4 text-sm text-slate-600 transition open:bg-white open:shadow-inner">
                                    <summary class="cursor-pointer select-none font-semibold text-slate-700 transition hover:text-slate-900">
                                        メモを編集する
                                    </summary>
                                    <form
                                        action="{{ route('memos.update', $memo) }}"
                                        method="POST"
                                        class="mt-4 flex flex-col gap-4"
                                    >
                                        @csrf
                                        @method('PUT')
                                        @php
                                            $isCurrent = (int) old('memo_id') === $memo->id;
                                            $currentTitle = $isCurrent ? old('title', $memo->title) : $memo->title;
                                            $currentColor = $isCurrent ? old('color', $memo->color) : $memo->color;
                                            $currentContent = $isCurrent ? old('content', $memo->content) : $memo->content;
                                            $currentPinned = $isCurrent ? (bool) old('is_pinned', false) : (bool) $memo->is_pinned;
                                        @endphp
                                        <input type="hidden" name="memo_id" value="{{ $memo->id }}">
                                        <label class="flex flex-col gap-1 text-xs font-medium text-slate-500">
                                            タイトル
                                            <input
                                                type="text"
                                                name="title"
                                                value="{{ $currentTitle }}"
                                                maxlength="120"
                                                required
                                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400"
                                            >
                                        </label>
                                        <label class="flex flex-col gap-2 text-xs font-medium text-slate-500">
                                            カラー
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($palette as $color)
                                                    @php
                                                        $selected = $currentColor === $color;
                                                    @endphp
                                                    <label class="group relative">
                                                        <input
                                                            type="radio"
                                                            name="color"
                                                            value="{{ $color }}"
                                                            class="peer sr-only"
                                                            {{ $selected ? 'checked' : '' }}
                                                        >
                                                        <span
                                                            class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-gradient-to-br {{ $colorGradients[$color] ?? $colorGradients['slate'] }} text-xs text-white shadow peer-checked:border-white peer-checked:ring-2 peer-checked:ring-slate-900/10"
                                                            title="{{ Str::ucfirst($color) }}"
                                                        >
                                                            @if ($selected)
                                                                ✓
                                                            @endif
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </label>
                                        <label class="flex flex-col gap-1 text-xs font-medium text-slate-500">
                                            本文
                                            <textarea
                                                name="content"
                                                rows="4"
                                                maxlength="5000"
                                                required
                                                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-1 focus:ring-slate-400"
                                            >{{ $currentContent }}</textarea>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600">
                                            <input
                                                type="checkbox"
                                                name="is_pinned"
                                                value="1"
                                                class="h-4 w-4 rounded border-slate-300 text-slate-800 focus:ring-slate-500"
                                                {{ $currentPinned ? 'checked' : '' }}
                                            >
                                            ピン留めする
                                        </label>
                                        <div class="flex items-center justify-between">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-700"
                                            >
                                                更新する
                                            </button>
                                            <button
                                                type="submit"
                                                form="delete-memo-{{ $memo->id }}"
                                                class="inline-flex items-center gap-2 rounded-full bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-600 shadow-sm transition hover:bg-rose-500/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-500"
                                                onclick="return confirm('メモを削除しますか？')"
                                            >
                                                削除する
                                            </button>
                                        </div>
                                    </form>
                                    <form
                                        id="delete-memo-{{ $memo->id }}"
                                        action="{{ route('memos.destroy', $memo) }}"
                                        method="POST"
                                        class="hidden"
                                    >
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </details>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
