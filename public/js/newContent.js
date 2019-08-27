document.addEventListener("DOMContentLoaded", toggleArticleForm); // Lance la fonction onReady qui initialise l'appli si la page est chargée
if (document.readyState !== "loading") { // Lance le script si l'état est différent de loading
  toggleArticleForm();
}

document.getElementById("togglePostForm").addEventListener("click", togglePostForm)

document.getElementById("toggleArticleForm").addEventListener("click", toggleArticleForm)

function toggleArticleForm() {
    document.getElementById("postForm").style.display = "none";
    document.getElementById("articleForm").style.display = "block";
}

function togglePostForm() {
    document.getElementById("postForm").style.display = "block";
    document.getElementById("articleForm").style.display = "none";
}
