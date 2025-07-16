<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can("product.create");//bu isteği yapan kullanıcının bir ürün
        //oluşturup oluşturmama yetkisine sahip olup olmadığı
        //"?" kullanılma nedeni eğer giriş yapan user yoksa hata yerine null dön 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:150',
            'price'       => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'tag_ids'     => 'array',
            'tag_ids.*'   => 'exists:tags,id',
            'description' => 'nullable|string',
        ];
    }
}
