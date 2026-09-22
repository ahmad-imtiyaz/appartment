<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'apartment_unit_number' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['penyewa', 'pemilik', 'agent'])],
            'daerah' => ['required', Rule::in(['Jakarta'])],
            'apartment_location_id' => ['required', 'exists:apartment_locations,id'],
            'apartment_tower_id' => [
                'required',
                Rule::exists('apartment_towers', 'id')
                    ->where(fn ($q) => $q->where('apartment_location_id', $this->apartment_location_id)),
            ],
        ];
    }
}
