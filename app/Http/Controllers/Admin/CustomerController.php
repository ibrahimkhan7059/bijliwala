<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->withCount(['orders']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('email_verified_at');
            } elseif ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            }
        }

        // Registration date filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Orders count filter
        if ($request->filled('orders_filter')) {
            switch ($request->orders_filter) {
                case 'no_orders':
                    $query->has('orders', '=', 0);
                    break;
                case 'has_orders':
                    $query->has('orders', '>', 0);
                    break;
                case 'frequent':
                    $query->has('orders', '>=', 5);
                    break;
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
        $customers = $query->paginate($perPage);

        // Export functionality
        if ($request->get('export') === 'csv') {
            return $this->exportCustomers($query);
        }

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'email_verified' => 'boolean'
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'email_verified_at' => $request->email_verified ? now() : null
        ]);

        return redirect()->route('admin.customers.index')
                        ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        // Ensure we're only showing customers
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->loadCount(['orders']);
        $recentOrders = $customer->orders()
                                ->with(['orderItems.product'])
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();

        $totalSpent = $customer->orders()
                              ->where('payment_status', 'paid')
                              ->sum('total_amount');

        return view('admin.customers.show', compact('customer', 'recentOrders', 'totalSpent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        // Ensure we're only editing customers
        if ($customer->role !== 'customer') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        // Ensure we're only updating customers
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'email_verified' => 'boolean'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified_at' => $request->email_verified ? now() : null
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $customer->update($updateData);

        return redirect()->route('admin.customers.show', $customer)
                        ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        // Ensure we're only deleting customers
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Check if customer has orders
        if ($customer->orders()->exists()) {
            return redirect()->route('admin.customers.index')
                           ->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
                        ->with('success', 'Customer deleted successfully!');
    }

    /**
     * Export customers to CSV
     */
    private function exportCustomers($query)
    {
        $customers = $query->get();
        
        $filename = 'customers_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Email Verified',
                'Orders Count',
                'Registration Date',
                'Last Login'
            ]);

            // CSV data
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? 'N/A',
                    $customer->email_verified_at ? 'Yes' : 'No',
                    $customer->orders_count,
                    $customer->created_at->format('Y-m-d H:i:s'),
                    $customer->updated_at->format('Y-m-d H:i:s')
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
            'total_customers' => User::where('role', 'customer')->count(),
            'verified_customers' => User::where('role', 'customer')->whereNotNull('email_verified_at')->count(),
            'new_customers_this_month' => User::where('role', 'customer')
                                            ->whereMonth('created_at', now()->month)
                                            ->count(),
            'customers_with_orders' => User::where('role', 'customer')
                                         ->whereHas('orders')
                                         ->count()
        ];
    }
}
