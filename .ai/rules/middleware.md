---
paths:
  - 'app/Http/Middleware/**'
---

# Middleware

## Guest redirect target is set explicitly in bootstrap/app.php, not Laravel's default 'login' route
This app has no route named `login` — only `admin.login`. `bootstrap/app.php` calls `$middleware->redirectGuestsTo(fn ($request) => route('admin.login'))` so the `auth` middleware doesn't throw RouteNotFoundException on unauthenticated requests. If a second authenticated area is ever added with its own login route, this closure needs to branch by request path instead of always returning admin.login.
