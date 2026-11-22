# DPL-T006 — Verify end-to-end and document rollout

**Iteration ID:** ITER-001
**Status:** Not started — blocked by DPL-T001–DPL-T005 and per-ticket approval  
**Iteration:** [Rootless multi-environment deployment](../overview.md)  
**Dependencies:** DPL-T001–DPL-T005

## Goal

Verify the approved deployment criteria on local and QA targets, document manual provisioning and recovery limits, and record any platform-specific gaps.

## Scope

- Run focused script tests, Compose validation, relevant PHP tests, Docker builds, and rootless integration checks.
- Verify camera discovery/capture on the Linux workstation and at least one ARM64 target after manual provisioning.
- Exercise local first and QA only after local criteria pass.
- Document environment-file handling, target selection, ports, preflight behavior, manual provisioning, and recovery limitations.
- Do not deploy to production as part of automated tests.
- Present local Docker-group removal as a separate user-approved host operation after rootless scripts are verified.

## Acceptance criteria

- Local and QA checks satisfy the approved design's verification strategy.
- ARM64 camera access is validated or the unresolved limitation is clearly recorded.
- Production is not changed without explicit approval.
- Documentation and the iteration checkpoint reflect actual test and deployment results.

## Approval and completion record

- **Start approval:** Pending
- **Verification result:** Not run
- **Commit approval:** Pending
- **Commit:** None
