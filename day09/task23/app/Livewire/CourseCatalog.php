<?php

namespace App\Livewire;


use App\Models\Course;

use Livewire\Component;
use Livewire\WithPagination;


class CourseCatalog extends Component
{

    use WithPagination;



    public string $search = '';

    public string $level = '';

    public string $sort = 'latest';




    protected $queryString = [

        'search',

        'level',

        'sort',

    ];





    public function updatingSearch()
    {

        $this->resetPage();
    }




    public function render()
    {


        $courses = Course::query()


            ->where('status', 'published')



            ->when(

                $this->search,

                function ($query) {

                    $query->where(
                        'title',
                        'like',
                        '%' . $this->search . '%'
                    );
                }

            )



            ->when(

                $this->level,

                function ($query) {

                    $query->where(
                        'level',
                        $this->level
                    );
                }

            )



            ->when(

                $this->sort === 'price',

                fn($query) =>
                $query->orderBy('price')

            )



            ->when(

                $this->sort === 'latest',

                fn($query) =>
                $query->latest()

            )



            ->paginate(6);



        return view(
            'livewire.course-catalog',
            compact('courses')
        );
    }
}
