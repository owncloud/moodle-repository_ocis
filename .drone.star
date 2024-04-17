OC_CI_PHP = "owncloudci/php:%s"
DEFAULT_PHP_VERSION = "8.1"
OC_UBUNTU = "owncloud/ubuntu:20.04"
PLUGINS_GITHUB_RELEASE = "plugins/github-release:1"
POSTGRESQL = "postgres:13"
MOODLEHQ_APACHE = "moodlehq/moodle-php-apache:8.1"
OC_CI_GOLANG = "owncloudci/golang:1.22"
OC_CI_NODEJS = "owncloudci/nodejs:18"
OC_CI_WAIT_FOR = "owncloudci/wait-for:latest"
SELENIUM = "selenium/standalone-chrome:94.0"

config = {
    "branches": [
        "main",
    ],
    "codestyle": True,
    "ocisBranches": ["master","stable"],
}

trigger = {
    "ref": [
        "refs/heads/main",
        "refs/pull/**",
        "refs/tags/**",
    ],
}

POSTGRESQL_ENV = {
    "POSTGRES_USER": "moodle",
    "POSTGRES_PASSWORD": "moodle",
    "POSTGRES_DB": "moodle",
}

OCIS_ENV = {
    "OCIS_INSECURE": "true",
    "PROXY_ENABLE_BASIC_AUTH": "true",
    "IDM_ADMIN_PASSWORD": 'admin',
    "OCIS_URL": "https://ocis:9200",
    "PROXY_TRANSPORT_TLS_KEY":"/usr/local/share/ca-certificates/ocis.pem",
    "PROXY_TRANSPORT_TLS_CERT":"/usr/local/share/ca-certificates/ocis.crt",
}

MOODLE_ENV = {
    "MOODLE_DBTYPE": "pgsql",
    "MOODLE_DBHOST": "postgresql",
    "MOODLE_DBNAME": "moodle",
    "MOODLE_DBUSER": "moodle",
    "MOODLE_DBPASS": "moodle",
    "MOODLE_DATAROOT": "/var/www/moodledata",
    "MOODLE_OCIS_URL": "https://ocis:9200",
    "MOODLE_DISABLE_CURL_SECURITY": "true",
    "MOODLE_OCIS_CLIENT_ID": "moodle-ocis-integration",
    "MOODLE_OCIS_CLIENT_SECRET": "UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh",
    "BROWSER": "chrome",
    "BEHAT_DATAROOT": "/var/www/behatdata",
    "BEHAT_WWWROOT": "https://apache/moodle",
    "SELENIUM_HOST": "selenium",
    "POSTGRES_USER": "moodle",
    "POSTGRES_PASSWORD": "moodle",
    "POSTGRES_DB": "moodle",
    "OCIS_ADMIN_USERNAME":"admin",
    "OCIS_ADMIN_PASSWORD":"admin",
    "MOODLE_DOCKER_BEHAT_FAILDUMP":"/drone/src/tests"
}

def main(ctx):
    testPipelines = tests(
        ctx,
        [
            ["codestyle", "make test-php-style"],
        ],
    )
    releasePipeline = release (ctx)
    uiTestPipeLine = behattest()
    dependsOn(testPipelines,uiTestPipeLine)
    dependsOn(testPipelines + uiTestPipeLine , releasePipeline)
    return testPipelines + uiTestPipeLine + releasePipeline

def tests(ctx, tests):
    pipelines = []
    for test in tests:
        if test[0] in config and config[test[0]]:
            pipelines += [
                {
                    "kind": "pipeline",
                    "name": test[0],
                    "steps": [
                        {
                            "name": test[0],
                            "image": OC_CI_PHP % DEFAULT_PHP_VERSION,
                            "commands": [
                                "composer install",
                                test[1],
                            ],
                        },
                    ],
                    "trigger": trigger,
                },
            ]
    return pipelines

