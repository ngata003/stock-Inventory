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
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
       @include('user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('nav_include')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-8 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                     <h4 class="card-title card-title-dash">Espace notifications </h4>
                                     <p class="card-subtitle card-subtitle-dash"> controllez toutes les actions effectuées dans votre boutique </p>
                                    </div>
                                  </div>
                                  <div class="table-responsive  mt-1">
                                    <table class="table select-table">
                                        <thead>
                                            <tr>
                                                <th> message  </th>
                                            </tr>
                                        </thead>
                                      <tbody>
                                        @forelse ($notifications as $notif )
                                            <tr class="{{ $notif->status == 0 ? 'table-secondary' : ''}}" style="cursor: pointer;" onclick="openNotifModal(`{{ $notif->description }}`)">
                                                <td>{{$notif->description}}</td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Aucune action enregistrée </td>
                                        </tr>
                                        @endforelse
                                      </tbody>
                                    </table>
                                  </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">
                <p id="notificationMessage" class="fs-5 text-dark"></p>
                <div class="text-end">
                    <form action="">
                        <button type="submit"></button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Supprimer le role </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir supprimer cette notification ?
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
                    @if(session('role_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('role_deleted')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
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
                    @if(session('role_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('role_updated')}}</h5>
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

        const deleteRolesUrl =@json(route('delete_roles', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteRolesUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        function openNotifModal(message) {
            document.getElementById('notificationMessage').textContent = message;
            const modal = new bootstrap.Modal(document.getElementById('shopModal'));
            modal.show();
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('role_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('role_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

  </body>

</html>
