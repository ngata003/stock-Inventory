<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAMES STOCK </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}../../">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="{{asset('assets/images/logo.svg')}} " alt="logo">
                </div>
                <h4>Hello Deja de retour ?</h4>
                <h6 class="fw-light">Connectez-vous pour continuer.</h6>
                <form class="pt-3" method="POST" action="{{route('login_post')}}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="votre email">
                    </div>
                    <div class="form-group position-relative">
                        <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" name="remember" class="form-check-input"> Se souvenir de moi </label>
                    </div>
                  <div class="mt-3 d-grid gap-2">
                    <input type="submit" name="save" value="Connectez-vous" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">

                  </div>
                  <div class="mb-2 d-grid gap-2">
                    <button type="button" class="btn btn-block btn-google auth-form-btn">
                      <i class="ti-google me-2"></i>connexion avec google </button>
                  </div>
                  <div class="text-center mt-4 fw-light"> Mot de passe oublié? <a href="{{route('reset_password')}}" class="text-primary">changez de mot de passe ici </a></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('success'))
                        <h5 class="text-success fw-bold mb-2">{{ session('success') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordInput = document.getElementById('exampleInputPassword1');
        let icon = this;

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.replace("bi-eye-slash", "bi-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.replace("bi-eye", "bi-eye-slash");
        }
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });
    </script>

  </body>
</html>
