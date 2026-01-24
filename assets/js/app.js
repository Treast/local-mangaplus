import Alpine from 'alpinejs'
import feather from 'feather-icons'

import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers"
import '../stimulus_bootstrap.js';

import '../css/app.css'

window.Alpine = Alpine

Alpine.start()

feather.replace();

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
