<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use Exception;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $products = Product::with('category')->orderBy('name')->paginate(20);
        return view('inventory.index', compact('products'));
    }

    public function create()
    {
        $categories = InventoryCategory::all();
        return view('inventory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string',
            'alert_level' => 'required|integer|min:0',
        ]);

        try {
            $labId = 1; // Default
            $this->inventoryService->createProduct($request->except('_token'), $labId);
            return redirect()->route('inventory.index')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Show form to add/remove stock
    public function adjust($id)
    {
        $product = Product::findOrFail($id);
        return view('inventory.adjust', compact('product'));
    }

    // Process stock adjustment
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:add,remove',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string'
        ]);

        try {
            $labId = 1;
            $this->inventoryService->adjustStock(
                $id, 
                $request->quantity, 
                $request->type, 
                $request->reason, 
                $labId,
                auth()->id() // Log the user if authenticated
            );

            return redirect()->route('inventory.index')->with('success', 'Stock updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
