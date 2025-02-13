# Middleware CheckUserTokenAbility

## Overview
The `CheckUserTokenAbility` middleware is responsible for verifying that incoming requests have the appropriate token abilities based on the URL path. It maps specific URL prefixes to guard names and checks if the authenticated user's token has the required abilities for the corresponding guard.
