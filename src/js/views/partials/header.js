window.addEventListener('load', () => {
    const LANG_COOKIE = 'aerbidelang';

    let selector = document.querySelector('#langsel');

    selector.addEventListener('change', () => {
        let lang = selector.options[selector.selectedIndex].value;

        // crar la cookie de idioma que no expire
        // el idioma es para la máquina, independientemente del usuario
        document.cookie = `${LANG_COOKIE}=${lang}`;
    });
});