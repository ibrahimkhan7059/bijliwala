<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .section h2 {
            color: #667eea;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f9f9f9;
            padding: 12px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .info-box label {
            font-weight: bold;
            color: #667eea;
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-box value {
            display: block;
            font-size: 16px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table thead {
            background-color: #f0f0f0;
            border-bottom: 2px solid #667eea;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #667eea;
        }
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        table tr:hover {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .total-row td {
            border-bottom: 2px solid #667eea;
        }
        .payment-info {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .payment-info strong {
            color: #856404;
        }
        .address-box {
            background-color: #f0f8ff;
            border-left: 4px solid #17a2b8;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .address-box h4 {
            margin: 0 0 8px 0;
            color: #17a2b8;
        }
        .address-box p {
            margin: 3px 0;
            font-size: 14px;
        }
        .action-buttons {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background-color: #5568d3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cod {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .highlight {
            background-color: #fffacd;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #ffd700;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 New Order Received!</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <!-- Order Summary -->
        <div class="section">
            <h2>Order Summary</h2>
            <div class="order-info">
                <div class="info-box">
                    <label>Order Number</label>
                    <value style="color: #667eea; font-size: 20px;">{{ $order->order_number }}</value>
                </div>
                <div class="info-box">
                    <label>Order Date</label>
                    <value>{{ $order->created_at->format('d M Y, H:i A') }}</value>
                </div>
                <div class="info-box">
                    <label>Payment Method</label>
                    <value>
                        @if($order->payment_method === 'cod')
                            <span class="status-badge status-cod">Cash on Delivery</span>
                        @else
                            <span class="status-badge status-pending">Bank Transfer</span>
                        @endif
                    </value>
                </div>
                <div class="info-box">
                    <label>Payment Status</label>
                    <value>{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</value>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <h2>Customer Information</h2>
            <table>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{ $billingAddress['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>
                        <a href="tel:{{ $billingAddress['phone'] }}">
                            {{ $billingAddress['phone'] ?? 'N/A' }}
                        </a>
                    </td>
                </tr>
                @if($order->user)
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>
                        <a href="mailto:{{ $order->user->email }}">
                            {{ $order->user->email }}
                        </a>
                    </td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Order Items -->
        <div class="section">
            <h2>Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->name }}</strong>
                            @if($item->variation_name)
                                <br><small style="color: #666;">{{ $item->variation_name }}</small>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rs. {{ number_format($item->price) }}</td>
                        <td style="text-align: right; font-weight: bold;">
                            Rs. {{ number_format($item->price * $item->quantity) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Total -->
        <div class="section">
            <h2>Order Total</h2>
            <table>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td style="text-align: right;">Rs. {{ number_format($order->subtotal) }}</td>
                </tr>
                @if($order->shipping_amount > 0)
                <tr>
                    <td><strong>Delivery Charges:</strong></td>
                    <td style="text-align: right;">Rs. {{ number_format($order->shipping_amount) }}</td>
                </tr>
                @else
                <tr>
                    <td><strong>Delivery Charges:</strong></td>
                    <td style="text-align: right; color: green;">
                        <strong>FREE ✓</strong>
                    </td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total Amount:</strong></td>
                    <td style="text-align: right; font-size: 18px;">Rs. {{ number_format($order->total_amount) }}</td>
                </tr>
            </table>
        </div>

        <!-- Delivery Address -->
        <div class="section">
            <h2>Delivery Address</h2>
            <div class="address-box">
                <h4>📍 Shipping Address</h4>
                <p>
                    {{ $shippingAddress['name'] ?? 'N/A' }}<br>
                    {{ $shippingAddress['address'] ?? 'N/A' }}<br>
                    @if($shippingAddress['postal_code'] ?? null)
                        Postal Code: {{ $shippingAddress['postal_code'] }}<br>
                    @endif
                    <strong>📞 {{ $shippingAddress['phone'] ?? 'N/A' }}</strong>
                </p>
            </div>
        </div>

        <!-- Payment Information -->
        @if($order->payment_method === 'bank_transfer' && $order->payment_proof)
        <div class="highlight">
            <strong>💳 Bank Transfer Payment:</strong><br>
            Payment proof uploaded. You can verify the payment and update the status from the admin panel.
            @if($order->payment_proof)
                <br><a href="{{ asset('storage/' . $order->payment_proof) }}" style="color: #667eea; text-decoration: underline;">View Payment Proof</a>
            @endif
        </div>
        @elseif($order->payment_method === 'cod')
        <div class="payment-info">
            <strong>💰 Cash on Delivery:</strong><br>
            Payment will be collected from customer at the time of delivery. Delivery charges: <strong>Rs. {{ $order->shipping_amount }}</strong>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">
                View Order Details
            </a>
            <a href="tel:{{ $billingAddress['phone'] }}" class="btn btn-secondary">
                Call Customer
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated notification from Bijliwala Admin Panel.</p>
            <p>Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Bijliwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
