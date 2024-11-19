<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
            font-weight: 300;
            line-height: 1.7;
            color: #ffffff;
            background-color: #1f2029;
            overflow: hidden;
            height: 100vh;
            background: radial-gradient(ellipse at bottom, #1B1A55 0%, #12141d 100%);
        }

        .reset-container {
            font-family: 'Kanit', sans-serif;
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            max-width: 500px;
            margin: 50px auto;
        }

        .reset-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .reset-header h5 {
            color: black;
            margin: 0;
        }

        .reset-body {
            padding: 20px 0;
        }

        .reset-footer {
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            margin-top: 20px;
            text-align: right;
        }

        .form-control {
            background-color: white;
            color: black;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            background-color: white;
            color: black;
            border-color: #80bdff;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        label {
            font-weight: 500;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="reset-container">
            <div class="reset-header">
                <h5>รีเซ็ตรหัสผ่าน</h5>
            </div>
            <form id="reset-password-form">
                <div class="reset-body">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email">อีเมล:</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email') }}" placeholder="กรุณากรอกอีเมล" required>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่านใหม่:</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="กรุณากรอกรหัสผ่านใหม่" required>
                        <small class="form-text error-message">รหัสผ่านต้องมีอย่างน้อย 8 ตัว และรองรับตัวอักษร: a-z,
                            A-Z, 0-9, !@#$%^&*()_+={}\[\]|\\:;"'<>,.?/-</small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">ยืนยันรหัสผ่าน:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="กรุณายืนยันรหัสผ่านใหม่" required>
                    </div>
                </div>
                <div class="reset-footer">
                    <a href="{{ route('login') }}" class="btn btn-secondary">กลับไปหน้าเข้าสู่ระบบ</a>
                    <button type="submit" class="btn btn-primary">รีเซ็ตรหัสผ่าน</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#reset-password-form').on('submit', function(e) {
                e.preventDefault(); // หยุดการส่งฟอร์มแบบปกติ

                const email = $('#email').val();
                const password = $('#password').val();
                const passwordConfirmation = $('#password_confirmation').val();
                const token = $('input[name="token"]').val();

                const allowedPattern = /^[a-zA-Z0-9!@#$%^&*()_+={}\[\]|\\:;"'<>,.?/-]*$/;

                // ตรวจสอบรหัสผ่านให้ตรงกันและมีเงื่อนไข
                if (password !== passwordConfirmation) {
                    Swal.fire({
                        title: "ข้อผิดพลาด!",
                        text: "รหัสผ่านไม่ตรงกัน",
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    });
                    return; // หยุดการส่งฟอร์ม
                }

                if (password.length < 8 || !allowedPattern.test(password)) {
                    Swal.fire({
                        title: "ข้อผิดพลาด!",
                        text: "รหัสผ่านต้องมีอย่างน้อย 8 หลักและใช้ตัวอักษรที่รองรับ",
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    });
                    return; // หยุดการส่งฟอร์ม
                }

                $.ajax({
                    url: '{{ route('password.update') }}',
                    method: 'POST',
                    data: {
                        email: email,
                        password: password,
                        password_confirmation: passwordConfirmation,
                        token: token,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "สำเร็จ!",
                            text: "รีเซ็ตรหัสผ่านสำเร็จ",
                            icon: "success",
                            confirmButtonText: "ตกลง"
                        }).then(() => {
                            window.location.href =
                            '{{ route('login') }}'; // Redirect to login
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // ตรวจสอบว่าเป็นข้อผิดพลาดการตรวจสอบ
                            const errors = xhr.responseJSON;
                            if (errors.error) {
                                Swal.fire({
                                    title: "ข้อผิดพลาด!",
                                    text: "อีเมลไม่ตรง",
                                    icon: "error",
                                    confirmButtonText: "ตกลง"
                                });
                            } else {
                                Swal.fire({
                                    title: "ข้อผิดพลาด!",
                                    text: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                                    icon: "error",
                                    confirmButtonText: "ตกลง"
                                });
                            }
                        } else {
                            Swal.fire({
                                title: "ข้อผิดพลาด!",
                                text: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                                icon: "error",
                                confirmButtonText: "ตกลง"
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
