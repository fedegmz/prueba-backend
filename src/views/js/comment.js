

//cargar todo al cargar la pagina
document.addEventListener('DOMContentLoaded', function () {
    //cargar todos los usuarios
    //cargarComentarios();

});

let URL ="http://localhost:8080/?url=api/comments/";


function cargarComentarios(idUser) {
    fetch(`${URL}showByUser&id=${idUser}`)
        .then(response => {
            if (response.status === 500) {
                return alert("Error al cargar los comentarios");
            }
            return response.json();
        })
        .then(data => {
            const $tableBody = document.getElementById("body-comment");
            $tableBody.innerHTML = "";
            const $trTemplate = document.createElement("tr");
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));
                    $trTemplate.appendChild(document.createElement("td"));
                   

            const $fragment = document.createDocumentFragment();
            console.log(data);
            data.forEach(comment => {
                console.log(comment);
                const $tr = $trTemplate.cloneNode(true);

                $tr.children[0].textContent = comment.coment_text;
                $tr.children[1].textContent = comment.likes;
                $tr.children[2].innerHTML = `
                <a id="edit-comment" onclick="editComments(${comment.id}, ${idUser})" href="#" class="btn btn-warning"  data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"">Editar</a>
                <a id="delete-comment" onclick="deleteComments(${comment.id}, ${idUser})" href="#" class="btn btn-danger"  >Eliminar</a>
            `;

                $fragment.appendChild($tr);
            });

            $tableBody.appendChild($fragment);
        });
}


function createComments(idComment, idUser) {
    let $modal = document.querySelector(".modal-2-title"),
        $modalBody = document.querySelector(".modal-2-body"),
        $modalFooter = document.querySelector(".modal-2-footer");
    
    $modal.textContent = "Crear Comentario";

    $modalBody.innerHTML = `
    <form id="form-user">
        <div class="mb-3">
            <input type="text" value="${idComment}" class="form-control" id="user" name="user" hidden>
        </div>
        <div class="mb-3">
            <label for="coment_text" class="form-label">Comentario</label>
            <input type="text" class="form-control" id="coment_text" name="coment_text">
        </div>
        <div class="mb-3">
            <label for="likes" class="form-label">Likes</label>
            <input type="text" class="form-control" id="likes" name="likes">
        </div>
    </form>
    `;
    $modalFooter.innerHTML = `
    <button class="btn btn-secondary regresar" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Regresar</button>
    <button type="button" class="btn btn-primary" onclick="storeComments(${idUser})">Guardar</button>
    `;
}

function createCommentsModal(){
    let $modal = document.querySelector(".modal-title"),
        $modalBody = document.querySelector(".modal-body"),
        $modalFooter = document.querySelector(".modal-footer");
    
    $modal.textContent = "Crear Comentario";

    $modalBody.innerHTML = `
    <form id="form-user">
        <div class="mb-3">
            <label for="user" class="form-label">Usuario Id</label>
            <input type="text" class="form-control" id="user" name="user">
        </div>
        <div class="mb-3">
            <label for="coment_text" class="form-label">Comentario</label>
            <input type="text" class="form-control" id="coment_text" name="coment_text">
        </div>
        <div class="mb-3">
            <label for="likes" class="form-label">Likes</label>
            <input type="text" class="form-control" id="likes" name="likes">
        </div>
    </form>
    `;
    $modalFooter.innerHTML = `
    <button class="btn btn-secondary"  data-bs-dismiss="modal">cerrar</button>
    <button type="button" class="btn btn-primary" onclick="storeComments()">Guardar</button>
    `;
}

function storeComments(idUser = null) {
    let $form = document.getElementById("form-user"),
        formData = new FormData($form),
        $regresar = document.querySelector(".regresar");

    fetch(`${URL}createComment`, {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al crear el comentario");
            }
            return response.json();
        })
        .then(data => {
            if (idUser != null) {
                cargarComentarios(idUser);
                $regresar.click();
            }else{
                let modal = document.getElementById("exampleModalToggle");
                let modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
                cargarUsuarios();
            }
            
        });
}

function editComments(idComment, idUser) {
    let $modal = document.querySelector(".modal-2-title"),
        $modalBody = document.querySelector(".modal-2-body"),
        $modalFooter = document.querySelector(".modal-2-footer");

        const $tr = event.target.parentElement.parentElement,
        $coment = $tr.children[0].textContent,
        $likes = $tr.children[1].textContent;
        
        console.log($coment, $likes);

    $modal.textContent = "Editar Comentario";

    $modalBody.innerHTML = `
    <form id="form-user">
        <div class="mb-3">
            <label for="coment_text" class="form-label">Comentario</label>
            <input type="email" value="${$coment}" class="form-control" id="coment_text" name="coment_text">
        </div>
        <div class="mb-3">
            <label for="likes" class="form-label">Likes</label>
            <input type="text" value="${$likes}" class="form-control" id="likes" name="likes">
        </div>
    </form>
    `;
    $modalFooter.innerHTML = `
    <button class="btn btn-secondary regresar" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Regresar</button>
    <button type="button" class="btn btn-primary" onclick="updateComments(${idComment}, ${idUser})">Actualizar</button>
    `;
}

function updateComments(id, idUser) {
    let $form = document.getElementById("form-user"),    
        formData = new FormData($form),
        $regresar = document.querySelector(".regresar");
        formData.append("id", id);
       
    fetch(`${URL}updateComment`, {
        method: 'PUT',
        body: JSON.stringify(Object.fromEntries(formData)),
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al actualizar el comentario");
            }
            return response.json();
        })
        .then(data => {
            $regresar.click();
            cargarComentarios(idUser);
        });
}

function deleteComments(id, idUser) {

    if (!confirm("¿Estás seguro de eliminar este comentario?")) {
        return false;
    }

    fetch(`${URL}deleteComment/&id=${id}`, {
        method: 'DELETE',
    })
        .then(response => {
            if (response.status === 500) {
                return alert("Error al eliminar el comentario");
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            cargarComentarios(idUser);
        });
}





