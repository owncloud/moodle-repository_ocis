OC_CI_PHP = "owncloudci/php:%s"
DEFAULT_PHP_VERSION = "8.1"
OC_UBUNTU = "owncloud/ubuntu:20.04"
PLUGINS_GITHUB_RELEASE = "plugins/github-release:1"
POSTGRESQL = "postgres:13"
MOODLEHQ_APACHE = "moodlehq/moodle-php-apache:8.1"
OC_OCIS = "owncloud/ocis:5.0.0-rc.3"
OC_CI_WAIT_FOR = "owncloudci/wait-for:latest"
SELENIUM = "selenium/standalone-chrome-debug"
TRAEFIK = "traefik:2.10.5"
config = {
    "branches": [
        "main",
    ],
    "codestyle": True,
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
    "MOODLE_WWWROOT": "http://apache",
    "MOODLE_DATAROOT": "/var/www/moodledata",
    "MOODLE_OCIS_URL": "https://ocis:9200",
    "MOODLE_DISABLE_CURL_SECURITY": "true",
    "MOODLE_OCIS_CLIENT_ID": "xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69",
    "MOODLE_OCIS_CLIENT_SECRET": "UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh"
}

BEHAT_ENV = {
    "MOODLE_DBTYPE": "pgsql",
    "MOODLE_DBHOST": "postgresql",
    "MOODLE_DBNAME": "moodle",
    "MOODLE_DBUSER": "moodle",
    "MOODLE_DBPASS": "moodle",
    "BROWSER": "chrome",
    "BEHAT_DATAROOT": "/var/www/behatdata",
    "BEHAT_WWWROOT": "http://apache",
    "SELENIUM_HOST": "selenium",
}

APACHE_ENV = {
    "POSTGRES_USER": "moodle",
    "POSTGRES_PASSWORD": "moodle",
    "POSTGRES_DB": "moodle",
    "MOODLE_WWWROOT": "http://apache",
    "MOODLE_DATAROOT": "/var/www/moodledata",
    "MOODLE_OCIS_URL": "https://ocis:9200",
    "MOODLE_DISABLE_CURL_SECURITY": "true",
    "MOODLE_OCIS_CLIENT_ID": "xdXOt13JKxym1B1QcEncf2XDkLAexMBFwiT9j6EfhhHFJhs2KM9jbjTmf8JBXE69",
    "MOODLE_OCIS_CLIENT_SECRET": "UBntmLjC2yYCeHwsyj73Uwo9TAaecAetRwMw0xYcvNL9yRdLSUi0hUAHfvCHFeFh",
    "MOODLE_DBTYPE": "pgsql",
    "MOODLE_DBHOST": "postgresql",
    "MOODLE_DBNAME": "moodle",
    "MOODLE_DBUSER": "moodle",
    "MOODLE_DBPASS": "moodle",
    "BROWSER": "chrome",
    "BEHAT_DATAROOT": "/var/www/behatdata",
    "SELENIUM_HOST": "selenium",
}

def main(ctx):
    return behattest()
    # testPipelines = tests(
    #     ctx,
    #     [
    #         ["codestyle", "make test-php-style"],
    #     ],
    # )
    # releasePipeline = release (ctx)
    # dependsOn(testPipelines, releasePipeline)
    # return testPipelines + releasePipeline

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
            },
        },
    ]

def behattest():
    return [
        {
            "kind": "pipeline",
            "type": "docker",
            "name": "behatUItest",
            "steps": moodleCert(),
                # generateSSLCert()+runOcis()+waitForService("ocis",9200)+setupMoodle(),
                # generateSSLCert()+runOcis()+waitForService("ocis",9200)+databaseService()+\
                #      waitForService("postgresql",5432)+runApache()+\
                #      waitForService("apache",80)+setupMoodle(),
                     # +setupSelenium()+runTest(),
            "volumes":[
                {
                    "name":"www-moodle",
                    "temp": {}
                },
                {
                    "name":"ocis-cert",
                    "temp":{}
                },
            ]
        },
    ]

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
def runOcis():
    return [
        {
            "name": "ocis",
            "image": OC_OCIS,
            "detach": True,
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"ocis-cert",
                    "path":"/usr/local/share/ca-certificates/"
                },
            ],
            "environment": OCIS_ENV,
            "commands": [
                "ocis init",
                "ocis server"
            ]
        }
    ]

