# Installation Guide

This guide covers the full installation of the Moodle–oCIS repository plugin,
including TLS certificate setup and development environment configuration.

## Requirements

- Moodle 4.2+
- PHP 8.1+
- oCIS 5.0+
- [oCIS PHP SDK](https://github.com/owncloud/ocis-php-sdk/)

## Step 1 — TLS Certificate

If your oCIS instance already has a trusted certificate you can skip this step.

If you are using self-signed certificates, copy them to the Moodle server and
configure trust. Example for Debian-based systems with oCIS on
`https://host.docker.internal:9200`:

1. **Create a TLS certificate**

   ```bash
   openssl req -x509 -newkey rsa:2048 -keyout ocis.pem -out ocis.crt \
     -nodes -days 365 -subj '/CN=host.docker.internal'
   ```

2. **Resolve `host.docker.internal` to `127.0.0.1`**

   ```bash
   sudo sh -c "echo '127.0.0.1 host.docker.internal' >> /etc/hosts"
   ```

## Step 2 — Install Moodle and this Plugin

### Development environment with Docker

```bash
# Clone Moodle
git clone https://github.com/moodle/moodle.git \
  --branch MOODLE_402_STABLE --single-branch --depth=1

# Clone this plugin into the repository directory
cd moodle/repository/
git clone https://github.com/owncloud/moodle-repository_ocis.git ocis

# Install PHP dependencies
cd ocis
composer install
```

Then follow the [moodle-docker](https://github.com/moodlehq/moodle-docker) setup
instructions to bring up the full Moodle + DB stack.

## Step 3 — Configure OAuth2

In Moodle's **Site administration → Server → OAuth 2 services**, create a new
service pointed at your oCIS OpenID Connect endpoint.

## Step 4 — Enable the Repository Plugin

In **Site administration → Plugins → Repositories → Manage repositories**, set
the *oCIS* plugin status to **Enabled and visible**.
