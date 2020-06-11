document.querySelectorAll('input[type=file]').forEach( input => {
    input.addEventListener('change', e => {
        e.target.nextElementSibling.innerText = input.files[0].name;
        console.log("Hello");
    });
});
