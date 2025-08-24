self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("stock-app-cache").then((cache) => {
      return cache.addAll([
        "/",
        "/css/app.css",
        "/js/app.js",
        "/icons/icon-192x192.png",
        "/icons/icon-512x512.png"
      ]);
    })
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
