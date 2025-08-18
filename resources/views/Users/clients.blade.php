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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
     @include('includes/user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('includes/nav_include')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash">Espace clients </h4>
                        <p class="card-subtitle card-subtitle-dash">managez vos clients en toute aisance</p>
                      </div>
                      <div>
                        <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p" data-bs-toggle="modal" data-bs-target="#shopModal" type="button" ><i class="mdi  mdi-plus"></i></button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom  </th>
                            <th> Email   </th>
                            <th> Contact  </th>
                            <th> Adresse </th>
                            <th colspan="2"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $clt )
                                <tr>
                                    <td >{{$clt->nom_client}}</td>
                                    <td>{{$clt->email}}</td>
                                    <td>{{$clt->telephone}}</td>
                                    <td> {{$clt->adresse}}</td>
                                    <td>
                                    <button type="button" class="btn btn-success" data-id="{{$clt->id}}" data-nom="{{$clt->nom_client}}" data-email="{{$clt->email}}" data-adresse="{{$clt->adresse}}" data-telephone="{{$clt->telephone}}" onclick="openEditModal(this)"> Modifier </button>
                                    <button type="button" class="btn btn-danger" data-id="{{$clt->id}}" onclick="openSuppModal(this)"> Supprimer </button>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="5" class="text-center text-muted">Aucun client enregistré</td>
                            @endforelse
                        </tbody>
                      </table>
                      <div class="mt-3 d-flex justify-content-center">
                        {{ $clients->links('pagination::bootstrap-5') }}
                     </div>
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

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ajouter une client   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('add_clients')}}" enctype="multipart/form-data" id="formulaire" >
                        @csrf
                            <div class="mb-3">
                                <label for="centreName" class="form-label">Nom client </label>
                                <input type="text" name="nom_client" class="form-control" id="" placeholder="entrer le nom du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> adresse </label>
                                <input type="text" name="adresse" class="form-control" id="" placeholder="entrer le quartier du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> telephone </label>
                                <input type="tel" name="telephone" class="form-control" id="" placeholder="entrer un contact du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> email </label>
                                <input type="email" name="email"  placeholder="entrez une adresse email du client " class="form-control" >
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Modifier les informations des clients   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"  action="" id="editForm" >
                        @csrf
                        @method('PUT')

                           <div class="mb-3">
                                <label for="centreName" class="form-label">Nom client </label>
                                <input type="text" name="nom_client" class="form-control" id="nom_client" placeholder="entrer le nom du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> adresse </label>
                                <input type="text" name="adresse" class="form-control" id="adresse" placeholder="entrer le quartier du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> telephone </label>
                                <input type="tel" name="telephone" class="form-control" id="telephone" placeholder="entrer un contact du client ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> email </label>
                                <input type="email" name="email" id="email"  placeholder="entrez une adresse email du client " class="form-control" >
                            </div>
                            <div class="button-container ">
                                <button type="submit" id="bouton" class="button btn btn-success" > Modifier </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Fermer </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Supprimer le client </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir supprimer ce client ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
              <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Oui</button>
              </form>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('delete_customers'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('delete_customers')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('client_creation'))
                        <h5 class="text-success fw-bold mb-2">{{ session('client_creation') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('customer_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('customer_updated')}}</h5>
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
            var nom = button.getAttribute('data-nom');
            var email = button.getAttribute('data-email');
            var adresse = button.getAttribute('data-adresse');
            var telephone = button.getAttribute('data-telephone');
            const updateClientUrl = @json(route('update_customers', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier un client ';
            document.getElementById('editForm').action = updateClientUrl.replace('__ID__', id);
            document.getElementById('nom_client').value = nom;
            document.getElementById('telephone').value = telephone;
            document.getElementById('adresse').value = adresse;
            document.getElementById('email').value = email;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>

        const deleteClientsUrl =@json(route('delete_customers', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteClientsUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('delete_customers'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('client_creation'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('customer_updated'))
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
