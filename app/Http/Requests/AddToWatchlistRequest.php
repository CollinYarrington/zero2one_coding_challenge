<?php

namespace App\Http\Requests;

use App\Rules\MaxWatchlistRule;
use Illuminate\Foundation\Http\FormRequest;

class AddToWatchlistRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', new MaxWatchlistRule(auth()->user())],
            'imdb_id' => 'required|unique:watchlists',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }

    public function messages()
    {
        return [
            'imdb_id.unique' => 'That movie is already in your watchlist',
        ];
    }
}
