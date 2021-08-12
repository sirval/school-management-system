const SmartSchool = "smartschools-v1";
const assets = [
  "/",
 
 "/index.php",
 "lib/bootstrap/css/bootstrap.min.css",
  
  "lib/font-awesome/css/font-awesome.css",
  "lib/advanced-datatable/css/demo_page.css",
  "lib/advanced-datatable/css/demo_table.css",
  "lib/advanced-datatable/css/DT_bootstrap.css",  
  "css/style.css",
  "css/style-responsive.css",
  "/dist/css/adminlte.min.css",
  "/plugins/fontawesome-free/css/all.min.css",
  "plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
  "/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
  "/plugins/datatables-responsive/css/responsive.bootstrap4.min.css"
  "/plugins/jquery/jquery.min.js",
  "/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
  "/plugins/bootstrap/js/bootstrap.bundle.min.js",
  "/dist/js/adminlte.js",
  "/plugins/jquery-mapael/jquery.mapael.min.js",
  "/plugins/jquery-mousewheel/jquery.mousewheel.js",
  "/plugins/jquery-mapael/maps/usa_states.min.js",
  "/plugins/raphael/raphael.min.js",
  "/plugins/datatables/jquery.dataTables.min.js",
  "/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
  "/plugins/datatables-responsive/js/dataTables.responsive.min.js",
  "/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
  "/dist/js/pages/dashboard2.js",
  "/dist/img/favicon.png",
  "/dist/img/apple-touch-icon.png",
  "/dist/img/boxed-bg.png",
  "/dist/img/boxed-bg.jpg",
  "/dist/img/hd-img.png",
  "/dist/img/uec-logo.png",
  "/dist/img/avatar5.png",
  "/dist/img/avatar3.png"
];

self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(SmartSchool).then(cache => {
      cache.addAll(assets);
    })
  );
});

self.addEventListener("fetch", fetchEvent => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then(res => {
      return res || fetch(fetchEvent.request);
    })
  );
});
