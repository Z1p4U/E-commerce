<?php

namespace App\Rules;

use App\Models\Item;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckItemQuantity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $item) {
            $item = Item::find($item['item_id']);
            if (!$item || $item->total_stock < $item['quantity']) {
                $fail($item->name . ' is out of stock');
            }
        }
    }
}
