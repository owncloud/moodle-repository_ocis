# AGENTS.md -- Moodle Repository for oCIS

## Repository Overview

Moodle repository plugin integrating oCIS with Moodle's file picker. Licensed under GPL-3.0. PHP-based, following Moodle's plugin conventions.

## Architecture & Key Paths

- `classes/` -- PHP classes (Moodle plugin conventions)
- `db/` -- Database schema and upgrades
- `lang/` -- Language strings
- `lib.php` -- Main plugin library file
- `version.php` -- Plugin version definition
- `vendor/` -- Composer dependencies
- `docs/` -- Screenshots and documentation
- `tests/` -- Unit tests
- `Makefile` -- Build and test automation
- `composer.json` -- PHP dependencies
- `thirdpartylibs.xml` -- Third-party library declarations

## Development Conventions

- Follows Moodle coding standards
- PHP 8.1+ required
- Code style checked via PHPCS

## Build & Test Commands

```bash
composer install              # Install dependencies
make test-php-style           # Check code style
make test-php-style-fix       # Fix code style issues
```

## Important Constraints

- Licensed under GPL-3.0 (copyleft, required by Moodle). Apache 2.0 migration may be constrained by Moodle's licensing requirements.
- Do not introduce new **copyleft-licensed dependencies** (GPL, AGPL, LGPL, MPL) without explicit discussion in an issue first. This is especially important for repos that are migrating to or already under Apache 2.0, as copyleft dependencies would block or complicate that migration.
- Depends on ocis-php-sdk and libre-graph-api-php.
- All contributions require a DCO sign-off.


## OSPO Policy Constraints

### GitHub Actions
- **Only** use actions owned by `owncloud`, created by GitHub (`actions/*`), verified on the GitHub Marketplace, or verified by the ownCloud Maintainers.
- Pin all actions to their full commit SHA (not tags): `uses: actions/checkout@<SHA> # vX.Y.Z`
- Never introduce actions from unverified third parties.

### Dependency Management
- Dependabot is configured for automated dependency updates.
- Review and merge Dependabot PRs as part of regular maintenance.
- Do not introduce new dependencies without discussion in an issue first.

### Git Workflow
- **Rebase policy**: Always rebase; never create merge commits. Use `git pull --rebase` and `git rebase` before pushing.
- **Signed commits**: All commits **must** be PGP/GPG signed (`git commit -S -s`).
- **DCO sign-off**: Every commit needs a `Signed-off-by` line (`git commit -s`).
- **Conventional Commits & Squash Merge**: Use the [Conventional Commits](https://www.conventionalcommits.org/) format where the repository enforces it. Many repos use squash merge, where the PR title becomes the commit message on the default branch — apply Conventional Commits format to PR titles as well. A reusable GitHub Actions workflow enforces this.

## Context for AI Agents

This is a Moodle plugin following Moodle's repository plugin architecture. The `lib.php` file is the main entry point. `classes/` follows Moodle's autoloading conventions. The plugin uses OpenID Connect for authentication against oCIS.
