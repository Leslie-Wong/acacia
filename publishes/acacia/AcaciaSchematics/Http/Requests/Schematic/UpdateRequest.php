<?php

namespace Acacia\AcaciaSchematics\Http\Requests\Schematic;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaSchematics\Models\Schematic;
class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "table_name" => ["sometimes", "string"],
            "model_class" => ["nullable", "string"],
            "controller_class" => ["nullable", "string"],
            "route_name" => ["nullable", "string"],
            "generated_at" => ["nullable", "date"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("update", $this->schematic);
    }

    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();
        //Add your code for manipulation with request data here
        return $sanitized;
    }
    /**
     * Return modified (sanitized data) as a php object
     * @return  object
     */
    public function sanitizedObject(): object
    {
        return json_decode(collect($this->sanitizedArray()));
    }
}
