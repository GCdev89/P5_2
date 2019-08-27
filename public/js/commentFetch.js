/*
* This script will manage comment posted, using fetch to send formdata to insert into db and display the comment.
*/

function commentManagement(element) {
    const formElt = element;
    formElt.addEventListener("submit", function(e){
        e.preventDefault();
        let url = 'index.php?action=addComment&id=' + formElt.elements.content_id.value;
        if (this.type.value === "article" || this.type.value === "post") {
            const formData = new FormData(this);
            let options = {
                method: 'post',
                body: formData
            }
            fetch(url , options).then(function (response) {
                return response.text();
            }).then(function (text) {
                let comment = JSON.parse(text);
                commentPrint(comment.userPseudo, comment.content );
            }).catch(function (error) {
                console.error(error);
            })
        } else {
            this.comment.value = "Cette action n'est pas possible";
        }
    });
}

function commentPrint(pseudo, content) {
    let commentToDisplay = `
    <div id="scrollAnchor" class="col-md-11 mx-auto my-2">
        <div class="row d-flex justify-content-between bg-secondary text-light rounded-top">
            <p class="m-2"><span class="h4 font-italic">${pseudo}</span></p>
        </div>
        <div class="row">
            <div class="p-2 col-12 bg-light rounded-bottom" >${content}</div>
        </div>
    </div>`;

    let commentAnchor = document.getElementById("scrollAnchor");
    document.getElementById("comment").insertAdjacentHTML("afterBegin", commentToDisplay);
    document.getElementById("scrollAnchor").scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
}

if (document.getElementById("comment_form") != undefined) {
    commentManagement(document.getElementById("comment_form"));
}
