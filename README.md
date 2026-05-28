# Moodle Repository for oCIS

<!-- OSPO-managed README | Generated: 2026-04-16 | v2 -->

[![License](https://img.shields.io/badge/License-GPL--3.0-blue.svg)](LICENSE) [![ownCloud OSPO](https://img.shields.io/badge/OSPO-ownCloud-blue)](https://kiteworks.com/opensource) [![Docker Hub](https://img.shields.io/docker/pulls/owncloud)](https://hub.docker.com/r/owncloud/ocis)

A Moodle repository plugin that integrates ownCloud Infinite Scale with Moodle's file picker. It enables Moodle users to browse, select, and link files stored in oCIS directly through the native Moodle file picker interface, using OpenID Connect for authentication and the oCIS PHP SDK for file operations.

## Getting Started

Follow the steps below to install and configure the Moodle repository plugin.

### Requirements

- Moodle 4.2+
- PHP 8.1+
- oCIS 5.0+
- [oCIS PHP SDK](https://github.com/owncloud/ocis-php-sdk/)

### Installation

1. Copy this repository into your Moodle `repository/ocis/` directory.
2. Run `composer install` to fetch dependencies.
3. Configure the OAuth2 service in Moodle to connect to your oCIS instance.
4. Enable the repository plugin in Moodle's administration panel.

For detailed setup including TLS certificate configuration, see the [full README](https://github.com/owncloud/moodle-repository_ocis).

## Documentation

- [Moodle Repository Plugin Docs](https://docs.moodle.org/402/en/Repositories)
- [oCIS Documentation](https://doc.owncloud.com/ocis/next/)
- [oCIS PHP SDK](https://github.com/owncloud/ocis-php-sdk)

## Part of ownCloud Infinite Scale

This plugin bridges [Moodle](https://moodle.org/) (4.2+) and [oCIS](https://github.com/owncloud/ocis) (5.0+), allowing educational institutions to use oCIS as a file storage backend for their learning management system.

This component is part of the [oCIS Docker image](https://hub.docker.com/r/owncloud/ocis).

Depends on the [oCIS PHP SDK](https://github.com/owncloud/ocis-php-sdk).

## Community & Support

**[Star](https://github.com/owncloud/moodle-repository_ocis)** this repo and **Watch** for release notifications!

- [ownCloud Website](https://owncloud.com)
- [Community Discussions](https://github.com/orgs/owncloud/discussions)
- [Matrix Chat](https://app.element.io/#/room/#owncloud:matrix.org)
- [Documentation](https://doc.owncloud.com)
- [Enterprise Support](https://owncloud.com/contact-us/)
- [OSPO Home](https://kiteworks.com/opensource)

## Contributing

We welcome contributions! Please read the [Contributing Guidelines](CONTRIBUTING.md)
and our [Code of Conduct](CODE_OF_CONDUCT.md) before getting started.

### Workflow

- **Rebase Early, Rebase Often!** We use a rebase workflow. Always rebase on the target branch before submitting a PR.
- **Dependabot**: Automated dependency updates are managed via Dependabot. Review and merge dependency PRs promptly.
- **Signed Commits**: All commits **must** be PGP/GPG signed. See [GitHub's signing guide](https://docs.github.com/en/authentication/managing-commit-signature-verification).
- **DCO Sign-off**: Every commit must carry a `Signed-off-by` line:
  ```
  git commit -s -S -m "your commit message"
  ```
- **GitHub Actions Policy**: Workflows may only use actions that are (a) owned by `owncloud`, (b) created by GitHub (`actions/*`), or (c) verified in the GitHub Marketplace.

## Security

**Do not open a public GitHub issue for security vulnerabilities.**

Report vulnerabilities at **<https://security.owncloud.com>** -- see [SECURITY.md](SECURITY.md).

Bug bounty: [YesWeHack ownCloud Program](https://yeswehack.com/programs/owncloud-bug-bounty-program)

## License

This project is licensed under the [GPL-3.0](LICENSE).

## About the ownCloud OSPO

The [Kiteworks Open Source Program Office](https://kiteworks.com/opensource), operating under
the [ownCloud](https://owncloud.com) brand, launched on May 5, 2026, to steward the open source
ecosystem around ownCloud's products. The OSPO ensures transparent governance, license compliance,
community health, and sustainable collaboration between the open source community and
[Kiteworks](https://www.kiteworks.com), which acquired ownCloud in 2023.

- **OSPO Home**: <https://kiteworks.com/opensource>
- **GitHub**: <https://github.com/owncloud>
- **ownCloud**: <https://owncloud.com>

For questions about the OSPO or licensing, contact ospo@kiteworks.com.

### License Migration to Apache 2.0

The OSPO is driving a strategic relicensing of ownCloud repositories toward the
[Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0), following
the [Apache Software Foundation's third-party license policy](https://www.apache.org/legal/resolved.html).

Individual repositories will migrate as their audit is completed. The LICENSE file
in each repo reflects its **current** license status (not the target).

**Current license: GPL-3.0** (Category X per Apache policy -- cannot be included in Apache-2.0 works).

Migration prerequisites for this repository:

- **CLA/DCO coverage**: All past contributors must have signed agreements permitting relicensing
- **Copyleft dependency audit**: All GPL dependencies must be replaced or isolated
- **Complete relicensing**: GPL-3.0 is a strong copyleft license; migration requires full relicensing of all files
