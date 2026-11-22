# DPL-T003 — Make startup safe for rootless mounts and camera devices

**Iteration ID:** ITER-001
**Status:** Not started — blocked by DPL-T002 and per-ticket approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** DPL-T002

## Goal

Prevent container startup from changing host source, environment-file, or camera-node permissions while retaining writable application data and camera access.

## Scope

- Restrict ownership initialization to writable application data-volume paths.
- Remove entrypoint attempts to `chgrp`/`chmod` host camera nodes and recursive ownership changes on source or environment paths.
- Configure and document the minimum camera-device mapping supported by existing device discovery.
- Add a disposable bind-mount test for source/env immutability and data-volume writability.

## Acceptance criteria

- Startup does not change source or environment file ownership/content.
- Data-volume paths remain writable by the application user.
- Missing device access produces an explicit diagnostic and does not trigger a host permission change.
- Camera discovery behavior in `HardwareModel` is unchanged.

## Open question

- **DPL-T003-Q01 — What device mapping and persistent host permissions are required?** Owner: operator/user. Status: open until tested after manual provisioning on the workstation and an ARM64 target.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
