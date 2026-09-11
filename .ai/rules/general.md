---
paths:
  - .env
---

# General

## Local dev runs against Neon Postgres via DB_URL, not the local host/user in .env
config/database.php's pgsql connection reads `env('DB_URL')` first, which overrides DB_HOST/DB_USERNAME/DB_PASSWORD when set. `.env` sets DB_URL to the Neon pooled connection string — the DB_HOST=127.0.0.1/DB_USERNAME=root values below it are unused leftovers from the Laravel skeleton and will fail if DB_URL is ever removed.

For schema migrations, temporarily override DB_URL to the *unpooled* Neon host (no `-pooler` suffix, same credentials — see DATABASE_URL_UNPOOLED in .env) since Neon's guidance is direct connections for migrations, pooled for app runtime: `DB_URL="<unpooled url>" php artisan migrate`.

phpunit.xml already clears DB_URL to "" and forces sqlite `:memory:` for the test suite — tests never touch the real Neon database.