def generateSSLCert():
    return  [
        {
            "name": "generate-ocis-ssl",
            "image": OC_UBUNTU,
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"ocis-cert",
                    "path":"/usr/local/share/ca-certificates/"
                },
            ],
            "commands": [
                "apt install openssl -y",
                # "openssl req -x509  -newkey rsa:2048 -keyout ocis.pem -out ocis.crt -nodes -days 365 -subj '/CN=ocis'",
                "openssl req -x509  -newkey rsa:2048 -keyout moodle.key -out moodle.crt -nodes -days 365 -subj '/CN=apache'",
                "cp moodle.key /usr/local/share/ca-certificates/",
                "cp moodle.crt /usr/local/share/ca-certificates/",
                # "cp ocis.crt /usr/local/share/ca-certificates/",
                # "cp ocis.pem /usr/local/share/ca-certificates/",
                # "chmod -R 755 /usr/local/share/ca-certificates/",
            ]
        }
    ]

def runApache():
    return [
        {
            "name": "apache",
            "image": MOODLEHQ_APACHE,
            "detach":True,
            "environment": APACHE_ENV,
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
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
                "update-ca-certificates",
                # "curl https:/ocis:9200",
                "git clone --branch MOODLE_402_STABLE --single-branch --depth=1 https://github.com/moodle/moodle.git /var/www/html",
                # "ls -al /var/www/html/repository",
                "cp -r /drone/src /var/www/html/repository/ocis",
                # "mkdir /var/www/html/repository/ocis && cp /drone/src /var/www/html/repository/ocis",
                "ls -al /var/www/html/repository/ocis/tests",
                "cp tests/drone/config.php /var/www/html",
                "sed -i 's/\\\\$CFG->dataroot = \\\\$CFG->behat_dataroot;/\\\\$CFG->dataroot = \\\\$CFG->behat_dataroot;\\\\n\\\\t\\\\t\\\\$CFG->sslproxy = true;/' /var/www/html/lib/setup.php",
                "php /var/www/html/admin/cli/install_database.php --agree-license --fullname='Moodle' --shortname='moodle' --summary='Moodle site' --adminpass='admin' --adminemail='admin@example.com'",
                "curl -I http://apache",
            ],
            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                },
                {
                    "name":"ocis-cert",
                    "path": "/usr/local/share/ca-certificates/"
                }
            ]
        },
    ]
def setupSelenium():
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

def setupTraefik():
    return [
        {
            "name": "traefik",
            "image":TRAEFIK,
            "commands":[
                "apk add --no-cache openssl",
                "openssl req -x509  -newkey rsa:2048 -keyout server.key -out server.crt -nodes -days 365 -subj '/CN=apache'",
            ],
        }
    ]
def runTest():
    return [
        {
            "name":"behat-test",
            "image":MOODLEHQ_APACHE,
            "environment": BEHAT_ENV,
            "commands": [
                "php /var/www/html/admin/tool/behat/cli/init.php",
                "/var/www/html/vendor/bin/behat --config /var/www/behatdata/behatrun/behat/behat.yml `pwd`/mod/forum/tests/behat/private_replies.feature:38",
                "curl http://apache",
            ],

            "volumes":[
                {
                    "name":"www-moodle",
                    "path": "/var/www"
                }
            ]

        }
    ]

def dependsOn(earlierStages, nextStages):
    for earlierStage in earlierStages:
        for nextStage in nextStages:
            nextStage["depends_on"].append(earlierStage["name"])
