import { spawn } from "node:child_process";
import path from "node:path";

import { buildSite } from "./lib/build-site.mjs";

function runCommand(command, args) {
  return new Promise((resolve, reject) => {
    const child = spawn(command, args, {
      cwd: process.cwd(),
      stdio: "inherit",
      shell: process.platform === "win32",
    });

    child.on("exit", (code) => {
      if (code === 0) {
        resolve();
        return;
      }

      reject(new Error(`${command} ${args.join(" ")} exited with code ${code}`));
    });
    child.on("error", reject);
  });
}

await buildSite({ rootDir: process.cwd(), outDir: process.cwd() });
await buildSite({
  rootDir: process.cwd(),
  outDir: path.join(process.cwd(), ".generated-site"),
});

await runCommand("git", ["diff", "--check"]);
await runCommand("node", ["--check", "assets/site.js"]);
await runCommand("node", ["--test", "tests/build-output.test.mjs"]);
await runCommand("npx", ["playwright", "test"]);
