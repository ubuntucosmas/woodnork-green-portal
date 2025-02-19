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



//function to Load searched data




// function to load data on refresh 

function loadStoreData() {
  // let item = document.getElementById("search_item").value;
  // let type = document.getElementById("filter_type").value;
  // let date = document.getElementById("filter_date").value;

  // Show loading state
  document.getElementById("total_stock").innerText = "Loading...";
  document.getElementById("low_stock").innerText = "Loading...";
  document.getElementById("recent_transactions").innerText = "Loading...";
  document.getElementById("transactions_body").innerHTML = `<tr><td colspan="5">Loading...</td></tr>`;

  fetch("pages/store_overview.php")
  .then(response => response.json())
  .then(data => {
      document.getElementById("total_stock").innerText = data.total_stock;
      document.getElementById("low_stock").innerText = data.low_stock;
      document.getElementById("recent_transactions").innerText = data.recent_transactions;

      let transactionsTable = document.getElementById("transactions_body");
      transactionsTable.innerHTML = "";

      if (data.transactions.length > 0) {
          data.transactions.forEach((item, index) => {
              transactionsTable.innerHTML += `
                  <tr>
                      <td>${index + 1}</td>
                      <td>${item.item_name}</td>
                      <td>${item.quantity}</td>
                      <td>${item.unit_of_measure}</td>
                      <td>${formatDate(item.created_at)}</td>
                      <td>${item.status}</td>
                  </tr>`;
          });
      } else {
          transactionsTable.innerHTML = `<tr><td colspan="5">No stock items found.</td></tr>`;
      }
  })
  .catch(error => {
      console.error("Error fetching store data:", error);
      document.getElementById("transactions_body").innerHTML = `<tr><td colspan="5">Failed to load data.</td></tr>`;
  });


}
// Load data on page load
document.addEventListener("DOMContentLoaded", function () {
  loadStoreData();
});
// adding event listeners to side bar links
document.querySelectorAll('.nav-menu a').forEach(link => {
  link.addEventListener('click', function(event) {
      event.preventDefault();
      const page = this.getAttribute('data-page');

      fetch(page)
          .then(response => response.text())
          .then(html => {
              document.querySelector('.dashboard-main').innerHTML = html;
              loadStoreData();
          })
          .catch(error => console.error('Error loading page:', error));
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-link");
  const dashboardMain = document.querySelector(".dashboard-main");

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

  // Check for stored active menu and apply it on reload
  const storedPage = localStorage.getItem("activePage") || "pages/dashboard.php"; // Default to dashboard
  setActiveMenu(storedPage);

  // Load default page content on refresh
  fetch(storedPage)
      .then(response => response.text())
      .then(html => {
          dashboardMain.innerHTML = html;
          loadStoreData();
      })
      .catch(error => console.error("Error loading page:", error));

  // Add click event to each nav link
  navLinks.forEach(link => {
      link.addEventListener("click", function (event) {
          event.preventDefault();
          const page = this.getAttribute("data-page");

          // Load new content dynamically
          fetch(page)
              .then(response => response.text())
              .then(html => {
                  dashboardMain.innerHTML = html;
                  setActiveMenu(page);
                  localStorage.setItem("activePage", page); // Save active page
                  loadStoreData(); // Reload store data after page load
              })
              .catch(error => console.error("Error loading page:", error));
      });
  });
});


//for the search functionality

function loadStock() {
  let searchItem = document.getElementById("search_item").value.trim();
  let filterType = document.getElementById("filter_type").value;
  let filterDate = document.getElementById("filter_date").value;

  let url = `search_filter_process.php?search_item=${encodeURIComponent(searchItem)}&filter_type=${encodeURIComponent(filterType)}&filter_date=${encodeURIComponent(filterDate)}`;

  fetch(url)
      .then(response => response.json())
      .then(data => {
          displayStoreData(data);
      })
      .catch(error => console.error("Error fetching data:", error));
}

// Function to display store data in a table (example)
function displayStoreData(data) {
  let tableBody = document.getElementById("storeTableBody");
  tableBody.innerHTML = ""; // Clear previous content

  if (data.length === 0) {
      tableBody.innerHTML = "<tr><td colspan='5'>No results found</td></tr>";
      return;
  }

  data.forEach(item => {
      let row = `<tr>
          <td>${item.date}</td>
          <td>${item.item_name}</td>
          <td>${item.type}</td>
          <td>${item.quantity}</td>
          <td>${item.status}</td>
      </tr>`;
      tableBody.innerHTML += row;
  });
}
