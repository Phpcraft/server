# Phpcraft Server

A simple Minecraft: Java Edition Server based on Phpcraft.

## Prerequisites

You'll need PHP, Composer, and Git.

### Instructions

- **Debian**: `apt-get -y install php-cli composer git`
- **Windows**:
  1. Install [Cone](https://getcone.org), which will install the latest PHP with it.
  2. Run `cone get composer` as administrator.
  3. Install [Git for Windows](https://git-scm.com/download/win).

## Setup

First, we'll clone the repository and generate the autoload script:

```Bash
git clone https://github.com/Phpcraft/server "Phpcraft Server"
cd "Phpcraft Server"
composer install --no-dev --no-suggest --ignore-platform-reqs
```

Next, we'll run a self check:

```Bash
php vendor/timmyrs/phpcraft/selfcheck.php
```

If any dependencies are missing, follow the instructions, and then run the self check again.

### That's it!

Now that you've got the Phpcraft Server all set up, you can start it:

```Bash
php server.php
```

After this, you will find a "config" folder containing the "Phpcraft Server.json" configuration file.
