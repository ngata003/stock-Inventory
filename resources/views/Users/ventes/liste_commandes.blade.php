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
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}"/>

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
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash"> Espace Commandes </h4>
                        <p class="card-subtitle card-subtitle-dash"> Consultez toutes les commandes effectuées au sein de votre boutique </p>
                      </div>
                       <div class="d-flex justify-content-end mb-3">
                            <a href="#" class="btn btn-success me-1"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-2"><i class="icon-download"></i> Export</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> contact client </th>
                            <th> coursier </th>
                            <th> Total  </th>
                            <th>  montant payé </th>
                            <th> reste </th>
                            <th> payé via </th>
                            <th> date commande </th>
                            <th> status </th>
                            <th > Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($commandes as $cmd )
                                <tr>
                                    <td >{{$cmd->contact_client}}</td>
                                    <td>{{$cmd->coursiers->nom_coursier}}</td>
                                    <td>{{$cmd->montant_total}}</td>
                                    <td>{{$cmd->montant_paye}}</td>
                                    <td> {{$cmd->montant_remboursé}}</td>
                                    <td> {{$cmd->moyen_paiement}}</td>
                                    <td> {{$cmd->date_vente}}</td>
                                    @if ($cmd->status == 0)
                                        <td>
                                            <div class="badge badge-opacity-danger"> non livré </div>
                                        </td>
                                    @elseif ($cmd->status == 1)
                                        <td>
                                            <div class="badge badge-opacity-success">livré</div>
                                        </td>
                                    @endif
                                    <td>
                                    <a href="{{route('update_ventes_view' , ['id' => $cmd->id])}}" class="btn btn-success btn-sm me-1"><i class="mdi mdi-pencil"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm me-1" data-id="{{$cmd->id}}" onclick="openSuppModal(this)"> <i class="mdi mdi-trash-can-outline"></i> </button>
                                    <a href="{{route('imprimer_factures' , ['id' => $cmd->id])}}" class=" btn btn-dark btn-sm me-1 "><i class="icon-printer"></i></a>
                                    <button type="button" class="btn btn-primary btn-sm me-1" data-id="{{$cmd->id}}" onclick="openValidModal(this)"> <i class="mdi mdi-check-circle-outline"></i> </button>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="9" class="text-center text-muted">Aucune commande enregistrée</td>
                            @endforelse
                        </tbody>
                      </table>
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
              <h5 class="modal-title" id="deleteModalLabel">Annuler la vente </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir annuler cette vente ?
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

    <div class="modal fade" id="validModal" tabindex="-1" aria-labelledby="validModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="validModalLabel">confirmer la commande </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Avez-vous réellement livré cette commande?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
              <form method="POST" id="validForm">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success">Oui</button>
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
                    @if(session('invoice_delete'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('invoice_delete')}}</h5>
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
                    @if(session('valid_success'))
                        <h5 class="text-success fw-bold mb-2">{{ session('valid_success') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès après édition -->
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


    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        const validCommandsUrl =@json(route('valid_commandes', ['id' => '__ID__'])) ;
        function openValidModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('validForm').action = validCommandsUrl.replace('__ID__', id);
            var validModal = new bootstrap.Modal(document.getElementById('validModal'));
            validModal.show();
        }
    </script>

    <script>
        const AnnulerCommandsUrl =@json(route('annuler_commandes', ['id' => '__ID__'])) ;
        function openSuppdModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = AnnulerCommandsUrl.replace('__ID__', id);
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
        @if(session('valid_success'))
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

  </body>
</html>
