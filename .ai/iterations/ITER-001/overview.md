# ITER-001 — Rootless multi-environment deployment

**Status:** Iteration layout approved; implementation tickets require separate authorization  
**Lifecycle stage:** Stage 5 delivery plan  
**Design:** [Approved Stage 4 design](../../lifecycle/stage-04-solution-design.md)  
**Plan:** [Stage 5 delivery plan](../../lifecycle/stage-05-delivery-plan.md)

## Outcome

Use rootless Docker for local, QA, and production CamLapse instances, with explicit target configuration, isolated persistent data, read-only preflight, and SSH-key deployment. Expose the app and Horizon on each target's configured HTTP port; keep Redis private.

## Decisions and constraints

- Rootless Docker only; no rootful fallback or `sudo docker`.
- Support the Linux workstation and ARM64 Raspberry Pi targets.
- Track non-secret instance configuration in the repository; keep local/QA/production environment files untracked and secret.
- Require an explicit host port for every target. No port values have been supplied yet; do not guess them.
- Use environment-specific persistent database, timelapse, and Redis volumes; never use `migrate:fresh` in deployment.
- Exclude secret files from build/deployment inputs. Preflight must not inspect `.env` contents or modify the host.
- Use SSH keys; do not forward sudo passwords. Provisioning remains manual.
- Serve Horizon at `/horizon` through the app URL and keep Redis off host-published ports.
- The current Horizon authorization allows every visitor. Public app access therefore also exposes Horizon without authentication; this is a documented residual risk, not an auth-change task.

## Ticket index

| Ticket | Slice | Status | Depends on |
|---|---|---|---|
| [DPL-T001](tickets/DPL-T001.md) | Instance and environment configuration | Not started; awaiting explicit start approval | — |
| [DPL-T002](tickets/DPL-T002.md) | Instance-aware Compose and image builds | Not started | DPL-T001 |
| [DPL-T003](tickets/DPL-T003.md) | Rootless-safe startup and camera devices | Not started | DPL-T002 |
| [DPL-T004](tickets/DPL-T004.md) | Rootless wrappers and read-only preflight | Not started | DPL-T001, DPL-T002 |
| [DPL-T005](tickets/DPL-T005.md) | SSH-key deployment | Not started | DPL-T001–DPL-T004 |
| [DPL-T006](tickets/DPL-T006.md) | End-to-end verification and handoff docs | Not started | DPL-T001–DPL-T005 |

## Approval, commit, and resume protocol

1. Ask the user to approve the specific ticket before implementation starts.
2. Implement only that ticket, run its focused checks, and update its ticket record.
3. Present the diff and actual verification results; wait for separate approval before committing.
4. Commit only that ticket's approved changes, then update this overview with the commit and status.
5. Stop after the commit. Do not begin the next ticket until the user explicitly approves it.

Production deployment and host changes are not authorized by these ticket approvals. Docker-group removal is deferred until rootless command paths have been verified and requires a separate approval before the host operation.

## Current checkpoint

- **Current ticket:** DPL-T001
- **Ticket status:** Not started; not authorized
- **Completed tickets:** None
- **Commits:** None
- **Next action:** Wait for explicit approval to begin DPL-T001

## Open questions

- **DPL-T001-Q01 — Host HTTP ports:** The local, QA, and production port values are not yet known. Owner: user. Status: open; DPL-T001 will require explicit values and will not invent defaults. Deployment of a target is blocked until its port is supplied. See [DPL-T001](tickets/DPL-T001.md).
- **DPL-T003-Q01 — Camera permissions:** The persistent device mapping and host permissions need validation after manual provisioning, including on an ARM64 target. Owner: operator/user. Status: open until verified in DPL-T003 and DPL-T006. See [DPL-T003](tickets/DPL-T003.md).

## Stop conditions

- Stop and revisit the approved design if ARM64 builds, camera access, secret exclusion, or volume isolation cannot meet the acceptance criteria.
