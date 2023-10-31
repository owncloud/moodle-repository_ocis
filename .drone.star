OC_CI_PHP = "owncloudci/php:%s"
DEFAULT_PHP_VERSION = "8.1"

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
    return (
        tests(
            ctx,
            [
                ["codestyle", "make test-php-style"],
            ],
        )
    )


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
