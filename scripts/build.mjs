import path from "node:path";

import { buildSite } from "./lib/build-site.mjs";

function getOutDirArg(argv) {
  const outDirFlagIndex = argv.indexOf("--out-dir");

  if (outDirFlagIndex === -1) {
    return process.cwd();
  }

  const outDirValue = argv[outDirFlagIndex + 1];

  if (!outDirValue) {
    throw new Error("Missing value for --out-dir.");
  }

  return path.resolve(process.cwd(), outDirValue);
}

const outDir = getOutDirArg(process.argv.slice(2));
const summary = await buildSite({
  rootDir: process.cwd(),
  outDir,
});

console.log(`Built ${summary.pages} pages into ${summary.output}`);
