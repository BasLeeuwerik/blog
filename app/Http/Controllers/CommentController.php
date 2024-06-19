<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        return view('posts.show', [
            'comments' => Comment::with('user')->latest()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment($validated);
        $comment->user_id = $request->user()->id;
        $comment->post_id = $validated['post_id'];
        $comment->save();

        $post = $validated['post_id'];

        return redirect()->route('posts.show', $post);
    }

    public function edit(Comment $comment)
    {
        // Implementation of edit method for comments
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|max:255',
            // Add any additional validation rules as needed
        ]);

        $comment->update($validated);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return redirect(route('posts.index'));
    }
}
