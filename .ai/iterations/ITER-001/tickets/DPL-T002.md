# DPL-T002 — Make Compose and image builds instance-aware

**Iteration ID:** ITER-001
**Status:** Not started — blocked by DPL-T001 and per-ticket approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** DPL-T001

## Goal

Make the Compose runtime use per-instance configuration and persistent storage under rootless Docker on amd64 and ARM64.

## Scope

- Derive Compose project and volume names from the selected instance; remove fixed container names and shared external volume names.
- Require an explicit configured host port for the app's internal HTTP service.
- Pass selected runtime values without mounting `.env` over `/srv/.env`.
- Keep Redis on the private Compose network and remove host publication of port 6379; retain Horizon access via the app HTTP port.
- Make the image's `gosu` binary selection architecture-aware and build natively on each target's rootless daemon.
- Add Compose configuration checks using non-secret fixture values.

## Acceptance criteria

- Local, QA, and production use distinct persistent database, timelapse, and Redis volumes.
- Missing port configuration fails instead of selecting a default host port.
- Compose publishes the app port only; Redis has no host-published port.
- The image selects compatible binaries for amd64 and ARM64.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
