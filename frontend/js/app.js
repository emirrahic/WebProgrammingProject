const allPages = ["login", "register", "dashboard", "books", "authors", "categories", "members", "loans"];

function loadPage() {
  let page = location.hash.replace("#", "");
  if (!allPages.includes(page)) page = "dashboard";

  fetch("frontend/views/" + page + ".html")
    .then(function (res) { return res.text(); })
    .then(function (html) {
      document.getElementById("content").innerHTML = html;
      setupPage(page);
    });
}

window.addEventListener("hashchange", loadPage);
window.addEventListener("load", loadPage);
