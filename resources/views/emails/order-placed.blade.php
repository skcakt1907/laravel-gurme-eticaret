@component('emails.layout', ['title' => 'Your Order Is Received'])
<h1 style="font-size:22px;margin:0 0 6px;">Your Order Is Received! 🎉</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">
    Hello <strong>{{ $order->name }}</strong>, your order has been placed successfully.
    Your order number: <strong style="color:#8a6a1f;">{{ $order->order_no }}</strong>
</p>

@if($order->payment_method === 'havale' && $order->payment_status !== 'paid')
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;padding:16px 18px;margin:0 0 18px;">
    <p style="margin:0 0 10px;font-size:15px;font-weight:bold;color:#065f46;">Bank Transfer Details</p>
    <p style="margin:0 0 10px;font-size:14px;line-height:1.6;color:#374151;">
        When sending <strong>{{ money($order->total) }}</strong> to the account below, add
        <strong>{{ $order->order_no }}</strong> as the payment reference.
    </p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr><td style="padding:3px 0;color:#6b7280;width:120px;">Bank</td><td style="padding:3px 0;">{{ setting('havale_banka') }}</td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">Account Name</td><td style="padding:3px 0;">{{ setting('havale_hesap_adi') }}</td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">IBAN</td><td style="padding:3px 0;"><strong>{{ setting('havale_iban') }}</strong></td></tr>
        <tr><td style="padding:3px 0;color:#6b7280;">Reference</td><td style="padding:3px 0;"><strong>{{ $order->order_no }}</strong></td></tr>
    </table>
</div>
@elseif($order->payment_method === 'kapida')
<div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px 18px;margin:0 0 18px;font-size:14px;color:#92400e;">
    You will pay <strong>on delivery</strong>. Your order is being prepared.
</div>
@elseif($order->payment_status === 'paid')
<div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;padding:14px 18px;margin:0 0 18px;font-size:14px;color:#065f46;">
    Your payment was received. We've started preparing your order.
</div>
@endif

<h3 style="font-size:16px;margin:18px 0 4px;">Order Summary</h3>
@include('emails.partials.order-table')

<h3 style="font-size:16px;margin:22px 0 4px;">Delivery</h3>
<p style="font-size:14px;line-height:1.6;color:#374151;margin:0;">
    {{ $order->name }}<br>
    {{ $order->phone }}<br>
    {{ $order->address }}{{ $order->district ? ', ' . $order->district : '' }}, {{ $order->city }}
</p>

<p style="font-size:13px;color:#6b7280;margin:24px 0 0;line-height:1.6;">
    For questions about your order, contact us at {{ setting('telefon') }} or
    {{ setting('eposta') }} .
</p>
@endcomponent
