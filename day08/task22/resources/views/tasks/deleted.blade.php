<x-app-layout>

    <x-slot name="header">
        Deleted Tasks
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white p-6 rounded shadow">


                <h2 class="text-xl font-bold">
                    Deleted Tasks
                </h2>


                @forelse($tasks as $task)
                    <div class="mt-6 border p-4 rounded">


                        <h3 class="font-bold">
                            {{ $task->title }}
                        </h3>


                        <p>
                            Project:
                            {{ $task->project->name }}
                        </p>


                        <p>
                            Deleted:
                            {{ $task->deleted_at }}
                        </p>



                        <form method="POST" action="{{ route('tasks.restore', $task->id) }}" class="mt-4">

                            @csrf
                            @method('PATCH')


                            <button type="submit">
                                Restore
                            </button>


                        </form>


                    </div>


                @empty

                    <p class="mt-4">
                        No deleted tasks.
                    </p>
                @endforelse



                <div class="mt-6">

                    {{ $tasks->links() }}

                </div>


            </div>


        </div>

    </div>

</x-app-layout>
