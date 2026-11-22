# Stage 4: Rootless multi-environment deployment

**Status:** Approved by user — proceed to Stage 5 delivery plan
**Scope:** Replace the current sudo/rootful-oriented local and deployment workflow with a rootless-Docker-only workflow for local, QA, and production. This stage defines the intended architecture and verification strategy; it does not authorize implementation.

## Goal

Use the same rootless Docker-based runtime for local testing, QA, and production, with explicit per-instance configuration and persistent data separation. Deployment should be invocable from the user's machine, use SSH keys, and avoid silently provisioning or modifying target hosts.

## Confirmed decisions and constraints

- Rootless Docker is the only supported runtime; do not fall back to rootful Docker or `sudo docker`.
- Support the user's Linux workstation and ARM64 Raspberry Pi targets.
- Use a tracked, non-secret instance inventory for local, `qa.server`, and `prod.server` targets. Each target must declare its environment and host HTTP port; do not assume port 80.
- Keep separate, untracked local environment files for local, QA, and production values. Local production-mode testing must use sanitized local values, not production secrets or production data.
- Exclude `.env*` and other secret-bearing files from build contexts and deployment archives. Runtime configuration may be supplied to Compose without mounting `.env` into the application source tree. Preflight must not inspect environment-file contents.
- Use instance-specific persistent volumes for SQLite, timelapse photos/videos, and Redis. Container recreation and redeployment must preserve them; deployment must not run `migrate:fresh`.
- Keep Redis on the private Compose network. Serve Horizon through the app's configured HTTP port at `/horizon`.
- Preflight checks local and remote prerequisites, reports failures and manual remediation, and does not install software, alter host configuration, or inspect `.env` files.
- Use SSH-key authentication. Do not interpolate or forward sudo passwords through SSH commands. Host provisioning remains a separate manual task.
- Only consider removing the user's local Docker-group membership after rootless scripts and validation are complete; scripts must not depend on that group.
- Do not change camera discovery behavior in `HardwareModel` as part of this deployment work.

## Proposed design

1. **Target selection:** A small tracked inventory defines target alias, environment, host, and required host port. Secret values remain in ignored per-environment files. Deployment requires an explicit target and fails before changing anything when its inventory entry, port, environment file, SSH access, or rootless runtime is missing.
2. **Rootless Compose project:** Use a distinct Compose project/volume namespace per instance. Remove fixed container names and shared external volume names so local, QA, and production cannot accidentally share state. Bind the app's container HTTP port to the explicitly configured host port.
3. **Runtime environment:** Pass the selected environment values to the container at runtime; do not bind-mount an environment file over `/srv/.env`. Keep local production-mode settings sanitized and isolated from real QA/production credentials.
4. **Redis and Horizon:** Do not publish host port 6379. The app and Horizon use Redis over the private Compose network. Horizon remains available at `/horizon` through the public app URL. The current `HorizonServiceProvider` authorizes every visitor; this proposal does not add authentication. Therefore, a public app URL also exposes the unauthenticated Horizon dashboard, a residual risk the user has accepted for this iteration.
5. **Rootless-safe startup:** Do not change ownership of the source tree or mounted environment files, and do not attempt to `chgrp`/`chmod` host camera nodes from the container entrypoint. Initialize ownership only on application data-volume paths. Camera access must be granted by explicit device mapping and host permissions; preflight reports missing access and gives manual remediation rather than changing host ACLs.
6. **Architecture support:** Replace the amd64-only `gosu` download with an architecture-aware build step for amd64 and ARM64. Build on the target's rootless daemon from a secret-free source bundle, avoiding a registry requirement.
7. **Deployment lifecycle:** Preflight is read-only. Deployment uploads only the selected source/configuration, builds and starts the target stack, runs non-destructive migrations, and verifies the app and Horizon endpoint. Named volumes remain untouched on updates. Destructive database reset commands are never part of deployment.

## Host and camera constraints

The rootless proof of concept established that the existing camera discovery code can find devices, but the container's mapped `www-data` UID did not inherit the login user's camera ACL. A temporary host ACL for the mapped UID enabled a capture test. Therefore, camera permissions are a manual host-provisioning prerequisite; preflight must detect/report access without applying ACLs. The exact device mapping and persistent host permission setup must be validated on both the workstation and ARM64 targets before claiming camera support.

The previous proof of concept also showed that the existing entrypoint's recursive ownership change can alter ownership of bind-mounted source files. That behavior must be removed or constrained to data volumes before using the workflow with the user's working tree or environment files.

## Verification strategy

| Requirement | Verification |
|---|---|
| Rootless-only commands | Script tests/mocks verify Docker commands use the selected rootless context and never invoke `sudo` or a rootful fallback. |
| Explicit, isolated targets | Validate inventory selection, required host port, environment mapping, and unique per-instance Compose project/volume names. |
| Secret exclusion | Inspect generated build/deploy archives and Docker build context to confirm `.env*` files are absent; verify preflight does not read their contents. |
| Persistent data | On a disposable integration instance, migrate/create data, recreate the app stack, and confirm SQLite and timelapse data remain. Verify normal migrations are used and `migrate:fresh` is absent from deployment. |
| Redis private, Horizon reachable | Validate Compose publishes the app port but not Redis port 6379; perform HTTP checks against `/` and `/horizon` on the selected app port. |
| Safe entrypoint | Run against a disposable bind-mounted source/env fixture and confirm source and environment-file ownership/contents are unchanged while data-volume directories are writable by the app user. |
| ARM64 support | Build the image for amd64 and ARM64; verify the selected `gosu` binary matches the target architecture. |
| Read-only preflight | Exercise successful and failing prerequisite checks with mocks; confirm it reports remediation and makes no installation, ACL, permission, or host-configuration changes. |
| Camera access | Validate device discovery and a capture on the workstation and at least one ARM64 device after manual provisioning; a failed check must identify missing device/permission access. |
| SSH deployment | Test target resolution and deployment command construction with a non-production fixture; verify no password interpolation and no accidental target fallback. |

## Out of scope and residual risks

- Automatic installation of Docker/rootless components, host provisioning, ACL changes, or system configuration.
- Changes to application authentication, CSRF, or Horizon authorization. The current public web routes and Horizon dashboard are not protected; rootless Docker does not mitigate that exposure.
- Backup/restore policy. Named-volume persistence protects against container recreation, not host or storage failure.
- Production deployment itself; a successful local/QA verification is not a production deployment claim.

## Approval gate

After approval of this design, proceed to Stage 5 to make a bounded implementation plan. Do not change deployment scripts, Compose files, Dockerfiles, or entrypoint behavior until the design is approved. Any material discovery about camera access, secret handling, or architecture support returns to this stage for revision.
