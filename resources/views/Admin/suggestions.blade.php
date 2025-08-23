<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES STOCK </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset(path: 'assets/images/cames_favIcon.png')}}"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
     @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('includes.nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Espace Suggestions </h4>
                    <p class="card-description"> Entrez votre problème ou des appreciations ici </p>
                    <form class="forms-sample" method="POST" action="{{route('add_suggestions')}}">
                        @csrf
                        <?php $user = Auth::user();?>
                      <div class="form-group">
                        <label for="exampleInputEmail3"> Mail Envoyé à : </label>
                        <input type="email" value="{{$superadmin->email}}" readonly class="form-control" id="exampleInputEmail3" placeholder="Email">
                      </div>
                     <div class="form-group row">
                        <div class="col-6">
                            <label for="exampleInputName1" class="col-12">Votre Mail</label>
                            <input type="email" readonly class="form-control" value="{{$user->email}}" id="exampleInputName1" placeholder="votre mail">
                        </div>

                        <div class="col-6">
                             <label for="exampleInputName1" class="col-12">Votre Boutique</label>
                            <input type="text" readonly value="{{$boutique_nom}}" class="form-control" id="exampleInputName2" placeholder="votre boutique">
                        </div>
                     </div>
                      <div class="form-group">
                        <label for="exampleTextarea1">Message (problèmes) : </label>
                        <textarea class="form-control" name="message" id="exampleTextarea1" rows="4"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Envoyer</button>
                      <button class="btn btn-light">Annuler</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @include('includes.footer')
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
                    @if(session('succes_suggestions'))
                        <h5 class="text-success fw-bold mb-2">{{ session('succes_suggestions') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
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
    <script src="{{asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script src="{{asset('assets/js/file-upload.js')}}"></script>
    <script src="{{asset('assets/js/typeahead.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('succes_suggestions'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
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
