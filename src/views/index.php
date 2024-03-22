<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Lista de usuarios</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center">Listado de Usuarios</h2>
            <a id="create-user" onclick="createUser()" href="#" class="btn btn-primary"  data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Crear Usuario</a>
            <a id="create-user" onclick="createCommentsModal()" href="#" class="btn btn-primary"  data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Crear Comentario</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Pass</th>
                        <th>Openid</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="body-user">
                   
                </tbody>
            </table>
        </div>

        
    </div>
</div>

<!-- modal  -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-2-title fs-5" id="exampleModalToggleLabel2">Modal 2</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-2-body">
        Hide this modal and show the first with the button below.
      </div>
      <div class="modal-2-footer">
      </div>
    </div>
  </div>
</div>

<!-- fin modal  -->
    
    <script src="./src/views/js/user.js?v=8976"></script>
    <script src="./src/views/js/comment.js?v=9878787"></script>
</body>
</html>