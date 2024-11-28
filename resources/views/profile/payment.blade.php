@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        <form id="paymentForm" action="{{ route('profile.payment.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="edit_profile">
                <div class="input_info">
                    <h4>ชื่อธนาคาร</h4>
                    <textarea id="bank_name" name="bank_name" class="form-control" placeholder="กรอกชื่อธนาคาร">{{ old('bank_name', $payment->bank_name ?? '') }}</textarea>
                    @error('bank_name')
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>หมายเลขบัญชี</h4>
                    <textarea id="account_number" name="account_number" placeholder="กรอกหมายเลขบัญชี">{{ old('account_number', $payment->account_number ?? '') }}</textarea>
                    @error('account_number')
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>ชื่อเจ้าของบัญชี</h4>
                    <textarea id="account_name" name="account_name" placeholder="กรอกชื่อเจ้าของบัญชี">{{ old('account_name', $payment->account_name ?? '') }}</textarea>
                    @error('account_name')
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info">
                    <h4>TrueWallet</h4>
                    <textarea id="truewallet_phone" name="truewallet_phone" placeholder="กรอกเบอร์มือถือ TrueWallet">{{ old('truewallet_phone', $payment->truewallet_phone ?? '') }}</textarea>
                    <small class="hint">* กรุณากรอกเบอร์มือถือที่ผูกกับ TrueWallet (เช่น 0812345678)</small>
                    @error('truewallet_phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input_info" style="display: flex; flex-direction: column; gap: 10px;">
                    <h4>อัพโหลด QR Code</h4>
                    
                    <!-- ซ่อน input file เดิม -->
                    <input type="file" name="qr_image" accept="image/*" id="qr_image_input" style="display: none;">
                    
                    <!-- ปุ่มที่จะแทน input file -->
                    <button type="button" id="custom_button" style="padding: 10px; background-color: #1B1A55; color: white; border: none; cursor: pointer; border-radius:10px">
                        เลือกรูปภาพ
                    </button>
                
                    <!-- แสดงชื่อไฟล์ที่เลือก -->
                    <div id="file_name" style="color: gray; font-style: italic; display: block;">
                        ยังไม่ได้เลือกรูป
                    </div>
                
                    @error('qr_image')
                        <small style="color: red">{{ $message }}</small>
                    @enderror
                
                    @if ($payment->qr_image)
                        <div class="input_info" style="display: flex; flex-direction: column; gap: 10px; align-items: center;">
                            <h4>QR Code ที่อัพโหลด</h4>
                            <img src="{{ asset('storage/' . $payment->qr_image) }}" alt="QR Code" width="100px" height="160px">
                        </div>
                    @endif

                    
                </div>
            </div>
            <div class="save">
                <button type="submit">บันทึก</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตรวจสอบกรอกข้อมูลในช่อง "ชื่อธนาคาร"
            document.getElementById('bank_name').addEventListener('input', function(event) {
                const bankName = event.target.value;

                // ตรวจสอบหากมีตัวเลขหรืออักขระพิเศษในชื่อธนาคาร
                const bankNamePattern = /^[A-Za-zก-๙\s]*$/; // อนุญาตเฉพาะตัวอักษรภาษาไทย/อังกฤษและช่องว่าง

                if (!bankNamePattern.test(bankName)) {
                    // ลบตัวอักษรที่ไม่ถูกต้องออก
                    event.target.value = bankName.replace(/[^A-Za-zก-๙\s]/g, '');
                }
            });

            // ตรวจสอบกรอกข้อมูลในช่อง "หมายเลขบัญชี"
            document.getElementById('account_number').addEventListener('input', function(event) {
                const accountNumber = event.target.value;

                // ตรวจสอบหากมีตัวอักษรหรือตัวอักขระพิเศษในหมายเลขบัญชี
                const accountNumberPattern = /^[0-9]*$/; // อนุญาตเฉพาะตัวเลข

                if (!accountNumberPattern.test(accountNumber)) {
                    // ลบตัวอักษรที่ไม่ใช่ตัวเลขออก
                    event.target.value = accountNumber.replace(/[^0-9]/g, '');
                }
            });

            // ตรวจสอบกรอกข้อมูลในช่อง "TrueWallet"
            document.getElementById('truewallet_phone').addEventListener('input', function(event) {
                let trueWalletPhone = event.target.value;

                // ตรวจสอบหากมีตัวอักษรหรือตัวอักขระพิเศษในเบอร์ TrueWallet
                const trueWalletPattern = /^[0-9]*$/; // อนุญาตเฉพาะตัวเลข

                if (!trueWalletPattern.test(trueWalletPhone)) {
                    // ลบตัวอักษรที่ไม่ใช่ตัวเลขออก
                    trueWalletPhone = trueWalletPhone.replace(/[^0-9]/g, '');
                }

                // จำกัดจำนวนตัวเลขไม่เกิน 10 ตัว
                if (trueWalletPhone.length > 10) {
                    trueWalletPhone = trueWalletPhone.slice(0, 10);
                }

                // อัพเดตค่าในฟอร์ม
                event.target.value = trueWalletPhone;
            });

            document.getElementById('custom_button').addEventListener('click', function() {
                document.getElementById('qr_image_input').click();
            });

            // เมื่อเลือกไฟล์แล้ว
            document.getElementById('qr_image_input').addEventListener('change', function(event) {
                var fileName = event.target.files[0] ? event.target.files[0].name : 'ยังไม่ได้เลือกรูป';
                var fileNameDisplay = document.getElementById('file_name');

                if (fileName === 'ยังไม่ได้เลือกรูป') {
                    fileNameDisplay.style.display = 'block';
                    fileNameDisplay.textContent = 'ยังไม่ได้เลือกรูป';
                } else {
                    fileNameDisplay.style.display = 'block';
                    fileNameDisplay.textContent = 'เลือกไฟล์: ' + fileName;
                }
            });
        });
    </script>


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

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '{{ session('error') }}',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
@endif

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
