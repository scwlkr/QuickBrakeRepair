import { expect, test } from "@playwright/test";

const mobileViewport = { width: 430, height: 932 };

async function openMobileNav(page, path = "/") {
  await page.setViewportSize(mobileViewport);
  await page.goto(path);
  await page.getByRole("button", { name: /open navigation/i }).click();
  await expect(page.locator(".site-nav")).toHaveClass(/is-open/);
}

test("mobile nav opens as a full drawer on the homepage", async ({ page }) => {
  await openMobileNav(page);

  const nav = page.locator(".site-nav");
  const navBox = await nav.boundingBox();

  expect(navBox).not.toBeNull();
  expect(navBox.width).toBeGreaterThan(300);
  expect(navBox.height).toBeGreaterThan(200);

  await expect(nav.getByRole("link", { name: "Home", exact: true })).toBeVisible();
  await expect(
    nav.getByRole("link", { name: "Contact", exact: true }),
  ).toBeVisible();
});

for (const path of ["/", "/contact/"]) {
  test(`mobile Services menu reveals Premium and Standard on ${path}`, async ({
    page,
  }) => {
    await openMobileNav(page, path);

    const servicesTrigger = page.getByRole("button", { name: /^Services$/i });

    await servicesTrigger.click();

    await expect(servicesTrigger).toHaveAttribute("aria-expanded", "true");

    const premiumLink = page.getByRole("link", { name: "Premium" });
    const standardLink = page.getByRole("link", { name: "Standard" });

    await expect(premiumLink).toBeVisible();
    await expect(standardLink).toBeVisible();

    const premiumBox = await premiumLink.boundingBox();
    const standardBox = await standardLink.boundingBox();

    expect(premiumBox).not.toBeNull();
    expect(standardBox).not.toBeNull();
    expect(premiumBox.x).toBeGreaterThanOrEqual(0);
    expect(standardBox.x).toBeGreaterThanOrEqual(0);
  });
}
