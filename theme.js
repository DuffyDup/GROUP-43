document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("dark-mode-toggle");

    if (!darkModeToggle) {
        console.error("Dark mode button not found!");
        return;
    }

    
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode");
        darkModeToggle.textContent = "Switch to: Light Mode"; 
    } else {
        darkModeToggle.textContent = " Switch to: Dark Mode"; 
    }

    darkModeToggle.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            darkModeToggle.textContent = "Switch to: Light Mode"; 
        } else {
            localStorage.setItem("theme", "light");
            darkModeToggle.textContent = "Switch to: Dark Mode"; 
        }
    });
});