def release(ctx):
    return [
        {
            "kind": "pipeline",
            "name": "release",
            "depends_on": [],
            "steps": [
                {
                    "name": "zip",
                    "image": OC_UBUNTU,
                    "commands": [
                        "apt-get update",
                        "apt-get install -y zip",
                        "mkdir ocis",
                        "cp -r `ls | grep -v \"^ocis$\"` ocis/",
                        "zip -r moodle-repository_ocis_%s.zip ocis" % (ctx.build.ref.replace("refs/tags/v", "")),
                        "ls -lh",
                    ],
                },
                {
                    "name": "release to GitHub",
                    "image": PLUGINS_GITHUB_RELEASE,
                    "settings": {
                        "api_key": {
                            "from_secret": "github_token",
                        },
                        "files": [
                            "moodle-repository_ocis_%s.zip" % (ctx.build.ref.replace("refs/tags/v", "")),
                        ],
                        "title": ctx.build.ref.replace("refs/tags/v", ""),
                        "note": "CHANGES.md",
                        "overwrite": True,
                        "prerelease": len(ctx.build.ref.split("-")) > 1,
                    },
                },
                {
                    "name": "release to moodle",
                    "image": OC_UBUNTU,
                    "environment": {
                        "ZIPURL": "https://github.com/owncloud/moodle-repository_ocis/releases/download/%s/moodle-repository_ocis_%s.zip" % (ctx.build.ref.replace("refs/tags/", ""), ctx.build.ref.replace("refs/tags/v", "")),
                        "TAGNAME": ctx.build.ref.replace("refs/tags/", ""),
                        "MOODLETOKEN": {
                            "from_secret": "moodle_token",
                        },
                    },
                    "commands": [
                        "RESPONSE=$(curl https://moodle.org/webservice/rest/server.php \
                            --data-urlencode \"wstoken=$MOODLETOKEN\" \
                            --data-urlencode \"wsfunction=local_plugins_add_version\" \
                            --data-urlencode \"moodlewsrestformat=json\" \
                            --data-urlencode \"frankenstyle=repository_ocis\" \
                            --data-urlencode \"zipurl=$ZIPURL\" \
                            --data-urlencode \"vcssystem=git\" \
                            --data-urlencode \"vcsrepositoryurl=https://github.com/owncloud/moodle-repository_ocis/\" \
                            --data-urlencode \"vcstag=$TAGNAME\" \
                            --data-urlencode \"changelogurl=https://github.com/owncloud/moodle-repository_ocis/releases/tag/$TAGNAME\" \
                            --data-urlencode \"altdownloadurl=$ZIPURL\")",
                        "echo $RESPONSE | jq",
                        "echo $RESPONSE | jq --exit-status \".id\"",
                    ],
                },
            ],
            "trigger": {
                "ref": [
                    "refs/tags/v*",
                ],
            }
        }
    ]

def behattest():
    pipelines = []
    for branch in config["ocisBranches"]:
        pipelines += [{
            "kind": "pipeline",
            "type": "docker",
            "name": "behatUItest-%s" % branch,
            "depends_on": [],
            "steps":generateSSLCert() + apacheService() + waitForService("apache",443) + runOcis(branch) + \
                    waitForService("ocis",9200) + databaseService() + waitForService("postgresql",5432) + \
                    seleniumService() + waitForService("selenium",4444) + setupMoodle() + runBehatTest() ,
            "volumes": [
                {
                    "name":"www-moodle",
                    "temp": {}
                },
                {
                    "name":"update-cert",
                    "temp":{}
                },
            ],
            "trigger": {
                "ref": [
                    "refs/pull/**",
                ],
            },
        }]
    return pipelines

def databaseService():
    return [
        {
            "name": "postgresql",
            "image": POSTGRESQL,
            "detach":True,
            "environment": POSTGRESQL_ENV
        },
    ]

def waitForService(name,port):
    return [
        {
            "name": "wait-for-%s" % name,
            "image": OC_CI_WAIT_FOR,
            "commands": ["wait-for -it %s:%s -t 600" % (name,port)]
        }
    ]

def getCommitId(branch):
    if branch == "master":
        return "$OCIS_COMMITID"
    return "$OCIS_STABLE_COMMITID"

def getBranchName(branch):
    if branch == "master":
        return "$OCIS_BRANCH"
    return "$OCIS_STABLE_BRANCH"

