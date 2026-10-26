function setupPage(page) {
  if (page === "books") fillTable(books);
  if (page === "authors") fillTable(authors);
  if (page === "categories") fillTable(categories);
  if (page === "members") fillTable(members);
  if (page === "loans") fillTable(loans);
  if (page === "dashboard") fillDashboard();

  const forms = document.querySelectorAll("form");
  for (let i = 0; i < forms.length; i++) {
    forms[i].onsubmit = handleSubmit;
  }
}

function fillTable(data) {
  let html = "";
  for (let i = 0; i < data.length; i++) {
    const values = Object.values(data[i]);
    html += "<tr>";
    for (let j = 0; j < values.length; j++) {
      html += "<td>" + values[j] + "</td>";
    }
    if (data[i].status === "Borrowed") {
      html += "<td><button class='btn btn-sm btn-dark' onclick='alert(\"Book returned (demo)\")'>Return</button></td>";
    } else if (data[i].status === "Returned") {
      html += "<td>-</td>";
    } else {
      html += "<td><button class='btn btn-sm btn-outline-dark me-1' onclick='openModal(\"Edit\")'>Edit</button>";
      html += "<button class='btn btn-sm btn-dark' onclick='alert(\"Deleted\")'>Delete</button></td>";
    }
    html += "</tr>";
  }
  document.getElementById("tableBody").innerHTML = html;
}

function openModal(title) {
  document.getElementById("modalTitle").innerText = title;
  new bootstrap.Modal(document.getElementById("formModal")).show();
}

function handleSubmit(e) {
  e.preventDefault();
  if (this.id === "loginForm") {
    location.hash = "#dashboard";
  } else if (this.id === "registerForm") {
    location.hash = "#login";
  } else {
    bootstrap.Modal.getInstance(document.getElementById("formModal")).hide();
    alert("Saved");
  }
}

function fillDashboard() {
  document.getElementById("countBooks").innerText = books.length;
  document.getElementById("countAuthors").innerText = authors.length;
  document.getElementById("countMembers").innerText = members.length;
  document.getElementById("countLoans").innerText = loans.length;

  let html = "";
  for (let i = 0; i < loans.length; i++) {
    html += "<tr><td>" + loans[i].book + "</td><td>" + loans[i].member + "</td><td>" + loans[i].dueDate + "</td><td>" + loans[i].status + "</td></tr>";
  }
  document.getElementById("recentLoans").innerHTML = html;
}

function searchOpenLibrary() {
  document.getElementById("apiResult").innerText = "Open Library results will appear here in the future.";
}
