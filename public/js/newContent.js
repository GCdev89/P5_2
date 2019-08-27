/*
* This script allow the admin to display the post form or the article form
*/

document.addEventListener("DOMContentLoaded", displayArticleForm);
if (document.readyState !== "loading") {
  displayArticleForm();
}

document.getElementById("displayPostForm").addEventListener("click", displayPostForm)

document.getElementById("displayArticleForm").addEventListener("click", displayArticleForm)

function displayArticleForm() {
    document.getElementById("postForm").style.display = "none";
    document.getElementById("articleForm").style.display = "block";
}

function displayPostForm() {
    document.getElementById("postForm").style.display = "block";
    document.getElementById("articleForm").style.display = "none";
}
