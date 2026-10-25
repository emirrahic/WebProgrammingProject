const books = [
  { id: 1, title: "1984", author: "George Orwell", category: "Fiction", isbn: "9780451524935", copies: 3 },
  { id: 2, title: "Animal Farm", author: "George Orwell", category: "Fiction", isbn: "9780451526342", copies: 2 },
  { id: 3, title: "A Brief History of Time", author: "Stephen Hawking", category: "Science", isbn: "9780553380163", copies: 1 },
  { id: 4, title: "Death and the Dervish", author: "Mesa Selimovic", category: "Novel", isbn: "9788670000001", copies: 4 }
];
const authors = [
  { id: 1, name: "George Orwell", country: "United Kingdom" },
  { id: 2, name: "Stephen Hawking", country: "United Kingdom" },
  { id: 3, name: "Mesa Selimovic", country: "Bosnia and Herzegovina" }
];
const categories = [
  { id: 1, name: "Fiction", description: "Made-up stories" },
  { id: 2, name: "Science", description: "Science and nature" },
  { id: 3, name: "Novel", description: "Long literary works" }
];
const members = [
  { id: 1, name: "Amar Hodzic", email: "amar@example.com", role: "member" },
  { id: 2, name: "Lejla Begic", email: "lejla@example.com", role: "member" },
  { id: 3, name: "Admin User", email: "admin@example.com", role: "admin" }
];
const loans = [
  { id: 1, book: "1984", member: "Amar Hodzic", loanDate: "2026-10-01", dueDate: "2026-10-15", status: "Borrowed" },
  { id: 2, book: "Animal Farm", member: "Lejla Begic", loanDate: "2026-09-20", dueDate: "2026-10-04", status: "Returned" }
];
