# DPL-T001 — Define instance and environment configuration

**Iteration ID:** ITER-001
**Status:** Not started — awaiting explicit implementation approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** None

## Goal

Define how operators select local, QA, and production instances without putting secrets in tracked files or silently choosing a deployment target.

## Scope

- Add a tracked, non-secret instance inventory for local, `qa.server`, and `prod.server`, including each target's environment, SSH host/alias, and required host HTTP port.
- Define ignored local environment files and selection rules for local, QA, and production. Keep local production-mode settings sanitized.
- Ensure `.env*` and other secret-bearing files are excluded from Docker build contexts and deployment archives.
- Add focused checks for unknown targets, missing required values, environment/target mismatches, and secret-file exclusion.

## Out of scope

- Compose/runtime changes, deployment script changes, remote transfers, host provisioning, secret values, and actual deployment.
- Guessing host port numbers. If the user has not supplied values, represent them as required configuration with no operational default.

## Open question

- **DPL-T001-Q01 — What host HTTP ports should local, QA, and production use?** Owner: user. Status: open. The inventory will require a value for each target; deployment remains blocked for targets without one.

## Acceptance criteria

- Inventory contains no credentials and supports the three agreed targets.
- A target cannot be used without an explicit valid host port and matching environment configuration.
- No implicit target fallback exists.
- Secret environment files are ignored and excluded from build/archive inputs.
- Focused tests cover valid selection, missing/invalid configuration, and secret exclusion without printing secret contents.

## Verification

- Review tracked inventory and ignore/build-context rules.
- Run focused configuration-selection tests with disposable non-secret fixtures.
- Inspect the resulting build/archive file list to confirm `.env*` files are absent.
- Do not inspect actual `.env` contents.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
- **Resume note:** No implementation has started.
