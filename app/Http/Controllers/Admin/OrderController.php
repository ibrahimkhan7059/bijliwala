<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('total_amount', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Amount range filter
        if ($request->filled('amount_range')) {
            $range = explode('-', $request->amount_range);
            if (count($range) == 2) {
                $query->whereBetween('total_amount', [$range[0], $range[1]]);
            } elseif ($request->amount_range === '50000+') {
                $query->where('total_amount', '>=', 50000);
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = 'desc';
        
        if (str_ends_with($sortField, '_desc')) {
            $sortField = str_replace('_desc', '', $sortField);
            $sortDirection = 'desc';
        } elseif (str_ends_with($sortField, '_asc')) {
            $sortField = str_replace('_asc', '', $sortField);
            $sortDirection = 'asc';
        } else {
            $sortDirection = 'asc';
        }

        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 25);
        $orders = $query->paginate($perPage);

        // Export functionality
        if ($request->get('export') === 'csv') {
            return $this->exportOrders($query);
        }

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'notes' => 'nullable|string|max:1000'
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'admin_notes' => $request->notes,
        ]);

        return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return redirect()->route('admin.orders.index')
                           ->with('error', 'Only cancelled orders can be deleted.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order deleted successfully!');
    }

    /**
     * Export orders to CSV
     */
    private function exportOrders($query)
    {
        $orders = $query->get();
        
        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order ID',
                'Customer Name',
                'Customer Email',
                'Total Amount',
                'Status',
                'Payment Status',
                'Items Count',
                'Order Date',
                'Updated Date'
            ]);

            // CSV data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user->name ?? 'Guest',
                    $order->user->email ?? 'N/A',
                    'PKR ' . number_format($order->total_amount, 2),
                    ucfirst($order->status),
                    ucfirst($order->payment_status),
                    $order->orderItems->count(),
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'monthly_revenue' => Order::where('payment_status', 'paid')
                                    ->whereMonth('created_at', now()->month)
                                    ->sum('total_amount')
        ];
    }
}
