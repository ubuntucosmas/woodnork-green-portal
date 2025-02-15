// assets/js/scripts.js
document.querySelectorAll('.dashboard-item').forEach(item => {
  item.addEventListener('click', () => {
    const department = item.getAttribute('data-department');
    const username = prompt(`Enter your username for the ${department} department:`);
    const password = prompt(`Enter your password for the ${department} department:`);

    if (username && password) {
      alert(`Logged in as ${username} for ${department}`);
      // Proceed with login logic here
    } else {
      alert('Login cancelled.');
    }
  })
});
// sidebar collapse toggle
document.addEventListener('DOMContentLoaded', function () {
  const burgerMenu = document.querySelector('.burger-menu');
  const sidebar = document.getElementById('sidebar');
  const content = document.querySelector('.content');

  burgerMenu.addEventListener('click', function () {
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('expanded');
  });
});
document.querySelectorAll('.nav-menu a').forEach(link => {
  link.addEventListener('click', function(event) {
      event.preventDefault();
      const page = this.getAttribute('data-page');

      fetch(page)
          .then(response => response.text())
          .then(html => {
              document.querySelector('.dashboard-main').innerHTML = html;
          })
          .catch(error => console.error('Error loading page:', error));
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const sidebarMenu = document.getElementById("sidebar-menu");
  const navLinks = document.querySelectorAll(".nav-link");

  // Function to set active menu item
  function setActiveMenu(page) {
      navLinks.forEach(link => {
          if (link.getAttribute("data-page") === page) {
              link.parentElement.classList.add("active");
          } else {
              link.parentElement.classList.remove("active");
          }
      });
  }

  // Check for stored active menu
  const storedPage = localStorage.getItem("activePage");
  if (storedPage) {
      setActiveMenu(storedPage);
  }

  // Add click event to each nav link
  navLinks.forEach(link => {
      link.addEventListener("click", function () {
          const page = this.getAttribute("data-page");
          setActiveMenu(page);
          localStorage.setItem("activePage", page); // Save active page
      });
  });
});


