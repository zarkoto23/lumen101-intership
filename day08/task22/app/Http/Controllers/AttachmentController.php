<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAttachmentRequest;

class AttachmentController extends Controller
{
    public function store(StoreAttachmentRequest $request, Task $task)
    {
        if (
            !$task->project->users()
                ->where('users.id', auth()->id())
                ->exists()
            &&
            $task->project->owner_id !== auth()->id()
        ) {
            abort(403);
        }


        $validated = $request->validated();


        $file = $request->file('file');


        $path = $file->store('attachments');


        $task->attachments()->create([
            'user_id' => auth()->id(),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);


        return back()
            ->with('success', 'Файлът е качен успешно.');
    }

    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);


        if (Storage::exists($attachment->file_path)) {
            Storage::delete($attachment->file_path);
        }


        $attachment->delete();


        return back()
            ->with('success', 'Файлът е изтрит успешно.');
    }
}
