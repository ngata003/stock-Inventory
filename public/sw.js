const CACHE_NAME = 'cames-stock-cache-v1';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/assets/images/cames_favIcon.png',
  '/assets/images/cames_stock.png',
  '/assets/images/banni1.png',
  '/assets/images/banni2.png',
  '/assets/videos/demo.mp4',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
  'https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css'
];

// Installer le SW et mettre en cache
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(urlsToCache))
  );
});

// Activer le SW
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.filter(name => name !== CACHE_NAME)
                  .map(name => caches.delete(name))
      )
    )
  );
});

// Intercepter les requêtes pour offline
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request))
  );
});
