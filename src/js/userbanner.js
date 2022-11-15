window.addEventListener('load', () => {
    let userbtn = document.querySelector('#userbtn');
    let userBanner = document.querySelector('#user-banner');

    userbtn.addEventListener('click', function(e) {
        console.log('a');
        userBanner?.classList.toggle('shown');
    });
});