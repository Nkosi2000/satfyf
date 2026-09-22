import { defineRailway, github, group, project, service } from "railway/iac";

export default defineRailway(() => {
  const source = github("Nkosi2000/satfyf", { branch: "main" });

  // Public web app. Build/start are left to Railpack's native Laravel
  // detection (composer install + npm build + PHP-FPM/Caddy on $PORT) —
  // matches what was already configured in the dashboard before this file
  // existed. preDeploy runs after build, before the new deployment goes
  // live, with env vars and the private network available — the right
  // place for migrations and framework caches, not the build step (which
  // runs before variables are guaranteed final) and not the start command
  // (which would re-run them on every restart, not just every deploy).
  const web = service("satfyf", {
    source,
    preDeploy:
      "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache",
    healthcheck: "/up",
    healthcheckTimeout: 120,
    replicas: 1,
  });

  // Background processes — no HTTP surface, so no healthcheck/domain.
  // Skip the npm build these don't need; only the PHP app itself.
  const scheduler = service("scheduler", {
    source,
    build: "composer install --no-dev --optimize-autoloader",
    // Laravel's own loop that calls schedule:run every minute — this is
    // what keeps app:warm-storage-urls actually running hourly in
    // production. Without this service, WarmStorageUrls::isStale() will
    // permanently show stale on the admin dashboard and the storage-URL
    // cold-cache risk from 22 Sept 2026 comes back.
    start: "php artisan schedule:work",
    replicas: 1,
  });

  const queueWorker = service("queue-worker", {
    source,
    build: "composer install --no-dev --optimize-autoloader",
    // Processes QUEUE_CONNECTION=redis jobs (currently: AdminResetPassword).
    // Without this service, queued notifications sit in Redis forever.
    start: "php artisan queue:work --tries=3",
    replicas: 1,
  });

  return project("diligent-youth", {
    resources: [web, group("Workers", [scheduler, queueWorker])],
  });
});
