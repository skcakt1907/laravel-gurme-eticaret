@component('emails.layout', ['title' => 'New Order'])
<h1 style="font-size:22px;margin:0 0 6px;">New Order Received</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">
    <strong style="color:#8a6a1f;">{{ $order->order_no }}</strong> has been received.
</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 0 18px;">
    <tr><td style="padding:4px 0;color:#6b7280;width:140px;">Customer</td><td style="padding:4px 0;">{{ $order->name }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Phone</td><td style="padding:4px 0;">{{ $order->phone }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Email</td><td style="padding:4px 0;">{{ $order->email }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Payment</td><td style="padding:4px 0;">{{ ucfirst($order->payment_method) }} ({{ $order->payment_status }})</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Address</td><td style="padding:4px 0;">{{ $order->address }}{{ $order->district ? ', ' . $order->district : '' }}, {{ $order->city }}</td></tr>
    @if($order->note)
    <tr><td style="padding:4px 0;color:#6b7280;">Note</td><td style="padding:4px 0;">{{ $order->note }}</td></tr>
    @endif
</table>

@include('emails.partials.order-table')

<p style="margin:24px 0 0;">
    <a href="{{ route('admin.orders.show', $order) }}" style="display:inline-block;background:#8a6a1f;color:#ffffff;text-decoration:none;padding:11px 22px;border-radius:8px;font-size:14px;font-weight:bold;">View Order</a>
</p>
@endcomponent
