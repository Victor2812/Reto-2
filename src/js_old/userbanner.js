window.addEventListener('load', () => {
    // botones
    let userBtn = document.querySelector('#userbtn');
    let editBtn = document.querySelector('#useredit');

    // elementos
    let banner = document.querySelector('#user-banner');
    let editable = document.querySelector('#user-banner #user-editable');

    // variables
    let data = {
        isEditable: false
    };

    async function getUserApi() {
        let r = await fetch('/user_api.php?method=getUser');
        if (r.ok) {
            return r.json();
        } else {
            return {'error': 'connection'};
        }
    }

    async function setUserApi(data) {
        let r = await fetch('/user_api.php?method=setUser', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: new Headers({
              'Content-Type': 'application/json'
            })
        });
        if (r.ok) {
            return r.json();
        } else {
            return {'error': 'connection'};
        }
    }

    // Mostrar/esconder el banner
    userBtn.addEventListener('click', function(e) {
        banner?.classList.toggle('shown');
    });

    // cuando un usuario es editado
    async function onUserEdited(e, form) {
        e.preventDefault();

        let errors = form.querySelector('.errors');

        function appendError(text) {
            let p = document.createElement('p');
            p.textContent = text;
            errors.appendChild(p);
        }

        let name = form.querySelector('input[name=name]')?.value;
        let surname = form.querySelector('input[name=surname]')?.value;
        let job = form.querySelector('input[name=job]')?.value;
        let passwd = form.querySelector('input[name=passwd]')?.value;
        let passwd2 = form.querySelector('input[name=passwd2]')?.value;

        // obligatorio
        if (!name) {
            appendError('Nombre no puede estar vacío');
            return;
        }

        // las contraseñas no coinciden y el usuario ha intentado cambiarla
        console.log(passwd);
        if (passwd && passwd != passwd2) {
            appendError('Las contraseñas no coinciden');
            return;
        }

        let r = await setUserApi({
            name: name,
            surname: surname,
            job: job,
            passwd: passwd,
            passwd2: passwd2
        });

        if (!r.error) {
            data.isEditable = !data.isEditable;
            await applyBanner();
        } else {
            appendError(r.error);
        }
    }

    // Construir la información del usuario en modo estático
    function mockupUserData(info) {
        let name = document.createElement('p');
        name.textContent = `${info.name} ${info.surname}`;

        let job = document.createElement('p');
        job.classList.add('user-job');
        job.textContent = info.job || 'No has elegido un departamento';

        // añadir datos
        editable.appendChild(name);
        editable.appendChild(job);
    }

    // Construir la información del usuario en modo edición
    function mockupUserDataForm(info) {
        let form = document.createElement('form');

        // añadir div para posibles errores
        form.innerHTML = '<div class="errors"></div>';

        let nameAndSurname = document.createElement('p');
        let name = document.createElement('input');
        name.type = 'text';
        name.name = 'name';
        name.placeholder = 'Nombre';
        name.value = info.name;
        nameAndSurname.appendChild(name);
        let surname = document.createElement('input');
        surname.type = 'text';
        surname.name = 'surname';
        surname.placeholder = 'Apellido';
        surname.value = info.surname;
        nameAndSurname.appendChild(surname);

        let job = document.createElement('p');
        let jobInput = document.createElement('input');
        jobInput.type = 'text';
        jobInput.name = 'job';
        jobInput.placeholder = 'Puesto de trabajo';
        jobInput.value = info.job;
        job.appendChild(jobInput);

        let password = document.createElement('p');
        let pass1 = document.createElement('input');
        pass1.type = 'password';
        pass1.placeholder = 'Contraseña nueva';
        pass1.name = 'passwd';
        password.appendChild(pass1);
        let pass2 = document.createElement('input');
        pass2.type = 'password';
        pass2.placeholder = 'Repetir contraseña';
        pass2.name = 'passwd2';
        password.appendChild(pass2);

        let submit = document.createElement('p');
        let submitInput = document.createElement('input');
        submitInput.type = 'submit';
        submitInput.value = 'Actualizar';
        submit.appendChild(submitInput);

        form.appendChild(nameAndSurname);
        form.appendChild(job);
        form.appendChild(password);
        form.appendChild(submit);

        form.addEventListener('submit', (e) => onUserEdited(e, form));

        editable.appendChild(form);
    }

    async function applyBanner() {
        let info = await getUserApi();

        if (info.error) {
            console.log(info.error);
        } else {
            // limpiar el contenedor
            editable.innerHTML = '';

            if (data.isEditable) {
                mockupUserDataForm(info);
            } else {
                mockupUserData(info);
            }
        }
    }

    // Editar la información del usuario
    editBtn.addEventListener('click', function (e) {
        e.preventDefault();

        data.isEditable = !data.isEditable;
        applyBanner();
    });

    applyBanner();
});