# DPL-T005 — Implement explicit SSH-key deployment

**Iteration ID:** ITER-001
**Status:** Not started — blocked by DPL-T001–DPL-T004 and per-ticket approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** DPL-T001–DPL-T004

## Goal

Deploy one explicitly selected instance from the user's machine to its rootless Docker host without forwarding passwords or risking persistent data.

## Scope

- Require a named target resolved through the tracked inventory.
- Transfer the required secret-free source bundle and selected runtime configuration over SSH-key access.
- Build/start on the target's rootless daemon, run non-destructive migrations, and verify the app plus `/horizon`.
- Preserve named volumes; never use `migrate:fresh`.
- Test target resolution and command construction with fixtures before any remote deployment.

## Acceptance criteria

- Missing/unknown target fails before remote changes; there is no implicit production or QA selection.
- No sudo password is interpolated or forwarded.
- Build inputs exclude environment secrets.
- Redeployment preserves data and only runs normal migrations.
- Redis remains private and app/Horizon health checks use the configured app port.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
