<?php

namespace App\Http\Requests;

use App\Enums\RepeateOptions;
use App\Enums\WeekDays;
use App\Rules\CheckTime;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;


class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'startDate' => 'required|date|date_format:Y-m-d',
            'endDate' => ['nullable','date','date_format:Y-m-d'],
            'startTime' => 'required|date_format:H:i',
            'endTime' => ['required','date_format:H:i', new CheckTime($this->get('startTime'))],
            'repeate' => ['required', new Enum(RepeateOptions::class)],
            'repeateDay' => [Rule::requiredIf(fn() => $this->get('repeate') != RepeateOptions::NEVER->value), new Enum(WeekDays::class)]
        ];
    }

    public function messages()
    {
        return [
            'endTime.gt' => 'A foglalás végpontjának nagyobb kell legyen mint a kezdeti',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json(['errors' => $errors->messages(), 'isSuccess' => false], 422);

        throw new HttpResponseException($response);
    }
}
