self.addEventListener("install", (event) => {
  console.log("Service worker installed");
});

self.addEventListener("fetch", function (event) {
  // Default fetch logic; extend for offline caching if needed
});
