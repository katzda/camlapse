# Decision log

This log records explicit process and product decisions. Observed implementation details belong in the architecture and inception records, not here.

## D-001 — Repository files are the lifecycle record

- **Status:** Confirmed by user
- **Decision:** Each lifecycle stage creates or updates repository artifacts, including questions, answers, and architecture/flow documentation where useful. Chat may be used for answers and concise stage approval; repository files retain the traceable state.
- **Reason:** Keep questions and decisions traceable and revise earlier artifacts when decisions change, rather than accumulating contradictory later notes.
- **Scope:** Lifecycle workflow for this repository; this is a process decision, not a Camlapse product/architecture decision.
- **Recorded:** 2026-11-14

## D-002 — Expose Horizon through the app; keep Redis private

- **Status:** Confirmed by user
- **Decision:** Make the Horizon dashboard reachable at the app's `/horizon` URL, while leaving Redis accessible only on the private container network.
- **Reason:** The user's debugging need is access to the Horizon web dashboard; that does not require publishing Redis port 6379.
- **Scope:** Deployment network exposure. This does not add authentication or change the current Horizon authorization behavior, which allows all visitors.
- **Risk:** If the app is internet-accessible, the current Horizon dashboard is also internet-accessible without authentication.

## D-003 — Approve and commit deployment slices individually

- **Status:** Confirmed by user
- **Decision:** Track the deployment work as an umbrella with a ticket per slice. Implement only one slice at a time; obtain the user's explicit approval before starting each slice; after implementation, present the diff and verification results and obtain separate approval before committing; then stop and report the checkpoint before beginning another.
- **Reason:** The user wants to be involved in reviewing implementation and commits and to resume the work in a later session without losing status.
- **Scope:** Implementation workflow for the rootless multi-environment deployment work. This does not authorize production deployment or host changes.

## D-004 — Track deployment tickets in repository lifecycle documents

- **Status:** Confirmed by user
- **Decision:** Track the deployment iteration and its per-slice tickets in the repository lifecycle documentation; do not create GitHub issues.
- **Reason:** Preserve progress and resume context in the repository across separate iterations.
- **Scope:** Ticket tracking for the rootless multi-environment deployment work.

## D-005 — Give substantial iterations a dedicated folder

- **Status:** Confirmed by user
- **Decision:** For larger iterations with multiple tickets or slices, create a dedicated `.ai/iterations/<iteration-id>/` directory using a stable reference ID (for example, `ITER-001`). Put the human-readable title and iteration-wide status in an overview, and keep each ticket's details in a focused file. Keep lifecycle stage records concise and link to the iteration records.
- **Reason:** Keep each ticket focused while preserving an easy-to-find overview and durable progress record.
- **Scope:** Lifecycle documentation convention for substantial iterations.

## D-006 — Keep open questions with their owning artifacts

- **Status:** Confirmed by user
- **Decision:** Do not require a standalone questions directory. Record consequential unresolved questions in the stage, architecture, iteration, or ticket that owns them. Record durable answers in the decision log and update the owning artifact; use a separate index only for genuinely cross-cutting questions.
- **Reason:** Keep questions connected to the design or work they affect, avoid duplicating resolved answers, and make the ownership/source of truth clear.
- **Scope:** Lifecycle documentation convention across this repository.
