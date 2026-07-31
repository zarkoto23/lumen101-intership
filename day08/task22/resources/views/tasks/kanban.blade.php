<x-app-layout>

    <x-slot name="header">
        Kanban
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">


            @foreach([
                'new' => 'New',
                'in_progress' => 'In Progress',
                'review' => 'Review',
                'completed' => 'Completed'
            ] as $status => $title)


            <div class="bg-white p-4 rounded shadow">


                <h2 class="font-bold mb-4">
                    {{ $title }}
                </h2>



                @forelse($tasks[$status] ?? [] as $task)

                    <div class="border p-3 mb-3 rounded">


                        <p class="font-bold">
                            {{ $task->title }}
                        </p>


                        <p>
                            Deadline:
                            {{ $task->deadline }}
                        </p>


                        <a href="{{ route('tasks.show', $task) }}">
                            View
                        </a>


                    </div>


                @empty

                    <p>
                        No tasks
                    </p>

                @endforelse


            </div>


            @endforeach


        </div>

    </div>


</x-app-layout>