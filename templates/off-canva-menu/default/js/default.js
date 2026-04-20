document.addEventListener("DOMContentLoaded", function () {
	let off_canvas_menu = document.getElementById("iw-off-canvas-menu");

	let menu_toggle_button = document.querySelectorAll(".iw-offcanvas-menu-toggle");
	let menu_close_button = document.querySelectorAll(".iw-offcanvas-menu-close");
	let menu_open_button = document.querySelectorAll(".iw-offcanvas-menu-open");

	if (off_canvas_menu) {
		if (menu_toggle_button) {
			menu_toggle_button.forEach(function (e) {
				e.addEventListener("click", function() {
					if (off_canvas_menu.classList.contains("iw-hidden")) {
						off_canvas_menu.style.display = "block";
						setTimeout(function () {
							off_canvas_menu.classList.remove("iw-hidden");
							off_canvas_menu.classList.add("iw-shown");
						}, 100);
					}
					else if (off_canvas_menu.classList.contains("iw-shown")) {
						off_canvas_menu.classList.remove("iw-shown");
						off_canvas_menu.classList.add("iw-hidden");
						setTimeout(function () {
							off_canvas_menu.style.display = "none";
						}, 1000);
					}
				});
			});
		}
		if (menu_close_button) {
			menu_close_button.forEach(function (e) {
				e.addEventListener("click", function() {
					if (off_canvas_menu.classList.contains("iw-shown")) {
						off_canvas_menu.classList.remove("iw-shown");
						off_canvas_menu.classList.add("iw-hidden");
						setTimeout(function () {
							off_canvas_menu.style.display = "none";
						}, 1000);
					}
				});
			});
		}
		if (menu_open_button) {
			menu_open_button.forEach(function (e) {
				e.addEventListener("click", function() {
					if (off_canvas_menu.classList.contains("iw-hidden")) {
						off_canvas_menu.style.display = "block";
						setTimeout(function () {
							off_canvas_menu.classList.remove("iw-hidden");
							off_canvas_menu.classList.add("iw-shown");
						}, 100);
					}
				});
			});
		}
	}


	const parents = document.querySelectorAll(".off-canvas-menu .menu-item-has-children");
    parents.forEach(sub => {
        sub.classList.add("closed");
    });

    parents.forEach(parent => {
        // Crear botón toggle
        const toggleBtn = document.createElement("button");
        toggleBtn.classList.add("submenu-toggle");
        toggleBtn.setAttribute("aria-label", "Abrir submenú");
        toggleBtn.innerHTML = "+";

        // Insertar el botón al lado del enlace
        const link = parent.querySelector("a");
        link.after(toggleBtn);

        // Acción al hacer clic
        toggleBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const submenu = parent.querySelector(".sub-menu");

            if (!submenu) return;

            parent.classList.toggle("closed");

            // Cambiar símbolo
            toggleBtn.innerHTML = parent.classList.contains("closed") ? "+" : "−";
        });
    });
});