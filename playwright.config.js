import path from "node:path";
import { defineConfig } from "@playwright/test";

const repoName = path.basename(process.cwd());
const baseURL = `http://127.0.0.1:4173/${repoName}/`;

export default defineConfig({
  testDir: "./tests",
  fullyParallel: false,
  retries: 0,
  use: {
    baseURL,
    trace: "on-first-retry",
  },
  webServer: {
    command: "python3 -m http.server 4173 --directory ..",
    url: baseURL,
    reuseExistingServer: true,
    timeout: 120_000,
  },
});
