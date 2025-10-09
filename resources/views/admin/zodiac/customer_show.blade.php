<div class="row">
    <div class="col-md-6">
        <h6>Personal Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Customer ID:</strong></td>
                <td>{{ $customer->id }}</td>
            </tr>
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $customer->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    @if($customer->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-secondary">Inactive</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6>Location Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Country:</strong></td>
                <td>{{ $customer->country ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>City:</strong></td>
                <td>{{ $customer->city ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $customer->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>IP Address:</strong></td>
                <td>{{ $customer->ip_address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>User Agent:</strong></td>
                <td>
                    <small class="text-muted">{{ Str::limit($customer->user_agent, 50) ?? 'N/A' }}</small>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h6>Account Information</h6>
        <table class="table table-sm">
            <tr>
                <td><strong>Joined Date:</strong></td>
                <td>{{ $customer->created_at->format('M d, Y h:i A') }}</td>
                <td><strong>Last Updated:</strong></td>
                <td>{{ $customer->updated_at->format('M d, Y h:i A') }}</td>
            </tr>
            @if($customer->email_verified_at)
            <tr>
                <td><strong>Email Verified:</strong></td>
                <td>{{ $customer->email_verified_at->format('M d, Y h:i A') }}</td>
                <td></td>
                <td></td>
            </tr>
            @endif
        </table>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h6>Transaction Summary</h6>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4 class="text-primary">{{ $customer->transactions->count() }}</h4>
                        <p class="mb-0">Total Transactions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4 class="text-success">₹{{ number_format($customer->transactions->where('payment_status', 'completed')->sum('product_price'), 2) }}</h4>
                        <p class="mb-0">Total Spent</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4 class="text-info">{{ $customer->is_active ? 'Active' : 'Inactive' }}</h4>
                        <p class="mb-0">Account Status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($customer->transactions->count() > 0)
<div class="row mt-3">
    <div class="col-12">
        <h6>Recent Transactions</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Zodiac Sign</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->transactions->take(5) as $transaction)
                        <tr>
                            <td>{{ $transaction->order_id }}</td>
                            <td>{{ ucfirst($transaction->zodiac_sign) }}</td>
                            <td>{{ $transaction->product_title }}</td>
                            <td>₹{{ number_format($transaction->product_price, 2) }}</td>
                            <td>
                                @if($transaction->payment_status == 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($transaction->payment_status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($transaction->payment_status == 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($transaction->payment_status) }}</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($customer->transactions->count() > 5)
            <p class="text-muted text-center mt-2">
                Showing 5 of {{ $customer->transactions->count() }} transactions
            </p>
        @endif
    </div>
</div>
@else
<div class="row mt-3">
    <div class="col-12">
        <h6>Transaction History</h6>
        <p class="text-muted text-center">No transactions found for this customer.</p>
    </div>
</div>
@endif
