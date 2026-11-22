# Stage 1: Inception

**Status:** Historical snapshot — Stage 1 approval was not separately recorded
**Scope:** Read-only current-state discovery for the `katzda/camlapse` repository.  
**Outcome sought:** Establish an evidence-based picture of the existing application before selecting a product change. At the time of this snapshot, no future feature scope had been selected.

## Current-state summary

Camlapse is a Laravel 11 application for configuring timelapses, discovering connected video devices, capturing still images on a schedule, and assembling those images into videos.

The browser UI is routed through `routes/web.php`. Controllers use Eloquent models and form request classes to manage camera and timelapse configuration. The `camlapses` table stores individual schedules; the `camera` table stores detected device names and paths; `job_meta` records video-processing start/end events.

The Laravel scheduler invokes `CamLapseCmd` every minute (`routes/console.php`). The command checks each timelapse via `CameraLapseService`, captures a frame with ffmpeg when due, and dispatches `CrunchVideoEvent`. `AppServiceProvider` registers `CrunchVideo` as that event's listener. The job gathers JPEGs from `public/timelapse/{id}/photos`, uses ffmpeg to create `video.mp4`, and records processing metadata.

Camera detection uses `v4l2-ctl` and ffmpeg (`HardwareModel`). Application data is configured for SQLite at `/database/database.sqlite` by default (`config/database.php`). The Docker Compose files mount persistent database and timelapse volumes and define a Redis service. External hardware and executables are part of the runtime boundary.

## Evidence and constraints

- **Core flow:** `routes/console.php`, `app/Console/Commands/CamLapseCmd.php`, `app/Services/CameraLapseService.php`, `app/Events/CrunchVideoEvent.php`, `app/Providers/AppServiceProvider.php`, `app/Jobs/CrunchVideo.php`.
- **Configuration UI and persistence:** `routes/web.php`, `app/Http/Controllers/`, `app/Http/Requests/`, `app/Models/`, `database/migrations/`.
- **Hardware integration:** `app/Models/HardwareModel.php`; external `v4l2-ctl` and `ffmpeg` executables and camera devices are required for capture-related behavior.
- **Runtime/deployment:** `config/database.php`, `config/queue.php`, `docker-compose.dev.yml`, `docker-compose.prod.yml`, `docker/Dockerfile`.
- **Build/test:** `package.json` defines Vite build/watch scripts. `composer.json` includes Laravel/PHPUnit/Pint dependencies. `phpunit.xml` configures Unit and Feature suites; `tests/Feature/ExampleTest.php` contains a basic home-page response test. These files describe test infrastructure, not comprehensive workflow coverage.
- **Documentation:** `README.md` contains a local host-entry note and a Blade icon usage note; it does not describe the product workflow or deployment.
- **Verified test coverage:** Only the example tests were inspected; no behavior-specific camera scheduling or video-generation tests were found in the initial test-directory listing.

## Architecture

See [System overview](../architecture/system-overview.md) for a Mermaid flow and system boundaries.

## Historical questions and approval status

The initial prompts covered intended outcome (Q-001), operating environment (Q-002), and scope (Q-003). They are retained here as historical discovery topics; the user's later deployment goals and approved design are recorded in [ITER-001](../iterations/ITER-001/overview.md), so these prompts are no longer active blockers for that work.

The Stage 1 approval prompt was not separately answered. Later approval of Stage 4 does not retroactively approve Stage 1. This inception remains a historical current-state snapshot, not an active gate for ITER-001.

## Risks and unknowns at inception

- Camera capture and video generation depend on external hardware and system executables; automated test behavior for those integrations is not established by the current tests.
- Docker configuration shows local deployment components, but the intended production environment, operator, and operational expectations are not established by repository evidence.
- The repository does not establish which future product change should be prioritized.

## Subsequent work

The deployment iteration proceeded through later discovery, design, and delivery planning. Its current status and open questions are in [ITER-001](../iterations/ITER-001/overview.md); implementation remains gated by per-ticket approval.
