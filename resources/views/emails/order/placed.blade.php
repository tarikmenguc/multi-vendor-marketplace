<x-mail::message>
# Siparişiniz Alındı!

Merhaba {{ $order->user->name }},

Siparişiniz başarıyla alındı. Detaylar aşağıdadır:

---

**Sipariş Numarası:** #{{ $order->id }}  
**Toplam Tutar:** ₺{{ $order->total }}  
**Durum:** {{ ucfirst($order->status) }}

---

<x-mail::button :url="''">
Siparişinizi Görüntüleyin
</x-mail::button>

Teşekkür ederiz.<br>
{{ config('app.name') }}
</x-mail::message>
