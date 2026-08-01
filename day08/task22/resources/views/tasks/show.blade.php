<x-app-layout>

    <x-slot name="header">
        Task Details
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 sm:px-8">


            <div class="bg-white p-6 rounded shadow">


                <h1>
                    {{ $task->title }}
                </h1>


                <p>
                    {{ $task->description }}
                </p>


                <p>
                    Project:
                    {{ $task->project->name }}
                </p>


                <p>
                    Assigned to:
                    {{ $task->assignedUser->name }}
                </p>


                <p>
                    Status:
                    {{ $task->status }}
                </p>


                <p>
                    Priority:
                    {{ $task->priority }}
                </p>


                <p>
                    Deadline:
                    {{ $task->deadline }}
                </p>


            </div>


            <div class="mt-6">

                <a href="{{ route('tasks.edit', $task) }}">
                    Edit Task
                </a>


            </div>


            <div class="mt-6">

                <form method="POST" action="{{ route('tasks.destroy', $task) }}">

                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Delete Task
                    </button>

                </form>

            </div>

            <div class="mt-8">

                <h2>
                    Comments
                </h2>


                @foreach ($task->comments as $comment)
                    <div class="border p-3 mt-3">

                        <p>
                            {{ $comment->user->name }}
                        </p>

                        <p>
                            {{ $comment->content }}
                        </p>


                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">

                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Delete
                            </button>

                        </form>


                    </div>
                @endforeach


                <form method="POST" action="{{ route('comments.store', $task) }}" class="mt-5">

                    @csrf


                    <textarea name="content"></textarea>


                    <button type="submit">
                        Add Comment
                    </button>


                </form>

                <div class="mt-8">

                    <h2>
                        Attachments
                    </h2>


                    @foreach ($task->attachments as $attachment)
                        <div class="border p-3 mt-3">

                            <p>
                                {{ $attachment->original_name }}
                            </p>


                            <form method="POST" action="{{ route('attachments.destroy', $attachment) }}">

                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Delete
                                </button>

                            </form>

                        </div>
                    @endforeach



                    <form method="POST" action="{{ route('attachments.store', $task) }}" enctype="multipart/form-data"
                        class="mt-5">

                        @csrf


                        <input type="file" name="file">


                        <button type="submit">
                            Upload
                        </button>


                    </form>


                </div>


            </div>

            <div class="mt-8">

                <h2>
                    Status History
                </h2>


                @foreach ($task->statusHistories as $history)
                    <div class="border p-3 mt-3">

                        <p>
                            {{ $history->user->name }}
                        </p>

                        <p>
                            {{ $history->old_status }}
                            →
                            {{ $history->new_status }}
                        </p>


                        <p>
                            {{ $history->created_at }}
                        </p>

                    </div>
                @endforeach


            </div>

        </div>

    </div>


</x-app-layout>
