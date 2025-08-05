document.addEventListener('DOMContentLoaded', () => {
    // Activar/Desactivar estado
    document.querySelectorAll('.toggle-estado').forEach(boton => {
        boton.addEventListener('click', () => {
            const id = boton.dataset.id;
            const estadoActual = boton.dataset.estado;
            const nuevoEstado = estadoActual === 'Activo' ? 'Inactivo' : 'Activo';

            fetch('../ajax/actualizar_estado_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&estado=${nuevoEstado}`
            })
            .then(res => res.text())
            .then(respuesta => {
                if (respuesta === 'ok') {
                    boton.textContent = nuevoEstado;
                    boton.dataset.estado = nuevoEstado;
                    boton.classList.toggle('btn-success');
                    boton.classList.toggle('btn-secondary');
                } else {
                    alert('Error al actualizar el estado');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX', error);
            });
        });
    });

    // Abrir modal con datos al hacer clic en "Editar"
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('edit_id_usuario').value = btn.dataset.id;
            document.getElementById('edit_usuario').value = btn.dataset.usuario;
            document.getElementById('edit_nombres').value = btn.dataset.nombres;
            document.getElementById('edit_apellidos').value = btn.dataset.apellidos;
            document.getElementById('edit_correo').value = btn.dataset.correo;
            document.getElementById('edit_rol').value = btn.dataset.rol;

            const modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
            modal.show();
        });
    });

    // Enviar formulario para actualizar usuario con validación
    const formularioEditar = document.getElementById('formEditarUsuario');
    formularioEditar.addEventListener('submit', function (e) {
        e.preventDefault();

        const nombres = document.getElementById('edit_nombres').value.trim();
        const apellidos = document.getElementById('edit_apellidos').value.trim();
        const correo = document.getElementById('edit_correo').value.trim();
        const usuario = document.getElementById('edit_usuario').value.trim();

        const soloLetras = /^[a-zA-ZÁÉÍÓÚáéíóúÑñ\s]+$/;
        const correoValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const usuarioValido = /^[a-zA-Z0-9_]{4,20}$/;

        if (!soloLetras.test(nombres) || !soloLetras.test(apellidos)) {
            alert('❌ Nombres y apellidos solo deben contener letras.');
            return;
        }
        if (!correoValido.test(correo)) {
            alert('❌ Correo inválido.');
            return;
        }
        if (!usuarioValido.test(usuario)) {
            alert('❌ Usuario inválido. Solo letras, números y guiones bajos (mínimo 4 caracteres).');
            return;
        }

        const formData = new FormData(this);

        fetch('../ajax/actualizar_usuario.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(respuesta => {
            if (respuesta === 'usuario_duplicado') {
                alert('❌ El nombre de usuario ya existe.');
                return;
            }
            if (respuesta === 'ok') {
                alert('✅ Usuario actualizado correctamente');
                location.reload();
            } else {
                alert('❌ Error al actualizar el usuario: ' + respuesta);
            }
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
            alert('❌ Ocurrió un error inesperado.');
        });
    });
});

// Eliminar usuario con confirmación
document.querySelectorAll('.btn-eliminar').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;

        if (confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
            fetch('../ajax/eliminar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}`
            })
            .then(res => res.text())
            .then(respuesta => {
                if (respuesta === 'ok') {
                    alert('✅ Usuario eliminado correctamente');
                    location.reload();
                } else {
                    alert('❌ Error al eliminar el usuario: ' + respuesta);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('❌ Ocurrió un error inesperado.');
            });
        }
    });
});


const formCrear = document.getElementById('formCrearUsuario');

formCrear.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('../ajax/crear_usuario.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
.then(respuesta => {
    console.log("Respuesta del servidor:", respuesta); // 👈 agrega esto
    alert(respuesta); // 👈 agrega esto para ver el mensaje real

        if (respuesta === 'ok') {
            alert('✅ Usuario creado correctamente');
            location.reload();
        } else if (respuesta === 'usuario_duplicado') {
            alert('❌ El nombre de usuario ya existe');
        } else if (respuesta === 'correo_duplicado') {
            alert('❌ El correo ya está en uso');
        } else if (respuesta === 'faltan_datos') {
            alert('❌ Faltan datos en el formulario');
        } else {
            alert('❌ Error al crear el usuario');
        }
    })
    .catch(error => {
        console.error('Error al crear el usuario:', error);
        alert('❌ Ocurrió un error inesperado');
    });
});
