<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\StoreManagement\StoreItem;

use Illuminate\Foundation\Http\FormRequest;

class DeductStoreItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_store_item_id' => ['required', 'uuid', 'exists:school_store_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'remark' => ['required', 'string', 'between:1,1000']
        ];
    }

    public function messages(): array
    {
        return [
            'school_store_item_id.required' => 'The store item is required.',
            'school_store_item_id.uuid' => 'The store item ID must be a valid UUID.',
            'school_store_item_id.exists' => 'The selected store item does not exist in the inventory.',

            'quantity.required' => 'Please specify the quantity to withdraw.',
            'quantity.integer' => 'The quantity must be a valid number.',
            'quantity.min' => 'The quantity must be at least 1 to proceed with the withdrawal.',

            'remark.required' => 'A remark is required to complete this transaction.',
            'remark.string' => 'The remark must be a valid text entry.',
            'remark.between' => 'The remark must be between 1 and 1000 characters.',
        ];
    }
}
