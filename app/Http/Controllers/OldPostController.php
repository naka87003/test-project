<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('post.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('test');

        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400'
        ]);

        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return back()->with('message', '保存しました');
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400'
        ]);
        $validated['user_id'] = auth()->id();
        $post->update($validated);

        return back()->with('message', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index')->with('message', '削除しました');
    }
}
