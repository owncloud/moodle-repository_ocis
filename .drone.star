OC_CI_PHP = "owncloudci/php:%s"
DEFAULT_PHP_VERSION = "8.1"
OC_UBUNTU = "owncloud/ubuntu:20.04"
PLUGINS_GITHUB_RELEASE = "plugins/github-release:1"

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

def main(ctx):
    testPipelines = tests(
        ctx,
        [
            ["codestyle", "make test-php-style"],
        ],
    )
    releasePipeline = release (ctx)
    dependsOn(testPipelines, releasePipeline)
    return testPipelines + releasePipeline

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
                }
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
                        "ls -lh"
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

def dependsOn(earlierStages, nextStages):
    for earlierStage in earlierStages:
        for nextStage in nextStages:
            nextStage["depends_on"].append(earlierStage["name"])
