@php
    $user = auth()->user();
    $trxs = \App\Models\Transaction::where('sender_id', $user->id)
        ->orWhere('receiver_id', $user->id);
@endphp

<x-layout app>
    <x-layout.section title="Dashboard" />
    
    <x-view.row>
        <x-card.info title="Balance"      value="Rp {{ $user->balance }}" icon="fa-money-bills-wave text-primary" />
        <x-card.info title="Total Topup"  value="86" icon="fa-coins text-gray-300" color="warning" />
        <x-card.info title="Total Buying" value="48" icon="fa-cart-shopping text-gray-300" color="success" />
        <x-card.info title="Total Refund" value="10" icon="fa-clock-rotate-left text-gray-300" color="danger" />
    </x-view.row>
</x-layout.section>