# System overview

**Status:** Proposed  
**Evidence snapshot:** Repository source and configuration reviewed for Stage 1 inception.

## Runtime flow

```mermaid
flowchart TD
    Browser[Browser UI] --> Routes[Web routes]
    Routes --> Controllers[Controllers and form requests]
    Controllers --> Models[Eloquent models]
    Models --> DB[(SQLite by default)]

    Scheduler[Laravel scheduler<br/>every minute] --> Command[CamLapseCmd]
    Command --> ScheduleCheck[CameraLapseService<br/>schedule checks]
    ScheduleCheck -->|due| Capture[ffmpeg still capture]
    Capture --> Photos[public/timelapse/{id}/photos]
    Capture -->|success| Event[CrunchVideoEvent]
    Event --> Listener[CrunchVideo listener<br/>registered in AppServiceProvider]
    Listener --> Job[CrunchVideo job]
    Job --> Photos
    Job --> Video[ffmpeg video assembly]
    Video --> Output[public/timelapse/{id}/video.mp4]
    Job --> Meta[(job_meta)]

    Routes --> Discovery[HardwareModel device discovery]
    Discovery --> Tools[v4l2-ctl and ffmpeg]
    Discovery --> Cameras[(camera table)]
```

## Boundaries and responsibilities

- **Web/application layer:** `routes/web.php`, controllers, and request validation expose the configuration and device-management interface.
- **Persistence:** Eloquent models use the `camlapses`, `camera`, and `job_meta` tables defined by migrations. SQLite is the configured default connection.
- **Scheduling and capture:** the Laravel scheduler invokes `CamLapseCmd` every minute; `CameraLapseService` checks active status, stop time, allowed time window, and cron expression before capture.
- **Hardware integration:** `HardwareModel` probes video devices using `v4l2-ctl` and ffmpeg. Capture/video processing also invokes ffmpeg directly.
- **Video processing:** a successful capture dispatches `CrunchVideoEvent`; `AppServiceProvider` maps it to the `CrunchVideo` listener/job. The job uses saved photos and updates `job_meta`.
- **Deployment/runtime:** Docker Compose defines the app, Redis, and persistent database/timelapse volumes. Device access and actual ffmpeg/v4l2 availability depend on the host/container environment.

## Relevant source

- Schedule registration: `routes/console.php`
- Capture command and due logic: `app/Console/Commands/CamLapseCmd.php`, `app/Services/CameraLapseService.php`
- Event/listener wiring: `app/Events/CrunchVideoEvent.php`, `app/Providers/AppServiceProvider.php`
- Video creation and processing metadata: `app/Jobs/CrunchVideo.php`, `app/Models/JobMeta.php`
- Device discovery: `app/Models/HardwareModel.php`
- Data schema and runtime configuration: `database/migrations/`, `config/database.php`, `config/queue.php`
- Containers and persistent volumes: `docker-compose.dev.yml`, `docker-compose.prod.yml`

## Proposed deployment direction

The deployment design under review is documented in [Stage 4: Rootless multi-environment deployment](../lifecycle/stage-04-solution-design.md). Its current proposal uses rootless Docker for local, QA, and production targets; publishes the app (including Horizon at `/horizon`) on each target's configured HTTP port; keeps Redis private; and isolates persistent data by instance. This is a proposal, not an implementation or deployment guarantee.
