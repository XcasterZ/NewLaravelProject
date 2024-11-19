<!doctype html>
<html lang="en">

<head>
    <title>SADUAKPRA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#login-form').on('submit', function(event) {
                event.preventDefault();

                const username = $('input[name="username"]').val();
                const password = $('input[name="password"]').val();

                $.ajax({
                    url: '{{ route('auth.login') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'เข้าสู่ระบบสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = '{{ url('/') }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อผิดพลาด',
                                text: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                    }
                });
            });

            // Forgot Password form submit handler
            $('#forgot-password-form').on('submit', function(event) {
                event.preventDefault();

                const email = $('input[name="email"]').val();
                const submitButton = $(this).find('button[type="submit"]');

                // Disable button while processing
                submitButton.prop('disabled', true);
                submitButton.text('กำลังส่ง...');

                $.ajax({
                    url: '{{ route('auth.password.email') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ส่งลิงก์สำเร็จ',
                            text: 'ลิงก์สำหรับรีเซ็ตรหัสผ่านถูกส่งไปยังอีเมลของคุณแล้ว'
                        }).then(() => {
                            $('#forgot-password-form')[0].reset();
                            $('#forgotPasswordModal').modal('hide');
                        });
                    },
                    error: function(xhr) {
                        console.error('Error:', {
                            status: xhr.status,
                            response: xhr.responseText
                        });

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            const errorMessages = Object.values(errors).flat().join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อผิดพลาด',
                                text: errorMessages
                            });
                        } else if (xhr.status === 400) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'โปรดรอสักครู่',
                                text: 'กรุณารอสักครู่ก่อนลองใหม่'
                            });
                        } else if (xhr.status === 429) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'ดำเนินการบ่อยเกินไป',
                                text: 'คุณได้พยายามหลายครั้งเกินไป กรุณารอสักครู่'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ข้อผิดพลาด',
                                text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
                            });
                        }
                    },
                    complete: function() {
                        // Re-enable button and reset text
                        submitButton.prop('disabled', false);
                        submitButton.text('ส่งลิงค์เปลี่ยนรหัสผ่าน');
                    }
                });
            });

            // Reset form when modal is closed
            $('#forgotPasswordModal').on('hidden.bs.modal', function() {
                $('#forgot-password-form')[0].reset();
                const submitButton = $('#forgot-password-form').find('button[type="submit"]');
                submitButton.prop('disabled', false);
                submitButton.text('ส่งลิงค์เปลี่ยนรหัสผ่าน');
            });
        });
    </script>
</head>

<body>
    <div class="section">
        <div class="section text-center">
            <div class="form-container">
                <h4 class="mb-4 pb-3 ">เข้าสู่ระบบ</h4>
                <form id="login-form" action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" class="form-style" placeholder="ชื่อผู้ใช้" title="กรอกชื่อผู้ใช้" required
                        oninvalid="this.setCustomValidity('กรุณากรอกชื่อผู้ใช้')" 
                        oninput="this.setCustomValidity('')" >
                        <i class="input-icon uil uil-user"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input type="password" name="password" class="form-style" placeholder="รหัสผ่าน" title="กรอกรหัสผ่าน" required
                        oninvalid="this.setCustomValidity('กรุณากรอกรหัสผ่าน')" 
                        oninput="this.setCustomValidity('')">
                        <i class="input-icon uil uil-lock-alt"></i>
                    </div>
                    <div>
                        <button type="submit" class="btn mt-4">เข้าสู่ระบบ</button>
                        <br>
                        <button type="button" class="btn mt-4 google"
                            onclick="window.location.href='{{ route('auth.google.redirect') }}'">Google</button>
                        <button type="button" class="btn mt-4 facebook"
                            onclick="window.location.href='{{ route('auth.facebook.redirect') }}'">Facebook</button>
                    </div>
                </form>
                <p class="mb-0 mt-4 text-center">
                    <a href="#" class="link" data-toggle="modal" data-target="#forgotPasswordModal">ลืมรหัสผ่าน?</a>
                </p>
                <p class="mb-0 mt-4 text-center">
                    <a href="{{ route('auth.register') }}" class="link">ยังไม่มีบัญชี?</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel" style="color: black;">เปลี่ยนรหัสผ่าน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="forgot-password-form">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="example@example.com"
                                required oninvalid="this.setCustomValidity('กรุณากรอกอีเมล')" 
                                oninput="this.setCustomValidity('')" title="">
                        </div>
                        <div class="form-group text-center" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary btn-block">ส่งลิงค์เปลี่ยนรหัสผ่าน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.querySelector('input[name="username"]');
        const passwordInput = document.querySelector('input[name="password"]');

        usernameInput.addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove any non-alphanumeric characters
            event.target.value = value.replace(/[^A-Za-z0-9]/g, '');
        });

        passwordInput.addEventListener('input', function(event) {
            const value = event.target.value;
            // Remove spaces
            event.target.value = value.replace(/\s+/g, '');
        });
    });
</script>
<style>
    .facebook {
        background-color: #4267B2;
        color: white;
    }

    .google {
        background-color: #DB4437;
        color: white;
    }

    .modal-content {
        padding: 20px;
        border-radius: 10px;
    }

    .modal-body {
        padding: 20px;
    }

    .btn-block {
        width: 100%;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
    }

    .modal-header {
        border-bottom: none;
        /* position: absolute; */
        z-index: 1050;
    }

    .modal-title {
        font-weight: bold;
    }

    .close {
        font-size: 1.5rem;
        position: absolute;
        right: 15px;
        top: 15px;
        z-index: 1051;
        padding: 0.5rem;
        cursor: pointer;
        border: none;
        background: none;
    }

    .close:focus {
        outline: none;
        box-shadow: none;
    }

    .close:hover {
        opacity: 0.75;
    }

    .modal-dialog-centered {
        display: flex;
        justify-content: center;
    }

    .btn-primary {
        background-color: #007BFF;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .close-icon {
        z-index: 1054;
    }
</style>

</html>