def runOcis(branch):
    ocis_commit_id = getCommitId(branch)
    ocis_branch = getBranchName(branch)
    ocis_repo_url = "https://github.com/owncloud/ocis.git"
    return [
        {
            "name": "clone-ocis-%s" % branch,
            "image": OC_CI_GOLANG,
            "commands": [
                "source .drone.env",
                "cd /var/www/html",
                "git clone -b %s --single-branch %s" % (ocis_branch, ocis_repo_url),
                "cd ocis",
                "git checkout %s" % ocis_commit_id,
            ],
            "volumes": [
                {
                    "name": "www-moodle",
                    "path": "/var/www",
                },
                {
                    "name": "update-cert",
                    "path": "/usr/local/share/ca-certificates/",
                },
            ],
        },
        {
            "name": "generate-ocis-%s" % branch,
            "image": OC_CI_NODEJS,
            "commands": [
                "cd /var/www/html/ocis/ocis",
                "retry -t 3 'make ci-node-generate'",
            ],
            "volumes": [
                {
                    "name": "www-moodle",
                    "path": "/var/www",
                },
                {
                    "name": "update-cert",
                    "path": "/usr/local/share/ca-certificates/",
                },
            ],
        },
        {
            "name": "ocis",
            "image": OC_CI_GOLANG,
            "detach": True,
            "commands": [
                "update-ca-certificates",
                "source .drone.env",
                "cd /var/www/html/ocis/ocis",
                "retry -t 3 'make build'",
                "bin/ocis init",
                "cp /drone/src/tests/drone/idp.yaml /root/.ocis/config/",
                "bin/ocis server",
            ],
            "environment": OCIS_ENV,
            "volumes": [
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"update-cert",
                    "path":"/usr/local/share/ca-certificates/"
                },
            ],
        }
    ]

def generateSSLCert():
    return [
        {
            "name": "generate-ssl-certs",
            "image": MOODLEHQ_APACHE,
            "commands": [
                "cd /usr/local/share/ca-certificates/",
                "openssl req -x509  -newkey rsa:2048 -keyout ocis.pem -out ocis.crt -nodes -days 365 -subj '/CN=ocis'",
                "openssl req -x509  -newkey rsa:2048 -keyout moodle.key -out moodle.crt -nodes -days 365 -subj '/CN=apache'",
                "chmod -R 755 /usr/local/share/ca-certificates/",
            ],
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"update-cert",
                    "path":"/usr/local/share/ca-certificates/"
                },
            ],
        }
    ]

def apacheService():
    return [
        {
            "name": "apache",
            "image": MOODLEHQ_APACHE,
            "detach":True,
            "environment": MOODLE_ENV,
            "commands":[
                "cd /usr/local/share/ca-certificates/",
                "update-ca-certificates",
                "cp moodle.crt /etc/ssl/certs/ssl-cert-snakeoil.pem",
                "cp moodle.key /etc/ssl/private/ssl-cert-snakeoil.key",
                "a2ensite default-ssl.conf",
                "a2enmod ssl",
                "moodle-docker-php-entrypoint apache2-foreground",
            ],
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"update-cert",
                    "path":"/usr/local/share/ca-certificates"
                },
            ]
        },
    ]

def setupMoodle():
    return [
        {
            "name": "moodle-setup",
            "image": MOODLEHQ_APACHE,
            "environment": MOODLE_ENV,
            "commands": [
                "cd /var/www/html",
                "update-ca-certificates",
                "git clone --branch MOODLE_402_STABLE --single-branch --depth=1 https://github.com/moodle/moodle.git",
                "cd moodle",
                "cp -r /drone/src repository/ocis",
                "cp /drone/src/tests/drone/config.php ./",
                "php admin/tool/behat/cli/init.php",
            ],
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"update-cert",
                    "path":"/usr/local/share/ca-certificates"
                },
            ]
        },
    ]

def seleniumService():
    return [
        {
            "name":"selenium",
            "image":SELENIUM,
            "detach":True,
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                }
            ]
        }
    ]

def runBehatTest():
    return [
        {
            "name":"behat-test",
            "image":MOODLEHQ_APACHE,
            "environment": MOODLE_ENV,
            "commands": [
                "update-ca-certificates",
                "cd /var/www/html/moodle",
                "vendor/bin/behat --config /var/www/behatdata/behatrun/behat/behat.yml --tags=@ocis",
            ],
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"update-cert",
                    "path":"/usr/local/share/ca-certificates"
                },
            ]

        }
    ]

def dependsOn(earlierStages, nextStages):
    for earlierStage in earlierStages:
        for nextStage in nextStages:
            nextStage["depends_on"].append(earlierStage["name"])
