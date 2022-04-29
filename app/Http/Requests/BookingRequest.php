<?php

namespace App\Http\Requests;

use App\Rules\CheckRoomAvailability;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $from = $this->from ? Carbon::parse($this->from)->format('y-m-d') : null;
        $to = $this->to ? Carbon::parse($this->to)->format('y-m-d') : null;

        $this->merge([
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', new CheckRoomAvailability($this->from, $this->to)],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.required' => 'Room field is required.',
            'from.required' => 'Date from field is required.',
            'to.required' => 'Date to field is required.',
            'to.after_or_equal' => 'Date to value must be greater or same as date from value.'
        ];
    }

    public function validated($key = null, $default = null)
    {
        return array_merge(parent::validated($key, $default), [
            'user_id' => auth()->id(),
            'days' => Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to)) + 1
        ]);
    }
}
