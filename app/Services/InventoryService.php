<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Adjust stock level for a product and log the transaction.
     *
     * @param int $productId
     * @param int $quantity Change amount (always positive for logic, type determines sign)
     * @param string $type 'add', 'remove', 'adjustment'
     * @param string|null $reason
     * @param int $labId
     * @param int|null $userId
     * @return Product
     * @throws Exception
     */
    public function adjustStock(int $productId, int $quantity, string $type, ?string $reason, int $labId, ?int $userId = null)
    {
        DB::beginTransaction();

        try {
            $product = Product::where('id', $productId)->where('lab_id', $labId)->lockForUpdate()->firstOrFail();

            // Calculate new quantity
            if ($type === 'add') {
                $product->quantity += $quantity;
            } elseif ($type === 'remove') {
                if ($product->quantity < $quantity) {
                    throw new Exception("Insufficient stock. Current: {$product->quantity}, Requested: {$quantity}");
                }
                $product->quantity -= $quantity;
            } elseif ($type === 'adjustment') {
                // For adjustment, we might want to set absolute value or diff. 
                // PRD implies 'adjust' might be correction. Let's assume it acts like set or diff.
                // For safety in this iteration, let's treat 'adjustment' as a signed visual log, 
                // but usually it implies finding a discrepancy. 
                // Let's implement it as: quantity passed is what we act on based on sign? 
                // To keep it simple and standard: 
                // If type is adjustment, we assume the quantity passed IS the difference (positive or negative).
                // But the param says $quantity.
                // Let's stick to strict types: 'add' (purchase), 'remove' (usage). 
                // If 'adjustment', we need to know if we are adding or removing. 
                // Let's assume the UI handles the math and calls add/remove, OR 'adjustment' means strict set.
                // Let's stick to add/remove for now.
                throw new Exception("Use 'add' or 'remove' types for stock changes.");
            }

            $product->save();

            // Log the transaction
            InventoryLog::create([
                'lab_id' => $labId,
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => $quantity, // Log the change amount
                'reason' => $reason,
                'user_id' => $userId,
            ]);

            DB::commit();
            return $product;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data, int $labId)
    {
        $data['lab_id'] = $labId;
        return Product::create($data);
    }
}
