document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("dark-mode-toggle");

    if (!darkModeToggle) {
        console.error("Dark mode button not found!");
        return;
    }

    // Set initial theme based on localStorage
    const currentTheme = localStorage.getItem("theme");
    console.log('Current Theme from localStorage: ', currentTheme); // Debugging line

    // If "dark" is saved in localStorage, apply dark mode
    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode");
    }

    // Toggle dark mode on button click
    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            console.log("Dark mode enabled");
        } else {
            localStorage.setItem("theme", "light");
            console.log("Light mode enabled");
        }
    });
});
