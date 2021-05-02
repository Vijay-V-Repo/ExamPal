<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->isTeacher();
    }

    public function prepareForValidation()
    {
        $questions = [];

        for($q = 1; $q <= (int)$this->questions_count; $q++){
            $questions[$q] = ['question' => $this->get('question_' . $q)];
            for ($o = 1; $o <= (int)$this->get('questions_' . $q . '_options_count'); $o++){
                $questions[$q]['options'][$o] = $this->get('question_' . $q . '_' . $o);
            }
            $questions[$q]['answer'] = $this->get('question_' . $q . '_options');
            $questions[$q]['marks'] = $this->get('question_' . $q . '_marks');
        }

        $this->merge([
            'questions' => $questions
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:128'],
            'guidelines' => ['required', 'string', 'max:2500'],
            'total_time' => ['required', 'numeric'],
            'start_after' => ['required', 'date'],
            'due'=> ['required', 'date'],
            'image' => ['nullable', 'file', 'image'],
            'questions' => ['required', 'array'],
        ];
    }
}
