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
    </script>
    <script>
      // Function to check for existing username or email
      function checkExistingData() {
        const username = document.querySelector('input[name="username"]').value;
        const email = document.querySelector('input[name="email"]').value;
    
        return $.ajax({
          url: '{{ secure_url(route("check.existing.data")) }}',
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
              form.submit(); // Submit form if no duplicates
            }
          }).fail(function() {
            alert('An error occurred while checking data.');
          });
        });
      });
    </script>
  </head>

  <body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <div class="section">
      <div class="container">
        <div class="row full-height justify-content-center">
          <div class="col-12 text-center align-self-center py-5">
            <div class="section pb-5 pt-5 pt-sm-2 text-center">
              <div class="card-3d-wrap mx-auto">
                <div class="card-3d-wrapper">
                  <div class="card-back">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 class="mb-3 pb-3">Sign Up</h4>
                        <form method="POST" action="{{ route('auth.register') }}">
                          @csrf
                          <div class="form-group">
                            <input type="text" name="username" class="form-style" placeholder="Username"
                              pattern="[A-Za-z0-9]+" title="Username must be alphanumeric with no spaces" required
                              onkeypress="restrictAlphanumericInput(event)">
                            <i class="input-icon uil uil-user"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="tel" name="phone_number" class="form-style" placeholder="Phone Number"
                              pattern="[0-9]{10}" title="Phone number must be 10 digits long" maxlength="10" required
                              onkeypress="restrictDigitsInput(event)">
                            <i class="input-icon uil uil-phone"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="email" name="email" class="form-style" placeholder="Email"
                              pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}" title="Email must be a valid email address" required
                              onkeypress="restrictEmailInput(event)">
                            <i class="input-icon uil uil-at"></i>
                          </div>
                          <div class="form-group mt-2">
                            <input type="password" name="password" class="form-style" placeholder="Password"
                              pattern="[A-Za-z0-9!@#$%^&*()_+]{8,}" title="Password must be at least 8 characters long and include letters, numbers, and special characters" required
                              onkeypress="restrictPasswordInput(event)">
                            <i class="input-icon uil uil-lock-alt " style="color: white; cursor: pointer;"></i>
                            <small class="form-text text-muted mt-2">
                              Minimum 8 digits and Supported characters: a-z, A-Z, 0-9, !@#$%^&*()_+={}\[\]|\\:;"'<>,.?/-
                            </small>
                          </div>
                          <button type="submit" class="btn mt-4">Register</button>
                          <p class="mb-0 mt-4 text-center">
                            <a href="{{route('auth.login') }}" class="link">already have account?</a>
                        </p>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>
