<?php

namespace App\Traits;

use App\Models\AddStockLogs;
use App\Models\OrderLog;
use App\Models\Product;
use App\Models\ReturnStockLog;
use App\Models\WareHouse;
use App\Models\StockTransferLogs;
use App\Models\ReturnStockDetail;

trait StockTrait
{
    public function getProductTotalQuantity($productId, $warehouse_id = null)
    {
        $stockIn = AddStockLogs::where('product_id', $productId)
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            })
            ->selectRaw('COALESCE(SUM(unit_qty), 0) as total_quantity')
            ->first();

        $stockOut = OrderLog::where('product_id', $productId)
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            })
            ->selectRaw('COALESCE(SUM(unit_qty), 0) as total_quantity')
            ->first();

        $returnStock = ReturnStockLog::where('product_id', $productId)
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            })
            ->selectRaw('COALESCE(SUM(return_qty), 0) as total_quantity')
            ->first();

        $transfer_stockIn = StockTransferLogs::where('product_id', $productId)
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                $query->where('to_warehouse_id', $warehouse_id)
                    ->where('status', 'Transfered')
                    ->whereNotIn('status', ['Cancelled']);
            })
            ->selectRaw('COALESCE(SUM(transfer_quantity), 0) as total_quantity')
            ->first();

        $transfer_stockOut = StockTransferLogs::where('product_id', $productId)
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                $query->where('from_warehouse_id', $warehouse_id)
                    ->whereNotIn('status', ['Cancelled']);
            })
            ->selectRaw('COALESCE(SUM(transfer_quantity), 0) as total_quantity')
            ->first();

        $returnStockDetail = ReturnStockDetail::where('product_id', $productId)
        ->when($warehouse_id, function ($query) use ($warehouse_id) {
            $query->where('warehouse_id', $warehouse_id);
        })
        ->whereHas('returnStock',function ($query){
            $query->where('status','!=','Cancelled');
        })
        ->selectRaw('COALESCE(SUM(unit_qty), 0) as total_quantity')
        ->first();

        $totalTransferStockIn = $transfer_stockIn ? $transfer_stockIn->total_quantity : 0;
        $totalTransferStockOut = $transfer_stockOut ? $transfer_stockOut->total_quantity : 0;
        $totalStockIn = $stockIn ? $stockIn->total_quantity : 0;
        $totalStockOut = $stockOut ? $stockOut->total_quantity : 0;
        $totalReturnQty = $returnStock ? $returnStock->total_quantity : 0;
        $totalReturnStockDetailQty = $returnStockDetail ? $returnStockDetail->total_quantity : 0;

        $grandTotalStockIn =  $totalStockIn + $totalTransferStockIn;
        $grandTotalStockOut =  $totalStockOut + $totalTransferStockOut + $totalReturnQty + $totalReturnStockDetailQty;

        return max(0, $grandTotalStockIn - $grandTotalStockOut);
    }

    public function getAvailableStockByWarehouse($warehouseId = null)
    {
        $products = Product::all();
        $warehouses = $warehouseId ? [Warehouse::find($warehouseId)] : Warehouse::all();
        $stockData = [];
        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                $totalQuantity = $this->getProductTotalQuantity($product->id, $warehouse->id);
                if ($totalQuantity > 0) {
                    $stockData[] = [
                        'warehouse_id' => $warehouse->id,
                        'warehouse_name' => $warehouse->abbreviation,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'category_name' => $product->category->name,
                        'total_quantity' => $totalQuantity
                    ];
                }
            }
        }
        return $stockData;
    }
}