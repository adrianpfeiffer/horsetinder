@AGENTS.md

# Neigh (horsetinder)

University project: "Tinder for horses". All work must satisfy the assignment requirements in @docs/requirements.md and implement the submitted app description in @docs/app-description.md (models, relations, routes, seeder). Check both before planning features.

Code must stay simple and explainable: the author has to defend it live and make small changes on the spot.

## Conventions

- Every method and function gets a PHPDoc block that starts with a short one-line description of what it does (e.g. `Let one horse like another, unless it already does.`), followed by any `@param`/`@return` tags. A docblock with only tags is not enough. This does not apply to inline closures or Pest `it()` tests, whose description string already says what they do.
