function toggleTopicDropdown() {
    var dropdown = document.getElementById("topicDropdown");
    dropdown.style.display = "block";
}

function toggleAccountDropdown() {
    var dropdown = document.getElementById("accountDropdown");
    dropdown.style.display = "block";
}

// Đóng dropdown nếu click bên ngoài dropdown
window.onclick = function(event) {
    if (!event.target.matches('.topic-dropdown-content, #topicInput, #account, .account-dropdown-content')) {
        var dropdowns = document.getElementsByClassName("topic-dropdown-content, .account-dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}