<?php

namespace App\Models\Concerns;

/**
 * Shared by CartItem and OrderItem so a basket line and the order line it
 * becomes describe themselves the same way.
 */
trait NormalisesToppings
{
    /**
     * Older baskets reported every ticked option as `added`, including the
     * pre-selected ones already reported as `kept`, so each ingredient was
     * listed twice: "With: Lettuce" and then "+ Lettuce, Tomato...". The
     * customise popup no longer does that, but baskets and orders taken before
     * the fix still carry the duplicates, so drop them on the way out.
     *
     * Anything carrying a charge stays on the "+" line whatever else it appears
     * in - the basket, the checkout and the kitchen slip all have to account
     * for the money either way.
     */
    protected function withoutDuplicatedKeeps(array $toppings): array
    {
        if (empty($toppings['kept']) || empty($toppings['added'])) {
            return $toppings;
        }

        $kept = array_map([$this, 'toppingKey'], $toppings['kept']);

        $toppings['added'] = array_values(array_filter(
            $toppings['added'],
            fn ($t) => (float) ($t['price'] ?? 0) > 0
                || ! in_array($this->toppingKey($t), $kept, true)
        ));

        return $toppings;
    }

    /** Match on id where the snapshot recorded one, otherwise on the name. */
    protected function toppingKey(array $topping): string
    {
        return isset($topping['id'])
            ? 'id:' . $topping['id']
            : 'name:' . mb_strtolower(trim($topping['name'] ?? ''));
    }
}
