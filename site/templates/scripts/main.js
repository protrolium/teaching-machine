// theme switcher
const html = document.querySelector('html');
html.dataset.theme = `theme-dark`;
// let whichMode = localStorage.getItem('dark-mode');

function switchTheme(theme) {
    html.dataset.theme = `theme-${theme}`;
}

function switchAssets(theme) {

    if (theme === "dark") {
        document.getElementById("dark-mode-btn").innerHTML = '🌖';
        document.getElementById("dark-mode-btn-desktop").innerHTML = '🌖';
        document.getElementById("header-nav").style.color = "#fff";
        document.getElementById("header-nav-desktop").style.color = "#fff";

    } else {
        document.getElementById("dark-mode-btn").innerHTML = '🌒';
        document.getElementById("dark-mode-btn-desktop").innerHTML = '🌒';
        document.getElementById("header-nav").style.color = "#000";
        document.getElementById("header-nav-desktop").style.removeProperty("color");
        document.getElementById("header-nav-desktop").style.color = "000";
    }
}

// logos switcher
function toggleTheme() {
    if (html.dataset.theme === 'theme-light') {
        switchTheme('dark');
        switchAssets('dark');
        localStorage.setItem("dark-mode", "enabled");
    } else {
        switchTheme('light');
        switchAssets('light');
        localStorage.setItem("dark-mode", "disabled");
    }
}

// if (whichMode === "enabled") { // set state of darkMode on page load
//     document.addEventListener('DOMContentLoaded', (event) => {
//         switchAssets('dark');
//     });
// }

/*
// listen to os preference
const isOsDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const matchMediaPrefDark = window.matchMedia('(prefers-color-scheme: dark)');

function startListeningToOSTheme() {
    matchMediaPrefDark.addEventListener('change', onSystemThemeChange);
}

function stopListeningToOSTheme() {
    matchMediaPrefDark.removeEventListener('change', onSystemThemeChange);
}

function onSystemThemeChange(e) {
    const isDark = e.matches;
    document.querySelector('html').dataset.theme = `theme-${isDark ? 'dark' : 'light'}`;
}
*/