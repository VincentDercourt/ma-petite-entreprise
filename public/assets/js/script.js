window.onload = init;

function init() {

    let btnConfirm = document.querySelectorAll(".confirm");

    for (let btn of btnConfirm) {
        btn.addEventListener('click', function (event) {
            let message = "Êtes-vous sur de bien vouloir supprimer ?";
            let dataMessage = this.dataset.message;
            if (dataMessage.length > 0) {
                message = dataMessage;
            }
            if (!confirm(message)) {
                event.preventDefault();
            }
        })
    }

}