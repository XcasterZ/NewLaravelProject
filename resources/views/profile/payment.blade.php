@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        <form id="paymentForm" action="{{ route('profile.payment.update') }}" method="POST">
            @csrf
            <div class="edit_profile">
                <div class="input_info">
                    <h4>ชื่อธนาคาร</h4>
                    <textarea name="bank_name" class="form-control" placeholder="กรอกชื่อธนาคาร" required>{{ old('bank_name', $payment->bank_name ?? '') }}</textarea>
                    @error('bank_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>หมายเลขบัญชี</h4>
                    <textarea name="account_number"     
                           placeholder="กรอกหมายเลขบัญชี">{{ old('account_number', $payment->account_number ?? '') }}</textarea>
                    @error('account_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>ชื่อเจ้าของบัญชี</h4>
                    <textarea name="account_name" 
                           placeholder="กรอกชื่อเจ้าของบัญชี">{{ old('account_name', $payment->account_name ?? '') }}</textarea>
                    @error('account_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>TrueWallet</h4>
                    <textarea name="truewallet_phone" 
                           placeholder="กรอกเบอร์มือถือ TrueWallet">{{ old('truewallet_phone', $payment->truewallet_phone ?? '') }}</textarea>
                    <small class="hint">* กรุณากรอกเบอร์มือถือที่ผูกกับ TrueWallet (เช่น 0812345678)</small>
                    @error('truewallet_phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="save">
                <button type="submit">บันทึก</button>
            </div>
        </form>
    </div>
@endsection

@section('profile_menu')
    <div class="profile_menu">
        <ul>
            <a href="{{ route('profile.edit') }}">
                <li>โปรไฟล์</li>
            </a>
            <a href="{{ route('profile.address') }}">
                <li>ที่อยู่</li>
            </a>
            <a href="{{ route('cart.show') }}">
                <li>ตะกร้า</li>
            </a>
            <a href="{{ route('wishlist.show') }}">
                <li>พระที่ถูกใจ</li>
            </a>
            <a href="{{ route('profile.sell') }}">
                <li>ลงขายพระ</li>
            </a>
            <a href="{{ route('profile.payment') }}">
                <li class="active">ช่องทางการชำระเงิน</li>
            </a>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; color: inherit; cursor: pointer; width:100%">ออกจากระบบ</button>
                </form>
            </li>
        </ul>
    </div>
@endsection

@if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: '{{ session('status') }}',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
@endif
