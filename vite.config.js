import {defineConfig} from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    symfonyPlugin({
      stimulus: true,
    }),
    tailwindcss()
  ],
  build: {
    rollupOptions: {
      input: {
        app: "./assets/js/app.js"
      },
    }
  },
});
