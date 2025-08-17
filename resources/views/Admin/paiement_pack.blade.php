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
                <h6 class="fw-light"> Renseignez les informations de paiement.</h6>
                <form class="pt-3" action="{{route('add_paiement')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="nom_depositaire" class="form-control form-control-lg" name="nom_depositaire" placeholder="entrez le nom du depositaire">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-lg" name="montant" placeholder="Entrez le montant envoyé">
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        <input type="submit" value="Validez le paiement" class="btn btn-primary btn-lg">
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

     <div class="modal fade" id="errorNbModal" tabindex="-1" aria-labelledby="errorNbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                     @if(session('error_paiement'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('error_paiement')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-danger shadow-lg">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                        </div>
                        <h5 class="text-danger fw-bold mb-3">Erreur(s) détectée(s)</h5>
                        <ul class="text-start text-danger small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error_paiement'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
        @endif
        });
    </script>


    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif

  </body>
</html>
