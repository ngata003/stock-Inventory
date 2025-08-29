<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}" />
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
            <div class="d-flex justify-content-center align-items-center mt-4 mb-5">
                <div class="profile-card-custom shadow-lg p-4 w-50">
                    <div class="row g-0 align-items-center">
                    <div class="col-md-4 text-center">
                        <img src="{{ asset('assets/images/' . $user->profil) }}"
                        class="img-fluid"
                        alt="profil"
                        style="width: 100%; height: 320px; object-fit: cover; border-radius: 20px;">
                    </div>
                    <div class="col-md-8 ps-4">
                        <div class="card-body p-0">
                        <h3 class="card-title fw-bold mb-3">{{ $user->name }}</h3>
                        <p class="card-text"><strong>Email :</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Adresse :</strong> {{ $user->adresse }}</p>
                        <p class="card-text"><strong>Contact :</strong> {{ $user->contact }}</p>
                        <p class="card-text"><strong>Rôle :</strong> {{ $user->role }}</p>
                        <p class="card-text"><strong>Boutique :</strong> {{ $boutique_nom ?? 'Non défini' }}</p>
                        <button class="btn btn-primary mt-3" data-id="{{$user->id}}" data-name="{{$user->name}}" data-profil="{{$user->profil}}" data-email="{{$user->email}}" data-adresse="{{$user->adresse}}" data-contact="{{$user->contact}}" onclick="openEditModal(this)">Modifier mon profil</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.footer')
        </div>
      </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Modifier mon profil   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"  action="" id="editForm" >
                        @csrf
                        @method('PUT')

                            <div class="mb-3">
                                <label for="centreName" class="form-label">Nom utilisateur </label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="entrer votre nom ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> Email </label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="entrer une adresse email valide ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> contact </label>
                                <input type="tel" name="contact" class="form-control" id="contact" placeholder="entrer votre contact ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> adresse </label>
                                <input type="text" name="adresse" class="form-control" id="adresse" placeholder="entrez votre adresse ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> Mot de passe </label>
                                <input type="password" name="password" class="form-control" id="" placeholder="entrez votre nouveau mot de passe">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> profil Utilisateur </label>
                                <input type="file" name="profil" class="form-control" >
                                <img src="" height="65px" width="65px" id="profil" alt="">
                            </div>
                            <div class="button-container">
                                <button type="submit" id="bouton" class="button btn btn-success" > enregistrer </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('profil_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('profil_updated')}}</h5>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-dismiss="modal">
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

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        function openEditModal(button) {

            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-name');
            var email = button.getAttribute('data-email');
            var adresse = button.getAttribute('data-adresse');
            var telephone = button.getAttribute('data-contact');
            var profil = button.getAttribute('data-profil');
            const updateProfilUrl = @json(route('update_profil', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier Mon Profil ';
            document.getElementById('editForm').action = updateProfilUrl.replace('__ID__', id);
            document.getElementById('name').value = nom;
            document.getElementById('contact').value = telephone;
            document.getElementById('adresse').value = adresse;
            document.getElementById('email').value = email;
            document.getElementById('profil').src = '/assets/images/'+ profil;
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('profil_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
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

