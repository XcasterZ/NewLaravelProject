document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".hidden-checkbox").forEach((checkbox, index) => {
        checkbox.addEventListener("change", function() {
            const toggleId = `toggle-${index + 1}`;
            const toggleElement = document.getElementById(toggleId);
            const checkboxImage = document.getElementById(`checkboxImage${index + 1}`);
            toggleElement.style.display = this.checked ? "block" : "none";
            checkboxImage.src = this.checked ? "Component Pic/arrow_down.png" : "Component Pic/arrow.png";
        });
    });
});