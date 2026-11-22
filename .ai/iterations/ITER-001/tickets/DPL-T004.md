# DPL-T004 — Replace sudo wrappers and add read-only preflight

**Iteration ID:** ITER-001
**Status:** Not started — blocked by DPL-T001, DPL-T002, and per-ticket approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** DPL-T001, DPL-T002

## Goal

Make local commands rootless-only and provide a read-only preflight for local and remote targets.

## Scope

- Update operational wrappers to use rootless Docker/Compose without `sudo` or a rootful fallback.
- Check rootless Docker/Compose, SSH resolution/access, required host port, target configuration, architecture, and camera availability/permissions.
- Report actionable failures and manual remediation without installing packages, changing host configuration, changing ACLs/permissions, or inspecting `.env` contents.
- Add mocked tests for successful and failing prerequisite checks.

## Acceptance criteria

- Runtime wrappers do not invoke `sudo` or rootful Docker.
- Preflight checks both local and remote prerequisites.
- Preflight makes no host changes and does not inspect environment-file contents.
- Failures identify the missing prerequisite and a manual remediation.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
