<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Http\Requests\StoreCommentRequest;
use App\Models\User;
use App\Notifications\NewCommentNotification;


class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Task $task)
    {
        $this->authorize('view', $task);
        $validated = $request->validated();
        $comment = $task->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $users = $task->project
            ->users()
            ->where('users.id', '!=', auth()->id())
            ->get();


        foreach ($users as $user) {

            $user->notify(
                new NewCommentNotification($comment)
            );
        }
        return back()->with('success', 'Коментарът е добавен успешно.');
    }
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Коментарът е изтрит успешно.');
    }
}
