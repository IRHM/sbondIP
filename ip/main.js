let body = document.getElementsByTagName("body")[0];

/**
 * Get value of a cookie
 * @param name Name of cookie to fetch value of
 */
window.getCookie = function(name) {
  var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
  if (match) return match[2];
}

/**
 * Set current theme
 * @param theme Theme to change to
 */
function setTheme(theme) {  
  if (theme == "dark") {
    body.classList.add("dark");
  }
  else {
    body.classList.remove("dark");
  }
}

/**
 * Change theme on click of themeSwitch button
 */
document.getElementById("themeSwitch").addEventListener("click", function() {
  if (body.classList.contains("dark")) {
    setTheme("light");
    document.cookie = "theme=; expires=Thu, 01 Jan 1970 00:00:00 UTC; same-site=strict; secure";
  }
  else {
    setTheme("dark");
    document.cookie = `theme=dark; expires=${new Date().getTime() * 2}; same-site=strict; secure`;
  }

  // Enable transition here so there is no transition the first time the theme is set from cookie
  body.style.transition = "color 250ms ease-in-out, background-color 250ms ease-in-out, border-color 250ms ease-in-out";
});

/**
 * If theme cookie is set to dark, change theme
 */
if (window.getCookie("theme") == "dark") {
  setTheme("dark");
}
