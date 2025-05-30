<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateProductRequest extends FormRequest
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
 * @return array<string, 
\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
 */
 public function rules(): array
 {
 return [
 'code' => 'required|string|max:255|unique:products,code,'.$this->product->id,
 'name' => 'required|string|max:255',
 'quantity' => 'required|integer|min:0',
 'price' => 'required|numeric|min:0',
 'description' => 'nullable|string',
 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
 ];
 }
}