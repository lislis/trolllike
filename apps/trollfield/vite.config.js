import { fileURLToPath, URL } from "node:url";

import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],

    resolve: {
	alias: {
	    "@": fileURLToPath(new URL("./src", import.meta.url)),
	},
    },
    build: {
        sourcemap: true,
        rollupOptions: {
            output: {
                chunkFileNames: '[name].js',
                entryFileNames: '[name].js',
                assetFileNames: "assets/[name].[ext]",
            },
        },
    }
});
