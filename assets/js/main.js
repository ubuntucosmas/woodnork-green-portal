// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

$(document).ready(function() {
  $(".menu-link").click(function(e) {
      e.preventDefault();
      let pageUrl = $(this).data("page");

      $(".main-content").html("<p>Loading...</p>");

      $.ajax({
          url: pageUrl,
          type: "GET",
          success: function(response) {
              console.log("Success:", response); // ✅ Log success response
              $(".main-content").html(response);
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", xhr.status, xhr.statusText, xhr.responseText); // ❌ Log errors
              $(".main-content").html(`<p>Error loading page: ${xhr.status} - ${xhr.statusText}</p>`);
          }
      });
  });
});





