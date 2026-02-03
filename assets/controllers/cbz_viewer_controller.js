import { Controller } from "@hotwired/stimulus";
import lightGallery from "lightgallery";

import "lightgallery/css/lightgallery.css";
import "lightgallery/css/lg-zoom.css";
import "lightgallery/css/lg-thumbnail.css";
import "lightgallery/css/lg-fullscreen.css";

import lgZoom from "lightgallery/plugins/zoom";
import lgThumbnail from "lightgallery/plugins/thumbnail";
import lgFullscreen from "lightgallery/plugins/fullscreen";

export default class extends Controller {
  connect() {
    this.lightGallery = lightGallery(this.element, {
      plugins: [lgZoom, lgThumbnail, lgFullscreen],
      speed: 500,
      download: true,
      counter: true,
      fullScreen: true,
    });
  }

  disconnect() {
    if (this.lightGallery) {
      this.lightGallery.destroy();
    }
  }
}
