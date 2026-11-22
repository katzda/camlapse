# Copilot instructions for camlapse

## Project shape

This repository is a Laravel 11 app that schedules camera captures, stores metadata in SQLite/MySQL-compatible Laravel tables, and turns captured stills into a time-lapse video with ffmpeg.

The important runtime flow is:

- `routes/web.php` defines the browser UI and route-level actions for devices and timelapse records.
- `app/Http/Controllers/*` and `app/Http/Requests/*` handle the admin UI for camera devices and timelapse configuration.
- `app/Models/Camlapse.php` stores the schedule and cron fields for each timelapse; the `getCronAttribute()` helper concatenates the per-field cron values into a single expression.
- `app/Services/CameraLapseService.php` decides whether a capture is due and actually calls ffmpeg to save a still from a video device.
- `app/Console/Commands/CamLapseCmd.php` is the scheduler entry point: it loads all `Camlapse` rows, checks `isDue()`, and dispatches a `CrunchVideoEvent` when a snapshot succeeds.
- `app/Jobs/CrunchVideo.php` assembles `public/timelapse/{id}/photos/*.jpg` into `public/timelapse/{id}/video.mp4` using ffmpeg concat mode. This is the main post-capture background job.
- `app/Models/HardwareModel.php` scans available video devices and verifies them with ffmpeg before writing the `camera` table entries.
- `database/migrations/*` defines the project tables: `camera`, `camlapses`, and `job_meta`.

Important convention: this app is not a standard CRUD app. The behavior depends on system commands (`ffmpeg`, `v4l2-ctl`, shell file operations) and direct writes under `public/timelapse/...`.

## Build, test, and lint commands

Setup:

- `composer install`
- `npm install`

Frontend asset build:

- `npm run dev` (runs `vite build`)
- `npm run watch` (runs `vite build --watch`)

PHP test suite:

- `php artisan test`
- Single file: `php artisan test tests/Feature/ExampleTest.php`
- Single test or method filter: `php artisan test --filter=ExampleTest tests/Feature/ExampleTest.php`

Formatting/linting:

- `./vendor/bin/pint --test`
- `./vendor/bin/pint` to auto-fix formatting issues

There is no custom repo-level test script in `package.json` or `composer.json`; the Laravel/PHPUnit setup is the canonical validation path for code changes.

## Key conventions specific to this project

- Follow the existing Laravel structure: controllers stay thin, logic belongs in Eloquent models or dedicated services, and request classes validate input.
- Keep the `Camlapse` data model and column names aligned with the migration schema (`camera_id`, `cron_min`, `cron_hour`, `cron_day`, `cron_weekday`, `cron_month`, `between_time_start`, `between_time_end`, `stop_datetime`, `is_active`).
- The `Camlapse` model intentionally builds a cron string from separate fields via `getCronAttribute()`. When changing schedule behavior, keep this combined cron semantics in sync with `CameraLapseService::isDue()`.
- Camera discovery is done by probing devices with ffmpeg; do not assume the device list is static. Changes to hardware detection should keep `HardwareModel::getFunctionalVideoDevice()` and the `camera` table model in step.
- Video generation writes to `public/timelapse/<id>/photos` and assembles `video.mp4` in the parent directory. The app uses file timestamps in the UI (`?v=<mtime>`) to invalidate browser caches for generated videos.
- Queue behavior is intentionally explicit: `CrunchVideoEvent` dispatches a queued job in the `camera` queue, and `JobMeta` prevents overlapping work by checking whether the most recent job ended before starting a new one.
- Keep shell-based ffmpeg commands in the service/job layer; do not move this into controller methods or front-end code.

## Notes from the repo

- The primary app docs are minimal; the repository relies on Laravel conventions and the code itself for behavior.
- There are no custom AI instructions or repo-specific rule files present (for example, no `CLAUDE.md`, `AGENTS.md`, `.cursorrules`, or equivalent were found in the root of this repo).
