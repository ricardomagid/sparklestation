<?php
/**
 * Process individual cost entry and convert to standardized material format
 *
 * Takes raw cost data from configuration and converts it into a standardized
 * format with proper material objects and quantities adjusted for character rarity
 *
 * @param array $costs Raw cost data from config (credits, path, enemy, etc)
 * @param array $materials Array of material objects indexed by type
 * @param float $creditMultiplier Multiplier for credit costs based on character rarity
 * @param int $charRarityIndex Index for character rarity (0 for 4-star, 1 for 5-star)
 * 
 * @return array Array of cost entries with 'quantity' and 'material' keys
 */
function processCostEntry($costs, $materials, $creditMultiplier, $charRarityIndex) {
    $entry = [];
    
    foreach ($costs as $type => $value) {
        if ($type == 'credits') {
            $entry[] = ['quantity' => $value * $creditMultiplier, 'material' => $materials['credits']];
        } else {
            if (is_array($value)) { // path and enemy mats
                $mat_rarity = array_key_first($value);
                $quantity = $value[$mat_rarity][$charRarityIndex];
                $mat_index = $mat_rarity - 2;
                $final_mat = $materials[$type][$mat_index];
            } else {
                $final_mat = $materials[$type];
                $quantity = $value;
            }
            $entry[] = ['quantity' => $quantity, 'material' => $final_mat];
        }
    }
    
    return $entry;
}
?>