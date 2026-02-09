import { resolve } from 'path';
import handlebars from 'vite-plugin-handlebars';

export default {
  root: 'src',
  publicDir: 'public',
  plugins: [
    handlebars({
      partialDirectory: resolve(__dirname, 'src/partials'),
    }),
  ],
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'src/index.html'),
        service: resolve(__dirname, 'src/service/index.html'),
        serviceSuccess: resolve(__dirname, 'src/service/success/index.html'),
        findyourproductionnumber: resolve(__dirname, 'src/findyourproductionnumber/index.html'),
      },
    },
  },
};
