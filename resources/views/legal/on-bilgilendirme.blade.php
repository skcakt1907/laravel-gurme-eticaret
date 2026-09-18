<h4>1. Seller Information</h4>
<ul>
    <li><strong>Trade name:</strong> {{ setting('firma_unvan', setting('site_adi')) }}</li>
    <li><strong>Brand:</strong> {{ setting('site_adi') }}</li>
    <li><strong>Address:</strong> {{ setting('adres') }}</li>
    @if(setting('ticaret_sicil_no'))<li><strong>Trade Registry No:</strong> {{ setting('ticaret_sicil_no') }}</li>@endif
    @if(setting('mersis_no'))<li><strong>MERSIS No:</strong> {{ setting('mersis_no') }}</li>@endif
    @if(setting('vergi_dairesi'))<li><strong>Tax Office / No:</strong> {{ setting('vergi_dairesi') }} — {{ setting('vergi_no') }}</li>@endif
    <li><strong>Phone:</strong> {{ setting('telefon') }}</li>
    <li><strong>Email:</strong> {{ setting('eposta') }}</li>
    @if(setting('kep'))<li><strong>KEP:</strong> {{ setting('kep') }}</li>@endif
</ul>

<h4>2. Subject</h4>
<p>The purpose of this Pre-Information Form is to determine the parties' rights and obligations regarding the sale and delivery of the products ordered electronically by the BUYER from the {{ setting('site_adi') }} ({{ request()->getHost() }}) website, in accordance with Turkish Law No. 6502 on Consumer Protection and the Regulation on Distance Contracts.</p>

<h4>3. Product and Payment Information</h4>
<p>The essential qualities of the ordered products, the sale price (VAT included), the payment method and delivery details are communicated to the BUYER on the order confirmation page and in the order confirmation email. Listed prices are current sale prices.</p>

<h4>4. Right of Withdrawal</h4>
<p>The BUYER has the right to withdraw from the contract within <strong>14 (fourteen) days</strong> of receiving the product, without giving any reason and without paying any penalty. To exercise this right, notifying {{ setting('eposta') }} within this period is sufficient.</p>
<p>Products that cannot be returned by their nature (opened foodstuffs, perishable products or those likely to pass their use-by date, etc.) are outside the scope of the right of withdrawal.</p>

<h4>5. Delivery</h4>
<p>Products are delivered by courier to the address specified by the BUYER within 30 days at the latest following confirmation of payment. The shipping cost is stated on the cart and checkout pages before the order is confirmed.</p>

<h4>6. Dispute Resolution</h4>
<p>For disputes arising from this contract, the Consumer Arbitration Committees and Consumer Courts are competent according to the value limits announced by the Ministry of Trade.</p>
