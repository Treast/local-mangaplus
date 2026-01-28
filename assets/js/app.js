import Alpine from "alpinejs";
import tippy from "tippy.js";
import "../bootstrap.js";

import "../css/app.css";
import "tippy.js/dist/tippy.css";

window.Alpine = Alpine;

Alpine.start();

tippy("[data-tippy-content]");
