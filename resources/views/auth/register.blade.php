  <!doctype html>
  <html lang="en">

  <head>
      <title>SADUAKPRA</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="css/login.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
          // Function to restrict input to alphanumeric characters only
          function restrictAlphanumericInput(event) {
              const allowedPattern = /^[A-Za-z0-9]*$/;
              const inputChar = String.fromCharCode(event.which);
              d
              if (!allowedPattern.test(inputChar)) {
                  event.preventDefault();
              }
          }

          // Function to restrict input to digits only
          function restrictDigitsInput(event) {
              const allowedPattern = /^[0-9]*$/;
              const inputChar = String.fromCharCode(event.which);

              if (!allowedPattern.test(inputChar)) {
                  event.preventDefault();
              }
          }

          // Function to restrict email input to valid characters
          function restrictEmailInput(event) {
              const allowedPattern = /^[A-Za-z0-9._@+-]*$/;
              const inputChar = String.fromCharCode(event.which);

              if (!allowedPattern.test(inputChar)) {
                  event.preventDefault();
              }
          }

          // Function to restrict password input to valid characters
          function restrictPasswordInput(event) {
              const allowedPattern = /^[a-zA-Z0-9!@#$%^&*()_+={}\[\]|\\:;"'<>,.?/-]*$/;
              const inputChar = String.fromCharCode(event.which);

              if (!allowedPattern.test(inputChar)) {
                  event.preventDefault();
              }
          }

          function checkExistingData() {
              const username = document.querySelector('input[name="username"]').value;
              const email = document.querySelector('input[name="email"]').value;

              return $.ajax({
                  url: '{{ secure_url(route('check.existing.data')) }}',
                  method: 'POST',
                  data: {
                      _token: '{{ csrf_token() }}',
                      username: username,
                      email: email
                  }
              });
          }
          document.addEventListener('DOMContentLoaded', function() {
              const form = document.querySelector('form');
              form.addEventListener('submit', function(event) {
                  event.preventDefault();
                  checkExistingData().done(function(response) {
                      let message = '';

                      if (response.existsUsername && response.existsEmail) {
                          message = 'Username and Email already exist.';
                      } else if (response.existsUsername) {
                          message = 'Username already exists.';
                      } else if (response.existsEmail) {
                          message = 'Email already exists.';
                      }

                      if (message) {
                          alert(message);
                      } else {
                          // ส่งข้อมูลการลงทะเบียน
                          $.ajax({
                              url: '{{ route('auth.register') }}',
                              method: 'POST',
                              data: {
                                  _token: '{{ csrf_token() }}',
                                  username: document.querySelector('input[name="username"]')
                                      .value,
                                  phone_number: document.querySelector(
                                      'input[name="phone_number"]').value,
                                  email: document.querySelector('input[name="email"]').value,
                                  password: document.querySelector('input[name="password"]')
                                      .value
                              },
                              success: function(response) {
                                  if (response.success && response.otp_required) {
                                      console.log("Opening OTP modal...");
                                      $('#otpModal').modal('show');
                                  } else {
                                      alert('Registration successful!'); // ถ้าไม่มี OTP
                                      window.location.href = '{{ route('auth.login') }}';
                                  }
                              },
                              error: function(xhr) {
                                  alert(xhr.responseJSON.message || 'An error occurred.');
                              }
                          });
                      }
                  }).fail(function() {
                      alert('An error occurred while checking data.');
                  });
              });

              // OTP verification event listener
              document.getElementById('verifyOtp').addEventListener('click', function() {
                  const enteredOtp = document.getElementById('otp').value;

                  $.ajax({
                      url: '{{ route('verify.otp') }}',
                      method: 'POST',
                      data: {
                          _token: '{{ csrf_token() }}',
                          otp: enteredOtp,
                          email: document.querySelector('input[name="email"]').value
                      },
                      success: function(response) {
                          if (response.success) {
                              alert('Registration successful!');
                              window.location.href = '{{ route('auth.login') }}';
                          } else {
                              alert('Invalid OTP. Please try again.');
                          }
                      },
                      error: function(xhr) {
                          alert(xhr.responseJSON.message || 'An error occurred.');
                      }
                  });
              });
          });
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

  </head>

  <body>
    <div class="section">
        <div class="section text-center">
            <div class="form-container">
                <h4 class="mb-3 pb-3">สมัครสมาชิก</h4>
                <form method="POST" action="{{ route('auth.register') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" class="form-style"
                            placeholder="ชื่อผู้ใช้" pattern="[A-Za-z0-9]+"
                            title="ชื่อผู้ใช้ต้องเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น ห้ามมีช่องว่าง" required
                            onkeypress="restrictAlphanumericInput(event)">
                        <i class="input-icon uil uil-user"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input type="tel" name="phone_number" class="form-style"
                            placeholder="เบอร์โทร" pattern="[0-9]{10}"
                            title="เบอร์โทรศัพท์ต้องมี 10 หลัก" maxlength="10"
                            required onkeypress="restrictDigitsInput(event)">
                        <i class="input-icon uil uil-phone"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input type="email" name="email" class="form-style"
                            placeholder="อีเมล"
                            pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}"
                            title="อีเมลต้องอยู่ในรูปแบบที่ถูกต้อง" required
                            onkeypress="restrictEmailInput(event)">
                        <i class="input-icon uil uil-at"></i>
                    </div>
                    <div class="form-group mt-2">
                        <input type="password" name="password" class="form-style"
                            placeholder="รหัสผ่าน" pattern="[A-Za-z0-9!@#$%^&*()_+]{8,}"
                            title="รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร และประกอบด้วยตัวอักษร ตัวเลข และอักขระพิเศษ"
                            required onkeypress="restrictPasswordInput(event)">
                        <i class="input-icon uil uil-lock-alt "
                            style="color: white; cursor: pointer;"></i>
                        <small class="form-text text-muted mt-2">
                            ต้องมีอย่างน้อย 8 ตัวอักษร และรองรับตัวอักษร: a-z, A-Z, 0-9, !@#$%^&*()_+={}\[\]|\\:;"'<>,.?/-
                        </small>
                    </div>
                    <button type="submit" class="btn mt-4">สมัครสมาชิก</button>
                    <p class="mb-0 mt-4 text-center">
                        <a href="{{ route('auth.login') }}" class="link">มีบัญชีอยู่แล้ว?</a>
                    </p>
                </form>
            </div>
        </div>  
    </div>

      <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered"  role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="otpModalLabel" style="color: black;">กรอกรหัส OTP</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <input type="text" id="otp" class="form-control" placeholder="Enter OTP" required>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="verifyOtp">ยืนยัน OTP</button>
                  </div>
              </div>
          </div>
      </div>
  </body>

  </html>

  <style>
    .modal-dialog-centered {
        display: flex;
        justify-content: center;
    }

    .close:focus {
        outline: none;
        box-shadow: none;
    }

    .close:hover {
        opacity: 0.75;
    }
  </style>