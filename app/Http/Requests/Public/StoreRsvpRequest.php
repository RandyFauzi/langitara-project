<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Invitation;

class StoreRsvpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if invitation exists.
        // We assume invitation_id is passed in the request body.
        return Invitation::where('id', $this->input('invitation_id'))->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invitation_id' => ['required', 'integer', 'exists:invitations,id'],
            'guest_name' => ['required_without:guest_id', 'string', 'max:255'],
            'guest_id' => ['nullable', 'integer', 'exists:guests,id'], // If updating existing guest
            'presence_status' => ['required', Rule::in(['hadir', 'tidak', 'ragu'])],
            'total_guests' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'presence_status' => 'status kehadiran',
            'total_guests' => 'jumlah tamu',
            'guest_name' => 'nama tamu',
        ];
    }
}
