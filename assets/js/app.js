import Alpine from 'alpinejs'

import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers"
import '../stimulus_bootstrap.js';

import '../css/app.css'

window.Alpine = Alpine

Alpine.start()

const app = startStimulusApp();
registerControllers(
  app,
  import.meta.glob(
    "./controllers/*_controller.js",
    {
      query: "?stimulus",
      eager: true,
    },
  ),
);
