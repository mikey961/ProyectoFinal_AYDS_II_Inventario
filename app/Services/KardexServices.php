<?php
namespace App\Services;

use App\Models\Inventory;

class KardexServices 
{
    public function getLastKardex($productId, $warehouseId) {
        //Kardex
        $lastKardex = Inventory::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->latest('id')
            ->first();
        
        return [
            'quantity' => $lastKardex?->quantity_balance ?? 0,
            'cost' => $lastKardex?->cost_balance ?? 0,
            'total' => $lastKardex?->total_balance ?? 0,
            'date' => $lastKardex?->created_at ?? null
        ];
    }

    public function registerEntry($model, array $product, $warehouseId, $detail) {
        $lastKardex = $this->getLastKardex($product['id'], $warehouseId);

        $newQuantityBalance = $lastKardex['quantity'] + $product['quantity'];
        $newTotalBalance = $lastKardex['total'] + ($product['quantity'] * $product['price']);
        $newCostBalance = $newTotalBalance / $newQuantityBalance;

        $model->inventories()->create([
            'detail' => $detail,
            'quantity_in' => $product['quantity'],
            'cost_in' => $product['price'],
            'total_in' => $product['quantity'] * $product['price'],  
            'quantity_balance' => $newQuantityBalance,
            'cost_balance' => $newCostBalance,
            'total_balance' => $newTotalBalance,
            'product_id' => $product['id'],
            'warehouse_id' => $warehouseId
        ]);
    }

    public function registerExit($model, array $product, $warehouseId, $detail) {
        $lastKardex = $this->getLastKardex($product['id'], $warehouseId);

        $newQuantityBalance = $lastKardex['quantity'] - $product['quantity'];
        $newTotalBalance = $lastKardex['total'] - ($product['quantity'] * $lastKardex['cost']);
        $newCostBalance = $newTotalBalance / ($newQuantityBalance ?: 1);

        $model->inventories()->create([
            'detail' => $detail,
            'quantity_out' => $product['quantity'],
            'cost_out' => $lastKardex['cost'],
            'total_out' => $product['quantity'] * $lastKardex['cost'],  
            'quantity_balance' => $newQuantityBalance,
            'cost_balance' => $newCostBalance,
            'total_balance' => $newTotalBalance,
            'product_id' => $product['id'],
            'warehouse_id' => $warehouseId
        ]);
    }
}