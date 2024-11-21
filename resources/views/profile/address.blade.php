@extends('profile_layout')
@section('title', 'profile')
@section('content2')
    <div class="profile_content2">
        <form id="addressForm" action="{{ route('profile.address.update') }}" method="POST">
            @csrf
            <div class="edit_profile">
                <div class="input_info">
                    <h4>จังหวัด</h4>
                    <textarea name="province" placeholder="กรอกจังหวัด">{{ old('province', $address->province ?? '') }}</textarea>
                </div>
                <div class="input_info">
                    <h4>อำเภอ</h4>
                    <textarea name="district" placeholder="กรอกอำเภอ">{{ old('district', $address->district ?? '') }}</textarea>
                </div>
                <div class="input_info">
                    <h4>ตำบล</h4>
                    <textarea name="subdistrict" placeholder="กรอกตำบล">{{ old('subdistrict', $address->subdistrict ?? '') }}</textarea>
                </div>
                <div class="input_info">
                    <h4>รหัสไปรษณีย์</h4>
                    <textarea name="post_code" placeholder="กรอกรหัสไปรษณีย์" pattern="[0-9]*">{{ old('post_code', $address->post_code ?? '') }}</textarea>
                </div>
            </div>
            <div class="myacc">
                <h4>รายละเอียดเพิ่มเติม</h4>
                <textarea name="additional_details" class="profile-text" placeholder="กรอกรายละเอียดเพิ่มเติม">{{ old('additional_details', $address->additional_details ?? '') }}</textarea>
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
                <li class="active">ที่อยู่</li>
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
                <li>ช่องทางการชำระเงิน</li>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('JavaScript loaded'); // ตรวจสอบการโหลด

            const form = document.getElementById('addressForm');
            if (form) {
                console.log('Form found');
            } else {
                console.log('Form not found');
            }

            form.addEventListener('submit', function(event) {
                const postCodeField = document.querySelector('textarea[name="post_code"]');
                const postCodeValue = postCodeField.value.trim();

                console.log('Post code value:', postCodeValue); // ตรวจสอบค่า

                // ตรวจสอบว่ามีช่องว่างหรือไม่
                if (postCodeValue === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ข้อมูลไม่ครบถ้วน',
                        text: 'กรุณากรอกรหัสไปรษณีย์',
                        confirmButtonText: 'ตกลง'
                    });
                    event.preventDefault();
                    return;
                }

                // ตรวจสอบว่ามีตัวอักษรที่ไม่ใช่ตัวเลขหรือไม่
                const postCodePattern = /^[0-9]*$/;
                if (!postCodePattern.test(postCodeValue)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ข้อมูลไม่ถูกต้อง',
                        text: 'กรุณากรอกรหัสไปรษณีย์ที่เป็นตัวเลขเท่านั้น',
                        confirmButtonText: 'ตกลง'
                    });
                    event.preventDefault();
                    return;
                }

                // ตรวจสอบความยาวของรหัสไปรษณีย์
                if (postCodeValue.length !== 5) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ข้อมูลไม่ถูกต้อง',
                        text: 'กรุณากรอกรหัสไปรษณีย์ที่มีความยาว 5 ตัวเลข',
                        confirmButtonText: 'ตกลง'
                    });
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>


@endsection

@if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('status') }}',
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
@endif
