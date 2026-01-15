from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # Go to Home
    print("Navigating to Home...")
    page.goto("http://127.0.0.1:8000")

    # Check Title
    expect(page).to_have_title("Toko Digital")

    # Check Search Bar (Indonesian)
    expect(page.get_by_placeholder("Cari produk...")).to_be_visible()

    # Check Categories (Header) - Indonesian
    expect(page.get_by_role("heading", name="Kategori")).to_be_visible()
    expect(page.get_by_role("heading", name="Produk Populer")).to_be_visible()

    print("Home page verified (Indonesian).")

    # Go to Admin Login
    print("Navigating to Admin Login...")
    page.goto("http://127.0.0.1:8000/admin")
    expect(page.get_by_role("heading", name="Admin Login")).to_be_visible()

    # Take Screenshot of Admin Login
    page.screenshot(path="verification/admin_login.png")

    # Take Screenshot of Home
    page.goto("http://127.0.0.1:8000")
    page.screenshot(path="verification/home.png")

    print("Screenshots taken.")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)
