{{-- resources/views/checkout.blade.php --}}

<form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    {{-- Input Alamat --}}
    <div class="mb-4">
        <label>Alamat Lengkap Pengiriman</label>
        <textarea name="customer_address" class="form-control" required></textarea>
    </div>

    {{-- Input WhatsApp (Opsional tapi disarankan) --}}
    <div class="mb-4">
        <label>Nomor WhatsApp</label>
        <input type="text" name="customer_phone" class="form-control" required>
    </div>

    {{-- Input Bukti Transfer --}}
    <div class="mb-4">
        <label>Unggah Bukti Transfer (Gambar)</label>
        <input type="file" name="payment_proof" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-full">Selesaikan Pesanan</button>
</form>