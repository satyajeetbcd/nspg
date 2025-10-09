<div class="row">
    <div class="col-md-6">
        <h6>Order Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Order ID:</strong></td>
                <td>{{ $transaction->order_id }}</td>
            </tr>
            <tr>
                <td><strong>Zodiac Sign:</strong></td>
                <td>{{ ucfirst($transaction->zodiac_sign) }}</td>
            </tr>
            <tr>
                <td><strong>Product:</strong></td>
                <td>{{ $transaction->product_title }}</td>
            </tr>
            <tr>
                <td><strong>Amount:</strong></td>
                <td>₹{{ number_format($transaction->product_price, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Currency:</strong></td>
                <td>{{ $transaction->currency ?? 'INR' }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6>Payment Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Gateway:</strong></td>
                <td>{{ ucfirst($transaction->payment_gateway ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    @if($transaction->payment_status == 'completed')
                        <span class="badge badge-success">Completed</span>
                    @elseif($transaction->payment_status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($transaction->payment_status == 'failed')
                        <span class="badge badge-danger">Failed</span>
                    @elseif($transaction->payment_status == 'refunded')
                        <span class="badge badge-secondary">Refunded</span>
                    @else
                        <span class="badge badge-secondary">{{ ucfirst($transaction->payment_status ?? 'N/A') }}</span>
                    @endif
                </td>
            </tr>
            @if($transaction->payment_id)
            <tr>
                <td><strong>Payment ID:</strong></td>
                <td>{{ $transaction->payment_id }}</td>
            </tr>
            @endif
            @if($transaction->paid_at)
            <tr>
                <td><strong>Paid At:</strong></td>
                <td>{{ $transaction->paid_at->format('M d, Y h:i A') }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h6>Customer Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $transaction->customer->name ?? 'N/A' }}</td>
                <td><strong>Email:</strong></td>
                <td>{{ $transaction->customer->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $transaction->customer->phone ?? 'N/A' }}</td>
                <td><strong>Country:</strong></td>
                <td>{{ $transaction->customer->country ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>IP Address:</strong></td>
                <td>{{ $transaction->ip_address ?? 'N/A' }}</td>
                <td><strong>Created:</strong></td>
                <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
            </tr>
        </table>
    </div>
</div>
@if($transaction->customer_notes)
<div class="row mt-3">
    <div class="col-12">
        <h6>Customer Notes</h6>
        <p class="text-muted">{{ $transaction->customer_notes }}</p>
    </div>
</div>
@endif
