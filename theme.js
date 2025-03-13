document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("dark-mode-toggle");

    if (!darkModeToggle) {
        console.error("Dark mode button not found!");
        return;
    }

    // Check local storage for theme preference
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode");
        darkModeToggle.textContent = "Switch to: Light Mode"; // Text for light mode
    } else {
        darkModeToggle.textContent = " Switch to: Dark Mode"; // Text for dark mode
    }

    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            darkModeToggle.textContent = "Switch to: Light Mode"; // Text for light mode
        } else {
            localStorage.setItem("theme", "light");
            darkModeToggle.textContent = "Switch to: Dark Mode"; // Text for dark mode
        }
    });
});

