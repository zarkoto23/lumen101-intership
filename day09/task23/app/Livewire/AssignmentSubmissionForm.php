<?php

namespace App\Livewire;


use App\Models\Assignment;
use App\Models\AssignmentSubmission;


use Illuminate\Support\Facades\Auth;


use Livewire\Component;
use Livewire\WithFileUploads;



class AssignmentSubmissionForm extends Component
{


    use WithFileUploads;



    public Assignment $assignment;


    public $file;


    public string $comment = '';






    public function submit()
    {


        $student = Auth::user();



        if (!$student || !$student->isStudent()) {

            abort(403);

        }




        $enrolled = $this->assignment

            ->course

            ->enrollments()

            ->where(
                'student_id',
                $student->id
            )

            ->exists();





        if(!$enrolled){

            session()->flash(
                'error',
                'You are not enrolled in this course.'
            );

            return;

        }





        if(
            $this->assignment->deadline
            &&
            now()->gt($this->assignment->deadline)
        ){


            session()->flash(
                'error',
                'Deadline passed.'
            );


            return;

        }







        $this->validate([


            'file'=>'required|file|max:5120',


            'comment'=>'nullable|string|max:1000',


        ]);







        $path = $this->file->store(
            'assignments',
            'public'
        );






        AssignmentSubmission::updateOrCreate(

            [

                'assignment_id'=>$this->assignment->id,

                'student_id'=>$student->id,

            ],

            [

                'file_path'=>$path,

                'comment'=>$this->comment,

                'submitted_at'=>now(),

                'status'=>'submitted',

            ]

        );





        session()->flash(

            'success',

            'Assignment submitted.'

        );





        $this->reset(
            [
                'file',
                'comment'
            ]
        );


    }







    public function render()
    {

        return view(
            'livewire.assignment-submission-form'
        );

    }


}