<form>
    <input type="file" name="archivo">
    <input type="submit" value="Enviar">
</form>
<script>
    let form = document.querySelector('form');
    let input = form.querySelector("input[name='archivo']");
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let file = input.files[0];

        console.log(typeof file);

        if (file) {
            let data = new FormData();
            data.append('file', file);

            let r = fetch('/test2.php', {
                method: 'POST',
                body: data
            });
            if (r.ok) {
                console.log(r);
            }
        }
    });
</script>