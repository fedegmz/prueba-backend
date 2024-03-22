

//cargar todo al cargar la pagina
document.addEventListener('DOMContentLoaded', function () {
    //cargar todos los usuarios
    cargarUsuarios();

});

let URLUser  ="http://localhost:8080/?url=api/user/";

function cargarUsuarios() {
    console.log("carga usuarios")
    fetch(`${URLUser}index`)
        .then(response => {
            if (response.status === 500) {
                return alert("Error al cargar los usuarios");
            }
            return response.json();
        })
        .then(data => {
            const $tableBody = document.getElementById("body-user");
            $tableBody.innerHTML = "";
            const $trTemplate = document.createElement("tr");
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));

            const $fragment = document.createDocumentFragment();

            data.forEach(user => {
                const $tr = $trTemplate.cloneNode(true);

                $tr.children[0].innerHTML = user.id_comment === null ? user.fullname : `<a href="#"data-bs-target="#exampleModalToggle" data-bs-toggle="modal" onclick="openModalComments(${user.id_comment},${user.id})">${user.fullname}</a>`;
                $tr.children[1].textContent = user.email;
                $tr.children[2].textContent = user.pass;
                $tr.children[3].textContent = user.openid;
                $tr.children[4].innerHTML = `
                <a id="edit-user" onclick="editUser(${user.id})" href="#" class="btn btn-warning"  data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Editar</a>
                <a id="delete-user" onclick="deleteUser(${user.id})" href="#" class="btn btn-danger"  >Eliminar</a>
            `;

                $fragment.appendChild($tr);
            });

            $tableBody.appendChild($fragment);
        });
}


function createUser() {
    let $modal = document.querySelector(".modal-title"),
        $modalBody = document.querySelector(".modal-body"),
        $modalFooter = document.querySelector(".modal-footer");
    
    $modal.textContent = "Crear Usuario";

    $modalBody.innerHTML = `
    <form id="form-user">
        <div class="mb-3">
            <label for="fullname" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="fullname" name="fullname">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="pass" name="pass">
        </div>
        <div class="mb-3">
            <label for="openid" class="form-label">OpenID</label>
            <input type="text" class="form-control" id="openid" name="openid">
        </div>
    </form>
    `;
    $modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" onclick="storeUser()">Guardar</button>
    `;
}

function storeUser() {
    let $form = document.getElementById("form-user"),
        formData = new FormData($form);

    fetch(`${URLUser}createUser`, {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al crear el usuario");
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            cerrarModal();   
            cargarUsuarios();        
        });
}

function editUser(id) {
    let $modal = document.querySelector(".modal-title"),
        $modalBody = document.querySelector(".modal-body"),
        $modalFooter = document.querySelector(".modal-footer");

        const $tr = event.target.parentElement.parentElement,
        $fullname = $tr.children[0].textContent.trim(),
        $email = $tr.children[1].textContent,
        $pass = $tr.children[2].textContent,
        $openid = $tr.children[3].textContent;
        
        console.log($fullname, $email, $pass, $openid);

    $modal.textContent = "Editar Usuario";

    $modalBody.innerHTML = `
    <form id="form-user">
        <div class="mb-3">
            <label for="fullname" class="form-label">Nombre Completo</label>
            <input type="text" value="${$fullname}" class="form-control" id="fullname" name="fullname">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" value="${$email}" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" value="${$pass}" class="form-control" id="pass" name="pass">
        </div>
        <div class="mb-3">
            <label for="openid" class="form-label">OpenID</label>
            <input type="text" value="${$openid}" class="form-control" id="openid" name="openid">
        </div>
    </form>
    `;
    $modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" onclick="updateUser(${id})">Guardar</button>
    `;
}

function updateUser(id) {
    let $form = document.getElementById("form-user"),
        formData = new FormData($form);
        formData.append("id", id);
       
    fetch(`${URLUser}updateUser/${id}`, {
        method: 'PUT',
        body: JSON.stringify(Object.fromEntries(formData)),
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al actualizar el usuario");
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            cerrarModal();
        });
}

function deleteUser(id) {

    if (!confirm("¿Estás seguro de eliminar este usuario?")) {
        return false;
    }

    fetch(`${URLUser}deleteUser/&id=${id}`, {
        method: 'DELETE',
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al eliminar el usuario");
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            cargarUsuarios();
        });
}

function openModalComments(idComment,idUser) {
    let $modal = document.querySelector(".modal-title"),
        $modalBody = document.querySelector(".modal-body"),
        $modalFooter = document.querySelector(".modal-footer");

    $modal.innerHTML = `<a id="create-comment" onclick="createComments(${idComment}, ${idUser})" href="#" class="btn btn-primary"  data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Crear Comentario</a>`;

    $modalBody.innerHTML = `
            <h6 class="text-center">Listado de Comentarios</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Comentario</th>
                        <th>Likes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="body-comment">
                   
                </tbody>
            </table>
    `;
    $modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    `;
    cargarComentarios(idComment,idUser);
}

function cerrarModal() {
    let modal = document.getElementById("exampleModalToggle");
    let modalInstance = bootstrap.Modal.getInstance(modal);
    modalInstance.hide();
    cargarUsuarios();
}





