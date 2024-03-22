# Prueba técnica para Backend o Fullstack

Este documento proporciona una descripción detallada de los endpoints de la API para usuarios y comentarios. Cada endpoint incluye detalles sobre la URL completa, los parámetros requeridos y opcionales, y ejemplos de respuestas.

## API Endpoints

### Usuarios

#### GET /usuarios

Obtiene una lista de todos los usuarios.

URL completa: `http://localhost:8080/?url=api/user/index`

##### Respuesta

- `200 OK` en éxito

```json
[
    {
        "id": 1,
        "fullname": "Juan",
        "email": "juan@example.com",
        "pass" : "12345",
        "openid":"1",
        "id_comment": 1
    },
    {
        "id": 2,
        "fullname": "Juan diaz",
        "email": "diaz@example.com",
        "pass" : "12345",
        "openid":"2",
        "id_comment": 2
    }
]
```


#### GET /usuarios

Obtiene un usuario

URL completa: `http://localhost:8080/?url=api/user/show&id=1`

##### Respuesta

- `200 OK` en éxito

```json
{
  "fullname": "Juan lopez lopez",
  "email": "juana@gmail.com",
  "pass": "mypassword",
  "openid": "1"
}
```

#### POST /usuarios

Crear un usuario

URL completa: `http://localhost:8080/?url=api/user/createUser`

##### Parámetros

Se deben enviar en el cuerpo de la solicitud como JSON:

- `fullname` (requerido): El nombre completo del usuario.
- `email` (requerido): El correo electrónico del usuario.
- `pass` (requerido): La contraseña del usuario.
- `openid` (opcional): El ID de OpenID del usuario.

##### Ejemplo de solicitud

```json
{
    "fullname": "Juan lopez lopez",
    "email": "juan@gmail.com",
    "pass": "mypassword",
    "openid": "1"
}
```
##### Respuesta

- `200 OK` en éxito

```json
{"message":"Usuario creado correctamente."}
```


#### PUT /usuarios

Actualizar un usuario

URL completa: `http://localhost:8080/?url=api/user/updateUser`

##### Parámetros

Se deben enviar en el cuerpo de la solicitud como JSON:

- `fullname` (opcional): El nombre completo del usuario.
- `email` (opcional): El correo electrónico del usuario.
- `pass` (opcional): La contraseña del usuario.
- `openid` (requerido): El ID de OpenID del usuario.

##### Ejemplo de solicitud

```json
{
    "fullname": "Juan lopez lopez",
    "email": "juan@gmail.com",
    "pass": "mypassword",
    "openid": "2",
    "id": "2"
}
```
##### Respuesta

- `200 OK` en éxito

```json
{
  "message": "User Actualizado correctamente."
}
```


#### DELETE /usuarios

Eliminar un usuario

URL completa: `http://localhost:8080/?url=api/user/deleteUser/&id=3`

##### Respuesta

- `200 OK` en éxito

```json
{
  "message": "User Eliminado"
}
```

### Comentarios

#### GET /comentarios

Obtiene una lista de todos los usuarios.

URL completa: `http://localhost:8080/?url=api/comments/index`

##### Respuesta

- `200 OK` en éxito

```json
[
  {
    "id": 7,
    "user": 4,
    "coment_text": "e3e3e3",
    "likes": 4
  }
]
```

#### GET /comentarios

Obtener un comentario

URL completa: `http://localhost:8080/?url=api/comments/show&id=7`

##### Respuesta

- `200 OK` en éxito

```json
[
  {
    "id": 7,
    "user": 4,
    "coment_text": "e3e3e3",
    "likes": 4
  }
]
```

#### POST /comentario

Crear un comentario

URL completa: `http://localhost:8080/?url=api/comments/createComment
`

##### Parámetros

Se deben enviar en el cuerpo de la solicitud como JSON:

- `user` (requerido): es el id del usuario del comentario 
- `coment_text` (requerido): el comentario es requerido.
- `likes` (opcional): El like no es requerido.

##### Ejemplo de solicitud

```json
{
    "user": "4",
    "coment_text": "e3e3e3",
    "likes": "4"
}
```
##### Respuesta

- `200 OK` en éxito

```json
{"message":"Comentario creado correctamente"}
```


#### PUT /comentario

Actualizar un comentario

URL completa: `http://localhost:8080/?url=api/comments/updateComment`

##### Parámetros

Se deben enviar en el cuerpo de la solicitud como JSON:

- `idUsuario` (requerido): es el id del usuario del comentario 
- `coment_text` (requerido): el comentario es requerido.
- `likes` (requerido): El like es requerido.

##### Ejemplo de solicitud

```json
{
    "coment_text": "e3e3e3",
    "likes": "6",
    "id": "7"
}
```

##### Respuesta

- `200 OK` en éxito

```json
{"message": "comentario actualizado correctamente."}
```


#### DELETE /comentario

Eliminar un comentario

URL completa: `http://localhost:8080/?url=api/comments/deleteComment/&id=8`

##### Respuesta

- `200 OK` en éxito

```json
{"message": "comentario eliminado"}
```