exports.config = {
  hostUrl: process.BASE_URL ?? "http://localhost:8000",
  adminUser: process.ADMIN_USER ?? "admin",
  adminPassword: process.ADMIN_PASSWORD ?? "admin",
  headless: process.HEADLESS === "true",
  slowMo: parseInt(process.SLOW_MO) || 0,
  timeout: parseInt(process.TIMEOUT) || 60,
};
