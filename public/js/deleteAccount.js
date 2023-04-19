
let body
let deleteButton
reloadElements()
let Confirmation =
    `
    <div class="delete-validation-container">
        <div id="connectForm" class="form-connect delete-validation">
            <form action="/deleteAccount" method='POST'>
                <h1 class="form-title">Etes-vous sûr de vouloir supprimer ce compte</h1>
                <div class="form-container">
                    <div class='inline-buttons'>
                        <input type="submit" value="Oui" name="submit" class="form-submit"/>
                        <input type="button" value="non" name="submit" class="form-submit refuse-button"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
`

document.addEventListener('click',()=>{
    if(event.target.classList.contains('delete-validation-container') ||
        event.target.classList.contains('refuse-button')){
        document.getElementsByClassName('delete-validation-container')[0].remove()
        reloadElements();
    }
})
function reloadElements(){
    deleteButton = document.getElementsByClassName('delete-account')[0]
    body = document.getElementsByTagName("body")[0]
    deleteButton.addEventListener('click',(event) => {
        body.innerHTML += Confirmation;
    })
}